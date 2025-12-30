@extends('admin.layout')

@section('title', 'Manajemen Galeri')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                <i class="fa-solid fa-images text-orange-500"></i>
                Galeri Foto
            </h1>
            <p class="text-slate-400 text-sm">
                Upload foto kegiatan untuk dijual ke siswa.
            </p>
        </div>

        <a href="{{ route('admin.photos.create') }}"
           class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3
                  rounded-xl font-bold flex items-center gap-2 transition
                  shadow-lg shadow-orange-500/20">
            <i class="fa-solid fa-cloud-arrow-up"></i>
            Upload Baru
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @forelse($photos as $photo)
            <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden
                        group hover:border-orange-500/50 transition relative">

                <div class="aspect-[4/3] overflow-hidden">
                    <img src="{{ asset('storage/' . $photo->image_path) }}"
                         alt="{{ $photo->title }}"
                         class="w-full h-full object-cover
                                group-hover:scale-110 transition duration-500">
                </div>

                <div class="p-4">
                    <h3 class="font-bold text-white truncate">
                        {{ $photo->title }}
                    </h3>
                    <p class="text-orange-400 font-mono mt-1">
                        Rp {{ number_format($photo->price, 0, ',', '.') }}
                    </p>
                </div>

                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                    <button
                        onclick="openDeleteModal('{{ route('admin.photos.destroy', $photo->id) }}')"
                        class="bg-red-600 text-white w-8 h-8 rounded-lg
                               flex items-center justify-center
                               hover:bg-red-700 shadow-lg transition transform hover:scale-110">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>

            </div>
        @empty
            <div class="col-span-full text-center py-20 text-slate-500 bg-slate-900 rounded-2xl border border-dashed border-slate-700">
                <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-regular fa-image text-3xl opacity-50"></i>
                </div>
                <p>Belum ada foto yang di-upload.</p>
            </div>
        @endforelse

    </div>

    {{-- Pagination --}}
    <div class="mt-10">
        {{ $photos->links() }}
    </div>

    <div id="deleteModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/80 backdrop-blur-sm p-4 transition-opacity duration-300">

        <div class="bg-[#0f172a] border border-slate-700 w-full max-w-sm rounded-2xl p-6 shadow-2xl transform scale-100 transition-transform duration-300 relative">

            <button onclick="closeDeleteModal()" class="absolute top-4 right-4 text-slate-500 hover:text-white">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="text-center">
                <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fa-solid fa-triangle-exclamation text-3xl text-red-500"></i>
                </div>

                <h3 class="text-xl font-bold text-white mb-2">Hapus Foto Ini?</h3>
                <p class="text-slate-400 text-sm mb-6">
                    Foto yang dihapus tidak dapat dikembalikan. Pastikan kamu yakin.
                </p>

                <div class="flex gap-3">
                    <button onclick="closeDeleteModal()"
                            type="button"
                            class="flex-1 bg-slate-800 hover:bg-slate-700 text-white py-2.5 rounded-xl font-semibold transition border border-slate-700">
                        Batal
                    </button>

                    <form id="deleteForm" action="" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-xl font-bold transition shadow-lg shadow-red-900/20">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- SCRIPT MANUAL (DIJAMIN JALAN) --}}
<script>
    function openDeleteModal(actionUrl) {
        // 1. Ambil elemen modal & form
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');

        // 2. Isi action form dengan URL delete yang sesuai
        form.action = actionUrl;

        // 3. Tampilkan Modal (Hapus class hidden, tambah flex)
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');

        // Sembunyikan Modal
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Tutup modal jika klik di luar area (background hitam)
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endsection
