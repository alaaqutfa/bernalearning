@extends('admin.layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">لوحة التحكم</h1>

        <!-- بطاقات الإحصائيات باستخدام Flowbite -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <!-- إجمالي الزيارات -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
                <div class="flex justify-center items-center gap-4">
                    <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                            <path fill-rule="evenodd"
                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="mr-4 rtl:mr-0 rtl:ml-4">
                        <p class="text-sm text-gray-500">إجمالي الزيارات</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalVisitors }}</p>
                    </div>
                </div>
            </div>

            <!-- زوار فريدون -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
                <div class="flex justify-center items-center gap-4">
                    <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z">
                            </path>
                        </svg>
                    </div>
                    <div class="mr-4 rtl:mr-0 rtl:ml-4">
                        <p class="text-sm text-gray-500">زوار فريدون</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $uniqueVisitors }}</p>
                    </div>
                </div>
            </div>

            <!-- الطلاب المسجلين -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
                <div class="flex justify-center items-center gap-4">
                    <div class="flex-shrink-0 bg-yellow-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838l-4 1.714c-.028.012-.057.024-.084.036l2.935 1.491a1 1 0 01.553.894v2.465a.75.75 0 01-1.5 0v-2.124l-2.75-1.396v2.393a1 1 0 00.553.894l4.5 2.25a1 1 0 00.894 0l4.5-2.25a1 1 0 00.553-.894v-2.393l2.75 1.396v2.124a.75.75 0 01-1.5 0v-2.465a1 1 0 01.553-.894l2.935-1.491a.992.992 0 01-.084-.036l-4-1.714a1 1 0 11.788-1.838l4 1.714c.13.056.248.13.356.257l2.106-1.131a1 1 0 000-1.84l-7-3z">
                            </path>
                        </svg>
                    </div>
                    <div class="mr-4 rtl:mr-0 rtl:ml-4">
                        <p class="text-sm text-gray-500">الطلاب المسجلين</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $students }}</p>
                    </div>
                </div>
            </div>

            <!-- الدورات المتاحة -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-red-500">
                <div class="flex justify-center items-center gap-4">
                    <div class="flex-shrink-0 bg-red-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z">
                            </path>
                        </svg>
                    </div>
                    <div class="mr-4 rtl:mr-0 rtl:ml-4">
                        <p class="text-sm text-gray-500">الدورات المتاحة</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $levelsCount }}</p>
                    </div>
                </div>
            </div>

            <!-- كوبونات مباعة -->
            <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
                <div class="flex justify-center items-center gap-4">
                    <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                        <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 2a2 2 0 00-2 2v14l3.5-2 3.5 2 3.5-2 3.5 2V4a2 2 0 00-2-2H5zm2.5 3a1.5 1.5 0 100 3 1.5 1.5 0 000-3zm6.207.293a1 1 0 00-1.414 0l-6 6a1 1 0 101.414 1.414l6-6a1 1 0 000-1.414zM14 10.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="mr-4 rtl:mr-0 rtl:ml-4">
                        <p class="text-sm text-gray-500">كوبونات مباعة</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $couponsSold }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- الرسم البياني -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">الزيارات اليومية (آخر 30 يوم)</h2>
            <canvas id="visitorsChart" class="w-full h-64"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('visitorsChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($visitorsChart->pluck('date')->toArray()) !!},
                    datasets: [{
                        label: 'عدد الزيارات اليومية',
                        data: {!! json_encode($visitorsChart->pluck('views')->toArray()) !!},
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.3,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(156, 163, 175, 0.2)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
