@extends('layouts.user')

@section('content')
    {{--
       WRAPPER UTAMA
       pt-24: Memberi jarak agar tidak tertutup Navbar
       bg-slate-950: Warna background gelap (Hampir hitam)
    --}}
    <div class="pt-24 pb-12 bg-slate-950 min-h-screen">

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="flex flex-col gap-1">
                <h1 class="text-3xl font-bold text-white">
                    Pengaturan Akun
                </h1>
                <p class="text-gray-400">
                    Kelola informasi profil, keamanan password, dan data akun kamu.
                </p>
            </div>

            <div>
                @include('profile.partials.update-profile-information-form')
            </div>

        </div>
    </div>
@endsection
