<nav x-data="{ open: false }"
     class="bg-[#0B1C2D] border-b border-orange-500/20 fixed w-full z-50">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT -->
            <div class="flex items-center gap-8">
                <!-- LOGO -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                    <img src="/images/aphixlogo.jpg"
                         class="w-10 h-10 rounded-full ring-2 ring-orange-500"
                         alt="Aphix Logo">

                    <span class="hidden sm:block text-white font-bold tracking-wide">
                        APHIX PRIVATE
                    </span>
                </a>

                <!-- DESKTOP MENU -->
                <div class="hidden sm:flex gap-6">
                    <a href="{{ route('dashboard') }}"
                       class="text-sm font-semibold transition
                       {{ request()->routeIs('dashboard')
                            ? 'text-orange-500'
                            : 'text-white hover:text-orange-500' }}">
                        Beranda
                    </a>
                </div>
            </div>

            <!-- RIGHT -->
            <div class="hidden sm:flex items-center">
                <div x-data="{ openProfile: false }" class="relative">
                    <button
                        @click="openProfile = !openProfile"
                        class="flex items-center gap-2 px-4 py-2 rounded-full
                               bg-orange-500 text-[#0B1C2D] font-semibold
                               hover:bg-orange-400 transition"
                    >
                        {{ Auth::user()->name }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <!-- DROPDOWN -->
                    <div
                        x-show="openProfile"
                        @click.outside="openProfile = false"
                        x-transition
                        class="absolute right-0 mt-3 w-48 rounded-xl overflow-hidden
                               bg-[#10283F] border border-orange-500/30 shadow-2xl"
                        style="display:none"
                    >
                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-3 text-sm text-white hover:bg-orange-500/20 transition">
                            👤 Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-3 text-sm
                                       text-orange-400 hover:bg-orange-500/20 transition">
                                🚪 Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- HAMBURGER -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                        class="p-2 rounded-lg text-orange-500 hover:bg-orange-500/20 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- MOBILE -->
    <div x-show="open" x-transition class="sm:hidden bg-[#0B1C2D] border-t border-orange-500/20">
        <div class="px-4 py-4 space-y-2">
            <a href="{{ route('dashboard') }}"
               class="block px-4 py-3 rounded-lg text-white hover:bg-orange-500/20 transition">
                🏠 Beranda
            </a>

            <a href="{{ route('profile.edit') }}"
               class="block px-4 py-3 rounded-lg text-white hover:bg-orange-500/20 transition">
                👤 Profil
            </a>

            <a href="{{ route('eraport') }}"
               class="block px-4 py-3 rounded-lg text-white hover:bg-orange-500/20 transition">
               📊 E-Raport
            </a>


            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full text-left px-4 py-3 rounded-lg
                               text-orange-400 hover:bg-orange-500/20 transition">
                    🚪 Logout
                </button>
            </form>
        </div>
    </div>
</nav>
