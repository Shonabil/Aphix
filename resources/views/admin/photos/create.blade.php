@extends('admin.layout')

@section('title', 'Upload Foto')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">

    <h1 class="text-3xl font-bold text-white mb-8 flex items-center gap-3">
        <i class="fa-solid fa-cloud-arrow-up text-orange-500"></i>
        Upload Foto Baru
    </h1>

    <form action="{{ route('admin.photos.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-slate-900 border border-slate-800 rounded-2xl p-8 space-y-6">

        @csrf

        {{-- Judul --}}
        <div>
            <label class="block text-slate-300 mb-2 font-semibold">
                Judul Foto
            </label>
            <input
                type="text"
                name="title"
                value="{{ old('title') }}"
                placeholder="Contoh: Kegiatan Latihan Sore"
                class="w-full rounded-xl bg-slate-800 border border-slate-700
                       text-white px-4 py-3 focus:ring-2
                       focus:ring-orange-500 focus:outline-none placeholder-slate-500"
                required>
            @error('title')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Harga --}}
        <div>
            <label class="block text-slate-300 mb-2 font-semibold">
                Harga (Rp)
            </label>
            <input
                type="number"
                name="price"
                value="{{ old('price') }}"
                placeholder="0"
                class="w-full rounded-xl bg-slate-800 border border-slate-700
                       text-white px-4 py-3 focus:ring-2
                       focus:ring-orange-500 focus:outline-none placeholder-slate-500"
                required>
            @error('price')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Foto & Preview --}}
        <div>
            <label class="block text-slate-300 mb-2 font-semibold">
                File Foto
            </label>

            <div class="relative border-2 border-dashed border-slate-700 rounded-xl p-6 text-center hover:bg-slate-800/50 transition cursor-pointer group" onclick="document.getElementById('imageInput').click()">

                <input
                    id="imageInput"
                    type="file"
                    name="image"
                    accept="image/*"
                    class="hidden"
                    onchange="previewImage(event)"
                    required>

                <div id="uploadPlaceholder" class="flex flex-col items-center justify-center py-4">
                    <div class="w-16 h-16 bg-slate-800 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition">
                        <i class="fa-solid fa-image text-3xl text-slate-500 group-hover:text-orange-500 transition"></i>
                    </div>
                    <p class="text-slate-400 font-medium">Klik untuk pilih foto</p>
                    <p class="text-xs text-slate-600 mt-1">PNG, JPG, JPEG (Max 5MB)</p>
                </div>

                <div id="imagePreviewContainer" class="hidden relative mt-2">
                    <img id="imagePreview" src="#" alt="Preview" class="max-h-64 mx-auto rounded-lg shadow-lg border border-slate-700">

                    <div class="mt-3">
                        <span class="text-xs text-orange-400 hover:text-orange-300 underline cursor-pointer">
                            Ganti Foto Lain
                        </span>
                    </div>
                </div>

            </div>

            @error('image')
                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-4 pt-6 border-t border-slate-800">
            <a href="{{ route('admin.photos.index') }}"
               class="px-6 py-3 rounded-xl bg-slate-800 border border-slate-700
                      text-slate-300 hover:bg-slate-700 hover:text-white transition">
                Batal
            </a>

            <button
                type="submit"
                class="px-8 py-3 rounded-xl bg-orange-500
                       text-white font-bold hover:bg-orange-600
                       transition shadow-lg shadow-orange-500/20 transform hover:-translate-y-1">
                <i class="fa-solid fa-cloud-arrow-up mr-2"></i> Upload Sekarang
            </button>
        </div>

    </form>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const placeholder = document.getElementById('uploadPlaceholder');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewImage = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;

                // Sembunyikan placeholder, Tampilkan preview
                placeholder.classList.add('hidden');
                previewContainer.classList.remove('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
