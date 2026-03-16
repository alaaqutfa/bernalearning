@extends('auth.layouts.app')

@section('title', 'إنشاء حساب')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
        <div class="w-full max-w-md bg-white rounded-lg shadow-xs p-6">
            <a href="https://berna-violin.art/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('public/assets/img/full-logo.png') }}" class="h-24" alt="Berna Logo" />
            </a>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">إنشاء حساب</h2>
            <p class="text-gray-600 text-sm mb-6">أدخل اسمك والبريد الإلكتروني أو رقم هاتفك وكلمة المرور</p>

            @if ($errors->any())
                <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-base text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="register-form">
                @csrf

                <!-- حقل الاسم -->
                <div class="mb-5">
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                        الاسم
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 p-2.5 @error('name') border-red-500 @enderror"
                            placeholder="أدخل اسم المستخدم (اختياري)">
                    </div>
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- حقل البريد الإلكتروني -->
                <div class="mb-5">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">
                        البريد الإلكتروني
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 p-2.5 @error('email') border-red-500 @enderror"
                            placeholder="user@example.com">
                    </div>
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- حقل رقم الهاتف مع مكتبة intl-tel-input -->
                <div class="mb-5">
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">
                        رقم الهاتف
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none z-10">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                </path>
                            </svg>
                        </div>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 p-2.5 @error('phone') border-red-500 @enderror"
                            placeholder="رقم الهاتف">
                    </div>
                    @error('phone')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div id="phone-error" class="text-red-600 text-sm mt-1 hidden"></div>
                </div>

                <!-- حقل كلمة المرور -->
                <div class="mb-5">
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900">
                        كلمة المرور <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" required
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 p-2.5 @error('password') border-red-500 @enderror"
                            placeholder="********">
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- حقل تأكيد كلمة المرور -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">
                        تأكيد كلمة المرور <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <input type="password" id="password_confirmation" name="password_confirmation" required
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 p-2.5"
                            placeholder="********">
                    </div>
                </div>

                <!-- زر الإنشاء -->
                <button type="submit"
                    class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 w-full">
                    إنشاء
                </button>

                <div class="flex justify-start items-center gap-2 flex-wrap">
                    <a href="{{ route('login') }}" class="font-medium text-fg-brand underline hover:no-underline">
                        لديك حساب ؟
                    </a>
                    <a href="https://berna-violin.art/" class="font-medium text-fg-brand underline hover:no-underline">
                        الصفحة الرئيسية
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <!-- إضافة CSS لمكتبة intl-tel-input -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <style>
        /* تخصيص مظهر الحقل ليتناسب مع التصميم RTL */
        .iti {
            width: 100%;
            direction: ltr;
            /* لأن الأرقام تكون من اليسار لليمين */
        }

        .iti__selected-flag {
            padding: 0 6px 0 12px;
            border-radius: 8px 0 0 8px;
        }

        .iti--allow-dropdown input,
        .iti--allow-dropdown input[type=tel] {
            padding-right: 6px;
            padding-left: 52px;
            border-radius: 8px;
        }

        /* تعديل موضع الأيقونة الداخلية (الظل) */
        .relative .absolute.inset-y-0.right-0 {
            left: auto;
            right: 0;
        }

        /* جعل القائمة المنسدلة للدول تظهر بشكل صحيح */
        .iti__country-list {
            z-index: 50;
            width: 300px;
            max-width: 80vw;
        }
    </style>
@endpush

@push('scripts')
    <!-- إضافة JavaScript لمكتبة intl-tel-input -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        (function() {
            const phoneInput = document.querySelector("#phone");
            if (!phoneInput) return;

            // تهيئة مكتبة intl-tel-input
            const iti = window.intlTelInput(phoneInput, {
                initialCountry: "lb", // لبنان كدولة افتراضية
                preferredCountries: ["lb", "sa", "ae", "us", "gb"],
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js", // للتحقق من الصحة
                separateDialCode: true,
                hiddenInput: "full_phone", // اختياري: لإرسال الرقم الكامل كحقل منفصل
                formatOnDisplay: true,
                autoPlaceholder: "aggressive",
                nationalMode: false,
            });

            // التحقق عند تقديم النموذج
            const form = document.getElementById('register-form');
            const phoneError = document.getElementById('phone-error');

            form.addEventListener('submit', function(e) {
                phoneError.classList.add('hidden');
                phoneError.textContent = '';

                if (phoneInput.value.trim() !== '') {
                    if (!iti.isValidNumber()) {
                        e.preventDefault();
                        phoneError.textContent = 'رقم الهاتف غير صحيح. يرجى التحقق من الرقم.';
                        phoneError.classList.remove('hidden');
                        phoneInput.focus();
                        return;
                    }
                    // تعيين القيمة إلى الرقم الدولي الكامل (مع رمز البلد)
                    phoneInput.value = iti.getNumber();
                }
            });
            
            // اختيارياً: عند تغيير الحقل، إزالة رسالة الخطأ
            phoneInput.addEventListener('input', function() {
                phoneError.classList.add('hidden');
            });
        })();
    </script>
@endpush
