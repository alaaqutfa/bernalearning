<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Level;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        if (Auth::check()) {
            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'nullable|string|max:255',
            'email'    => 'nullable|email|unique:users,email',
            'phone'    => 'nullable|string|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (! $request->email && ! $request->phone) {
            return back()->withErrors(['email' => 'يجب إدخال البريد الإلكتروني أو رقم الهاتف على الأقل.'])->withInput();
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'is_admin' => false,
        ]);

        // إنشاء كوبون لكل مستوى مختار
        $levels = Level::where('price', 0)->get();
        foreach ($levels as $level) {
            do {
                $code = strtoupper(uniqid('BL-'));
            } while (Coupon::where('code', $code)->exists());

            $price = $level->price;
            $profitOwner = $price * 0.75;
            $profitDeveloper = $price * 0.25;

            $coupon = Coupon::create([
                'code'      => $code,
                'user_id'   => $user->id,
                'level_id'  => $level->id,
                'price'     => $price,
                'profit_owner' => $profitOwner,
                'profit_developer' => $profitDeveloper,
                'is_active' => true,
            ]);

            // إرسال الكوبون (اختياري)
            // if ($request->email) {
            //     Mail::to($request->email)->queue(new CouponCreated($coupon));
            // }
        }

        Auth::login($user);

        return redirect()->route('dashboard', $user)->with('success', 'تم إنشاء المستخدم بنجاح.');
    }
}
