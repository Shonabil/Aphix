@extends('admin.layout')

@section('title', 'Kelola Player of The Month')

@section('content')
<div class="p-6 relative">

    {{-- Header dengan Gradient Text ala Aphix --}}
    <div class="mb-8 flex justify-between items-center animate-fade-in-down">
        <div>
            <h1 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-400">
                Player of The Month
            </h1>
            <p class="text-orange-500 text-sm mt-1 tracking-wider uppercase font-semibold">Hall of Fame Management</p>
        </div>
    </div>

    {{-- Pesan Sukses --}}
    @if(session('success'))
        <div class="bg-green-500/10 border border-green-500/50 text-green-400 px-4 py-3 rounded-xl mb-6 backdrop-blur-sm shadow-lg shadow-green-500/10 flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-xl"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Validasi --}}
    @if ($errors->any())
        <div class="bg-red-500/10 border border-red-500/50 text-red-400 px-4 py-3 rounded-xl mb-6 backdrop-blur-sm shadow-lg shadow-red-500/10">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- FORM INPUT (Kiri) --}}
        <div class="lg:col-span-1">
            <div class="bg-[#0f172a] border border-slate-800 rounded-2xl shadow-2xl p-6 relative z-20">
                <h2 class="text-xl font-bold text-white mb-6 border-b border-slate-700 pb-4 flex items-center gap-2">
                    <i class="fa-solid fa-user-plus text-orange-500"></i> Tambah Pemenang
                </h2>

                <form action="{{ route('admin.pom.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Nama --}}
                    <div class="mb-5 relative">
                        <label class="block text-slate-300 text-sm font-bold mb-2 ml-1">Nama Pemain</label>
                        <input type="text" name="name"
                               class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-orange-500/30 focus:border-orange-500 bg-white text-black font-semibold placeholder-slate-400 relative z-30 transition-all"
                               placeholder="Contoh: Budi Santoso" required autocomplete="off">
                    </div>

                    {{-- Kategori --}}
                    <div class="mb-5 relative">
                        <label class="block text-slate-300 text-sm font-bold mb-2 ml-1">Kategori Juara</label>
                        <select name="category"
                                class="w-full px-4 py-3 border border-slate-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-orange-500/30 focus:border-orange-500 bg-white text-black font-semibold relative z-30 transition-all cursor-pointer" required>
                            <option value="" class="text-slate-400">Pilih Kategori...</option>
                            <option value="Most Disciplined">Most Disciplined (Paling Disiplin)</option>
                            <option value="Top Scorer">Top Scorer (Pencetak Gol)</option>
                            <option value="MVP">MVP (Pemain Terbaik)</option>
                            <option value="Best Attitude">Best Attitude</option>
                            <option value="Most Improved">Most Improved (Paling Berkembang)</option>
                        </select>
                    </div>

                    {{-- Upload Foto --}}
                    <div class="mb-8 relative">
                        <label class="block text-slate-300 text-sm font-bold mb-2 ml-1">Foto Pemain</label>
                        <div class="relative z-30">
                            <input type="file" name="image" class="block w-full text-sm text-slate-300
                                file:mr-4 file:py-2.5 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-bold
                                file:bg-orange-600 file:text-white
                                hover:file:bg-orange-500
                                cursor-pointer file:cursor-pointer" required>
                        </div>
                        <p class="text-xs text-slate-500 mt-2 ml-1">Format: JPG, PNG. Max: 5MB.</p>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-orange-600 to-orange-500 hover:from-orange-500 hover:to-orange-400 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-orange-500/20 transform hover:-translate-y-1 transition duration-300 relative z-30 cursor-pointer">
                        <i class="fa-solid fa-trophy mr-2"></i> Tambahkan ke Hall of Fame
                    </button>
                </form>
            </div>
        </div>

        {{-- LIST DATA (Kanan) --}}
        <div class="lg:col-span-2">
            <div class="bg-[#0f172a] border border-slate-800 rounded-2xl shadow-2xl overflow-hidden relative z-10">
                <div class="bg-slate-900/50 px-6 py-5 border-b border-slate-700 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-white">Daftar Pemenang Aktif</h2>
                    <span class="bg-slate-800 text-slate-400 px-3 py-1 rounded-lg text-xs font-mono">Total: {{ $players->count() }}</span>
                </div>

                @if($players->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-800/80 text-orange-400 uppercase text-xs tracking-wider font-bold">
                                    <th class="py-4 px-6">Foto</th>
                                    <th class="py-4 px-6">Profile</th>
                                    <th class="py-4 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-slate-300 text-sm">
                                @foreach($players as $player)
                                <tr class="border-b border-slate-800 hover:bg-slate-800/50 transition duration-200">
                                    <td class="py-4 px-6">
                                        <div class="w-16 h-20 overflow-hidden rounded-lg shadow-md border border-slate-700 ring-2 ring-transparent group-hover:ring-orange-500/30 transition">
                                            <img src="{{ asset('storage/' . $player->image) }}" class="w-full h-full object-cover">
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 align-middle">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-lg text-white mb-1">{{ $player->name }}</span>
                                            <span class="inline-flex w-fit items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-orange-500/10 text-orange-400 border border-orange-500/20">
                                                {{ $player->category }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-center align-middle">
                                        {{-- Tombol Hapus (Panggil Modal) --}}
                                        <button type="button"
                                                onclick="openDeleteModal('{{ route('admin.pom.destroy', $player->id) }}')"
                                                class="text-red-400 hover:text-white hover:bg-red-500 px-3 py-2 rounded-lg transition duration-200 group"
                                                title="Hapus Data">
                                            <i class="fa-solid fa-trash group-hover:animate-bounce"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-16 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-800 mb-6 animate-pulse">
                            <i class="fa-solid fa-trophy text-4xl text-slate-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Belum ada Pemenang</h3>
                        <p class="text-slate-400 max-w-sm mx-auto">Data Player of the Month masih kosong. Input data melalui formulir di samping kiri.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

{{-- ========================================== --}}
{{-- MODAL HAPUS (Desain Baru) --}}
{{-- ========================================== --}}
<div id="deleteModal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center" aria-labelledby="modal-title" role="dialog" aria-modal="true">

    {{-- Backdrop Gelap --}}
    <div class="fixed inset-0 bg-black/70 backdrop-blur-sm transition-opacity opacity-0" id="modalBackdrop"></div>

    {{-- Panel Modal --}}
    <div class="relative bg-[#0f172a] rounded-2xl shadow-2xl w-full max-w-sm p-6 transform scale-95 opacity-0 transition-all border border-slate-700 text-center" id="modalPanel">

        {{-- Tombol Close (X) --}}
        <button onclick="closeDeleteModal()" class="absolute top-4 right-4 text-slate-400 hover:text-white transition">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        {{-- Ikon Peringatan Merah --}}
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-red-500/10 mb-4">
            <i class="fa-solid fa-triangle-exclamation text-red-500 text-3xl"></i>
        </div>

        {{-- Judul & Deskripsi --}}
        <h3 class="text-xl font-bold text-white mb-2" id="modal-title">Hapus Pemenang Ini?</h3>
        <p class="text-sm text-slate-400 mb-8 leading-relaxed">
            Data pemenang yang dihapus tidak dapat dikembalikan. Pastikan kamu yakin.
        </p>

        {{-- Tombol Aksi (Grid) --}}
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
