<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #0b1c2d, #020617);
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #f97316; }
    </style>

    @stack('styles')
</head>
<body class="bg-[#020617] text-white font-sans antialiased overflow-hidden">

<div class="flex h-screen overflow-hidden relative">

    {{-- SIDEBAR: Tambahkan z-50 agar pasti paling atas --}}
    <aside id="sidebar"
        class="w-64 transition-all duration-300
               bg-[#050B1E] border-r border-slate-800
               flex flex-col relative z-50 h-full flex-shrink-0">

        <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800">
            <div class="flex items-center gap-3 overflow-hidden whitespace-nowrap">
                {{-- Pastikan gambar ada, jika error ganti asset ke link placeholder --}}
                <img src="{{ asset('images/aphixlogo.jpg') }}"
                     onerror="this.src='https://ui-avatars.com/api/?name=A+P&background=orange&color=fff'"
                     alt="Aphix Logo"
                     class="w-10 h-10 rounded-lg object-cover shrink-0 border border-slate-700">

                <div class="sidebar-text transition-opacity duration-300">
                    <span class="text-white font-bold text-lg tracking-wide">APHIX</span>
                    <span class="text-[10px] text-orange-400 block -mt-1 tracking-widest">ADMIN PANEL</span>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

            <p class="px-2 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 sidebar-text">Main Menu</p>

            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 group
                      {{ request()->routeIs('admin.dashboard') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-house w-5 text-center transition-transform group-hover:scale-110"></i>
                <span class="sidebar-text font-medium">Dashboard</span>
            </a>

            <a href="{{ route('admin.users') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 group
                      {{ request()->routeIs('admin.users') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-users w-5 text-center transition-transform group-hover:scale-110"></i>
                <span class="sidebar-text font-medium">Users</span>
            </a>

            <a href="{{ route('admin.eraport.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 group
                      {{ request()->routeIs('admin.eraport.*') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-file-signature w-5 text-center transition-transform group-hover:scale-110"></i>
                <span class="sidebar-text font-medium">E-Rapor</span>
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 group
                      {{ request()->routeIs('admin.orders.*') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-camera-retro w-5 text-center transition-transform group-hover:scale-110"></i>
                <span class="sidebar-text font-medium">Order Foto</span>
            </a>

            <a href="{{ route('admin.photos.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 group
                     {{ request()->routeIs('admin.photos.*') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-images w-5 text-center transition-transform group-hover:scale-110"></i>
                <span class="sidebar-text font-medium">Galeri Foto</span>
            </a>

            <a href="{{ route('admin.landing_gallery.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 group
                      {{ request()->routeIs('admin.landing_gallery.*') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-images w-5 text-center transition-transform group-hover:scale-110"></i>
                <span class="sidebar-text font-medium">Landing Gallery</span>
            </a>

            {{-- PERBAIKAN: Ganti routeIs menjadi admin.pom.* agar menu menyala saat diklik --}}
            <a href="{{ route('admin.pom.index') }}"
               class="flex items-center gap-4 px-4 py-3 rounded-xl transition-all duration-200 group
                      {{ request()->routeIs('admin.pom.*') ? 'bg-orange-500 text-white shadow-lg shadow-orange-500/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">
                <i class="fa-solid fa-trophy w-5 text-center transition-transform group-hover:scale-110"></i>
                <span class="sidebar-text font-medium">Player of the Month</span>
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800 space-y-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-4 px-4 py-2 rounded-lg text-red-400 hover:bg-red-500/10 hover:text-red-300 transition group">
                    <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                    <span class="sidebar-text text-sm font-medium">Logout</span>
                </button>
            </form>

            <button onclick="toggleSidebar()"
                class="w-full flex items-center justify-center gap-2 p-2 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition">
                <i class="fa-solid fa-bars"></i>
                <span class="sidebar-text text-sm">Close</span>
            </button>
        </div>
    </aside>

    {{-- CONTENT WRAPPER: Tambahkan z-0 untuk membuat stacking context baru --}}
    <div class="flex-1 flex flex-col h-full overflow-hidden relative z-0">

        <header class="bg-[#050B1E]/80 backdrop-blur-md border-b border-slate-800 h-16 flex items-center px-6 md:hidden z-40 sticky top-0">
             <button onclick="toggleSidebar()" class="text-slate-400 hover:text-white">
                <i class="fa-solid fa-bars text-xl"></i>
            </button>
            <span class="ml-4 font-bold text-white">APHIX ADMIN</span>
        </header>

        {{-- MAIN CONTENT: relative dan z-auto --}}
        <main id="mainContent" class="flex-1 overflow-y-auto p-4 md:p-8 relative">
            @yield('content')
        </main>

    </div>

</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const texts = document.querySelectorAll('.sidebar-text');

        // Cek lebar sidebar saat ini
        if (sidebar.classList.contains('w-64')) {
            // Tutup Sidebar (Mini Mode)
            sidebar.classList.remove('w-64');
            sidebar.classList.add('w-20');

            // Sembunyikan Teks
            texts.forEach(el => el.classList.add('hidden'));
        } else {
            // Buka Sidebar (Full Mode)
            sidebar.classList.remove('w-20');
            sidebar.classList.add('w-64');

            // Tampilkan Teks
            texts.forEach(el => el.classList.remove('hidden'));
        }
    }
</script>

@stack('scripts')

</body>
</html>
