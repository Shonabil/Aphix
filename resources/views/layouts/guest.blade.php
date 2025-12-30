<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Aphix') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    

    <style>
        /* Animated gradient background */
        .animated-bg {
            background: linear-gradient(135deg,
                #0a1628 0%,
                #0d1f35 25%,
                #1a2c4a 50%,
                #0f1e32 75%,
                #0a1628 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        /* Floating particles */
        .particle {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .particle-1 {
            width: 4px;
            height: 4px;
            background: rgba(249, 115, 22, 0.4);
            top: 20%;
            left: 10%;
            animation: float 8s ease-in-out infinite;
        }

        .particle-2 {
            width: 6px;
            height: 6px;
            background: rgba(251, 146, 60, 0.3);
            top: 60%;
            left: 80%;
            animation: float 10s ease-in-out infinite 2s;
        }

        .particle-3 {
            width: 3px;
            height: 3px;
            background: rgba(249, 115, 22, 0.5);
            top: 40%;
            left: 60%;
            animation: float 7s ease-in-out infinite 1s;
        }

        .particle-4 {
            width: 5px;
            height: 5px;
            background: rgba(251, 146, 60, 0.4);
            top: 80%;
            left: 30%;
            animation: float 9s ease-in-out infinite 3s;
        }

        .particle-5 {
            width: 4px;
            height: 4px;
            background: rgba(249, 115, 22, 0.3);
            top: 15%;
            left: 85%;
            animation: float 11s ease-in-out infinite 1.5s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1);
                opacity: 0.3;
            }
            25% {
                transform: translate(20px, -30px) scale(1.2);
                opacity: 0.6;
            }
            50% {
                transform: translate(-20px, -60px) scale(0.8);
                opacity: 0.4;
            }
            75% {
                transform: translate(30px, -30px) scale(1.1);
                opacity: 0.5;
            }
        }

        /* Grid pattern overlay */
        .grid-pattern {
            background-image:
                linear-gradient(rgba(249, 115, 22, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(249, 115, 22, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% { background-position: 0 0; }
            100% { background-position: 50px 50px; }
        }

        /* Glow orbs with pulsing effect */
        .glow-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            opacity: 0.4;
            animation: pulse 8s ease-in-out infinite;
        }

        .glow-orb-1 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #f97316 0%, transparent 70%);
            top: -150px;
            left: -150px;
            animation-delay: 0s;
        }

        .glow-orb-2 {
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, #fb923c 0%, transparent 70%);
            bottom: -100px;
            right: -100px;
            animation-delay: 2s;
        }

        .glow-orb-3 {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, #f97316 0%, transparent 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 4s;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1) translateX(0);
                opacity: 0.3;
            }
            50% {
                transform: scale(1.2) translateX(10px);
                opacity: 0.5;
            }
        }

        /* Shooting stars */
        .shooting-star {
            position: absolute;
            width: 2px;
            height: 2px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 0 10px 2px rgba(255, 255, 255, 0.5);
            animation: shoot 3s linear infinite;
        }

        .shooting-star-1 {
            top: 20%;
            right: 20%;
            animation-delay: 2s;
        }

        .shooting-star-2 {
            top: 60%;
            right: 60%;
            animation-delay: 5s;
        }

        .shooting-star-3 {
            top: 40%;
            right: 80%;
            animation-delay: 8s;
        }

        @keyframes shoot {
            0% {
                transform: translate(0, 0);
                opacity: 1;
            }
            70% {
                opacity: 1;
            }
            100% {
                transform: translate(-200px, 200px);
                opacity: 0;
            }
        }

        /* Subtle noise texture */
        .noise-texture {
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='3' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.03'/%3E%3C/svg%3E");
        }

        /* Card enhancement */
        .card-glow {
            box-shadow:
                0 0 60px rgba(249, 115, 22, 0.1),
                0 25px 50px rgba(0, 0, 0, 0.5),
                inset 0 0 0 1px rgba(249, 115, 22, 0.1);
        }

        /* Logo glow */
        .logo-blue {
    filter: brightness(0) saturate(100%)
            invert(18%)
            sepia(42%)
            saturate(1400%)
            hue-rotate(185deg)
            brightness(95%)
            contrast(95%);
}


        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        /* Floating text background - APHIX */
        .floating-text {
            position: absolute;
            font-size: 150px;
            font-weight: 900;
            color: rgba(249, 115, 22, 0.12);
            pointer-events: none;
            white-space: nowrap;
            user-select: none;
            letter-spacing: 0.1em;
            text-shadow:
                2px 2px 0 rgba(249, 115, 22, 0.08),
                4px 4px 0 rgba(249, 115, 22, 0.06),
                6px 6px 0 rgba(249, 115, 22, 0.04);
            -webkit-text-stroke: 2px rgba(249, 115, 22, 0.15);
        }

        .text-1 {
            top: 15%;
            left: -20%;
            animation: floatText1 20s linear infinite;
        }

        .text-2 {
            top: 30%;
            right: -20%;
            animation: floatText2 25s linear infinite;
            animation-delay: 3s;
        }

        .text-3 {
            top: 45%;
            left: -20%;
            animation: floatText3 22s linear infinite;
            animation-delay: 6s;
        }

        .text-4 {
            top: 60%;
            right: -20%;
            animation: floatText4 27s linear infinite;
            animation-delay: 9s;
        }

        .text-5 {
            top: 75%;
            left: -20%;
            animation: floatText5 24s linear infinite;
            animation-delay: 12s;
        }

        @keyframes floatText1 {
            0% {
                transform: translateX(0) rotate(-8deg);
                opacity: 0.12;
            }
            50% {
                opacity: 0.18;
            }
            100% {
                transform: translateX(150vw) rotate(5deg);
                opacity: 0.12;
            }
        }

        @keyframes floatText2 {
            0% {
                transform: translateX(0) rotate(6deg);
                opacity: 0.12;
            }
            50% {
                opacity: 0.18;
            }
            100% {
                transform: translateX(-150vw) rotate(-7deg);
                opacity: 0.12;
            }
        }

        @keyframes floatText3 {
            0% {
                transform: translateX(0) rotate(-5deg) scale(0.9);
                opacity: 0.12;
            }
            50% {
                opacity: 0.16;
            }
            100% {
                transform: translateX(150vw) rotate(4deg) scale(1.1);
                opacity: 0.12;
            }
        }

        @keyframes floatText4 {
            0% {
                transform: translateX(0) rotate(7deg) scale(1.1);
                opacity: 0.12;
            }
            50% {
                opacity: 0.15;
            }
            100% {
                transform: translateX(-150vw) rotate(-6deg) scale(0.9);
                opacity: 0.12;
            }
        }

        @keyframes floatText5 {
            0% {
                transform: translateX(0) rotate(-4deg);
                opacity: 0.12;
            }
            50% {
                opacity: 0.17;
            }
            100% {
                transform: translateX(150vw) rotate(3deg);
                opacity: 0.12;
            }
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-100">
    <div class="animated-bg grid-pattern noise-texture relative min-h-screen flex flex-col sm:justify-center items-center overflow-hidden">

        <!-- Animated glow orbs -->
        <div class="glow-orb glow-orb-1"></div>
        <div class="glow-orb glow-orb-2"></div>
        <div class="glow-orb glow-orb-3"></div>

        <!-- Floating particles -->
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
        <div class="particle particle-4"></div>
        <div class="particle particle-5"></div>

        <!-- Shooting stars -->
        <div class="shooting-star shooting-star-1"></div>
        <div class="shooting-star shooting-star-2"></div>
        <div class="shooting-star shooting-star-3"></div>

        <!-- Floating APHIX text -->
        <div class="floating-text text-1">APHIX</div>
        <div class="floating-text text-2">APHIX</div>
        <div class="floating-text text-3">APHIX</div>
        <div class="floating-text text-4">APHIX</div>
        <div class="floating-text text-5">APHIX</div>

        <!-- Logo -->
        <div class="relative z-10">
            <a href="/">
    <img src="{{ asset('images/aphixlogo.jpg') }}"
         alt="Aphix Logo"
         class="w-20 h-20 logo-blue" />
</a>

        </div>

        <!-- Card -->
        <div class="card-glow relative z-10 w-full sm:max-w-md mt-6 px-6 py-6
                    bg-gradient-to-br from-white/10 via-white/5 to-white/10
                    backdrop-blur-xl border border-white/20
                    shadow-2xl overflow-hidden sm:rounded-2xl">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
