<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    // Halaman Galeri Foto
    public function index()
    {
        $photos = Photo::latest()->get();
        return view('gallery', compact('photos'));
    }

    // Proses Simpan Order (Dipanggil via AJAX saat klik 'Beli di WA')
 public function storeOrder(Request $request)
{
    $request->validate([
        'payment_proof' => 'required|image|max:2048', // Wajib ada gambar
        'total_price' => 'required',
        'photo_ids' => 'required'
    ]);

    // 1. Simpan Bukti Transfer
    $proofPath = $request->file('payment_proof')->store('proofs', 'public');

    // 2. Decode photo_ids (karena dikirim via JSON string di JS)
    $photoIdsArray = json_decode($request->photo_ids);
    $photoIdsString = implode(',', $photoIdsArray); // Simpan "1,2,3" di DB

    // 3. Buat Order
    Order::create([
        'user_id' => Auth::id(),
        'photo_ids' => $photoIdsString,
        'total_price' => $request->total_price,
        'payment_proof' => $proofPath, // Simpan path
        'status' => 'pending'
    ]);

    return response()->json(['success' => true]);
}

// Halaman List Pesanan
public function myOrders() {
    $orders = Order::where('user_id', auth::id())->latest()->get();
    return view('user.my_orders', compact('orders'));
}

// Fitur Download Aman
public function downloadPhoto($orderId, $photoId) {
    $order = Order::where('id', $orderId)->where('user_id', auth::id())->firstOrFail();

    // CEK KEAMANAN: Cuma boleh download kalo status LUNAS
    if($order->status !== 'paid') {
        abort(403, 'Bayar dulu bos!');
    }

    $photo = \App\Models\Photo::findOrFail($photoId);

    // Download file asli
    return response()->download(storage_path('app/public/' . $photo->image_path));

{
        // LOGIKA 10 HARI: Hanya tampilkan order yang dibuat dalam 10 hari terakhir
        $orders = Order::where('user_id', Auth::id())
                        ->where('created_at', '>=', now()->subDays(10)) // <--- INI KUNCINYA
                        ->latest()
                        ->get();

        return view('user.my_orders', compact('orders'));
    }
}
}
