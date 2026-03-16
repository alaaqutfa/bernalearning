@extends('web.layouts.app')

@section('title', 'ملفي الشخصي')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 sm:p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">ملفي الشخصي</h2>

                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-base text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-base text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- تحديث المعلومات الأساسية --}}
                <form method="POST" action="{{ route('profile.update') }}" class="mb-8">
                    @csrf
                    @method('PUT')
                    <h3 class="text-lg font-medium text-gray-900 mb-4">المعلومات الشخصية</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">الاسم</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        {{-- <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="example@domain.com">
                        </div>
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">رقم الهاتف</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="+961 00 000 000">
                        </div> --}}
                    </div>
                    <div class="mt-4">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            تحديث المعلومات
                        </button>
                    </div>
                </form>

                {{-- تغيير كلمة المرور --}}
                <form method="POST" action="{{ route('profile.password') }}" class="mb-8">
                    @csrf
                    @method('PUT')
                    <h3 class="text-lg font-medium text-gray-900 mb-4">تغيير كلمة المرور</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور الحالية</label>
                            <input type="password" name="current_password" id="current_password" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور الجديدة</label>
                            <input type="password" name="new_password" id="new_password" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">تأكيد كلمة المرور الجديدة</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            تغيير كلمة المرور
                        </button>
                    </div>
                </form>

                {{-- حذف الحساب --}}
                {{-- <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-red-600 mb-4">حذف الحساب</h3>
                    <p class="text-sm text-gray-600 mb-4">عند حذف حسابك، سيتم إزالة جميع بياناتك بشكل نهائي. هذا الإجراء لا يمكن التراجع عنه.</p>
                    <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('هل أنت متأكد من حذف الحساب؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            حذف الحساب
                        </button>
                    </form>
                </div> --}}

                {{-- تواصل معنا --}}
                <div class="border-t pt-6 mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">تواصل معنا</h3>
                    <p class="text-sm text-gray-600">
                        إذا كان لديك أي استفسار أو تريد تقديم طلب حذف حسابك أو تعديل رقم الهاتف او الايميل، يمكنك التواصل معنا عبر البريد الإلكتروني:
                        <a href="mailto:support@berna-violin.art" class="text-blue-600 hover:underline">support@berna-violin.art</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
