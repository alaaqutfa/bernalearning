<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BunnyView;
use App\Models\Coupon;
use App\Models\Expense;
use App\Services\BunnyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialReportController extends Controller
{
    protected $bunnyService;

    public function __construct(BunnyService $bunnyService)
    {
        $this->bunnyService = $bunnyService;
    }

    /**
     * عرض لوحة التقارير المالية
     */
    public function index(Request $request)
    {
        $year  = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        // إحصائيات عامة
        $totalRevenue  = $this->getTotalRevenue($year, $month);
        $totalExpenses = $this->getTotalExpenses($year, $month);
        $bunnyCosts    = $this->getBunnyCosts($year, $month);

        $profitOwnerTotal = Coupon::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum('profit_owner');

        $profitDeveloperTotal = Coupon::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum('profit_developer');

        // صافي الربح بعد المصاريف
        $netProfit = $totalRevenue - $totalExpenses - $bunnyCosts;
        $netProfitOwner     = $netProfit * 0.75; // 75% لبيرنا
        $netProfitDeveloper = $netProfit * 0.25; // 25% للمطور

        // تفاصيل المصاريف
        $expensesByType = Expense::whereYear('expense_date', $year)
            ->whereMonth('expense_date', $month)
            ->select('type', DB::raw('SUM(amount) as total'))
            ->groupBy('type')
            ->get();

        // تفاصيل المبيعات
        $salesByLevel = Coupon::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->with('level')
            ->select('level_id', DB::raw('COUNT(*) as count'), DB::raw('SUM(price) as total'))
            ->groupBy('level_id')
            ->get();

        // إحصائيات المشاهدات
        $viewStats = BunnyView::whereYear('viewed_at', $year)
            ->whereMonth('viewed_at', $month)
            ->select(
                DB::raw('COUNT(*) as total_views'),
                DB::raw('SUM(watch_time) as total_watch_time'),
                DB::raw('SUM(bandwidth_used) as total_bandwidth'),
                DB::raw('COUNT(DISTINCT user_id) as unique_viewers')
            )
            ->first();

        // قائمة المصاريف لهذا الشهر
        $expenses = Expense::whereYear('expense_date', $year)
            ->whereMonth('expense_date', $month)
            ->orderBy('expense_date', 'desc')
            ->get();

        // أحدث الكوبونات
        $recentCoupons = Coupon::with(['user', 'level'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        return view('admin.financial.index', compact(
            'year', 'month',
            'totalRevenue', 'totalExpenses', 'bunnyCosts',
            'profitOwnerTotal', 'profitDeveloperTotal',
            'netProfit', 'netProfitOwner', 'netProfitDeveloper',
            'expensesByType', 'salesByLevel', 'viewStats',
            'expenses', 'recentCoupons'
        ));
    }

    /**
     * إضافة مصروف جديد
     */
    public function storeExpense(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'amount'       => 'required|numeric|min:0',
            'type'         => 'required|in:hosting,domain,bunny_cdn,marketing,other',
            'expense_date' => 'required|date',
            'description'  => 'nullable|string',
        ]);

        Expense::create($request->all());

        return redirect()->back()->with('success', 'تم إضافة المصروف بنجاح');
    }

    /**
     * حذف المصروف
     */
    public function destroyExpense(Expense $expense)
    {
        $expense->delete();
        return redirect()->back()->with('success', 'تم حذف المصروف بنجاح');
    }

    /**
     * جلب إجمالي الإيرادات
     */
    private function getTotalRevenue($year, $month)
    {
        return Coupon::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->sum('price');
    }

    /**
     * جلب إجمالي المصاريف (عدا Bunny)
     */
    private function getTotalExpenses($year, $month)
    {
        return Expense::whereYear('expense_date', $year)
            ->whereMonth('expense_date', $month)
            ->sum('amount');
    }

    /**
     * جلب تكاليف Bunny.net (تقديرية)
     */
    private function getBunnyCosts($year, $month)
    {
        // تاريخ بداية ونهاية الشهر
        $dateFrom = "$year-$month-01";
        $dateTo   = date('Y-m-t', strtotime($dateFrom));

        // جلب إحصائيات الحساب للفترة
        $accountStats = $this->bunnyService->getAccountStatistics($dateFrom, $dateTo);

        // جلب تفاصيل المكتبة لمعرفة حجم التخزين الحالي
        $libraryDetails = $this->bunnyService->getLibraryDetails();

        // القيم الافتراضية في حالة فشل API
        $bandwidthGB = 0;
        $storageGB   = 50;

        if ($accountStats && isset($accountStats['TotalBandwidthUsed'])) {
            // تحويل من بايت إلى جيجابايت (إذا كانت الوحدة بايت)
            $bandwidthGB = $accountStats['TotalBandwidthUsed'] / (1024 ** 3);
        }

        if ($libraryDetails && isset($libraryDetails['StorageUsage'])) {
            $storageGB = $libraryDetails['StorageUsage'] / (1024 ** 3);
        }

        $pricePerGB = 0.06; // دولار

        $bandwidthCost = $bandwidthGB * $pricePerGB;
        $storageCost   = $storageGB * $pricePerGB;

        return $storageCost + $bandwidthCost;
    }

    /**
     * تقرير سنوي مفصل
     */
    public function yearlyReport($year)
    {
        $monthlyData = [];

        for ($month = 1; $month <= 12; $month++) {
            $revenue    = $this->getTotalRevenue($year, $month);
            $expenses   = $this->getTotalExpenses($year, $month);
            $bunnyCosts = $this->getBunnyCosts($year, $month);

            $profitOwner = Coupon::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->sum('profit_owner');

            $profitDeveloper = Coupon::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->sum('profit_developer');

            $netProfit = $revenue - $expenses - $bunnyCosts;

            $monthlyData[] = [
                'month'                => $month,
                'revenue'              => $revenue,
                'expenses'             => $expenses,
                'bunny_costs'          => $bunnyCosts,
                'profit_owner'         => $profitOwner,
                'profit_developer'     => $profitDeveloper,
                'net_profit'           => $netProfit,
                'net_profit_owner'     => $netProfit * 0.75,
                'net_profit_developer' => $netProfit * 0.25,
            ];
        }

        return view('admin.financial.yearly', compact('year', 'monthlyData'));
    }
}
