@extends('layouts.user')

@section('title', 'Beranda - Aphix Private')

@push('styles')
    {{-- Load Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Utility untuk menyembunyikan scrollbar tapi tetap bisa di-scroll */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Agar banner bisa di-snap satu per satu */
        .snap-x-mandatory {
            scroll-snap-type: x mandatory;
        }

        .snap-center {
            scroll-snap-align: center;
        }
    </style>
@endpush

@section('content')

    {{-- ========================================================== --}}
    {{-- 1. SECTION: PLAYER OF THE MONTH (FULL WIDTH BANNER DESIGN) --}}
    {{-- ========================================================== --}}
    @if (isset($pom) && $pom->count() > 0)
        <section class="bg-[#020617] pt-6 pb-2 relative overflow-hidden">

            {{-- Container Utama Scroll --}}
            <div id="pomBannerContainer" class="flex overflow-x-auto hide-scrollbar snap-x-mandatory z-10 relative py-4">

                @foreach ($pom as $p)
                    {{-- ITEM BANNER (Persegi Panjang Full) --}}
                    {{-- Kita pakai w-[95vw] atau w-full dengan max-w-7xl agar di layar besar tidak terlalu lebar --}}
                    <div class="w-full md:max-w-7xl mx-auto px-4 md:px-6 flex-shrink-0 snap-center">

                        <div
                            class="relative w-full rounded-[2.5rem] overflow-hidden bg-gradient-to-br from-slate-900 via-[#0F2A44] to-slate-950 border border-slate-800 shadow-2xl shadow-orange-900/20 h-[500px] md:h-[450px] lg:h-[400px] grid md:grid-cols-12 group">

                            {{-- BACKGROUND DEKORASI --}}
                            <div
                                class="absolute inset-0 opacity-20 mix-blend-overlay bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
                            </div>
                            <div class="absolute -top-20 -left-20 w-60 h-60 bg-orange-500/20 rounded-full blur-[100px]">
                            </div>
                            <div class="absolute bottom-0 right-0 w-80 h-80 bg-accent/10 rounded-full blur-[120px]"></div>

                            {{-- KOLOM KIRI: TEKS (Dominan di HP) --}}
                            <div class="md:col-span-7 relative z-20 flex flex-col justify-center p-8 md:p-12 lg:pl-16">

                                {{-- Badge Kecil --}}
                                <div class="flex items-center gap-2 mb-4 animate-fade-in-down"
                                    style="animation-delay: 100ms">
                                    <span
                                        class="bg-orange-600 text-white text-[10px] md:text-xs font-black uppercase tracking-[0.2em] px-3 py-1.5 rounded-full">
                                        <i class="fa-solid fa-crown mr-1"></i> Hall of Fame
                                    </span>
                                    <span class="text-slate-400 text-sm font-medium">Player of The Month</span>
                                </div>

                                {{-- KATEGORI (Besar Sekali) --}}
                                <h2 class="text-4xl sm:text-5xl lg:text-7xl font-black text-white uppercase italic leading-none mb-2 drop-shadow-lg animate-fade-in-down"
                                    style="animation-delay: 200ms">
                                    {{ $p->category }}
                                </h2>

                                {{-- NAMA PEMAIN --}}
                                <h3 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-orange-400 via-accent to-white animate-fade-in-down"
                                    style="animation-delay: 300ms">
                                    {{ $p->name }}
                                </h3>

                                {{-- Garis Hiasan --}}
                                <div class="h-1 w-24 bg-orange-600 mt-6 rounded-full"></div>
                            </div>

                            {{-- KOLOM KANAN: FOTO (Full height, blended) --}}
                            <div class="md:col-span-5 relative h-full overflow-hidden">
                                {{-- Overlay Gradient agar foto menyatu dengan background di bagian bawah/samping --}}
                                <div
                                    class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-l from-slate-950 via-slate-950/50 to-transparent z-10">
                                </div>

                                {{-- FOTO --}}
                                <img src="{{ asset('storage/' . $p->image) }}"
                                    class="w-full h-full object-cover object-top md:object-center transform group-hover:scale-105 transition duration-700 ease-in-out"
                                    alt="{{ $p->name }}">
                            </div>

                        </div>
                    </div>
                @endforeach

            </div>
        </section>
    @endif
    {{-- ================= END PLAYER OF THE MONTH ================= --}}


    {{-- HERO SECTION --}}
    <section class="max-w-7xl mx-auto px-6 py-12 md:py-20 grid md:grid-cols-2 gap-12 items-center">
        <div class="animate-slide-up">
            <h2 class="text-4xl sm:text-5xl md:text-6xl font-bold leading-tight">
                Personalized football<span class="gradient-text"> training for winners.</span>
            </h2>

            <div class="mt-10 flex flex-col sm:flex-row gap-4">
                @guest
                    <a href="{{ route('login') }}"
                        class="bg-accent text-primary px-8 py-4 rounded-full font-semibold hover:bg-orange-600 transition transform hover:scale-105 shadow-xl text-center flex items-center justify-center gap-2">
                        <i class="fa-solid fa-right-to-bracket"></i> Login untuk Daftar
                    </a>
                @endguest
                @auth
                    <a href="{{ route('daftar') }}"
                        class="bg-accent text-primary px-8 py-4 rounded-full font-semibold hover:bg-orange-600 transition transform hover:scale-105 shadow-xl text-center flex items-center justify-center gap-2">
                        <i class="fa-solid fa-user-plus"></i> Daftar Sekarang
                    </a>
                @endauth
            </div>
            <div class="grid grid-cols-3 gap-4 mt-12"></div>
        </div>

        <div class="relative overflow-hidden">
            <div class="absolute -top-10 -left-10 w-40 h-40 bg-accent/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-10 -right-10 w-60 h-60 bg-orange-500/10 rounded-full blur-3xl"></div>

            {{-- GALLERY OTOMATIS (HANYA DARI ADMIN) --}}
            <div id="autoGallery"
                class="flex gap-6 select-none relative z-10 overflow-x-scroll hide-scrollbar h-[350px] items-center">

                @if (isset($landingContent) && $landingContent->count() > 0)
                    {{-- LOOPING DATA DARI DATABASE (UPLOAD ADMIN) --}}
                    @foreach ($landingContent as $content)
                        @if ($content->file_type == 'video')
                            <video class="gallery-img rounded-xl min-w-[250px] h-[350px] object-cover"
                                src="{{ asset('storage/' . $content->file_path) }}" muted autoplay loop playsinline></video>
                        @else
                            <img class="gallery-img rounded-xl min-w-[250px] h-[350px] object-cover"
                                src="{{ asset('storage/' . $content->file_path) }}" alt="Gallery Content" />
                        @endif
                    @endforeach
                @else
                    {{-- JIKA KOSONG: TAMPILKAN PLACEHOLDER SEDERHANA ATAU KOSONG --}}
                    <div
                        class="w-full text-center text-slate-500 opacity-50 flex flex-col items-center justify-center border-2 border-dashed border-slate-700 rounded-xl h-full min-w-[300px]">
                        <i class="fa-regular fa-images text-4xl mb-2"></i>
                        <p class="text-sm">Belum ada konten galeri.</p>
                    </div>
                @endif

            </div>
        </div>
    </section>

    {{-- APHIX PRIVATE SECTION --}}
    <section class="relative py-20 md:py-28 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-[#0F2A44] to-primary"></div>
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-accent/5 rounded-full blur-3xl"></div>

        <div class="relative max-w-6xl mx-auto px-6 text-center">
            <h3 class="text-3xl sm:text-4xl md:text-5xl font-bold gradient-text">Aphix Private</h3>
            <p class="mt-6 text-gray-300 text-base sm:text-lg max-w-3xl mx-auto leading-relaxed">
                Program pembinaan sepak bola yang berfokus pada proses, disiplin, dan progres pemain. Latihan dirancang
                personal, intens, dan aplikatif sesuai kebutuhan di lapangan.
            </p>

            <div class="mt-12 grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="glass-effect p-6 rounded-2xl card-hover group">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition text-orange-500">
                        <i class="fa-solid fa-futbol"></i>
                    </div>
                    <p class="text-accent font-bold text-lg">Berbasis Match</p>
                    <p class="text-gray-300 text-sm mt-2">Latihan relevan dengan situasi pertandingan nyata.</p>
                </div>
                <div class="glass-effect p-6 rounded-2xl card-hover group">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition text-green-400">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>
                    <p class="text-accent font-bold text-lg">Progres Terukur</p>
                    <p class="text-gray-300 text-sm mt-2">Fokus peningkatan skill & konsistensi berkelanjutan.</p>
                </div>
                <div class="glass-effect p-6 rounded-2xl card-hover group">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition text-purple-400">
                        <i class="fa-solid fa-brain"></i>
                    </div>
                    <p class="text-accent font-bold text-lg">Mental Juara</p>
                    <p class="text-gray-300 text-sm mt-2">Disiplin, fokus, dan etika bertanding profesional.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- PROGRAM SECTION --}}
    <section class="py-20 md:py-28 max-w-7xl mx-auto px-6 relative">
        <div class="absolute top-1/2 right-0 w-96 h-96 bg-orange-500/5 rounded-full blur-3xl"></div>
        <div class="text-center mb-16 relative z-10">
            <h3 class="text-3xl sm:text-4xl md:text-5xl font-bold gradient-text">Our Program</h3>
            <p class="mt-4 text-gray-300 max-w-2xl mx-auto">Latihan terstruktur dan komprehensif untuk mengembangkan potensi
                maksimal Anda</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 relative z-10">
            <div
                class="glass-effect p-8 rounded-3xl text-center card-hover group border-2 border-transparent hover:border-accent/50">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-accent to-orange-600 rounded-2xl mx-auto flex items-center justify-center mb-6 group-hover:rotate-12 transition">
                    <i class="fa-solid fa-bolt text-3xl text-white"></i>
                </div>
                <h4 class="font-bold text-xl text-accent mb-3">Technical Training</h4>
                <p class="text-gray-300 leading-relaxed">Dribbling, passing, first touch, dan finishing dengan teknik
                    profesional.</p>
            </div>
            <div
                class="glass-effect p-8 rounded-3xl text-center card-hover group border-2 border-transparent hover:border-accent/50">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-accent to-orange-600 rounded-2xl mx-auto flex items-center justify-center mb-6 group-hover:rotate-12 transition">
                    <i class="fa-solid fa-dumbbell text-3xl text-white"></i>
                </div>
                <h4 class="font-bold text-xl text-accent mb-3">Physical & Conditioning</h4>
                <p class="text-gray-300 leading-relaxed">Speed, agility, strength, dan stamina fungsional untuk performa
                    maksimal.</p>
            </div>
            <div
                class="glass-effect p-8 rounded-3xl text-center card-hover group border-2 border-transparent hover:border-accent/50">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-accent to-orange-600 rounded-2xl mx-auto flex items-center justify-center mb-6 group-hover:rotate-12 transition">
                    <i class="fa-solid fa-bullseye text-3xl text-white"></i>
                </div>
                <h4 class="font-bold text-xl text-accent mb-3">Mental & Discipline</h4>
                <p class="text-gray-300 leading-relaxed">Fokus, percaya diri, dan sikap profesional untuk menjadi juara
                    sejati.</p>
            </div>
        </div>
    </section>

    {{-- EVENT SECTION --}}
    <section class="relative py-20 md:py-28 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-[#0F2A44] to-primary"></div>
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-accent/5 rounded-full blur-3xl"></div>

        <div class="relative max-w-6xl mx-auto px-6 text-center">
            <h3 class="text-3xl sm:text-4xl md:text-5xl font-bold gradient-text">Our Event</h3>
            <p class="mt-6 text-gray-300 text-base sm:text-lg max-w-3xl mx-auto leading-relaxed">
                Agenda rutin bulanan Aphix yang diselenggarakan sebagai wadah kegiatan, pembinaan pemain, dan pengembangan
                performa kompetitif.
            </p>

            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="glass-effect p-6 rounded-2xl card-hover group">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition text-cyan-400">
                        <i class="fa-solid fa-person-swimming"></i>
                    </div>
                    <p class="text-accent font-bold text-lg">Swim Session</p>
                    <p class="text-gray-300 text-sm mt-2">Program renang rutin dengan pendampingan pelatih khusus untuk
                        menunjang kebugaran.</p>
                </div>
                <div class="glass-effect p-6 rounded-2xl card-hover group">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition text-white">
                        <i class="fa-solid fa-user-tie"></i>
                    </div>
                    <p class="text-accent font-bold text-lg">Guest Coach</p>
                    <p class="text-gray-300 text-sm mt-2">Sesi latihan bersama Coach tamu untuk menambah wawasan, motivasi,
                        dan kualitas latihan.</p>
                </div>
                <div class="glass-effect p-6 rounded-2xl card-hover group">
                    <div class="text-4xl mb-4 group-hover:scale-110 transition text-yellow-400">
                        <i class="fa-solid fa-trophy"></i>
                    </div>
                    <p class="text-accent font-bold text-lg">Internal Match</p>
                    <p class="text-gray-300 text-sm mt-2">Turnamen internal sebagai sarana evaluasi kemampuan dan
                        peningkatan pengalaman.</p>
                </div>
                <div
                    class="glass-effect p-6 rounded-2xl card-hover group flex flex-col items-center justify-center text-center">
                    <div class="mb-4 group-hover:scale-110 transition-transform duration-300 text-4xl text-orange-400">
                        <i class="fa-regular fa-calendar-plus"></i>
                    </div>
                    <p class="text-accent font-bold text-lg">Coming Up</p>
                </div>
            </div>
        </div>
    </section>

    {{-- VENUE & SCHEDULE --}}
    <section class="py-20 md:py-28 max-w-7xl mx-auto px-6 relative overflow-hidden">
        <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-accent/5 rounded-full blur-3xl"></div>
        <div class="grid md:grid-cols-2 gap-16 items-center relative z-10">
            <div>
                <h3 class="text-3xl sm:text-4xl md:text-5xl font-bold gradient-text mb-6">Venue & Schedule</h3>
                <p class="text-gray-300 leading-relaxed max-w-md">Program Aphix dirancang untuk memberikan pengalaman
                    latihan yang nyaman, terstruktur, dan terjangkau bagi setiap pemain.</p>
            </div>

            <div class="space-y-6">
                <div
                    class="glass-effect p-8 max-w rounded-3xl card-hover reveal animate-float hover:-translate-y-1 hover:shadow-xl hover:shadow-accent 500/20">
                    <span class="text-3xl mb-3 block text-orange-500">
                        <i class="fa-solid fa-location-dot"></i>
                    </span>
                    <h4 class="font-bold text-lg text-accent mb-2">Facility</h4>
                    <ul class="text-gray-300 text-sm space-y-1.5 fa-ul ml-6">
                        <li><span class="fa-li"><i class="fa-solid fa-check text-orange-500"></i></span>Lapangan standar
                        </li>
                        <li><span class="fa-li"><i class="fa-solid fa-check text-orange-500"></i></span>Peralatan lengkap
                        </li>
                        <li><span class="fa-li"><i class="fa-solid fa-check text-orange-500"></i></span>Coach berlisensi
                            PSSI</li>
                    </ul>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                    <!-- Registration Fee -->
                    <div
                        class="glass-effect bg-white/10 backdrop-blur-xl p-5 rounded-2xl card-hover reveal animate-float hover:-translate-y-1 hover:shadow-xl hover:shadow-green-400/40">
                        <span class="text-4xl mb-3 block drop-shadow-lg text-green-400">
                            <i class="fa-solid fa-money-bill-wave"></i>
                        </span>
                        <h4 class="font-bold text-lg text-green-300 drop-shadow-sm mb-2">
                            Registration Fee
                        </h4>
                        <div class="text-2xl font-bold text-white drop-shadow-md">
                            Rp 200K
                        </div>
                        <p class="text-xs text-gray-300 mb-3">Pendaftaran (sekali bayar)</p>
                        <ul class="text-sm text-gray-200 space-y-1">
                            <li>• Free training ball</li>
                            <li>• Free resistance band</li>
                        </ul>
                    </div>

                    <!-- Monthly Fee -->
                    <div
                        class="glass-effect bg-white/10 backdrop-blur-xl p-5 rounded-2xl card-hover reveal animate-float hover:-translate-y-1 hover:shadow-xl hover:shadow-green-400/40">
                        <span class="text-4xl mb-3 block drop-shadow-lg text-green-400">
                            <i class="fa-solid fa-calendar-check"></i>
                        </span>
                        <h4 class="font-bold text-lg text-green-300 drop-shadow-sm">
                            Monthly Fee
                        </h4>

                        <div class="text-2xl font-bold text-white drop-shadow-md mt-10">
                            Rp 200K
                        </div>

                        <p class="text-xs text-gray-300 mb-3">Per bulan</p>
                        <ul class="text-sm text-gray-200 space-y-1">
                            <li>
                                • Semua sesi latihan
                                <span class="font-semibold text-white"> (include renang &amp; cardio)</span>
                            </li>
                            <li>• Event internal Aphix</li>
                        </ul>

                    </div>

                    <!-- Non-Renang Program -->
                    <div
                        class="glass-effect bg-white/10 backdrop-blur-xl p-5 rounded-2xl card-hover reveal animate-float hover:-translate-y-1 hover:shadow-xl hover:shadow-blue-400/40">
                        <span class="text-4xl mb-3 block drop-shadow-lg text-blue-400">
                            <i class="fa-solid fa-dumbbell"></i>
                        </span>
                        <h4 class="font-bold text-lg text-blue-300 drop-shadow-sm mb-2">
                            Program Non-Renang
                        </h4>
                        <div class="text-2xl font-bold text-white drop-shadow-md">
                            Rp 150K
                        </div>
                        <p class="text-xs text-gray-300 mb-3">per bulan</p>
                        <ul class="text-sm text-gray-200 space-y-1">
                            <li>• Semua sesi latihan</li>
                            <li>• Event internal Aphix</li>
                        </ul>
                    </div>

                </div>


                <div
                    class="glass-effect p-8 max-w rounded-3xl card-hover reveal animate-float hover:-translate-y-1 hover:shadow-xl hover:shadow-accent 500/20">
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-8 sm:gap-16">

                        <div class="flex items-center gap-4 w-full sm:w-auto justify-center sm:justify-start">
                            <span class="text-5xl text-orange-500 drop-shadow-sm">
                                <i class="fa-solid fa-futbol"></i>
                            </span>
                            <div class="text-left">
                                <h4 class="font-bold text-lg text-orange-400">Latihan</h4>
                                <p class="text-gray-300 text-sm">
                                    Selasa <br />
                                    17.00 – 18.00
                                </p>
                                <br>
                                <p class="text-gray-300 text-sm">
                                    Sabtu <br />
                                    14.00 – 15.00
                                </p>
                                <b><b class="text-gray-300">Flexible</b></b>
                            </div>
                        </div>

                        <div class="hidden sm:block w-px h-16 bg-white/10"></div>

                        <div class="flex items-center gap-4 w-full sm:w-auto justify-center sm:justify-start">
                            <div class="flex flex-col items-center justify-center gap-1">
                                <span class="text-4xl text-cyan-400 drop-shadow-sm">
                                    <i class="fa-solid fa-person-swimming"></i>
                                </span>
                                <span class="text-4xl text-rose-400 drop-shadow-sm">
                                    <i class="fa-solid fa-heart-pulse"></i>
                                </span>
                            </div>

                            <div class="text-left">
                                <h4 class="font-bold text-lg text-cyan-300">
                                    Berenang & <span class="text-rose-400">Cardio</span>
                                </h4>
                                <p class="text-gray-300 text-sm leading-relaxed">
                                    Minggu<br />
                                    07.00 – 09.00 WIB
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CONTACT / CTA SECTION --}}
    <section id="contact" class="relative py-24 md:py-32 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-accent via-orange-600 to-orange-500"></div>
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-20 w-72 h-72 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-5xl mx-auto px-6 text-center">
            <h3 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">Siap Tingkatkan
                Skill<br />Sepak Bola?</h3>
            <p class="text-xl text-white/90 mb-10 max-w-2xl mx-auto">
                Hubungi kami sekarang dan mulai latihan bersama Aphix Private. Wujudkan mimpi menjadi pemain sepak bola
                profesional!
            </p>
            @guest
                <a href="{{ route('login') }}"
                    class="inline-flex items-center gap-3 bg-primary text-white px-10 py-5 rounded-full font-bold text-lg hover:bg-[#0a1520] transition transform hover:scale-105 shadow-2xl">
                    <i class="fa-solid fa-lock"></i> Login untuk Chat
                </a>
            @endguest
            @auth
                <a href="{{ route('chat.wa') }}"
                    class="inline-flex items-center gap-3 bg-primary text-white px-10 py-5 rounded-full font-bold text-lg hover:bg-[#0a1520] transition transform hover:scale-105 shadow-2xl">
                    <i class="fa-brands fa-whatsapp text-2xl"></i> Chat WhatsApp
                </a>
            @endauth
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // ==========================================
        // SCRIPT 1: GALLERY HERO (Auto Infinite Scroll)
        // ==========================================
        const gallery = document.getElementById("autoGallery");
        if (gallery) {
            if (gallery.children.length > 0) {
                const galleryItems = Array.from(gallery.children);
                galleryItems.forEach((item) => {
                    const clone = item.cloneNode(true);
                    gallery.appendChild(clone);
                });
            }

            let speed = 0.5;
            let scrollInterval;

            function autoScroll() {
                gallery.scrollLeft += speed;
                if (gallery.scrollLeft >= gallery.scrollWidth / 2) {
                    gallery.scrollLeft = 0;
                }
            }

            if (gallery.children.length > 0) {
                scrollInterval = setInterval(autoScroll, 16);
                gallery.addEventListener("mouseenter", () => clearInterval(scrollInterval));
                gallery.addEventListener("mouseleave", () => {
                    scrollInterval = setInterval(autoScroll, 16);
                });
            }
        }


        // ==========================================
        // SCRIPT 2: PLAYER OF THE MONTH BANNER (Auto Scroll - Snap per Item)
        // ==========================================
        const pomBannerContainer = document.getElementById("pomBannerContainer");

        if (pomBannerContainer && pomBannerContainer.children.length > 1) {
            let bannerInterval;
            const scrollAmount = pomBannerContainer.clientWidth; // Scroll selebar container

            function scrollNextBanner() {
                // Cek jika sudah di ujung kanan
                if (pomBannerContainer.scrollLeft + pomBannerContainer.clientWidth >= pomBannerContainer.scrollWidth - 10) {
                    // Balik ke awal dengan smooth
                    pomBannerContainer.scrollTo({
                        left: 0,
                        behavior: 'smooth'
                    });
                } else {
                    // Scroll ke item berikutnya
                    pomBannerContainer.scrollBy({
                        left: scrollAmount,
                        behavior: 'smooth'
                    });
                }
            }

            // Jalankan setiap 4 detik (karena banner besar, butuh waktu baca lebih lama)
            bannerInterval = setInterval(scrollNextBanner, 2000);

            // Pause interaksi
            pomBannerContainer.addEventListener("mouseenter", () => clearInterval(bannerInterval));
            pomBannerContainer.addEventListener("touchstart", () => clearInterval(bannerInterval));

            // Resume interaksi
            pomBannerContainer.addEventListener("mouseleave", () => {
                bannerInterval = setInterval(scrollNextBanner, 4000);
            });
            pomBannerContainer.addEventListener("touchend", () => {
                bannerInterval = setInterval(scrollNextBanner, 4000);
            });
        }
    </script>
@endpush
