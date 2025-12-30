<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth; // Tidak perlu jika pakai $request->user()

class UserEraportController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data rapor milik user yang sedang login
        // Kita gunakan $request->user() karena lebih efisien (sudah di-inject)
        $reports = $request->user()
                        ->eraports() // Pastikan relasi 'eraports' ada di Model User
                        ->latest()   // Urutkan dari yang terbaru
                        ->paginate(5); // Batasi 5 per halaman

        // 2. Return View
        // PENTING: Sesuaikan string di dalam view() dengan lokasi file blade kamu.
        // Jika file kamu ada di: resources/views/user/eraport/index.blade.php
        // Maka tulisnya: 'user.eraport.index'

        return view('eraport', compact('reports'));
    }
}
