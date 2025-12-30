@extends('layouts.user')

@section('title', 'E-Rapor Saya - Aphix Private')

@push('styles')

<style> /* Styling khusus progress bar agar terlihat lebih halus */ .progress-bar { transition: width 1s ease-in-out; } </style>

@endpush

@section('content')

<div class="max-w-5xl mx-auto px-6 pt-24 pb-16">

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4 animate-slide-up">
    <div>
        <h1 class="text-4xl font-black tracking-tight text-white flex items-center gap-3">
            <i class="fa-solid fa-chart-line text-orange-500"></i>
            E-Rapor Saya
        </h1>
        <p class="text-slate-400 mt-2 text-lg">
            Pantau perkembangan statistik & evaluasi performamu secara berkala.
        </p>
    </div>

    <div class="flex items-center gap-3 bg-slate-800/50 px-5 py-3 rounded-2xl border border-slate-700 backdrop-blur-sm shadow-xl">
        <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : '[https://ui-avatars.com/api/?name=](https://ui-avatars.com/api/?name=)' . urlencode(Auth::user()->name) . '&background=f97316&color=fff' }}"
             class="w-10 h-10 rounded-full border border-slate-600 object-cover">
        <div>
            <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Student</p>
            <p class="text-sm font-bold text-white">{{ Auth::user()->name }}</p>
        </div>
    </div>
</div>

<div class="space-y-8">
    @forelse($reports as $report)
        <div class="relative overflow-hidden rounded-3xl bg-slate-900 border border-slate-800 shadow-2xl transition hover:border-slate-600 group reveal">

            <div class="bg-slate-800/50 p-6 flex justify-between items-center border-b border-slate-700/50">
                <div>
                    <p class="text-slate-400 text-sm font-medium mb-1">Periode Penilaian</p>
                    <p class="text-white font-bold text-lg flex items-center gap-2">
                        <i class="fa-regular fa-calendar-days text-blue-400"></i>
                        {{ $report->created_at->format('d M Y') }}
                        <span class="text-xs bg-slate-700 text-slate-300 px-2 py-1 rounded-md font-normal ml-1">
                            {{ $report->created_at->diffForHumans() }}
                        </span>
                    </p>
                </div>

                @php
                    $avg = $report->average_score;
                    $colorClass = $avg >= 85 ? 'text-green-400 bg-green-500/10 border-green-500/20'
                                : ($avg >= 70 ? 'text-yellow-400 bg-yellow-500/10 border-yellow-500/20'
                                : 'text-red-400 bg-red-500/10 border-red-500/20');
                @endphp
                <div class="text-right">
                    <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">Rata-Rata</p>
                    <div class="px-5 py-2 rounded-xl border {{ $colorClass }}">
                        <span class="text-3xl font-black">{{ number_format($avg, 1) }}</span>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8">

                @if($report->general_note)
                <div class="mb-8 bg-blue-900/20 border border-blue-500/30 p-4 rounded-xl flex gap-4 items-start">
                    <div class="shrink-0 w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center mt-1">
                        <i class="fa-regular fa-lightbulb text-xl text-yellow-400"></i>
                    </div>
                    <div class="w-full overflow-hidden"> {{-- Tambahkan overflow-hidden --}}
                        <h4 class="text-blue-400 font-bold text-sm uppercase mb-1">Catatan Umum</h4>
                        {{-- break-words untuk mematahkan kata panjang, whitespace-pre-line untuk menjaga baris baru --}}
                        <p class="text-slate-200 text-sm leading-relaxed break-words whitespace-pre-line">{{ $report->general_note }}</p>
                    </div>
                </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">

                    <div>
                        <h3 class="text-orange-400 font-bold text-lg mb-5 flex items-center gap-2">
                            <i class="fa-solid fa-bolt"></i> Aspek Fisik
                        </h3>
                        <div class="space-y-5">
                            @foreach(['agility' => 'Kelincahan', 'speed' => 'Kecepatan', 'stamina' => 'Daya Tahan', 'strength' => 'Kekuatan'] as $key => $label)
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-slate-300">{{ $label }}</span>
                                    <span class="font-bold text-white">{{ $report->$key }}</span>
                                </div>
                                <div class="w-full bg-slate-800 rounded-full h-2.5 overflow-hidden">
                                    <div class="progress-bar bg-gradient-to-r from-orange-600 to-orange-400 h-2.5 rounded-full" style="width: {{ $report->$key }}%"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h3 class="text-blue-400 font-bold text-lg mb-5 flex items-center gap-2">
                            <i class="fa-regular fa-futbol"></i> Aspek Teknik
                        </h3>
                        <div class="space-y-5">
                            @foreach(['passing' => 'Passing', 'dribbling' => 'Dribbling', 'shooting' => 'Shooting', 'defending' => 'Defending'] as $key => $label)
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="text-slate-300">{{ $label }}</span>
                                    <span class="font-bold text-white">{{ $report->$key }}</span>
                                </div>
                                <div class="w-full bg-slate-800 rounded-full h-2.5 overflow-hidden">
                                    <div class="progress-bar bg-gradient-to-r from-blue-600 to-blue-400 h-2.5 rounded-full" style="width: {{ $report->$key }}%"></div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8 pt-8 border-t border-slate-800">
                    <div class="bg-green-500/5 border border-green-500/20 p-5 rounded-2xl h-full">
                        <h4 class="text-green-400 font-bold mb-2 flex items-center gap-2">
                            <i class="fa-solid fa-circle-check"></i> Kelebihan (Strength)
                        </h4>
                        <div class="overflow-hidden"> {{-- Tambahkan overflow-hidden --}}
                            <p class="text-slate-300 text-sm leading-relaxed break-words whitespace-pre-line">
                                {{ $report->strength_note ?? '-' }}
                            </p>
                        </div>
                    </div>
                    <div class="bg-red-500/5 border border-red-500/20 p-5 rounded-2xl h-full">
                        <h4 class="text-red-400 font-bold mb-2 flex items-center gap-2">
                            <i class="fa-solid fa-circle-exclamation"></i> Evaluasi (Improvement)
                        </h4>
                        <div class="overflow-hidden"> {{-- Tambahkan overflow-hidden --}}
                            <p class="text-slate-300 text-sm leading-relaxed break-words whitespace-pre-line">
                                {{ $report->weakness_note ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    @empty
        <div class="text-center py-20 rounded-3xl bg-slate-900/50 border border-dashed border-slate-700 animate-slide-up">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-800 text-slate-500 text-4xl mb-4">
                <i class="fa-regular fa-folder-open"></i>
            </div>
            <h3 class="text-xl font-bold text-white">Belum Ada Rapor</h3>
            <p class="text-slate-400 mt-2 max-w-sm mx-auto">
                Pelatih belum menerbitkan nilai rapor untuk akun kamu. Silakan cek lagi nanti ya!
            </p>
        </div>
    @endforelse

    @if(method_exists($reports, 'links'))
        <div class="mt-8">
            {{ $reports->links() }}
        </div>
    @endif
</div>
</div> @endsection
