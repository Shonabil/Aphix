@extends('admin.layout')

@section('title', 'Manajemen E-Rapor')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                <i class="fa-solid fa-file-signature"></i>
                Manajemen E-Rapor
            </h1>
            <p class="text-slate-400 mt-1 text-sm">Kelola nilai dan evaluasi performa siswa.</p>
        </div>

        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-slate-500 group-focus-within:text-orange-500 transition-colors"></i>
            </div>
            <input type="text"
                   placeholder="Cari nama siswa..."
                   class="bg-slate-900 text-white pl-10 pr-4 py-3 rounded-xl border border-slate-700 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 w-full md:w-64 transition-all shadow-sm placeholder-slate-500">
        </div>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-white border-collapse">
                <thead class="bg-slate-950 uppercase text-xs tracking-wider text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="p-5 font-semibold">Siswa</th>
                        <th class="p-5 font-semibold text-center">Total Rapor</th>
                        <th class="p-5 font-semibold text-center">Rata-Rata Terakhir</th>
                        <th class="p-5 font-semibold text-center">Update Terakhir</th>
                        <th class="p-5 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($users as $user)
                    <tr class="group hover:bg-slate-800/50 transition-colors duration-200">
                        <td class="p-5">
                            <div class="flex items-center gap-4">
                                <div class="relative shrink-0">
                                    <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=f97316&color=fff' }}"
                                         alt="{{ $user->name }}"
                                         class="w-12 h-12 rounded-full object-cover border border-slate-600 group-hover:border-orange-500 transition-colors">
                                </div>
                                <div>
                                    <h3 class="font-bold text-white text-base group-hover:text-orange-400 transition-colors">{{ $user->name }}</h3>
                                    <p class="text-slate-500 text-sm">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="p-5 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-800 border border-slate-700 text-white font-bold text-sm">
                                {{ $user->eraports->count() }}
                            </span>
                        </td>

                        <td class="p-5 text-center">
                            @php
                                $lastReport = $user->eraports->last();
                            @endphp

                            @if($lastReport && $lastReport->average_score)
                                @php
                                    $score = $lastReport->average_score;
                                    $color = $score >= 85 ? 'text-green-400' : ($score >= 70 ? 'text-yellow-400' : 'text-red-400');
                                @endphp
                                <span class="text-xl font-black {{ $color }}">{{ number_format($score, 1) }}</span>
                            @else
                                <span class="text-slate-600 text-sm italic flex items-center justify-center gap-1">
                                    <i class="fa-solid fa-minus"></i> Belum ada
                                </span>
                            @endif
                        </td>

                        <td class="p-5 text-center">
                            @if($lastReport)
                                <div class="flex flex-col items-center">
                                    <div class="flex items-center gap-2 text-sm font-medium text-slate-300">
                                        <i class="fa-regular fa-calendar-days text-slate-500"></i>
                                        {{ $lastReport->created_at->format('d M Y') }}
                                    </div>
                                    <span class="text-xs text-slate-500 mt-1">
                                        {{ $lastReport->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            @else
                                <span class="text-slate-600">-</span>
                            @endif
                        </td>

                        <td class="p-5 text-right">
                            <div class="flex items-center justify-end gap-2 opacity-90 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.eraport.create', $user) }}"
                                   class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-4 py-2 rounded-lg font-medium text-sm shadow-lg shadow-orange-900/20 transition-all flex items-center gap-2 transform hover:scale-105">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Input Nilai</span>
                                </a>

                                <button class="bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white border border-slate-700 px-3 py-2 rounded-lg transition-all" title="Lihat Riwayat">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-user-graduate text-3xl opacity-50"></i>
                                </div>
                                <p class="text-xl font-semibold mb-1 text-slate-400">Belum ada siswa</p>
                                <p class="text-sm">Silakan tambahkan user baru di menu Users.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($users, 'links'))
        <div class="p-4 border-t border-slate-800 bg-slate-900">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
