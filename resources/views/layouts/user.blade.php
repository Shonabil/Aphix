<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Aphix Private')</title>

    {{-- 1. Load Libraries --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Turbo Drive (Untuk Transisi Halaman Cepat/SPA) --}}
    <script type="module">
        import hotwiredTurbo from 'https://cdn.skypack.dev/@hotwired/turbo';
    </script>

    {{-- NProgress (Loading Bar Merah/Orange di atas) --}}
    <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/nprogress@0.2.0/nprogress.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: "#0B1C2D", accent: "#F97316" },
                    animation: { float: "float 3s ease-in-out infinite", "slide-up": "slideUp 0.5s ease-out" },
                    keyframes: {
                        float: { "0%, 100%": { transform: "translateY(0px)" }, "50%": { transform: "translateY(-10px)" } },
                        slideUp: { "0%": { opacity: "0", transform: "translateY(20px)" }, "100%": { opacity: "1", transform: "translateY(0)" } },
                    },
                },
            },
        };
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet" />

    <style>
        body { font-family: "Poppins", sans-serif; background: linear-gradient(135deg, #0b1c2d 0%, #1a3a52 100%); }
        .gradient-text { background: linear-gradient(135deg, #f97316 0%, #fb923c 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-8px) scale(1.02); box-shadow: 0 20px 40px rgba(249, 115, 22, 0.3); }
        .glass-effect { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); }
        #autoGallery { scrollbar-width: none; -ms-overflow-style: none; }
        #autoGallery::-webkit-scrollbar { display: none; }
        .gallery-img { min-width: 280px; height: 320px; object-fit: cover; border-radius: 1.5rem; box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4); border: 1px solid rgba(255, 255, 255, 0.1); }

        /* Kustomisasi Loading Bar */
        #nprogress .bar { background: #F97316 !important; height: 3px !important; }
        #nprogress .peg { box-shadow: 0 0 10px #F97316, 0 0 5px #F97316; }

        @media (min-width: 768px) {
            .gallery-img { min-width: 340px; height: 450px; }
            .animate-float { animation: float 6s ease-in-out infinite; }
            .reveal { opacity: 0; transform: translateY(40px); transition: all 0.8s ease; }
            .reveal.active { opacity: 1; transform: translateY(0); }
        }
    </style>
    @stack('styles')
</head>

<body class="bg-primary text-white overflow-x-hidden">


    <nav class="fixed top-0 w-full z-50 glass-effect px-6 py-4 animate-slide-up" data-turbo-permanent id="navbar">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-accent flex items-center justify-center">
                    {{-- Pastikan asset logo benar --}}
                    <img src="{{ asset('images/aphixlogo.jpg') }}" class="w-11 h-11 object-contain rounded-full" alt="Aphix Logo" />
                </div>
                <h1 class="text-2xl md:text-3xl font-bold text-white">APHIX PRIVATE</h1>
            </div>

            @guest
                {{-- data-turbo="false" pada login agar refresh full saat masuk sistem auth --}}
                <a href="{{ route('login') }}" data-turbo="false" class="inline-flex items-center gap-2 bg-accent text-primary px-6 py-2.5 rounded-full font-semibold tracking-wide hover:bg-orange-500 transition-all duration-300 hover:scale-105 shadow-lg shadow-orange-500/30">
                    <i class="fa-solid fa-right-to-bracket"></i> Login
                </a>
            @endguest

            @auth
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="w-11 h-11 rounded-full bg-accent text-primary flex items-center justify-center text-xl font-bold hover:bg-orange-500 transition-all duration-300 shadow-lg shadow-orange-500/40 focus:outline-none">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 scale-95"
                         @click.outside="open = false"
                         class="absolute right-0 mt-3 w-56 rounded-2xl bg-white shadow-2xl border border-gray-100 overflow-hidden z-50" style="display: none;">

                        <div class="px-4 py-3 text-xs font-bold text-gray-400 uppercase tracking-wider bg-gray-50 border-b border-gray-100">
                            Menu Navigasi
                        </div>

                        {{-- Link Navigasi (Otomatis pakai Turbo) --}}
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-primary hover:bg-orange-50 transition group">
                            <i class="fa-solid fa-house text-lg text-slate-500 group-hover:scale-110 transition"></i>
                            <span class="font-medium">Beranda</span>
                        </a>

                        <a href="{{ route('my.orders') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-primary hover:bg-orange-50 transition group">
                            <i class="fa-solid fa-box-open text-lg text-slate-500 group-hover:scale-110 transition"></i>
                            <span class="font-medium">Pesanan Saya</span>
                        </a>

                        <a href="{{ route('gallery.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-primary hover:bg-orange-50 transition group">
                            <i class="fa-solid fa-camera text-lg text-slate-500 group-hover:scale-110 transition"></i>
                            <span class="font-medium">Galeri Foto</span>
                        </a>

                        <a href="{{ route('eraport') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-primary hover:bg-orange-50 transition group">
                            <i class="fa-solid fa-chart-simple text-lg text-slate-500 group-hover:scale-110 transition"></i>
                            <span class="font-medium">E-Raport</span>
                        </a>

                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-sm text-primary hover:bg-orange-50 transition group">
                            <i class="fa-solid fa-user text-lg text-slate-500 group-hover:scale-110 transition"></i>
                            <span class="font-medium">Profil</span>
                        </a>

                        <div class="h-px bg-gray-100 my-1"></div>

                        <form method="POST" action="{{ route('logout') }}" data-turbo="false">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition group">
                                <i class="fa-solid fa-right-from-bracket text-lg group-hover:translate-x-1 transition"></i>
                                <span class="font-bold">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="pt-24 min-h-screen">
        @yield('content')
    </main>

    <footer class="bg-[#0a1520] py-12 border-t border-white/5" data-turbo-permanent id="footer">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h4 class="text-xl font-bold gradient-text mb-3">APHIX PRIVATE</h4>
                    <p class="text-gray-400 text-sm">Program latihan sepak bola profesional untuk masa depan gemilang Anda.</p>
                </div>
                <div>
                    <h5 class="font-semibold text-white mb-3">Kontak</h5>
                    <p class="text-gray-400 text-sm">📱 WhatsApp: +62-8958-0349-9012</p>
                    <p class="text-gray-400 text-sm mt-2">📍 Balikpapan, Kalimantan Timur</p>
                </div>
                <div>
                    <h5 class="font-semibold text-white mb-3">Jam Operasional</h5>
                    <p class="text-gray-400 text-sm">Senin - Minggu: 08.00 - 22.00</p>
                </div>
            </div>
            <div class="border-t border-white/5 pt-8 text-center">
                <p class="text-sm text-gray-400">© 2025 Aphix Private. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // --- 1. SETUP LOADING BAR ---
        document.addEventListener('turbo:click', () => {
            NProgress.start(); // Mulai bar loading saat klik link
        });
        document.addEventListener('turbo:load', () => {
            NProgress.done(); // Selesai loading
            initializeScripts(); // Jalankan ulang script JS halaman
        });
        document.addEventListener('turbo:visit', () => {
            NProgress.start();
        });

        // --- 2. SETUP MUSIK (Hanya sekali jalan) ---
        const music = document.getElementById("bgMusic");
        let hasInteracted = false;

        function playMusic() {
            if (!hasInteracted) {
                music.volume = 1.0;
                music.play().then(() => {
                    hasInteracted = true;
                    // Hapus listener setelah play berhasil agar tidak spam
                    window.removeEventListener("click", playMusic);
                    window.removeEventListener("scroll", playMusic);
                }).catch(error => {
                    console.log("Autoplay prevented:", error);
                });
            }
        }

        // Listener tetap ada di window, tidak hilang saat ganti halaman karena window tidak refresh
        window.addEventListener("click", playMusic);
        window.addEventListener("scroll", playMusic);


        // --- 3. FUNGSI INISIALISASI ULANG (Untuk Animasi Scroll) ---
        // Karena Turbo tidak me-refresh halaman, script reveal harus dipanggil ulang setiap pindah halaman
        function initializeScripts() {
            const reveals = document.querySelectorAll(".reveal");

            const revealOnScroll = () => {
                reveals.forEach((el) => {
                    const top = el.getBoundingClientRect().top;
                    const trigger = window.innerHeight - 100;
                    if (top < trigger) el.classList.add("active");
                });
            };

            // Hapus listener lama sebelum tambah baru (biar ga numpuk)
            window.removeEventListener("scroll", revealOnScroll);
            window.addEventListener("scroll", revealOnScroll);

            // Jalankan sekali saat load
            revealOnScroll();
        }

        // Jalankan saat pertama kali buka website
        initializeScripts();
    </script>

    @stack('scripts')
</body>
</html>
