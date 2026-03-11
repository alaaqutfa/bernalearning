@extends('admin.layouts.app')

@section('title', 'إدارة الفيديوهات')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- رأس الصفحة مع فلتر المستوى وزر الإضافة -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
            <h1 class="text-2xl font-bold text-gray-800">إدارة الفيديوهات</h1>

            <div class="flex flex-wrap gap-3">
                <!-- فلتر المستوى -->
                <form method="GET" class="flex gap-2">
                    <select name="level_id" onchange="this.form.submit()" class="border border-blue-300 rounded-lg px-3 py-2">
                        <option value="">جميع المستويات</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}" {{ $levelId == $level->id ? 'selected' : '' }}>
                                {{ $level->title }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <!-- زر إضافة فيديو جديد -->
                <a href="{{ route('admin.videos.create', ['level_id' => $levelId]) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    إضافة فيديو جديد
                </a>
            </div>
        </div>

        <!-- رسالة النجاح -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <!-- جدول الفيديوهات -->
        <div class="bg-white rounded-lg shadow-sm border border-blue-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-blue-200">
                    <thead class="bg-blue-50">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">#</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">الصورة المصغرة</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">العنوان</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">المستوى</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">معرف Bunny</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">الترتيب</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-blue-200">
                        @forelse($videos as $video)
                            @php
                                $thumbUrl = $bunny->signedThumbnailUrl($video->bunny_video_id, 2592000);
                            @endphp
                            <tr class="hover:bg-blue-50">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $video->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img src="{{ $thumbUrl }}" alt="{{ $vid->title }}"
                                        class="w-40 h-24 object-cover rounded">
                                </td>
                                <td class="px-6 py-4">{{ $video->title }}</td>
                                <td class="px-6 py-4">{{ $video->level->title }}</td>
                                <td class="px-6 py-4 text-xs text-gray-500">{{ $video->bunny_video_id }}</td>
                                <td class="px-6 py-4">{{ $video->order }}</td>
                                <td class="px-6 py-4 whitespace-nowrap space-x-2 space-x-reverse">
                                    <a href="{{ route('admin.videos.edit', $video) }}"
                                        class="inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-sm rounded-md transition">
                                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                        تعديل
                                    </a>
                                    <form action="{{ route('admin.videos.destroy', $video) }}" method="POST"
                                        class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('هل أنت متأكد من حذف هذا الفيديو؟')"
                                            class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-sm rounded-md transition">
                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                            حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        <p class="text-lg font-medium">لا توجد فيديوهات مضافة بعد</p>
                                        <a href="{{ route('admin.videos.create') }}"
                                            class="mt-3 text-blue-600 hover:text-blue-800">
                                            اضغط هنا لإضافة فيديو جديد
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
