<header class="fixed top-0 z-50 w-full bg-blue-100/20 border-b border-blue-500">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                <button data-drawer-target="top-bar-sidebar" data-drawer-toggle="top-bar-sidebar"
                    aria-controls="top-bar-sidebar" type="button"
                    class="sm:hidden text-heading bg-transparent box-border border border-transparent hover:bg-neutral-secondary-medium focus:ring-4 focus:ring-neutral-tertiary font-medium leading-5 rounded-base text-sm p-2 focus:outline-none">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                            d="M5 7h14M5 12h14M5 17h10" />
                    </svg>
                </button>
                <a href="{{ route('admin.dashboard') }}" class="flex ms-2 md:me-24">
                    <img src="{{ asset('public/assets/img/logo.png') }}" class="h-24" alt="Berna Logo" />
                </a>
            </div>
            <div class="flex items-center">
                <div class="flex items-center ms-3">
                    <div>
                        <button type="button"
                            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                            aria-expanded="false" data-dropdown-toggle="dropdown-user">
                            <span class="sr-only">فتح قائمة المستخدم</span>
                            <p class="w-8 h-8 rounded-full bg-blue-300 text-white flex items-center justify-center">
                                {{ Auth::user()->name[0] }}
                            </p>
                        </button>
                    </div>
                    <div class="z-50 hidden bg-neutral-primary-medium border border-blue-500 rounded-base shadow-lg w-44"
                        id="dropdown-user">
                        <div class="px-4 py-3 border-b border-blue-500" role="none">
                            <p class="text-sm font-medium text-heading" role="none">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="text-sm text-body truncate" role="none">
                                {{ Auth::user()->email ? Auth::user()->email : Auth::user()->phone }}
                            </p>
                        </div>
                        <ul class="p-2 text-sm text-body font-medium" role="none">
                            <li>
                                <a href="{{ route('admin.dashboard') }}"
                                    class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded"
                                    role="menuitem">
                                    لوحة التحكم
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    class="inline-flex items-center w-full p-2 hover:bg-neutral-tertiary-medium hover:text-heading rounded"
                                    role="menuitem">تسجيل الخروج</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
