<x-guest-layout>

    {{-- FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        /* ===============================
           BASE ANIMATION
        ================================ */
        .animate-enter {
            animation: enter .5s cubic-bezier(.16, 1, .3, 1) forwards;
            opacity: 0;
            transform: translateY(12px);
            will-change: transform, opacity;
        }

        .delay-100 { animation-delay: .08s; }
        .delay-200 { animation-delay: .16s; }

        @keyframes enter {
            to { opacity: 1; transform: none; }
        }

        /* ===============================
           INPUT
        ================================ */
        .input-group { position: relative; }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #051D6B;
            opacity: .45;
            transition: .25s ease;
            pointer-events: none;
        }

        .custom-input {
            padding-left: 48px !important;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            transition: border-color .2s, box-shadow .2s;
        }

        .custom-input:focus {
            background: #fff;
            border-color: #f97316;
            box-shadow: 0 0 0 4px rgba(249,115,22,.12);
            outline: none;
        }

        .custom-input:focus ~ .input-icon {
            opacity: 1;
            color: #f97316;
        }

        /* ===============================
           BUTTON (SAMA DENGAN LOGIN)
        ================================ */
       .custom-button {
    background: linear-gradient(
        90deg,
        #1f2a5a 0%,
        #3b3f78 35%,
        #c98a2a 70%,
        #f2a93b 100%
    );
    transition: transform .25s ease, box-shadow .25s ease;
}

.custom-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px -6px rgba(31, 42, 90, .55);
}


        /* ===============================
           LINK
        ================================ */
        .link-back {
            color: #132557;
            transition: .2s;
        }

        .link-back:hover {
            color: #ab5520;
            transform: translateX(-3px);
        }
    </style>

    <div class="w-full max-w-sm mx-auto">

        {{-- Header --}}
        <div class="text-center mb-8 animate-enter">
            <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-blue-50 flex items-center justify-center border border-blue-100 shadow-sm">
                <i class="fa-solid fa-key text-2xl text-[#051D6B]"></i>
            </div>

            <h1 class="text-2xl font-black text-[#051D6B] mb-2">
                Lupa Kata Sandi?
            </h1>

            <p class="text-sm text-black px-2 leading-relaxed">
                Jangan khawatir. Masukkan email Anda dan kami akan mengirimkan link reset password.
            </p>
        </div>

        {{-- Status --}}
        <x-auth-session-status
            class="mb-4 text-sm text-center font-medium text-green-600 bg-green-50 p-3 rounded-xl border border-green-100 animate-enter"
            :status="session('status')" />

        {{-- Form --}}
        <form method="POST" action="{{ route('password.email') }}" class="space-y-6 animate-enter delay-100">
            @csrf

            <div>
                <x-input-label
                    for="email"
                    value="Email Address"
                    class="text-xs font-extrabold uppercase tracking-wide mb-0.5 ml-1 relative -top-1 text-black" />

                <div class="input-group">
                    <x-text-input
                        id="email"
                        name="email"
                        type="email"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="nama@email.com"
                        class="block w-full rounded-xl py-3 custom-input" />

                    <i class="fa-regular fa-envelope input-icon"></i>
                </div>

                <x-input-error
                    :messages="$errors->get('email')"
                    class="mt-1 text-xs text-red-500 font-semibold ml-1" />
            </div>

            <button
                type="submit"
                class="w-full justify-center custom-button text-white font-bold py-3.5 rounded-xl shadow-lg relative z-10">
                Kirim Link Reset
            </button>

            <div class="text-center pt-2 animate-enter delay-200">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm link-back">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                    Kembali ke Login
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>
