@extends('admin.layouts.app')

@section('title', 'إنشاء مستخدم جديد')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- رأس الصفحة -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">إنشاء مستخدم جديد</h1>
            <p class="text-gray-600 mt-1">قم بإدخال بيانات المستخدم الجديد</p>
        </div>

        <!-- بطاقة النموذج -->
        <div class="bg-white rounded-lg shadow-sm border border-blue-500 overflow-hidden">
            <form method="POST" action="{{ route('admin.users.store') }}" class="p-6" id="create-user-form">
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

                <!-- حقل رقم الهاتف (مع مكتبة intl-tel-input) -->
                <div class="mb-5">
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">
                        رقم الهاتف
                    </label>
                    <!-- تمت إزالة الأيقونة الثابتة لتجنب التعارض مع المكتبة -->
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                        class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('phone') border-red-500 @enderror"
                        placeholder="رقم الهاتف">
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

                <!-- اختيار المستويات -->
                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-900">
                        المستويات المطلوب الاشتراك بها <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 p-4 bg-gray-50 rounded-lg border border-blue-200">
                        @foreach ($levels as $level)
                            <div class="flex items-center">
                                <input type="checkbox" name="level_ids[]" value="{{ $level->id }}"
                                    id="level_{{ $level->id }}"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-blue-300 rounded focus:ring-blue-500"
                                    {{ in_array($level->id, old('level_ids', [])) ? 'checked' : '' }}>
                                <label for="level_{{ $level->id }}" class="mr-2 text-sm font-medium text-gray-900">
                                    {{ $level->title }} - <span
                                        class="text-green-600">${{ number_format($level->price, 2) }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('level_ids')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('level_ids.*')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- أزرار الإجراءات -->
                <div class="flex items-center gap-3 border-t border-blue-200 pt-5">
                    <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors duration-200">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        إنشاء المستخدم
                    </button>
                    <a href="{{ route('admin.users.index') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition-colors duration-200">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        إلغاء والعودة
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
            const phoneInput = document.querySelector("#phone");
            if (!phoneInput) return;

            // تهيئة مكتبة intl-tel-input
            const iti = window.intlTelInput(phoneInput, {
                initialCountry: "lb",
                preferredCountries: ["lb", "sa", "ae", "us", "gb"],
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                separateDialCode: true,
                formatOnDisplay: true,
                autoPlaceholder: "aggressive",
                nationalMode: false,
            });

            const form = document.getElementById('create-user-form');
            const phoneError = document.getElementById('phone-error');

            form.addEventListener('submit', function(e) {
                // إخفاء رسالة الخطأ السابقة
                phoneError.classList.add('hidden');
                phoneError.textContent = '';

                // التحقق إذا كان الحقل غير فارغ
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
