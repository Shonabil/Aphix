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
            padding: 14px;
            border-radius: 12px; /* Matches input radius */
            background-color: #ffffff;
            border: 1px solid #e2e8f0; /* Slate 200 */
            color: #1f2937; /* Gray 800 */
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
            background-color: #f8fafc; /* Slate 50 */
            border-color: #cbd5e1;
        }

        .btn-google img {
            width: 20px;
            height: 20px;
        }

        /* ===============================
           LINK STYLES
        ================================ */
        .custom-link {
            position: relative;
            color: #f97316; /* Orange */
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
                <span class="px-8 text-black font-medium">atau login dengan</span>
            </div>
        </div>

        <div class="text-center text-sm text-blue-900">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-orange-400 font-semibold custom-link ml-1">
                Daftar sekarang
            </a>
        </div>
    </div>
</x-guest-layout>
