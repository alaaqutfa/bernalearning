@extends('admin.layouts.app')

@section('title', 'إضافة اشتراك للمستخدم')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">إضافة اشتراك جديد</h1>
            <p class="text-gray-600 mt-1">للمستخدم: {{ $user->email ?? $user->phone }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-blue-500 overflow-hidden max-w-2xl">
            <form method="POST" action="{{ route('admin.users.store-coupon', $user) }}" class="p-6">
                @csrf
                <div class="mb-6">
                    <label for="level_id" class="block mb-2 text-sm font-medium text-gray-900">
                        اختر المستوى <span class="text-red-500">*</span>
                    </label>
                    <select name="level_id" id="level_id" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                        <option value="">-- اختر مستوى --</option>
                        @foreach ($levels as $level)
                            <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>
                                {{ $level->title }} - ${{ number_format($level->price, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('level_id')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3 border-t border-blue-200 pt-5">
                    <button type="submit"
                        class="inline-flex items-center px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg text-sm transition-colors duration-200">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        إضافة الاشتراك
                    </button>
                    <a href="{{ route('admin.users.show', $user) }}"
                        class="inline-flex items-center px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg text-sm transition-colors duration-200">
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        إلغاء
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
