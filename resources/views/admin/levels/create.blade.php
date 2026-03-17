@extends('admin.layouts.app')

@section('title', 'إضافة مستوى جديد')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- رأس الصفحة -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">إضافة مستوى جديد</h1>
            <p class="text-gray-600 mt-1">قم بإدخال بيانات المستوى الجديد</p>
        </div>

        <!-- بطاقة النموذج -->
        <div class="bg-white rounded-lg shadow-sm border border-blue-500 overflow-hidden">
            <form method="POST" action="{{ route('admin.levels.store') }}" class="p-6">
                @csrf

                <!-- حقل العنوان -->
                <div class="mb-5">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900">
                        العنوان <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                        </div>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 p-2.5 @error('title') border-red-500 @enderror"
                            placeholder="أدخل عنوان المستوى">
                    </div>
                    @error('title')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- حقل الوصف -->
                <div class="mb-5">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900">
                        الوصف
                    </label>
                    <div class="relative">
                        <div class="absolute top-3 right-0 flex items-start pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h7"></path>
                            </svg>
                        </div>
                        <textarea id="description" name="description" rows="4"
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 p-2.5 @error('description') border-red-500 @enderror"
                            placeholder="أدخل وصف المستوى">{{ old('description') }}</textarea>
                    </div>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- حقل السعر -->
                <div class="mb-5">
                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900">
                        السعر ($) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01"
                            min="0" required
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 p-2.5 @error('price') border-red-500 @enderror"
                            placeholder="0.00">
                    </div>
                    @error('price')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- حقل الترتيب -->
                <div class="mb-6">
                    <label for="order" class="block mb-2 text-sm font-medium text-gray-900">
                        الترتيب
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h10M7 12h10M7 17h6"></path>
                            </svg>
                        </div>
                        <input type="number" id="order" name="order" value="{{ old('order', 0) }}" min="0"
                            class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pr-10 p-2.5 @error('order') border-red-500 @enderror"
                            placeholder="0">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">تحديد ترتيب ظهور المستوى في القائمة (الأصغر يظهر أولاً)</p>
                    @error('order')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- نشر (Publish) -->
                <div class="flex items-start mb-6">
                    <div class="flex items-center h-5">
                        <input id="publish" name="publish" type="checkbox"
                            class="w-4 h-4 border border-blue-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300">
                    </div>
                    <label for="publish" class="ms-2 text-sm font-medium text-gray-900">
                        نشر
                    </label>
                </div>

                <!-- أزرار الإجراءات -->
                <div class="flex items-center gap-3 border-t border-blue-200 pt-5">
                    <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition-colors duration-200">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        حفظ المستوى
                    </button>
                    <a href="{{ route('admin.levels.index') }}"
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
    <style>
        /* تنسيقات إضافية للحقول */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            opacity: 0.5;
        }

        input[type="number"]:hover::-webkit-inner-spin-button,
        input[type="number"]:hover::-webkit-outer-spin-button {
            opacity: 1;
        }
    </style>
@endpush
