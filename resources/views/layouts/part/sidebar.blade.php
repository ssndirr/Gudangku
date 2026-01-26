<aside id="sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full lg:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
        <!-- Logo & Brand -->
        <div class="flex items-center justify-center mb-6 pb-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center w-10 h-10 bg-indigo-100 dark:bg-indigo-900 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900 dark:text-white">GudangKu</h1>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Inventaris</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <ul class="space-y-2 font-medium">
            <!-- Dashboard -->
            <li>
            <a href="{{ route('dashboard') }}" 
            class="flex items-center p-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900 dark:text-indigo-400' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }} group">
                <!-- Icon chart misalnya -->
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M11 3v10h10M3 17h18M5 21h14" />
                </svg>
                <span class="ml-3">Dashboard</span>
             </a>
             </li>


            <!-- User -->
            <li>
                <a href="{{route('users.index')}}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('user.*') ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900 dark:text-indigo-400' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }} group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="ml-3">User</span>
                </a>
            </li>

            <!-- Kategori -->
            <li>
                <a href="{{route('kategori.index')}}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('kategori.*') ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900 dark:text-indigo-400' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }} group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span class="ml-3">Kategori</span>
                </a>
            </li>

            <!-- Ruangan -->
            <li>
                <a href="{{route('ruangan.index')}}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('ruangan.*') ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900 dark:text-indigo-400' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }} group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span class="ml-3">Ruangan</span>
                </a>
            </li>

            <!-- Barang -->
            <li>
                <a href="{{route('barang.index')}}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('barang.index') || request()->routeIs('barang.show') || request()->routeIs('barang.edit') || request()->routeIs('barang.create') ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900 dark:text-indigo-400' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }} group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span class="ml-3">Barang</span>
                </a>
            </li>

            <!-- Divider -->
            <li class="pt-4 mt-4 space-y-2 border-t border-gray-200 dark:border-gray-700">
                <span class="text-xs font-semibold text-gray-400 uppercase dark:text-gray-500 px-2">Transaksi</span>
            </li>

            <!-- Barang Masuk -->
            <li>
                <a href="{{route('barangmasuk.index')}}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('barang-masuk.*') ? 'bg-green-50 text-green-600 dark:bg-green-900 dark:text-green-400' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }} group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                    </svg>
                    <span class="ml-3">Barang Masuk</span>
                </a>
            </li>

            <!-- Barang Keluar -->
            <li>
                <a href="{{route('barangkeluar.index')}}" class="flex items-center p-2 rounded-lg {{ request()->routeIs('barang-keluar.*') ? 'bg-red-50 text-red-600 dark:bg-red-900 dark:text-red-400' : 'text-gray-900 dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700' }} group">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                    </svg>
                    <span class="ml-3">Barang Keluar</span>
                </a>
            </li>
        </ul>

        <!-- User Info (Bottom) -->
        <div class="absolute bottom-4 left-0 right-0 px-3">
            <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900 rounded-full flex items-center justify-center">
                            <span class="text-indigo-600 dark:text-indigo-400 font-semibold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                            {{ Auth::user()->name }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                            {{ Auth::user()->email }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- Mobile Sidebar Toggle Button -->
<button data-drawer-target="sidebar" data-drawer-toggle="sidebar" aria-controls="sidebar" type="button" class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
    </svg>
</button>

<script>
// Toggle sidebar on mobile
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const toggleButton = document.querySelector('[data-drawer-toggle="sidebar"]');
    
    if (toggleButton) {
        toggleButton.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
        });
    }

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isClickOnToggle = toggleButton && toggleButton.contains(event.target);
        
        if (!isClickInsideSidebar && !isClickOnToggle && window.innerWidth < 1024) {
            sidebar.classList.add('-translate-x-full');
        }
    });
});
</script>
