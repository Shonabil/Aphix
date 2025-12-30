<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        // Ambil data order, urutkan terbaru, load relasi user agar tidak berat (Eager Loading)
        $orders = Order::with('user')->latest()->paginate(10);

        // Kirim variabel $orders ke view
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus($id)
    {
        $order = Order::findOrFail($id);

        // Toggle status: Kalau pending jadi paid, kalau paid jadi pending
        $order->status = ($order->status === 'pending') ? 'paid' : 'pending';
        $order->save();

        return redirect()->back()->with('success', 'Status pembayaran diperbarui!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('success', 'Order berhasil dihapus!');
    }
}
