@extends('admin.layout')

@section('title', 'Manajemen User')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                <i class="fa-solid fa-users-gear"></i>
                User Management
            </h1>
            <p class="text-slate-400 mt-1 text-sm">Kelola data pengguna, role, dan akses sistem.</p>
        </div>
        <form method="GET" class="w-full md:w-auto">
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fa-solid fa-magnifying-glass text-slate-500 group-focus-within:text-orange-500 transition-colors"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                       class="w-full md:w-64 pl-10 pr-4 py-2.5 rounded-xl bg-slate-900 border border-slate-700 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all shadow-sm"
                       placeholder="Cari nama atau email...">
            </div>
        </form>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-950 text-slate-400 uppercase text-xs tracking-wider border-b border-slate-800">
                    <tr>
                        <th class="px-6 py-4 font-semibold">User Info</th>
                        <th class="px-6 py-4 font-semibold text-center">Role</th>
                        <th class="px-6 py-4 font-semibold">Bergabung</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-800">
                    @forelse ($users as $user)
                        <tr class="group hover:bg-slate-800/50 transition-colors duration-200">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="relative shrink-0">
                                        <img class="h-10 w-10 rounded-full object-cover border border-slate-600 group-hover:border-orange-500 transition-colors"
                                             src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=f97316&color=fff' }}" alt="{{ $user->name }}">
                                    </div>
                                    <div>
                                        <div class="font-semibold text-white group-hover:text-orange-400 transition-colors">{{ $user->name }}</div>
                                        <div class="text-sm text-slate-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($user->role === 'admin')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-purple-500/10 text-purple-400 border border-purple-500/20"><i class="fa-solid fa-shield-halved"></i> ADMIN</span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20"><i class="fa-solid fa-user"></i> STUDENT</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-sm text-slate-400">
                                <div class="flex items-center gap-2">
                                    <i class="fa-regular fa-calendar text-slate-600"></i> {{ $user->created_at->format('d M Y') }}
                                </div>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <button type="button"
                                        onclick="confirmDelete('{{ route('admin.users.destroy', $user->id) }}', '{{ $user->name }}')"
                                        class="flex items-center gap-2 px-3 py-2 bg-red-500/10 border border-red-500/20 rounded-lg text-red-500 hover:bg-red-600 hover:text-white hover:border-red-600 transition-all duration-200 ml-auto"
                                        title="Hapus Permanen">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                    <span class="text-xs font-bold">Hapus</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-500">User tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($users->hasPages())
            <div class="px-6 py-4 bg-slate-900 border-t border-slate-800">{{ $users->links() }}</div>
        @endif
    </div>

    <div id="deleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4 transition-opacity duration-300 opacity-0">
        <div class="bg-slate-900 border border-slate-700 rounded-2xl shadow-2xl w-full max-w-md transform scale-95 transition-transform duration-300" id="modalContent">

            <div class="p-6 text-center">
                <div class="mx-auto w-16 h-16 bg-red-500/10 border border-red-500/20 rounded-full flex items-center justify-center mb-5 animate-pulse">
                    <i class="fa-solid fa-triangle-exclamation text-3xl text-red-500"></i>
                </div>

                <h3 class="text-xl font-bold text-white mb-2">Konfirmasi Hapus</h3>
                <p class="text-slate-400 text-sm leading-relaxed">
                    Apakah Anda yakin ingin menghapus user <span id="modalUserName" class="text-white font-bold decoration-orange-500 underline decoration-2"></span>?
                    <br><span class="text-red-400 text-xs mt-2 block font-semibold">⚠️ Data yang dihapus tidak dapat dikembalikan.</span>
                </p>
            </div>

            <div class="flex items-center border-t border-slate-800 bg-slate-950/30 rounded-b-2xl">
                <button type="button" onclick="closeModal()"
                        class="w-1/2 py-4 text-slate-400 hover:text-white hover:bg-slate-800 font-semibold transition-colors border-r border-slate-800 first:rounded-bl-2xl">
                    Batal
                </button>

                <form id="deleteForm" method="POST" class="w-1/2">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full py-4 text-red-500 hover:text-white hover:bg-red-600 font-bold transition-colors last:rounded-br-2xl flex items-center justify-center gap-2">
                        <i class="fa-solid fa-trash"></i> Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    const modal = document.getElementById('deleteModal');
    const modalContent = document.getElementById('modalContent');
    const deleteForm = document.getElementById('deleteForm');
    const userNameSpan = document.getElementById('modalUserName');

    function confirmDelete(url, name) {
        // 1. Set URL form action sesuai user yg dipilih
        deleteForm.action = url;
        // 2. Tampilkan nama user di teks modal
        userNameSpan.textContent = name;

        // 3. Tampilkan Modal (Hapus class hidden, atur animasi masuk)
        modal.classList.remove('hidden');
        // Sedikit delay biar transisi opacity jalan
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }, 10);
    }

    function closeModal() {
        // 1. Animasi keluar
        modal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');

        // 2. Sembunyikan element setelah animasi selesai (300ms)
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    // Tutup modal jika klik di area gelap (background)
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
</script>
@endpush
