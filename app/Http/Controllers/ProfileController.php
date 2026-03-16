<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{

    public function edit()
    {
        $user = Auth::user();
        return view('web.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|unique:users,phone,' . $user->id,
        ]);

        if (! $request->email && ! $request->phone) {
            return back()->withErrors(['email' => 'يجب إدخال البريد الإلكتروني أو رقم الهاتف على الأقل.'])->withInput();
        }

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return back()->with('success', 'تم تحديث المعلومات بنجاح.');
    }

    public function password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', function ($attr, $value, $fail) {
                if (!Hash::check($value, Auth::user()->password)) {
                    $fail('كلمة المرور الحالية غير صحيحة.');
                }
            }],
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        Auth::user()->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'تم تغيير كلمة المرور بنجاح.');
    }

    public function destroy()
    {
        $user = Auth::user();
        Auth::logout();
        $user->delete();

        return redirect('/')->with('success', 'تم حذف الحساب بنجاح.');
    }
}
