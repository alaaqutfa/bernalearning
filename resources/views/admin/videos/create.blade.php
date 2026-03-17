@extends('admin.layouts.app')

@section('title', 'إضافة فيديو جديد')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">إضافة فيديو جديد</h1>
            <p class="text-gray-600 mt-1">قم باختيار فيديو من مكتبة Bunny وربطه بمستوى</p>
        </div>

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-sm border border-blue-500 overflow-hidden">
            <form method="POST" action="{{ route('admin.videos.store') }}" class="p-6">
                @csrf

                <!-- اختيار المستوى -->
                <div class="mb-5">
                    <label for="level_id" class="block mb-2 text-sm font-medium text-gray-900">
                        المستوى <span class="text-red-500">*</span>
                    </label>
                    <select name="level_id" id="level_id" required
                        class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('level_id') border-red-500 @enderror">
                        <option value="">اختر المستوى</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}"
                                {{ old('level_id', $selectedLevel) == $level->id ? 'selected' : '' }}>
                                {{ $level->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('level_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- اختيار فيديو من Bunny -->
                <div class="mb-5">
                    <label for="bunny_video_id" class="block mb-2 text-sm font-medium text-gray-900">
                        فيديو Bunny <span class="text-red-500">*</span>
                    </label>
                    <select name="bunny_video_id" id="bunny_video_id" required
                        class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('bunny_video_id') border-red-500 @enderror">
                        <option value="">اختر فيديو</option>
                        @foreach ($availableVideos as $video)
                            <option value="{{ $video['guid'] }}" data-title="{{ $video['title'] }}"
                                data-length="{{ $video['length'] }}">
                                {{ $video['title'] }} ({{ gmdate('i:s', $video['length']) }})
                            </option>
                        @endforeach
                    </select>
                    @error('bunny_video_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">اختر فيديو من القائمة. الفيديوهات المعروضة غير مرتبطة مسبقاً.</p>
                </div>

                <!-- عنوان الفيديو (يمكن تعديله) -->
                <div class="mb-5">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900">
                        عنوان الفيديو <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
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
                        placeholder="أدخل وصف الفيديو (اختياري)">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ترتيب الفيديو -->
                <div class="mb-6">
                    <label for="order" class="block mb-2 text-sm font-medium text-gray-900">
                        الترتيب
                    </label>
                    <input type="number" id="order" name="order" value="{{ old('order', 0) }}" min="0"
                        class="bg-gray-50 border border-blue-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('order') border-red-500 @enderror"
                        placeholder="0">
                    @error('order')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">تحديد ترتيب ظهور الفيديو ضمن المستوى (الأصغر يظهر أولاً).</p>
                </div>

                <!-- أزرار الإجراءات -->
                <div class="flex items-center gap-3 border-t border-blue-200 pt-5">
                    <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm transition">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        حفظ الفيديو
                    </button>
                    <a href="{{ route('admin.videos.index') }}"
                        class="inline-flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition">
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

    @push('scripts')
        <script>
            document.getElementById('bunny_video_id').addEventListener('change', function() {
                var selected = this.options[this.selectedIndex];
                var titleInput = document.getElementById('title');
                // إذا كان حقل العنوان فارغاً، نملأه بعنوان الفيديو من Bunny
                if (!titleInput.value.trim() && selected.dataset.title) {
                    titleInput.value = selected.dataset.title;
                }
            });
        </script>
    @endpush
@endsection
