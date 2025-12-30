<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - System Error | Aphix Private</title>

    {{-- Load Tailwind & Font --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* Font Futuristic */
        body {
            font-family: 'Chakra Petch', sans-serif;
            background-color: #020617;
        }

        /* Animasi Glitch */
        .glitch-wrapper {
            position: relative;
            display: inline-block;
        }
        .glitch-wrapper::before,
        .glitch-wrapper::after {
            content: attr(data-text);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #020617;
        }
        .glitch-wrapper::before {
            left: 2px;
            text-shadow: -1px 0 #ff00c1;
            clip: rect(44px, 450px, 56px, 0);
            animation: glitch-anim 5s infinite linear alternate-reverse;
        }
        .glitch-wrapper::after {
            left: -2px;
            text-shadow: -1px 0 #00fff9;
            clip: rect(44px, 450px, 56px, 0);
            animation: glitch-anim2 5s infinite linear alternate-reverse;
        }

        @keyframes glitch-anim {
            0% { clip: rect(30px, 9999px, 10px, 0); }
            5% { clip: rect(80px, 9999px, 90px, 0); }
            10% { clip: rect(10px, 9999px, 40px, 0); }
            100% { clip: rect(60px, 9999px, 20px, 0); }
        }
        @keyframes glitch-anim2 {
            0% { clip: rect(10px, 9999px, 80px, 0); }
            5% { clip: rect(50px, 9999px, 10px, 0); }
            10% { clip: rect(90px, 9999px, 30px, 0); }
            100% { clip: rect(20px, 9999px, 60px, 0); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center text-white overflow-x-hidden relative selection:bg-orange-500 selection:text-white">

    {{-- Background Tech Grid --}}
    <div class="absolute inset-0 z-0 opacity-10 pointer-events-none"
         style="background-image: linear-gradient(rgba(11, 28, 45, 0.5) 1px, transparent 1px),
         linear-gradient(90deg, rgba(11, 28, 45, 0.5) 1px, transparent 1px);
         background-size: 30px 30px;">
    </div>

    {{-- Spotlights (Responsive Size) --}}
    <div class="absolute top-0 left-0 w-64 h-64 md:w-96 md:h-96 bg-blue-600/20 rounded-full blur-[100px] -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-64 h-64 md:w-96 md:h-96 bg-orange-600/20 rounded-full blur-[100px] translate-x-1/2 translate-y-1/2"></div>

    {{-- Main Container --}}
    <div class="relative z-10 w-full max-w-4xl px-4 sm:px-6 py-10 text-center flex flex-col items-center">

        {{-- Image Wrapper --}}
        <div class="relative group w-full max-w-xs sm:max-w-md md:max-w-xl lg:max-w-2xl mb-8 md:mb-10 mx-auto">
            <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-orange-500 rounded-lg blur opacity-30 group-hover:opacity-60 transition duration-1000"></div>

            {{-- IMAGE --}}
            <img src="{{ asset('images/404.png') }}"
                 alt="System Failure"
                 class="relative w-full rounded-lg shadow-2xl border border-slate-700/50 object-cover aspect-video">

            {{-- Overlay Scanline --}}
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-white/5 to-transparent bg-[length:100%_4px] pointer-events-none opacity-20 rounded-lg"></div>
        </div>

        {{-- Text Content --}}
        <div class="space-y-3 md:space-y-4 w-full">
            {{-- Text Size Responsive: 4xl di HP, 7xl di Desktop --}}
            <h1 class="text-4xl sm:text-6xl md:text-7xl font-bold tracking-tighter text-transparent bg-clip-text bg-gradient-to-r from-white via-slate-200 to-slate-400 glitch-wrapper leading-tight" data-text="SYSTEM FAILURE">
                SYSTEM FAILURE
            </h1>

            <p class="text-slate-400 text-sm sm:text-base md:text-xl max-w-lg mx-auto font-light px-2">
                <span class="text-orange-500 font-bold block sm:inline mb-1 sm:mb-0">[ERR_404]:</span>
                Halaman yang kamu cari tidak ditemukan di database. Silakan periksa kembali URL atau kembali ke halaman utama.
            </p>
        </div>

        {{-- Action Buttons (Stack di HP, Row di Desktop) --}}
        <div class="mt-8 md:mt-10 flex flex-col sm:flex-row gap-4 w-full sm:w-auto justify-center items-center">

            {{-- Tombol Utama --}}
            <a href="{{ url('/') }}" class="w-full sm:w-auto group relative px-6 py-3.5 bg-orange-600 hover:bg-orange-500 text-white font-bold rounded overflow-hidden transition-all skew-x-0 sm:skew-x-[-10deg] shadow-lg shadow-orange-900/20 active:scale-95">
                <div class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1s_infinite]"></div>
                {{-- Skew text back to normal on desktop --}}
                <span class="block skew-x-0 sm:skew-x-[10deg]">
                    <i class="fa-solid fa-power-off mr-2"></i> REBOOT SYSTEM
                </span>
            </a>

            {{-- Tombol Kedua --}}
            <button onclick="history.back()" class="w-full sm:w-auto px-6 py-3.5 border border-slate-600 hover:border-slate-400 text-slate-300 hover:text-white font-semibold rounded transition-all skew-x-0 sm:skew-x-[-10deg] hover:bg-slate-800/50 active:scale-95">
                <span class="block skew-x-0 sm:skew-x-[10deg]">
                    <i class="fa-solid fa-arrow-left mr-2"></i> KEMBALI
                </span>
            </button>
        </div>

        {{-- Footer Code --}}
        <div class="mt-12 md:mt-16 text-slate-700 text-[10px] md:text-xs font-mono break-all px-4">
            ID: {{ uniqid() }} // SERVER: APHIX_CORE_01
        </div>
    </div>

</body>
</html>
