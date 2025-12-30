@extends('admin.layout')
@section('title', 'Konten Beranda')

@section('content')
<div class="max-w-6xl mx-auto px-6 py-10 relative">
    <h1 class="text-3xl font-bold text-white mb-8 flex items-center gap-3">
        <i class="fa-solid fa-layer-group text-orange-500"></i> Konten Slide Beranda
    </h1>

    {{-- Form Upload --}}
    <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl mb-10 shadow-lg">
        <h3 class="text-white font-bold mb-4">Upload Video/Foto Baru</h3>
        <form action="{{ route('admin.landing_gallery.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-4 items-end">
            @csrf
            <div class="flex-1 w-full">
                <input type="file" name="file" required class="block w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-500 file:text-white hover:file:bg-orange-600 cursor-pointer bg-slate-800 rounded-lg border border-slate-700 focus:outline-none focus:border-orange-500">
                <p class="text-xs text-slate-500 mt-2">*Support: JPG, PNG, MP4 (Max 30MB)</p>
            </div>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-bold transition shadow-lg shadow-green-900/20 w-full md:w-auto">
                <i class="fa-solid fa-cloud-arrow-up mr-2"></i> Upload
            </button>
        </form>
    </div>

    {{-- Grid Gallery --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($galleries as $item)
        <div class="relative group bg-slate-900 rounded-xl overflow-hidden border border-slate-800 shadow-md transition-all hover:border-orange-500/50">
            @if($item->file_type == 'video')
                <video src="{{ asset('storage/' . $item->file_path) }}" class="w-full h-40 object-cover" muted loop autoplay></video>
                <div class="absolute top-2 left-2 bg-black/60 backdrop-blur-sm px-2 py-1 rounded text-[10px] font-bold text-white tracking-wider border border-white/10">VIDEO</div>
            @else
                <img src="{{ asset('storage/' . $item->file_path) }}" class="w-full h-40 object-cover hover:scale-105 transition duration-500">
                <div class="absolute top-2 left-2 bg-orange-500/90 backdrop-blur-sm px-2 py-1 rounded text-[10px] font-bold text-white tracking-wider shadow-sm">FOTO</div>
            @endif

            {{-- Tombol Hapus (Memicu Modal) --}}
            <button onclick="openDeleteModal('{{ route('admin.landing_gallery.destroy', $item->id) }}')"
                    class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-all transform translate-y-2 group-hover:translate-y-0 bg-red-600 text-white w-8 h-8 rounded-lg flex items-center justify-center hover:bg-red-700 shadow-lg cursor-pointer z-10">
                <i class="fa-solid fa-trash text-sm"></i>
            </button>
        </div>
        @endforeach
    </div>
</div>

{{-- ========================================== --}}
{{-- MODAL HAPUS (Mirip Referensi Gambar) --}}
{{-- ========================================== --}}
<div id="deleteModal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center" aria-labelledby="modal-title" role="dialog" aria-modal="true">

    {{-- Backdrop (Gelap) --}}
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity opacity-0" id="modalBackdrop"></div>

    {{-- Modal Panel --}}
    <div class="relative bg-[#0f172a] rounded-2xl shadow-2xl w-full max-w-sm p-6 transform scale-95 opacity-0 transition-all border border-slate-700 text-center" id="modalPanel">

        {{-- Tombol Close (X) --}}
        <button onclick="closeDeleteModal()" class="absolute top-4 right-4 text-slate-400 hover:text-white transition">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        {{-- Ikon Peringatan --}}
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-500/10 mb-4">
            <i class="fa-solid fa-triangle-exclamation text-red-500 text-3xl"></i>
        </div>

        {{-- Judul & Deskripsi --}}
        <h3 class="text-xl font-bold text-white mb-2" id="modal-title">Hapus Foto Ini?</h3>
        <p class="text-sm text-slate-400 mb-8 leading-relaxed">
            Foto yang dihapus tidak dapat dikembalikan. Pastikan kamu yakin.
        </p>

        {{-- Tombol Aksi --}}
        <div class="grid grid-cols-2 gap-4">
            <button type="button" onclick="closeDeleteModal()" class="w-full py-2.5 rounded-lg bg-slate-700 hover:bg-slate-600 text-white font-semibold transition">
                Batal
            </button>

            <form id="deleteForm" method="POST" action="" class="w-full">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold transition shadow-lg shadow-red-900/20">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT PENGENDALI MODAL --}}
<script>
    const modal = document.getElementById('deleteModal');
    const backdrop = document.getElementById('modalBackdrop');
    const panel = document.getElementById('modalPanel');
    const deleteForm = document.getElementById('deleteForm');

    function openDeleteModal(url) {
        deleteForm.action = url;
        modal.classList.remove('hidden');

        // Animasi Masuk
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            panel.classList.remove('opacity-0', 'scale-95');
            panel.classList.add('opacity-100', 'scale-100');
        }, 10);
    }

    function closeDeleteModal() {
        // Animasi Keluar
        backdrop.classList.add('opacity-0');
        panel.classList.remove('opacity-100', 'scale-100');
        panel.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    backdrop.addEventListener('click', closeDeleteModal);
</script>
@endsection
