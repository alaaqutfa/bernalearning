@extends('web.layouts.app')

@section('title', 'سياسة الخصوصية - ' . config('app.name'))

@section('content')
<div class="bg-gradient-to-b from-gray-50 to-white py-12" dir="rtl">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <!-- رأس الصفحة -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-flex items-center justify-center p-2 bg-blue-100 rounded-full mb-4">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl mb-4">
                سياسة الخصوصية
            </h1>
            <p class="text-xl text-gray-600">
                آخر تحديث: {{ now()->format('d F Y') }}
            </p>
            <div class="mt-4 h-1 w-24 bg-blue-600 rounded-full mx-auto"></div>
        </div>

        <!-- المحتوى الرئيسي -->
        <div class="max-w-4xl mx-auto">
            <!-- بطاقات المحتوى -->
            <div class="space-y-6">
                <!-- مقدمة -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">مقدمة</h2>
                        </div>
                        <p class="text-gray-600 leading-relaxed">
                            نحن في {{ config('app.name') }} نلتزم بحماية خصوصيتك وبياناتك الشخصية. توضح سياسة الخصوصية هذه كيفية جمع واستخدام وحماية المعلومات التي تقدمها عند استخدام منصتنا التعليمية.
                        </p>
                    </div>
                </div>

                <!-- المعلومات التي نجمعها -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">المعلومات التي نجمعها</h2>
                        </div>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-1">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">معلومات التسجيل</h3>
                                    <p class="text-sm text-gray-600">الاسم، البريد الإلكتروني، رقم الهاتف</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-1">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">بيانات الاستخدام</h3>
                                    <p class="text-sm text-gray-600">تقدمك في الدورات، الوقت المستغرق، التفاعلات</p>
                                </div>
                            </div>
                            {{-- <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-1">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">معلومات الدفع</h3>
                                    <p class="text-sm text-gray-600">بيانات الدفع مشفرة ولا تخزن بشكل كامل</p>
                                </div>
                            </div> --}}
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-1">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 mb-1">معلومات تقنية</h3>
                                    <p class="text-sm text-gray-600">عنوان IP، نوع المتصفح، نظام التشغيل</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- كيف نستخدم معلوماتك -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 hover:shadow-xl transition-shadow duration-300">
                    <div class="p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">كيف نستخدم معلوماتك</h2>
                        </div>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mt-1 text-blue-600 text-sm font-bold">1</span>
                                <p class="text-gray-600">توفير وتحسين خدماتنا التعليمية وتجربة المستخدم</p>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mt-1 text-blue-600 text-sm font-bold">2</span>
                                <p class="text-gray-600">تخصيص المحتوى والتوصيات بناءً على اهتماماتك</p>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mt-1 text-blue-600 text-sm font-bold">3</span>
                                <p class="text-gray-600">التواصل معك بشأن التحديثات والعروض الجديدة</p>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mt-1 text-blue-600 text-sm font-bold">4</span>
                                <p class="text-gray-600">تحليل أداء المنصة وتحسين جودة المحتوى</p>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- حماية البيانات -->
                <div class="bg-blue-700 rounded-2xl shadow-lg overflow-hidden">
                    <div class="p-8 text-white">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold">حماية بياناتك</h2>
                        </div>
                        <p class="text-white text-opacity-90 leading-relaxed mb-4">
                            نستخدم أحدث تقنيات التشفير لحماية بياناتك. جميع المعلومات الحساسة مشفرة باستخدام بروتوكول SSL/TLS. نقوم بتحديث إجراءاتنا الأمنية باستمرار لضمان أعلى مستويات الحماية.
                        </p>
                        <div class="flex flex-wrap gap-3 mt-6">
                            <span class="px-4 py-2 bg-white text-blue-600 bg-opacity-20 rounded-lg text-sm font-medium">تشفير SSL</span>
                            <span class="px-4 py-2 bg-white text-blue-600 bg-opacity-20 rounded-lg text-sm font-medium">جدر نارية</span>
                            <span class="px-4 py-2 bg-white text-blue-600 bg-opacity-20 rounded-lg text-sm font-medium">مراقبة 24/7</span>
                            <span class="px-4 py-2 bg-white text-blue-600 bg-opacity-20 rounded-lg text-sm font-medium">نسخ احتياطي</span>
                        </div>
                    </div>
                </div>

                <!-- ملفات تعريف الارتباط -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">ملفات تعريف الارتباط (Cookies)</h2>
                        </div>
                        <p class="text-gray-600 leading-relaxed mb-4">
                            نستخدم ملفات تعريف الارتباط لتحسين تجربتك على المنصة. يمكنك التحكم في إعدادات cookies من خلال متصفحك.
                        </p>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <h3 class="font-semibold text-gray-900 mb-2">أنواع cookies التي نستخدمها:</h3>
                            <div class="space-y-2">
                                <p class="text-sm text-gray-600">• Cookies ضرورية: لتشغيل المنصة بشكل أساسي</p>
                                <p class="text-sm text-gray-600">• Cookies تحليلية: لتحسين أداء المنصة</p>
                                <p class="text-sm text-gray-600">• Cookies وظيفية: لتذكر تفضيلاتك</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- حقوقك -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="p-8">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">حقوقك</h2>
                        </div>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div class="border border-gray-200 rounded-xl p-4 hover:border-blue-300 transition-colors">
                                <h3 class="font-semibold text-gray-900 mb-2">حق الوصول</h3>
                                <p class="text-sm text-gray-600">يمكنك طلب نسخة من بياناتك الشخصية</p>
                            </div>
                            <div class="border border-gray-200 rounded-xl p-4 hover:border-blue-300 transition-colors">
                                <h3 class="font-semibold text-gray-900 mb-2">حق التصحيح</h3>
                                <p class="text-sm text-gray-600">يمكنك تحديث أو تصحيح بياناتك</p>
                            </div>
                            <div class="border border-gray-200 rounded-xl p-4 hover:border-blue-300 transition-colors">
                                <h3 class="font-semibold text-gray-900 mb-2">حق الحذف</h3>
                                <p class="text-sm text-gray-600">يمكنك طلب حذف حسابك وبياناتك</p>
                            </div>
                            <div class="border border-gray-200 rounded-xl p-4 hover:border-blue-300 transition-colors">
                                <h3 class="font-semibold text-gray-900 mb-2">حق الاعتراض</h3>
                                <p class="text-sm text-gray-600">يمكنك الاعتراض على معالجة بياناتك</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- معلومات الاتصال -->
                <div dir="ltr" class="bg-gray-50 rounded-2xl p-8 border border-gray-200">
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">للتواصل بخصوص الخصوصية</h3>
                        <p class="text-gray-600 mb-6">إذا كان لديك أي استفسار حول سياسة الخصوصية، يمكنك التواصل معنا:</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="mailto:info@berna-violin.art" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                info@berna-violin.art
                            </a>
                            <a href="tel:0096181139596" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-gray-600 text-white rounded-xl hover:bg-gray-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                +961 81 13 95 96
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- تذييل الصفحة -->
            <div class="mt-8 text-center text-sm text-gray-500">
                <p>© {{ date('Y') }} {{ config('app.name') }}. جميع الحقوق محفوظة.</p>
                <p class="mt-2">آخر تحديث: {{ now()->format('Y/m/d') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
