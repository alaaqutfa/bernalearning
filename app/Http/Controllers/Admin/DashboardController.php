<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Level;
use App\Models\User;
use App\Models\Visitor;
use App\Services\BunnyService;

class DashboardController extends Controller
{
    protected $bunnyService;

    public function __construct(BunnyService $bunnyService)
    {
        $this->bunnyService = $bunnyService;
    }

    public function index()
    {
        // إحصائيات Bunny لآخر 30 يوم
        $dateTo = now()->format('Y-m-d');
        $dateFrom = now()->subDays(30)->format('Y-m-d');
        $bunnyStats = $this->bunnyService->getAccountStatistics($dateFrom, $dateTo);

        // متغيرات افتراضية
        $totalBandwidthGB = 0;
        $totalRequests = 0;
        $cacheHitRate = 0;
        $estimatedCost = 0;

        if ($bunnyStats && !isset($bunnyStats['error'])) {
            // تحويل من بايت إلى جيجابايت (افتراض أن API يعيد البايت)
            $totalBandwidthGB = isset($bunnyStats['TotalBandwidthUsed'])
                ? round($bunnyStats['TotalBandwidthUsed'] / (1024 ** 3), 2)
                : 0;

            $totalRequests = $bunnyStats['TotalRequestsServed'] ?? 0;
            $cacheHitRate = $bunnyStats['CacheHitRate'] ?? 0;

            // تقدير التكلفة (0.06 دولار لكل جيجابايت)
            $estimatedCost = round($totalBandwidthGB * 0.06, 2);
        }

        // الإحصائيات المحلية
        $totalVisitors  = Visitor::count();
        $uniqueVisitors = Visitor::distinct('ip')->count('ip');
        $students       = User::where('is_admin', false)->count();
        $activeStudents = User::whereHas('coupons', function ($q) {
            $q->where('is_active', true);
        })->count();
        $levelsCount = Level::count();
        $couponsSold = Coupon::count();

        $visitorsChart = Visitor::selectRaw('DATE(created_at) as date, count(*) as views')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        $totalSales           = Coupon::sum('price');
        $totalOwnerProfit     = Coupon::sum('profit_owner');
        $totalDeveloperProfit = Coupon::sum('profit_developer');

        // تمرير كل المتغيرات إلى الواجهة
        return view('admin.dashboard', compact(
            'totalVisitors', 'uniqueVisitors', 'students', 'activeStudents',
            'levelsCount', 'couponsSold', 'visitorsChart',
            'totalSales', 'totalOwnerProfit', 'totalDeveloperProfit',
            'totalBandwidthGB', 'totalRequests', 'cacheHitRate', 'estimatedCost'
        ));
    }
}
