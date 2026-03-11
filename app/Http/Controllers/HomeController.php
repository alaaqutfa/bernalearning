<?php
namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return redirect()->url('https://berna-violin.art/');
    }

    public function dashboard()
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        $subscribedLevels = $user->subscribedLevels;                // levels التي اشترك بها
        $levels           = Level::orderBy('order')->get();         // كل المستويات
        $coupons          = $user->coupons()->with('level')->get(); // كوبونات المستخدم مع المستوى المرتبط
        return view('web.dashboard', compact('user', 'subscribedLevels', 'levels', 'coupons'));
    }

    public function levels()
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        $subscribedLevels = $user->subscribedLevels;
        $levels = Level::orderBy('order')->get(); // كل المستويات
        return view('web.level.index', compact('subscribedLevels','levels'));
    }

    public function privacy()
    {
        return view('web.privacy');
    }
}
