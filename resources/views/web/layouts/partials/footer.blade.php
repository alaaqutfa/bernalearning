<footer class="bg-neutral-primary-soft rounded-base shadow-xs border border-blue-500 m-4">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="https://berna-violin.art/" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('public/assets/img/logo.png') }}" class="h-24" alt="Flowbite Logo" />
            </a>
            <ul class="flex flex-wrap gap-3 items-center mb-6 text-sm font-medium text-body sm:mb-0">
                <li>
                    <a href="https://berna-violin.art/" class="hover:underline me-4 md:me-6">الخدمات</a>
                </li>
                <li>
                    <a href="https://berna-violin.art/" class="hover:underline me-4 md:me-6">الدورات</a>
                </li>
                <li>
                    <a href="https://berna-violin.art/" class="hover:underline">أحجز موعداً</a>
                </li>
                <li>
                    <a href="{{ route('privacy') }}" class="hover:underline me-4 md:me-6">سياسة الخصوصية</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-blue-500 sm:mx-auto lg:my-8" />
        <span class="block text-sm text-body sm:text-center">© 2026 <a href="{{ route('privacy') }}"
                class="hover:underline">{{ config('app.name') }}</a>. All Rights Reserved.</span>
    </div>
</footer>
