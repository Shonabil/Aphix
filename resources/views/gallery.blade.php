@extends('layouts.user')

@section('content')
<style>
    /* 1. PROTEKSI ALASAN */
    .protected-image {
        pointer-events: none; /* Gak bisa di drag */
        user-select: none;    /* Gak bisa di blok */
        -webkit-user-drag: none;
    }
    /* Mencegah klik kanan di seluruh area galeri */
    .gallery-container {
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Animasi Centang Sukses */
    @keyframes scaleIn {
        from { transform: scale(0); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .animate-scale-in {
        animation: scaleIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }
</style>

<div class="max-w-7xl mx-auto px-6 py-12 gallery-container" oncontextmenu="return false;"> {{-- Disable Klik Kanan --}}

    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-white mb-4">📸 Galeri Kegiatan</h2>
        <p class="text-slate-500">Pilih foto, upload bukti transfer, admin konfirmasi, lalu download.</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach($photos as $photo)
        <div class="relative group cursor-pointer"
             onclick="toggleSelect({{ $photo->id }}, {{ $photo->price }}, '{{ $photo->title }}')">

            <div id="check-{{ $photo->id }}" class="absolute top-3 right-3 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center border-2 border-white transition-all transform scale-0 opacity-0 z-20">
                <i class="fa-solid fa-check text-white"></i>
            </div>

            <div class="overflow-hidden rounded-2xl shadow-lg aspect-[3/4] relative">
                <img src="{{ asset('storage/' . $photo->image_path) }}"
                     class="w-full h-full object-cover protected-image filter brightness-75"
                     alt="Preview">

                <div class="absolute inset-0 flex items-center justify-center pointer-events-none z-10">
                    <p class="text-white/30 text-4xl font-bold -rotate-45 select-none">EITS BAYAR DULU</p>
                </div>

                <div class="absolute bottom-4 left-4 text-white z-10">
                    <p class="font-bold text-lg">Rp {{ number_format($photo->price, 0, ',', '.') }}</p>
                </div>
            </div>

            <div id="border-{{ $photo->id }}" class="absolute inset-0 border-4 border-green-500 rounded-2xl hidden pointer-events-none z-20"></div>
        </div>
        @endforeach
    </div>

    <div id="checkoutBar" class="fixed bottom-10 left-1/2 transform -translate-x-1/2 bg-slate-900 text-white px-8 py-4 rounded-full shadow-2xl flex items-center gap-6 transition-all duration-300 translate-y-32 opacity-0 z-40">
        <div>
            <p class="text-xs text-slate-400">Total Harga</p>
            <p class="font-bold text-xl text-orange-400">Rp <span id="totalPrice">0</span></p>
        </div>
        <button onclick="openPaymentModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-full font-bold transition ml-2">
            Beli & Upload Bukti
        </button>
    </div>

</div>

{{-- MODAL PEMBAYARAN --}}
<div id="paymentModal" class="fixed inset-0 bg-black/80 hidden z-50 flex items-center justify-center backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white text-slate-900 w-full max-w-md p-8 rounded-3xl shadow-2xl transform transition-all scale-100 relative max-h-[90vh] overflow-y-auto">

        <button onclick="closePaymentModal()" class="absolute top-4 right-4 text-slate-400 hover:text-red-500 transition-colors z-10 bg-slate-100 hover:bg-red-50 rounded-full w-8 h-8 flex items-center justify-center">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        <div class="text-center mb-6">
            <h3 class="text-2xl font-bold mb-1 tracking-tight">Pembayaran</h3>
            <p class="text-sm text-slate-500">Scan QRIS untuk menyelesaikan pesanan</p>
        </div>

        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 mb-6 flex flex-col items-center relative">
            <div class="bg-white p-2 rounded-xl shadow-sm border border-slate-100 mb-3">
                <img src="{{ asset('images/qr.jpg') }}"
                     alt="Scan QRIS"
                     class="w-48 h-48 object-contain">
            </div>

            <p class="font-bold text-slate-700">A.n Admin Aphix</p>

            <div class="mt-4 bg-orange-50 px-6 py-2 rounded-full border border-orange-100">
                <span class="text-xs text-orange-600 mr-2 uppercase tracking-wide font-bold">Total Tagihan</span>
                <span class="font-bold text-orange-600 text-xl">Rp <span id="modalTotalPrice">0</span></span>
            </div>
        </div>

        <form id="checkoutForm" onsubmit="submitOrder(event)">
            @csrf
            <div class="mb-6">
                <label class="block text-sm font-bold mb-2 text-slate-700">Upload Bukti Transfer</label>

                <div class="relative">
                    <input type="file" name="payment_proof" required accept="image/*"
                           onchange="previewProof(event)"
                           class="block w-full text-sm text-slate-500
                                  file:mr-4 file:py-3 file:px-4
                                  file:rounded-xl file:border-0
                                  file:text-sm file:font-bold
                                  file:bg-slate-100 file:text-orange-600
                                  hover:file:bg-orange-50
                                  cursor-pointer
                                  border border-slate-300 rounded-xl
                                  focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500">
                </div>

                <div id="proofPreviewBox" class="hidden mt-4 bg-slate-50 p-3 rounded-xl border border-dashed border-slate-300 text-center relative animate-fade-in">
                    <p class="text-xs text-slate-400 mb-2">Preview Bukti:</p>
                    <img id="proofImg" src="" class="max-h-48 mx-auto rounded-lg shadow-sm border border-slate-200">

                    <button type="button" onclick="resetProof()" class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition" title="Hapus Gambar">
                        <i class="fa-solid fa-xmark text-xs"></i>
                    </button>
                </div>

                <p class="text-[10px] text-slate-400 mt-2">
                    *Pastikan foto bukti transfer terlihat jelas.
                </p>
            </div>

            <button type="submit" id="btnSubmit" class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-4 rounded-xl transition-all shadow-lg shadow-orange-200">
                <div class="flex items-center justify-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i>
                    <span>Kirim Bukti</span>
                </div>
            </button>
        </form>
    </div>
</div>

{{-- MODAL SUKSES (BARU) --}}
<div id="successModal" class="fixed inset-0 bg-black/90 hidden z-[60] flex items-center justify-center backdrop-blur-md transition-opacity duration-500 opacity-0">
    <div class="bg-white w-full max-w-sm p-8 rounded-[2rem] shadow-2xl text-center transform scale-90 transition-transform duration-300 relative overflow-hidden">

        {{-- Confetti Decoration (Optional) --}}
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-green-400 to-green-600"></div>

        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-scale-in">
            <i class="fa-solid fa-check text-5xl text-green-600"></i>
        </div>

        <h3 class="text-2xl font-bold text-slate-800 mb-2">Pesanan Terkirim!</h3>
        <p class="text-slate-500 text-sm mb-8 leading-relaxed">
            Terima kasih! Bukti pembayaranmu sudah kami terima. Admin akan segera memverifikasinya.
        </p>

        <a href="{{ route('my.orders') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-green-200 transition-all transform hover:-translate-y-1">
            Lihat Status Pesanan
        </a>
    </div>
</div>

<script>
    let selectedPhotos = [];
    let totalPrice = 0;

    function toggleSelect(id, price, title) {
        const check = document.getElementById(`check-${id}`);
        const border = document.getElementById(`border-${id}`);
        const index = selectedPhotos.findIndex(p => p.id === id);

        if (index === -1) {
            selectedPhotos.push({ id, price, title });
            check.classList.remove('scale-0', 'opacity-0');
            check.classList.add('scale-100', 'opacity-100');
            border.classList.remove('hidden');
        } else {
            selectedPhotos.splice(index, 1);
            check.classList.add('scale-0', 'opacity-0');
            check.classList.remove('scale-100', 'opacity-100');
            border.classList.add('hidden');
        }
        updateUI();
    }

    function updateUI() {
        totalPrice = selectedPhotos.reduce((sum, item) => sum + item.price, 0);
        document.getElementById('totalPrice').innerText = new Intl.NumberFormat('id-ID').format(totalPrice);

        const bar = document.getElementById('checkoutBar');
        if (selectedPhotos.length > 0) bar.classList.remove('translate-y-32', 'opacity-0');
        else bar.classList.add('translate-y-32', 'opacity-0');
    }

    // --- LOGIKA MODAL PEMBAYARAN ---

    function openPaymentModal() {
        document.getElementById('modalTotalPrice').innerText = new Intl.NumberFormat('id-ID').format(totalPrice);
        document.getElementById('paymentModal').classList.remove('hidden');
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
        resetProof();
    }

    // --- LOGIKA MODAL SUKSES (BARU) ---
    function showSuccessModal() {
        // Tutup modal pembayaran dulu
        closePaymentModal();

        const successModal = document.getElementById('successModal');
        const modalContent = successModal.querySelector('div');

        // Tampilkan modal sukses
        successModal.classList.remove('hidden');

        // Trigger animasi fade in (perlu sedikit delay agar transisi CSS jalan)
        setTimeout(() => {
            successModal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-90');
            modalContent.classList.add('scale-100');
        }, 10);
    }

    // FUNGSI PREVIEW GAMBAR
    function previewProof(event) {
        const input = event.target;
        const previewBox = document.getElementById('proofPreviewBox');
        const img = document.getElementById('proofImg');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                previewBox.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // FUNGSI RESET GAMBAR
    function resetProof() {
        const input = document.querySelector('input[name="payment_proof"]');
        const previewBox = document.getElementById('proofPreviewBox');
        const img = document.getElementById('proofImg');

        input.value = '';
        img.src = '';
        previewBox.classList.add('hidden');
    }

    function submitOrder(e) {
        e.preventDefault();

        const btn = document.getElementById('btnSubmit');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mengirim...';
        btn.disabled = true;

        const photoIds = selectedPhotos.map(p => p.id);
        const form = document.getElementById('checkoutForm');
        const formData = new FormData(form);

        formData.append('photo_ids', JSON.stringify(photoIds));
        formData.append('total_price', totalPrice);

        fetch("{{ route('gallery.checkout') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                // TAMPILKAN MODAL SUKSES ALIH-ALIH ALERT
                showSuccessModal();

                // Opsional: Redirect otomatis setelah beberapa detik jika user diam saja
                // setTimeout(() => { window.location.href = "{{ route('my.orders') }}"; }, 5000);
            } else {
                alert('❌ Gagal: ' + data.message);
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        })
        .catch(err => {
            console.error(err);
            alert('❌ Terjadi kesalahan server.');
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }
</script>
@endsection
