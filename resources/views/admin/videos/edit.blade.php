@extends('admin.layouts.app')

@section('title', 'تعديل الفيديو')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">تعديل الفيديو</h1>
        <p class="text-gray-600 mt-1">تعديل بيانات الفيديو: {{ $video->title }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-blue-500 overflow-hidden">
        <form method="POST" action="{{ route('admin.videos.update', $video) }}" class="p-6">
            @csrf
            @method('PUT')

            <!-- اختيار المستوى -->
            <div class="mb-5">
                <label for="level_id" class="block mb-2 text-sm font-medium text-gray-900">
                    المستوى <span class="text-red-500">*</span>
                </label>
                <select name="level_id" id="level_id" required
                        class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('level_id') border-red-500 @enderror">
                    <option value="">اختر المستوى</option>
                    @foreach($levels as $level)
                        <option value="{{ $level->id }}" {{ old('level_id', $video->level_id) == $level->id ? 'selected' : '' }}>
                            {{ $level->title }}
                        </option>
                    @endforeach
                </select>
                @error('level_id')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- معرف الفيديو في Bunny (ثابت) -->
            <div class="mb-5">
                <label for="bunny_video_id" class="block mb-2 text-sm font-medium text-gray-900">
                    معرف الفيديو في Bunny
                </label>
                <input type="text" id="bunny_video_id" value="{{ $video->bunny_video_id }}" disabled
                       class="bg-gray-100 border border-blue-300 text-gray-600 text-sm rounded-lg block w-full p-2.5 cursor-not-allowed">
                <input type="hidden" name="bunny_video_id" value="{{ $video->bunny_video_id }}">
                <p class="mt-1 text-xs text-gray-500">لا يمكن تغيير معرف الفيديو بعد الربط.</p>
            </div>

            <!-- عنوان الفيديو -->
            <div class="mb-5">
                <label for="title" class="block mb-2 text-sm font-medium text-gray-900">
                    عنوان الفيديو <span class="text-red-500">*</span>
                </label>
                <input type="text" id="title" name="title" value="{{ old('title', $video->title) }}" required
                       class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('title') border-red-500 @enderror"
                       placeholder="أدخل عنوان الفيديو">
                @error('title')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- وصف الفيديو -->
            <div class="mb-5">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900">
                    الوصف
                </label>
                <textarea id="description" name="description" rows="4"
                          class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('description') border-red-500 @enderror"
                          placeholder="أدخل وصف الفيديو (اختياري)">{{ old('description', $video->description) }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- ترتيب الفيديو -->
            <div class="mb-6">
                <label for="order" class="block mb-2 text-sm font-medium text-gray-900">
                    الترتيب
                </label>
                <input type="number" id="order" name="order" value="{{ old('order', $video->order) }}" min="0"
                       class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('order') border-red-500 @enderror"
                       placeholder="0">
                @error('order')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- أزرار الإجراءات -->
            <div class="flex items-center gap-3 border-t border-blue-200 pt-5">
                <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    تحديث الفيديو
                </button>
                <a href="{{ route('admin.videos.index') }}"
                   class="inline-flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    إلغاء والعودة
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
