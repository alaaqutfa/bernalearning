<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CouponCreated;
use App\Models\Coupon;
use App\Models\Level;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::with('user', 'level')->latest()->paginate(20);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        $levels = Level::all();
        return view('admin.coupons.create', compact('levels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'level_id'   => 'required|exists:levels,id',
        ]);

        // البحث عن المستخدم بالبريد أو الهاتف
        $user = null;
        if (filter_var($request->identifier, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->identifier)->first();
        } else {
            $user = User::where('phone', $request->identifier)->first();
        }

        if (! $user) {
            return back()->withErrors(['identifier' => 'لم يتم العثور على مستخدم بهذا المعرف. الرجاء إنشاء المستخدم أولاً.'])->withInput();
        }

        do {
            $code = strtoupper(uniqid('BERNA-'));
        } while (Coupon::where('code', $code)->exists());

        $coupon = Coupon::create([
            'code'      => $code,
            'user_id'   => $user->id,
            'level_id'  => $request->level_id,
            'is_active' => true,
        ]);

        // إرسال الكوبون (اختياري)
        if ($user->email) {Mail::to($user->email)->send(new CouponCreated($coupon));}

        return redirect()->route('admin.coupons.index')->with('success', "كوبون $code تم إنشاؤه للمستخدم.");
    }
}
