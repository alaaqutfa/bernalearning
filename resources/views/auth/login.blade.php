@extends('auth.layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
    <div class="w-full max-w-md bg-white rounded-lg shadow-xs p-6">
        <a href="https://berna-violin.art/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('public/assets/img/full-logo.png') }}" class="h-24" alt="Berna Logo" />
        </a>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">تسجيل الدخول</h2>
        <p class="text-gray-600 text-sm mb-6">أدخل بريدك الإلكتروني أو رقم هاتفك وكلمة المرور</p>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-base text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="login-form">
            @csrf

            <!-- مفتاح الاختيار: رقم هاتف / بريد إلكتروني -->
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900">تسجيل الدخول باستخدام</label>
                <div class="flex gap-4 rtl:space-x-reverse mb-3">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="login_type" value="phone" checked class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="mr-2 text-sm text-gray-900">رقم الهاتف</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="login_type" value="email" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                        <span class="mr-2 text-sm text-gray-900">البريد الإلكتروني</span>
                    </label>
                </div>

                <!-- حاوية حقل الإدخال الديناميكي -->
                <div id="login-field-container"></div>
                @error('login')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- حقل كلمة المرور -->
            <div class="mb-6">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">كلمة المرور</label>
                <input type="password" name="password" id="password" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="••••••••">
                @error('password')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- تذكرني -->
            <div class="flex items-start mb-6">
                <div class="flex items-center h-5">
                    <input id="remember" name="remember" type="checkbox"
                        class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300">
                </div>
                <label for="remember" class="ms-2 text-sm font-medium text-gray-900">تذكرني</label>
            </div>

            <!-- زر الدخول -->
            <button type="submit"
                class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 w-full">
                دخول
            </button>

            <div class="flex justify-start items-center gap-2 flex-wrap">
                <a href="{{ route('register') }}" class="font-medium text-fg-brand underline hover:no-underline">
                    ليس لديك حساب ؟
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
        .iti {
            width: 100%;
            direction: ltr;
        }
        .iti__selected-flag {
            padding: 0 6px 0 12px;
            border-radius: 8px 0 0 8px;
        }
        .iti--allow-dropdown input, .iti--allow-dropdown input[type=tel] {
            padding-right: 6px;
            padding-left: 52px;
            border-radius: 8px;
        }
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
            const container = document.getElementById('login-field-container');
            const radioPhone = document.querySelector('input[type="radio"][value="phone"]');
            const radioEmail = document.querySelector('input[type="radio"][value="email"]');
            const form = document.getElementById('login-form');
            let currentIti = null; // لحفظ مرجع intl-tel-input الحالي

            // دالة لإنشاء حقل الهاتف مع المكتبة
            function createPhoneInput(value = '') {
                // إنشاء عنصر input
                const input = document.createElement('input');
                input.type = 'tel';
                input.name = 'login';
                input.id = 'login';
                input.value = value;
                input.required = true;
                input.className = 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5';
                input.placeholder = 'رقم الهاتف';
                input.dir = 'ltr';

                // إفراغ الحاوية وإضافة input
                container.innerHTML = '';
                container.appendChild(input);

                // تطبيق المكتبة
                const iti = window.intlTelInput(input, {
                    initialCountry: "lb",
                    preferredCountries: ["lb", "sa", "ae", "us", "gb"],
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                    separateDialCode: true,
                    formatOnDisplay: true,
                    autoPlaceholder: "aggressive",
                    nationalMode: false,
                });

                return { input, iti };
            }

            // دالة لإنشاء حقل البريد الإلكتروني
            function createEmailInput(value = '') {
                const input = document.createElement('input');
                input.type = 'email';
                input.name = 'login';
                input.id = 'login';
                input.value = value;
                input.required = true;
                input.className = 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5';
                input.placeholder = 'example@domain.com';
                input.dir = 'auto';

                container.innerHTML = '';
                container.appendChild(input);
                return { input, iti: null };
            }

            // دالة تبديل الحقل بناءً على الراديو المحدد
            function switchField() {
                const oldValue = document.getElementById('login')?.value || '';
                if (radioPhone.checked) {
                    const { input, iti } = createPhoneInput(oldValue);
                    currentIti = iti;
                } else {
                    createEmailInput(oldValue);
                    currentIti = null;
                }
            }

            // تهيئة الحالة الافتراضية (رقم الهاتف)
            switchField();

            // مراقبة تغيير الراديو
            radioPhone.addEventListener('change', switchField);
            radioEmail.addEventListener('change', switchField);

            // عند إرسال النموذج: إذا كان الهاتف نشطًا، نأخذ الرقم الدولي الكامل
            form.addEventListener('submit', function(e) {
                if (radioPhone.checked && currentIti) {
                    const input = document.getElementById('login');
                    if (input.value.trim() !== '') {
                        if (!currentIti.isValidNumber()) {
                            e.preventDefault();
                            alert('رقم الهاتف غير صحيح. يرجى التحقق من الرقم.');
                            input.focus();
                            return;
                        }
                        // تعيين القيمة إلى الرقم الدولي الكامل
                        input.value = currentIti.getNumber();
                    }
                }
            });
        })();
    </script>
@endpush
