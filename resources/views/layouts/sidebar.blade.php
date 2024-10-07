<aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
    <div class="p-6">
        <a href="{{ route('admin.dashboard') }}" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
    </div>
    <nav class="text-white text-base font-semibold pt-3">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard')}}" 
           class="flex items-center {{ request()->routeIs('admin.dashboard') ? 'active-nav-link' : 'opacity-75 hover:opacity-100' }} py-4 pl-6 nav-item">
            <i class="fas fa-tachometer-alt mr-3"></i>
            Dashboard
        </a>

        <!-- Tabel User -->
        <a href="{{ route('admin.users.index') }}" 
           class="flex items-center {{ request()->routeIs('admin.users.index') ? 'active-nav-link' : 'opacity-75 hover:opacity-100' }} py-4 pl-6 nav-item">
            <i class="fas fa-users mr-3"></i>
            Tabel User
        </a>

        <!-- Tabel Lapangan -->
        <a href="{{ route('admin.fields.index') }}" 
           class="flex items-center {{ request()->routeIs('admin.fields.index') ? 'active-nav-link' : 'opacity-75 hover:opacity-100' }} py-4 pl-6 nav-item">
            <i class="fas fa-table mr-3"></i>
            Tabel Lapangan
        </a>

        <!-- Log Out -->
        <a href="#" class="absolute w-full upgrade-btn bottom-0 active-nav-link text-white flex items-center justify-center py-4">
            <i class="fas fa-arrow-circle-up mr-3"></i>
            Log Out
        </a>
    </nav>
</aside>
