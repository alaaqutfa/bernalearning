<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Level;
use App\Models\User;
use App\Models\Visitor;

class DashboardController extends Controller
{
    public function index()
    {
        $totalVisitors  = Visitor::count();
        $uniqueVisitors = Visitor::distinct('ip')->count('ip');
        $students       = User::where('is_admin', false)->count();
        $activeStudents = User::whereHas('coupons', function ($q) {
            $q->where('is_active', true);
        })->count();
        $levelsCount = Level::count();
        $couponsSold = Coupon::count();

        // إحصائيات إضافية حسب الشهر
        $visitorsChart = Visitor::selectRaw('DATE(created_at) as date, count(*) as views')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        return view('admin.dashboard', compact(
            'totalVisitors', 'uniqueVisitors', 'students', 'activeStudents',
            'levelsCount', 'couponsSold', 'visitorsChart'
        ));
    }
}
