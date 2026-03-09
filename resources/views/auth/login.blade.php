@extends('auth.layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
        <div class="w-full max-w-md bg-white rounded-lg shadow-xs p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">تسجيل الدخول</h2>
            <p class="text-gray-600 text-sm mb-6">أدخل بريدك الإلكتروني أو رقم هاتفك وكلمة المرور</p>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-base text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- حقل البريد/الهاتف (باستخدام كلاسات Flowbite) -->
                <div class="mb-6">
                    <label for="login" class="block mb-2 text-sm font-medium text-gray-900">
                        البريد الإلكتروني أو رقم الهاتف:
                    </label>
                    <input type="text" name="login" id="login" value="{{ old('login') }}" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="example@domain.com">
                </div>

                <!-- حقل كلمة المرور -->
                <div class="mb-6">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">
                        كلمة المرور:
                    </label>
                    <input type="password" name="password" id="password" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="••••••••">
                </div>

                <!-- تذكرني (Checkbox) -->
                <div class="flex items-start mb-6">
                    <div class="flex items-center h-5">
                        <input id="remember" name="remember" type="checkbox"
                            class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300">
                    </div>
                    <label for="remember" class="ms-2 text-sm font-medium text-gray-900">
                        تذكرني
                    </label>
                </div>

                <!-- زر الدخول -->
                <button type="submit"
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 w-full">
                    دخول
                </button>


                <a href="https://berna-violin.art/" class="font-medium text-fg-brand underline hover:no-underline">
                    الصفحة الرئيسية
                </a>

            </form>
        </div>
    </div>
@endsection
