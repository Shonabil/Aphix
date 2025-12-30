<x-guest-layout>
    <style>
        /* ===============================
           TITLE
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
           LABEL & INPUT
        ================================ */
        label,
        .x-input-label {
            color: #051D6B !important;
            font-weight: 600;
        }

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
            border-color: #f79e18;
            box-shadow: 0 0 0 3px rgba(5, 29, 107, 0.25);
            outline: none;
        }

        /* ===============================
           BUTTON
        ================================ */
        .custom-button {
            background: linear-gradient(135deg, #051D6B, #fa9f21);
            transition: all 0.3s ease;
        }

        .custom-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 32px rgba(5, 29, 107, 0.45);
        }

        /* ===============================
           LINK
        ================================ */
        .custom-link {
            color: #f79e18;
            font-weight: 600;
            position: relative;
        }

        .custom-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #160e87;
            transition: width 0.3s ease;
        }

        .custom-link:hover::after {
            width: 100%;
        }

        /* ===============================
           FADE
        ================================ */
        .fade-in {
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="fade-in">
        <!-- Title -->
        <div class="text-center mb-6">
            <h1 class="text-4xl font-bold gradient-text mb-2">
                Register
            </h1>
            <p class="text-blue-900 text-sm">
                Buat akun baru untuk mulai bergabung
            </p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input
                    id="name"
                    class="block w-full custom-input rounded-xl px-4 py-3"
                    type="text"
                    name="name"
                    :value="old('name')"
                    placeholder="Nama lengkap"
                    required
                    autofocus
                    autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input
                    id="email"
                    class="block w-full custom-input rounded-xl px-4 py-3"
                    type="email"
                    name="email"
                    :value="old('email')"
                    placeholder="nama@email.com"
                    required
                    autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input
                    id="password"
                    class="block w-full custom-input rounded-xl px-4 py-3"
                    type="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
            </div>

            <!-- Confirm Password -->
            <div class="mb-6">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input
                    id="password_confirmation"
                    class="block w-full custom-input rounded-xl px-4 py-3"
                    type="password"
                    name="password_confirmation"
                    placeholder="Ulangi password"
                    required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
            </div>

            <!-- Action -->
            <div class="flex items-center justify-between">
                <a href="{{ route('login') }}" class="text-sm custom-link">
                    Sudah punya akun?
                </a>

                <x-primary-button class="custom-button text-white font-bold px-6 py-3 rounded-xl">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
