<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        if($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        $subscribedLevels = $user->subscribedLevels;
        $levels = Level::orderBy('order')->get();
        return view('web.dashboard', compact('subscribedLevels', 'levels'));
    }
}
