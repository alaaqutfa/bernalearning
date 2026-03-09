<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', false)->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'nullable|string|max:255',
            'email'    => 'nullable|email|unique:users,email',
            'phone'    => 'nullable|string|unique:users,phone',
            'password' => 'required|string|min:6|confirmed',
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

        return redirect()->route('admin.users.index')->with('success', 'تم إنشاء المستخدم بنجاح.');
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

        return redirect()->route('admin.users.index')->with('success', 'تم تحديث المستخدم بنجاح.');
    }

    public function destroy(User $user)
    {
        if ($user->is_admin) {
            return back()->with('error', 'لا يمكن حذف مستخدم مسؤول.');
        }
        $user->delete();
        return back()->with('success', 'تم حذف المستخدم.');
    }
}
