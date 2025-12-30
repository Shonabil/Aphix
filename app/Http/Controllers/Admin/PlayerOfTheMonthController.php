<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlayerOfTheMonth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PlayerOfTheMonthController extends Controller
{
    public function index()
    {
        $players = PlayerOfTheMonth::all();
        return view('admin.pom.index', compact('players'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'image' => 'required|image|max:5120', // Max 5MB
        ]);

        $path = $request->file('image')->store('pom', 'public');

        PlayerOfTheMonth::create([
            'name' => $request->name,
            'category' => $request->category,
            'image' => $path
        ]);

        return back()->with('success', 'Player berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $player = PlayerOfTheMonth::findOrFail($id);
        Storage::disk('public')->delete($player->image);
        $player->delete();

        return back()->with('success', 'Data dihapus.');
    }
}
