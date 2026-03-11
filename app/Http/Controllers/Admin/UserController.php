<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Level;
use App\Mail\CouponCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', false)->withCount('coupons')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $levels = Level::orderBy('order')->get();
        return view('admin.users.create', compact('levels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'nullable|string|max:255',
            'email'      => 'nullable|email|unique:users,email',
            'phone'      => 'nullable|string|unique:users,phone',
            'password'   => 'required|string|min:6|confirmed',
            'level_ids'  => 'required|array|min:1',
            'level_ids.*'=> 'exists:levels,id',
        ]);

        if (!$request->email && !$request->phone) {
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
        $levels = Level::whereIn('id', $request->level_ids)->get();
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

        return redirect()->route('admin.users.show', $user)->with('success', 'تم إنشاء المستخدم والكوبونات بنجاح.');
    }

    public function show(User $user)
    {
        $user->load('coupons.level');
        $totalDeveloperProfit = $user->coupons->sum('profit_developer');
        $totalOwnerProfit = $user->coupons->sum('profit_owner');
        return view('admin.users.show', compact('user', 'totalDeveloperProfit', 'totalOwnerProfit'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'nullable|string|max:255',
            'email'    => 'nullable|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|unique:users,phone,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if (!$request->email && !$request->phone) {
            return back()->withErrors(['email' => 'يجب أن يبقى أحد الحقلين موجوداً.'])->withInput();
        }

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.show', $user)->with('success', 'تم تحديث بيانات المستخدم بنجاح.');
    }

    public function destroy(User $user)
    {
        if ($user->is_admin) {
            return back()->with('error', 'لا يمكن حذف مستخدم مسؤول.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'تم حذف المستخدم.');
    }

    // عرض نموذج إضافة كوبون جديد لمستخدم
    public function addCouponForm(User $user)
    {
        $levels = Level::orderBy('order')->get();
        return view('admin.coupons.add-coupon', compact('user', 'levels'));
    }

    // تخزين كوبون جديد لمستخدم
    public function storeCoupon(Request $request, User $user)
    {
        $request->validate([
            'level_id' => 'required|exists:levels,id',
        ]);

        $level = Level::findOrFail($request->level_id);

        // التحقق من عدم وجود كوبون نشط لنفس المستوى (اختياري)
        $existing = Coupon::where('user_id', $user->id)
                          ->where('level_id', $level->id)
                          ->where('is_active', true)
                          ->first();
        if ($existing) {
            return back()->with('error', 'هذا المستخدم لديه بالفعل اشتراك نشط في هذا المستوى.');
        }

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
            'is_active' => true,
            'price'     => $price,
            'profit_owner' => $profitOwner,
            'profit_developer' => $profitDeveloper,
        ]);

        // if ($user->email) {
        //     Mail::to($user->email)->queue(new CouponCreated($coupon));
        // }

        return redirect()->route('admin.users.show', $user)->with('success', 'تم إضافة الكوبون الجديد بنجاح.');
    }

    // تعطيل كوبون (بدلاً من الحذف)
    public function deactivateCoupon(Coupon $coupon)
    {
        $coupon->update(['is_active' => false]);
        return back()->with('success', 'تم تعطيل الكوبون.');
    }
}
