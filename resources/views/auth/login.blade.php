<x-guest-layout>
    <style>
        /* ===============================
           GRADIENT TITLE
        ================================ */
        .gradient-text {
            background: linear-gradient(135deg, #051D6B, #1E40AF, #e4bc7f, #f79e18);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-size: 200% auto;
            animation: shimmer 3s linear infinite;
        }

        @keyframes shimmer {
            0% { background-position: 0% center; }
            100% { background-position: 200% center; }
        }

        /* ===============================
   LOADING OVERLAY
================================ */
#loading-overlay {
    opacity: 0;
    pointer-events: none; /* Supaya bisa diklik tembus saat hidden */
    transition: opacity 0.3s ease;
}

#loading-overlay.active {
    opacity: 1;
    pointer-events: all; /* Blokir klik saat loading aktif */
}

/* Spinner Cincin Ganda (Biru & Oranye) */
.spinner {
    width: 50px;
    height: 50px;
    border: 5px solid rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    border-top-color: #f97316; /* Warna Oranye */
    border-bottom-color: #051D6B; /* Warna Biru */
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

        /* ===============================
           LABEL
        ================================ */
        label, .x-input-label {
            color: #051D6B !important;
            font-weight: 600;
        }

        /* ===============================
           INPUT FIELDS
        ================================ */
        .custom-input {
            background: rgba(241, 151, 34, 0.06);
            border: 1.5px solid rgba(5, 29, 107, 0.45);
            color: #000;
            transition: all 0.3s ease;
        }

        .custom-input::placeholder {
            color: rgba(5, 29, 107, 0.45);
        }

        .custom-input:focus {
            background: rgba(5, 29, 107, 0.1);
            border-color: #ffb917;
            box-shadow: 0 0 0 3px rgba(5, 29, 107, 0.25);
            outline: none;
        }

        /* ===============================
           PRIMARY BUTTON (LOGIN)
        ================================ */
        .custom-button {
            background: linear-gradient(135deg, #051D6B, #fa9f21);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .custom-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(5, 29, 107, 0.45);
        }

        /* ===============================
           GOOGLE BUTTON (NEW DESIGN)
        ================================ */
        .btn-google {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 12px; /* Padding disesuaikan agar proporsional */
            border-radius: 12px;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            color: #1f2937;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            gap: 12px;
            position: relative;
        }

        .btn-google:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -5px rgba(0,0,0,0.1);
            background-color: #f8fafc;
            border-color: #cbd5e1;
        }

        /* ===============================
           LINK STYLES
        ================================ */
        .custom-link {
            position: relative;
            color: #f97316;
            font-weight: 600;
            margin-top: 10px;
            display: inline-block;
        }

        .custom-link::after {
            content: '';
            position: absolute;
            bottom: -3px;
            left: 0;
            width: 0;
            height: 2px;
            background: #07247c;
            transition: width 0.3s ease;
        }

        .custom-link:hover::after {
            width: 100%;
        }

        /* ===============================
           CHECKBOX
        ================================ */
        .custom-checkbox {
            appearance: none;
            width: 18px;
            height: 18px;
            background: transparent;
            border: 2px solid #051D6B;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
            transition: all 0.25s ease;
            margin-top: 8px;
        }

        .remember-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 8px;
        }

        .remember-text {
            margin-top: 10px;
            line-height: 1.4;
        }

        .custom-checkbox:hover {
            background: rgba(5, 29, 107, 0.1);
        }

        .custom-checkbox:checked {
            background: #051D6B;
            border-color: #f97316;
        }

        .custom-checkbox:checked::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -55%);
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        /* ===============================
           ANIMATIONS
        ================================ */
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>


    <div class="fade-in">
        <div class="text-center mb-6">
            <h1 class="text-4xl font-bold gradient-text mb-2">
                APHIX PRIVATE
            </h1>
            <p class="text-blue-900 text-sm">
                Selamat datang kembali! Silakan login untuk melanjutkan
            </p>
        </div>

        <x-auth-session-status class="mb-4 text-center text-green-400 font-medium" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-5">
                <x-input-label for="email" :value="__('Email')" class="text-[#051D6B] font-semibold mb-2" />
                <x-text-input id="email" class="block w-full custom-input rounded-xl px-4 py-3" type="email"
                    name="email" :value="old('email')" placeholder="nama@email.com" required autofocus
                    autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
            </div>

            <div class="mb-5">
                <x-input-label for="password" :value="__('Password')" class="text-[#051D6B] font-semibold mb-2" />
                <x-text-input id="password" class="block w-full custom-input rounded-xl px-4 py-3" type="password"
                    name="password" placeholder="••••••••" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
            </div>

            <div class="flex items-start justify-between mb-6">
                <label for="remember_me" class="remember-wrapper text-sm text-blue-900 cursor-pointer">
                    <input id="remember_me" type="checkbox" class="custom-checkbox" name="remember">
                    <span class="remember-text">Remember me</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm custom-link" href="{{ route('password.request') }}">
                        Forgot your password?
                    </a>
                @endif
            </div>

            <div class="mb-6">
                <x-primary-button
                    class="w-full justify-center custom-button text-white font-bold py-3.5 rounded-xl shadow-lg relative z-10">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>

        <div class="relative my-8">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500 font-medium">atau login dengan</span>
            </div>
        </div>

        {{-- <div class="mb-6">
            <a href="{{ route('auth.google') }}" class="btn-google"> --}}
                {{-- SVG Inline agar cepat loading tanpa request eksternal --}}
                {{-- <svg width="20" height="20" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                <span>Google Account</span>
            </a>
        </div> --}}

        <div class="text-center text-sm text-blue-900">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-orange-400 font-semibold custom-link ml-1">
                Daftar sekarang
            </a>
        </div>
    </div>

    <div id="loading-overlay"
     class="hidden fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-slate-900/80 backdrop-blur-sm text-white">

    <div class="spinner mb-4"></div>
    <p class="font-semibold animate-pulse tracking-wider">Memproses...</p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('loading-overlay');

    function showLoader() {
        loader.classList.remove('hidden');
        loader.classList.add('active');
    }

    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function () {
            showLoader();

            // Disable submit button (anti spam click)
            const btn = form.querySelector('button[type="submit"]');
            if (btn) {
                btn.setAttribute('disabled', true);
            }
        });
    });

    document.querySelectorAll('.btn-google').forEach(btn => {
        btn.addEventListener('click', function () {
            showLoader();
        });
    });
});
</script>

</x-guest-layout>
