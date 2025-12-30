@extends('admin.layout')

@section('title', 'Order Foto')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white flex items-center gap-3">
                <i class="fa-solid fa-camera-retro text-orange-500"></i>
                Order Foto Masuk
            </h1>
            <p class="text-slate-400 text-sm">Kelola status pembayaran dan pesanan siswa.</p>
        </div>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-white">
                <thead class="bg-slate-950 text-slate-400 uppercase text-xs border-b border-slate-800">
                    <tr>
                        <th class="p-5">Pemesan</th>
                        <th class="p-5">Detail Foto</th>
                        <th class="p-5 text-center">Bukti Transfer</th>
                        <th class="p-5 text-center">Total</th>
                        <th class="p-5 text-center">Status</th>
                        <th class="p-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    @forelse($orders as $order)
                    <tr class="hover:bg-slate-800/50 transition group">

                        <td class="p-5 align-top">
<div class="font-bold text-white">{{ optional($order->user)->name ?? 'User Terhapus' }}</div>
                            <div class="text-xs text-slate-500 mt-1">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </div>
                        </td>

                        <td class="p-5 align-top">
                            <div class="text-sm text-slate-300">
                                <span class="font-bold text-orange-400">{{ count(explode(',', $order->photo_ids)) }} Foto</span>
                                <ul class="list-disc list-inside mt-1 text-xs text-slate-500">
                                    @foreach($order->photos_list as $photo)
                                        <li class="truncate max-w-[200px]">{{ $photo->title }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </td>

                        <td class="p-5 align-top text-center">
                            @if($order->payment_proof)
                                <button onclick="openPreviewModal('{{ asset('storage/' . $order->payment_proof) }}')"
                                        class="group/img relative inline-block w-16 h-16 rounded-lg overflow-hidden border border-slate-700 hover:border-orange-500 transition cursor-zoom-in">
                                    <img src="{{ asset('storage/' . $order->payment_proof) }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover/img:opacity-100 transition">
                                        <i class="fa-solid fa-eye text-white text-xs"></i>
                                    </div>
                                </button>
                            @else
                                <span class="text-xs text-slate-500 italic">Belum upload</span>
                            @endif
                        </td>

                        <td class="p-5 text-center align-top font-bold text-orange-400">
                            Rp {{ number_format($order->total_price, 0, ',', '.') }}
                        </td>

                        <td class="p-5 text-center align-top">
                            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                    class="px-3 py-1 rounded-md text-xs font-bold border transition w-28
                                    {{ $order->status == 'paid'
                                        ? 'bg-green-500/10 text-green-500 border-green-500/20 hover:bg-red-500/10 hover:text-red-500 hover:border-red-500/30'
                                        : 'bg-yellow-500/10 text-yellow-500 border-yellow-500/20 hover:bg-green-500/10 hover:text-green-500 hover:border-green-500/30'
                                    }}">
                                    {{ $order->status == 'paid' ? 'LUNAS' : 'PENDING' }}
                                </button>
                            </form>
                            <div class="text-[10px] text-slate-500 mt-1">Klik untuk ubah</div>
                        </td>

                        <td class="p-5 text-right align-top">
                            <button onclick="openDeleteModal('{{ route('admin.orders.destroy', $order->id) }}')"
                                    class="text-slate-500 hover:text-red-500 transition p-2 rounded-lg hover:bg-red-500/10"
                                    title="Hapus Order">
                                <i class="fa-solid fa-trash-can text-lg"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-10 text-center text-slate-500">
                            <div class="flex flex-col items-center">
                                <i class="fa-regular fa-folder-open text-4xl mb-3 opacity-50"></i>
                                <p>Belum ada order masuk.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-800">
            {{ $orders->links() }}
        </div>
    </div>

</div>

<div id="previewModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center bg-black/90 backdrop-blur-sm p-4 transition-opacity duration-300" onclick="closePreviewModal()">
    <div class="relative max-w-4xl max-h-[90vh]">
        <img id="previewImage" src="" class="max-w-full max-h-[85vh] rounded-lg shadow-2xl border border-slate-700">
        <p class="text-center text-slate-400 text-sm mt-4">Klik dimana saja untuk tutup</p>
    </div>
</div>

<div id="deleteModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4 transition-opacity duration-300">
    <div class="bg-[#0f172a] border border-slate-700 w-full max-w-sm rounded-2xl p-6 shadow-2xl transform scale-100 transition-transform duration-300 relative">

        <button onclick="closeDeleteModal()" class="absolute top-4 right-4 text-slate-500 hover:text-white">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="text-center">
            <div class="w-16 h-16 bg-red-500/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-triangle-exclamation text-3xl text-red-500"></i>
            </div>

            <h3 class="text-xl font-bold text-white mb-2">Hapus Order Ini?</h3>
            <p class="text-slate-400 text-sm mb-6">
                Data order akan dihapus permanen dan tidak bisa dikembalikan.
            </p>

            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" class="flex-1 bg-slate-800 hover:bg-slate-700 text-white py-2.5 rounded-xl font-semibold transition border border-slate-700">
                    Batal
                </button>

                <form id="deleteForm" action="" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2.5 rounded-xl font-bold transition shadow-lg shadow-red-900/20">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // --- LOGIKA MODAL PREVIEW ---
    function openPreviewModal(imageUrl) {
        const modal = document.getElementById('previewModal');
        const img = document.getElementById('previewImage');
        img.src = imageUrl;
        modal.classList.remove('hidden');
    }

    function closePreviewModal() {
        document.getElementById('previewModal').classList.add('hidden');
    }

    // --- LOGIKA MODAL DELETE ---
    function openDeleteModal(actionUrl) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        form.action = actionUrl;
        modal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection
