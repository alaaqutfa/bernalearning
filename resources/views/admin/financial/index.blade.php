@extends('admin.layouts.app')

@section('title', 'التقارير المالية')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- رأس الصفحة مع تحديد الشهر والسنة -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">التقارير المالية</h1>
            <div class="flex gap-2">
                <form method="GET" class="flex gap-2">
                    <select name="month" class="w-32 border border-gray-300 rounded-lg px-3 py-2">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                            </option>
                        @endfor
                    </select>
                    <select name="year" class="w-24 border border-gray-300 rounded-lg px-3 py-2">
                        @for ($y = date('Y') - 2; $y <= date('Y'); $y++)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}
                            </option>
                        @endfor
                    </select>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">عرض</button>
                </form>
                <a href="{{ route('admin.financial.yearly', $year) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg">
                    تقرير سنوي
                </a>
            </div>
        </div>

        <!-- بطاقات الملخص -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- إجمالي الإيرادات -->
            <div class="bg-white rounded-lg shadow p-6 border-r-4 border-green-500">
                <h3 class="text-sm text-gray-500 mb-2">إجمالي الإيرادات</h3>
                <p class="text-2xl font-bold text-green-600">${{ number_format($totalRevenue, 2) }}</p>
                <p class="text-xs text-gray-400 mt-2">{{ $year }}/{{ $month }}</p>
            </div>

            <!-- إجمالي المصاريف -->
            <div class="bg-white rounded-lg shadow p-6 border-r-4 border-red-500">
                <h3 class="text-sm text-gray-500 mb-2">إجمالي المصاريف</h3>
                <p class="text-2xl font-bold text-red-600">${{ number_format($totalExpenses, 2) }}</p>
                <p class="text-xs text-gray-400 mt-2">شامل جميع المصاريف</p>
            </div>

            <!-- تكاليف Bunny -->
            <div class="bg-white rounded-lg shadow p-6 border-r-4 border-purple-500">
                <h3 class="text-sm text-gray-500 mb-2">تكاليف Bunny.net</h3>
                <p class="text-2xl font-bold text-purple-600">${{ number_format($bunnyCosts, 2) }}</p>
                <p class="text-xs text-gray-400 mt-2">تخزين + مشاهدات</p>
                {{-- <p class="text-xs text-gray-400 mt-2">
                    تخزين: {{ number_format($storageGB, 2) }} GB × 0.06$<br>
                    نقل: {{ number_format($bandwidthGB, 2) }} GB × 0.06$
                </p> --}}
            </div>

            <!-- صافي الربح -->
            <div class="bg-white rounded-lg shadow p-6 border-r-4 border-blue-500">
                <h3 class="text-sm text-gray-500 mb-2">صافي الربح</h3>
                <p class="text-2xl font-bold text-blue-600">${{ number_format($netProfit, 2) }}</p>
                <p class="text-xs text-gray-400 mt-2">بعد خصم جميع التكاليف</p>
            </div>
        </div>

        <!-- توزيع الأرباح -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold mb-4">توزيع الأرباح (قبل المصاريف)</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 bg-purple-50 rounded">
                        <span class="font-medium">أرباح المالك (75%)</span>
                        <span class="text-purple-600 font-bold">${{ number_format($profitOwnerTotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-blue-50 rounded">
                        <span class="font-medium">أرباح المطور (25%)</span>
                        <span class="text-blue-600 font-bold">${{ number_format($profitDeveloperTotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                        <span class="font-medium">الإجمالي</span>
                        <span class="text-gray-600 font-bold">${{ number_format($totalRevenue, 2) }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold mb-4">توزيع الأرباح (بعد المصاريف)</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 bg-purple-50 rounded">
                        <span class="font-medium">صافي أرباح المالك</span>
                        <span class="text-purple-600 font-bold">${{ number_format($netProfitOwner, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-blue-50 rounded">
                        <span class="font-medium">صافي أرباح المطور</span>
                        <span class="text-blue-600 font-bold">${{ number_format($netProfitDeveloper, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                        <span class="font-medium">صافي الربح الكلي</span>
                        <span class="text-gray-600 font-bold">${{ number_format($netProfit, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- إحصائيات المشاهدات -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h3 class="text-lg font-bold mb-4">إحصائيات المشاهدات</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <p class="text-2xl font-bold text-gray-700">{{ number_format($viewStats->total_views ?? 0) }}</p>
                    <p class="text-sm text-gray-500">إجمالي المشاهدات</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-gray-700">{{ number_format($viewStats->unique_viewers ?? 0) }}</p>
                    <p class="text-sm text-gray-500">مشاهدين فريدين</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-gray-700">{{ gmdate('H:i:s', $viewStats->total_watch_time ?? 0) }}
                    </p>
                    <p class="text-sm text-gray-500">إجمالي وقت المشاهدة</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-bold text-gray-700">{{ number_format($viewStats->total_bandwidth ?? 0, 2) }} GB
                    </p>
                    <p class="text-sm text-gray-500">استهلاك bandwidth</p>
                </div>
            </div>
        </div>

        <!-- مصاريف الشهر -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold">مصاريف الشهر</h3>
                <button onclick="openExpenseModal()" class="bg-green-600 text-white px-3 py-1 rounded text-sm">
                    + إضافة مصروف
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">التاريخ</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">العنوان</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">النوع</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">المبلغ</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($expenses as $expense)
                            <tr>
                                <td class="px-6 py-4">{{ $expense->expense_date->format('Y-m-d') }}</td>
                                <td class="px-6 py-4">{{ $expense->title }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 text-xs rounded-full
                                            @if ($expense->type == 'hosting') bg-blue-100 text-blue-800
                                            @elseif($expense->type == 'domain') bg-green-100 text-green-800
                                            @elseif($expense->type == 'bunny_cdn') bg-purple-100 text-purple-800
                                            @elseif($expense->type == 'marketing') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                        @switch($expense->type)
                                            @case('hosting')
                                                استضافة
                                            @break

                                            @case('domain')
                                                دومين
                                            @break

                                            @case('bunny_cdn')
                                                Bunny.net
                                            @break

                                            @case('marketing')
                                                تسويق
                                            @break

                                            @default
                                                أخرى
                                        @endswitch
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-bold">${{ number_format($expense->amount, 2) }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin.financial.expenses.destroy', $expense) }}" method="POST"
                                        class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" onclick="return confirm('هل أنت متأكد؟')"
                                            class="text-red-600 hover:text-red-900">
                                            <svg class="w-5 h-5 inline" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">لا توجد مصاريف لهذا الشهر
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- مودال إضافة مصروف -->
            <div id="expenseModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
                <div class="bg-white rounded-lg p-8 max-w-md w-full">
                    <h3 class="text-xl font-bold mb-4">إضافة مصروف جديد</h3>
                    <form method="POST" action="{{ route('admin.financial.expenses.store') }}">
                        @csrf
                        <input type="hidden" name="expense_date"
                            value="{{ $year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}-01">

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">العنوان</label>
                            <input type="text" name="title" required class="w-full border rounded-lg px-3 py-2">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">المبلغ ($)</label>
                            <input type="number" step="0.01" name="amount" required
                                class="w-full border rounded-lg px-3 py-2">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">النوع</label>
                            <select name="type" class="w-full border rounded-lg px-3 py-2">
                                <option value="hosting">استضافة</option>
                                <option value="domain">دومين</option>
                                <option value="bunny_cdn">Bunny.net</option>
                                <option value="marketing">تسويق</option>
                                <option value="other">أخرى</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">الوصف</label>
                            <textarea name="description" rows="3" class="w-full border rounded-lg px-3 py-2"></textarea>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" onclick="closeExpenseModal()"
                                class="px-4 py-2 bg-gray-300 rounded">إلغاء</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            function openExpenseModal() {
                document.getElementById('expenseModal').classList.remove('hidden');
                document.getElementById('expenseModal').classList.add('flex');
            }

            function closeExpenseModal() {
                document.getElementById('expenseModal').classList.add('hidden');
                document.getElementById('expenseModal').classList.remove('flex');
            }
        </script>
    @endpush
