<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Eraport; // Pastikan Model Report sudah dibuat
use Illuminate\Http\Request;

class EraportController extends Controller
{
    /**
     * Menampilkan daftar siswa untuk manajemen rapor
     */
    public function index()
    {
        // Ambil hanya user dengan role 'user' (siswa)
        // 'with' digunakan agar loading halaman cepat (Eager Loading)
        $users = User::where('role', 'user')
                    ->with('eraports') // Relasi ke tabel reports
                    ->latest()
                    ->paginate(10);

        return view('admin.eraport.index', compact('users'));
    }

    /**
     * Menampilkan Form Input Rapor
     */
    public function create(User $user)
    {
        return view('admin.eraport.create', compact('user'));
    }

    /**
     * Menyimpan Data Rapor ke Database
     */
    public function store(Request $request, User $user)
    {
        // Validasi Input
        $validated = $request->validate([
            // Fisik
            'agility' => 'required|integer|min:0|max:100',
            'speed'   => 'required|integer|min:0|max:100',
            'stamina' => 'required|integer|min:0|max:100',
            'strength'=> 'required|integer|min:0|max:100',
            // Teknik
            'passing' => 'required|integer|min:0|max:100',
            'dribbling'=> 'required|integer|min:0|max:100',
            'shooting'=> 'required|integer|min:0|max:100',
            'defending'=> 'required|integer|min:0|max:100',
            // Catatan
            'strength_note' => 'nullable|string',
            'weakness_note' => 'nullable|string',
            'general_note'  => 'nullable|string', // Kolom baru (catatan umum)
            'average_score' => 'nullable|numeric', // Kolom baru (rata-rata)
        ]);

        // Simpan menggunakan Relasi
        // Pastikan model Report punya $fillable yang sesuai
        $user->eraports()->create($validated);

        return redirect()->route('admin.eraport.index')
            ->with('success', 'Rapor berhasil diterbitkan untuk ' . $user->name);
    }
}
