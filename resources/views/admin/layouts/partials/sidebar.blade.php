<aside id="top-bar-sidebar"
    class="fixed top-30 right-0 z-40 w-64 h-full transition-transform translate-x-full sm:translate-x-0 rtl:translate-x-0 rtl:sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-blue-100/20 border-s border-blue-500">
        <ul class="space-y-2 font-medium">
            <!-- لوحة التحكم -->
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                    <svg class="w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M9 5v14M5 8h14M5 12h14M5 16h14M3 5h18v14H3V5Z" />
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M5 8h14M5 12h14M5 16h14" />
                    </svg>
                    <span class="ms-3">لوحة التحكم</span>
                </a>
            </li>
            
            <!-- المستويات -->
            <li>
                <a href="{{ route('admin.levels.index') }}"
                    class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                    <svg class="w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M4 7h16M4 12h16M4 17h10" />
                        <rect width="2" height="2" x="18" y="16" fill="currentColor" rx="1" />
                        <rect width="2" height="2" x="14" y="11" fill="currentColor" rx="1" />
                        <rect width="2" height="2" x="10" y="6" fill="currentColor" rx="1" />
                    </svg>
                    <span class="ms-3">المستويات</span>
                </a>
            </li>
            
            <!-- الكوبونات -->
            <li>
                <a href="{{ route('admin.coupons.index') }}"
                    class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                    <svg class="w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M6 5h12a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                        <circle cx="9" cy="9" r="1" fill="currentColor" />
                        <circle cx="15" cy="15" r="1" fill="currentColor" />
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="m8 15 8-8" />
                    </svg>
                    <span class="ms-3">الكوبونات</span>
                </a>
            </li>
            
            <!-- الفيديوهات -->
            <li>
                <a href="{{ route('admin.videos.index') }}"
                    class="flex items-center px-2 py-1.5 text-body rounded-base hover:bg-neutral-tertiary hover:text-fg-brand group">
                    <svg class="w-5 h-5 transition duration-75 group-hover:text-fg-brand" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M19 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1Z" />
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M8 8h8M8 12h6M8 16h4" />
                        <circle cx="16" cy="16" r="2" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="m18 14 2-2" />
                    </svg>
                    <span class="ms-3">الفيديوهات</span>
                </a>
            </li>
        </ul>
    </div>
</aside>