@extends('layouts.user')

@section('content')
{{-- Gunakan min-h-screen agar footer tetap di bawah, tapi konten di tengah --}}
<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 flex flex-col justify-center min-h-[60vh]">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-white flex items-center gap-2">
                <i class="fa-solid fa-box-open text-orange-700 text-lg"></i>
                Pesanan Saya
            </h1>
            <p class="text-slate-400 text-xs mt-1">
                *Pesanan otomatis hilang setelah <strong>10 hari</strong>
            </p>
        </div>

        <a href="{{ route('gallery.index') }}"
           class="inline-flex items-center gap-2 bg-slate-800 hover:bg-slate-700 text-orange-400 border border-slate-700 px-3 py-1.5 rounded text-xs font-semibold transition">
            <i class="fa-solid fa-plus text-xs"></i>
            Tambah Foto
        </a>
    </div>

    @forelse($orders as $order)

        <div class="bg-slate-900 border border-slate-700 rounded-md shadow mb-8 overflow-hidden">

            {{-- ORDER HEADER --}}
            <div class="bg-slate-950 px-4 py-3 border-b border-slate-800 flex flex-wrap justify-between items-center gap-3">
                <div class="flex items-center gap-3">
                    <span class="text-white font-semibold text-sm">#{{ $order->id }}</span>
                    <span class="text-slate-500 text-xs border-l border-slate-700 pl-3">
                        {{ $order->created_at->format('d M Y') }}
                        <span class="text-slate-600">({{ $order->created_at->diffForHumans() }})</span>
                    </span>
                </div>

                <div class="flex items-center gap-3">
                    @if($order->status == 'paid')
                        <span class="bg-green-500/10 text-green-400 border border-green-500/20 px-2 py-0.5 rounded text-[10px] font-bold uppercase">
                            Lunas
                        </span>
                    @else
                        <span class="bg-yellow-500/10 text-yellow-400 border border-yellow-500/20 px-2 py-0.5 rounded text-[10px] font-bold uppercase">
                            Menunggu
                        </span>
                    @endif

                    <span class="text-orange-500 font-semibold text-sm">
                        Rp {{ number_format($order->total_price, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- PHOTO GRID --}}
            <div class="p-4 bg-slate-900">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">

                    @foreach($order->photos_list as $photo)
                    <div class="group relative bg-slate-800 border border-slate-700 rounded overflow-hidden hover:border-orange-500/40 transition">

                        <div class="aspect-square w-full relative overflow-hidden">
                            <img src="{{ asset('storage/' . $photo->image_path) }}"
                                 class="w-full h-full object-cover transition duration-300 group-hover:scale-105 {{ $order->status != 'paid' ? 'filter brightness-50 blur-[1.5px]' : '' }}">

                            @if($order->status != 'paid')
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-white/60">
                                    <i class="fa-solid fa-lock text-lg mb-1"></i>
                                    <span class="text-[9px] uppercase font-bold tracking-widest">Locked</span>
                                </div>
                            @endif
                        </div>

                        <div class="p-2 text-center border-t border-slate-700 bg-slate-800">
                            <p class="text-[11px] text-white font-medium truncate mb-1" title="{{ $photo->title }}">
                                {{ $photo->title }}
                            </p>

                            @if($order->status == 'paid')
                                <a href="{{ route('photo.download', ['order'=>$order->id, 'photo'=>$photo->id]) }}"
                                   class="block w-full bg-green-700 hover:bg-green-600 text-white text-[9px] font-bold py-1 rounded transition">
                                    DOWNLOAD
                                </a>
                            @else
                                <button disabled
                                    class="block w-full bg-slate-700 text-slate-500 text-[9px] font-bold py-1 rounded cursor-not-allowed">
                                    PENDING
                                </button>
                            @endif
                        </div>

                    </div>
                    @endforeach

                </div>
            </div>

        </div>

    @empty
        {{-- EMPTY STATE (Tinggi disesuaikan agar tidak terlalu jauh ke footer) --}}
        <div class="flex-1 flex flex-col items-center justify-center py-10 text-center border border-dashed border-slate-700 rounded bg-slate-900/50">
            <div class="w-14 h-14 bg-slate-800 rounded-full flex items-center justify-center mb-3 text-slate-500">
                <i class="fa-regular fa-folder-open text-2xl"></i>
            </div>
            <h3 class="text-base font-semibold text-white mb-1">Tidak ada pesanan aktif</h3>
            <p class="text-slate-500 text-xs max-w-xs mx-auto mb-5">
                Pesanan mungkin sudah kadaluarsa atau kamu belum membeli foto.
            </p>
            <a href="{{ route('gallery.index') }}"
               class="bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 px-5 rounded text-xs transition">
                Beli Foto Sekarang
            </a>
        </div>
    @endforelse

</div>
@endsection
