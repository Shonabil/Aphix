<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * ADMIN DASHBOARD
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // proteksi admin
        if ($user->role !== 'admin') {
            abort(403, 'Bukan admin');
        }

        $totalUser = User::count();

        $userToday = User::whereDate('created_at', today())->count();

        $usersPerDay = User::selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $roleCount = User::selectRaw('role, COUNT(*) as total')
            ->groupBy('role')
            ->pluck('total', 'role');

        return view('admin.dashboard', compact(
            'totalUser',
            'userToday',
            'usersPerDay',
            'roleCount'
        ));

        
    }

    /**
     * USER MANAGEMENT
     */
    public function users(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            abort(403, 'Bukan admin');
        }

        $users = User::latest()
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('name', 'like', "%{$request->search}%")
                          ->orWhere('email', 'like', "%{$request->search}%");
                });
            })
            ->paginate(10);

        return view('admin.users', compact('users'));
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')
            ->with('success', 'User berhasil dihapus');
    }

    public function eraportIndex() // Atau nama method kamu
{

    $users = \App\Models\User::where('role', 'user') // Sesuaikan kolom role kamu
                ->with('eraports') // Pastikan nama relasi di Model User adalah 'eraports'
                ->latest()
                ->paginate(10);

    return view('admin.eraport.index', compact('users'));
}
}
