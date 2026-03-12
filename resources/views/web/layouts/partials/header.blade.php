@php
    use Illuminate\Support\Facades\Auth;
@endphp
<header class="bg-neutral-primary fixed w-full z-20 top-0 start-0 border-b border-blue-500 shadow shadow-blue-200">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="https://berna-violin.art/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('public/assets/img/logo.png') }}" class="h-16" alt="Berna Logo" />
        </a>
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            <button type="button"
                class="flex text-sm bg-neutral-primary cursor-pointer rounded-full md:me-0 focus:ring-4 focus:ring-neutral-tertiary"
                id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                data-dropdown-placement="bottom">
                <span class="sr-only">فتح قائمة المستخدم</span>
                <p class="w-12 h-12 rounded-full bg-blue-300 text-white flex items-center justify-center">
                    {{ Auth::user()->name[0] }}
                </p>
            </button>
            <!-- Dropdown menu -->
            <div class="z-50 hidden bg-neutral-primary-medium border border-blue-500 rounded-base shadow-lg w-44"
                id="user-dropdown">
                <div class="px-4 py-3 text-sm border-b border-blue-500">
                    <span class="block text-heading font-medium">{{ Auth::user()->name }}</span>
                    <span class="block text-body truncate">
                        {{ Auth::user()->email ? Auth::user()->email : Auth::user()->phone }}
                    </span>
                </div>
                <ul class="p-2 text-sm text-body font-medium" aria-labelledby="user-menu-button">
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">
                            لوحة التحكم
                        </a>
                    </li>
                    {{-- <li>
                        <a href="#"
                            class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded">ملفي
                            الشخصي
                        </a>
                    </li> --}}
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="cursor-pointer inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded"
                                role="menuitem">تسجيل الخروج</button>
                        </form>
                    </li>
                </ul>
            </div>
            <button data-collapse-toggle="navbar-user" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-body rounded-base md:hidden hover:bg-neutral-secondary-soft hover:text-heading focus:outline-none focus:ring-2 focus:ring-neutral-tertiary"
                aria-controls="navbar-user" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M5 7h14M5 12h14M5 17h14" />
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
            <ul
                class="font-medium flex flex-col gap-3 p-4 md:p-0 mt-4 border border-blue-500 rounded-base bg-neutral-secondary-soft md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-neutral-primary">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="block py-2 px-3 rounded md:p-0
       {{ request()->routeIs('dashboard')
           ? 'text-white bg-brand md:bg-transparent md:text-fg-brand'
           : 'text-heading hover:bg-neutral-tertiary md:hover:bg-transparent md:hover:text-fg-brand' }}">
                        الصفحة الرئيسية
                    </a>
                </li>

                <li>
                    <a href="https://berna-violin.art/"
                        class="block py-2 px-3 rounded md:p-0
       {{ request()->is('/')
           ? 'text-white bg-brand md:bg-transparent md:text-fg-brand'
           : 'text-heading hover:bg-neutral-tertiary md:hover:bg-transparent md:hover:text-fg-brand' }}">
                        الخدمات
                    </a>
                </li>

                <li>
                    <a href="{{ route('level.index') }}"
                        class="block py-2 px-3 rounded md:p-0
       {{ request()->routeIs('level.*')
           ? 'text-white bg-brand md:bg-transparent md:text-fg-brand'
           : 'text-heading hover:bg-neutral-tertiary md:hover:bg-transparent md:hover:text-fg-brand' }}">
                        الدورات
                    </a>
                </li>

                <li>
                    <a href="https://berna-violin.art"
                        class="block py-2 px-3 rounded md:p-0
       {{ request()->is('contact')
           ? 'text-white bg-brand md:bg-transparent md:text-fg-brand'
           : 'text-heading hover:bg-neutral-tertiary md:hover:bg-transparent md:hover:text-fg-brand' }}">
                        تواصل
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>
