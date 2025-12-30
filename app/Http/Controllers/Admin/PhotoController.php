<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
 public function index()
{
    $photos = Photo::latest()->paginate(12);
    return view('admin.photos.index', compact('photos'));
}


    public function create()
    {
        return view('admin.photos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('image')->store('photos', 'public');

        Photo::create([
            'title' => $request->title,
            'price' => $request->price,
            'image_path' => $imagePath,
        ]);

        return redirect()
            ->route('admin.photos.index')
            ->with('success', 'Foto berhasil diupload!');
    }

    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);

        if ($photo->image_path) {
            Storage::disk('public')->delete($photo->image_path);
        }

        $photo->delete();

        return back()->with('success', 'Foto dihapus!');
    }
}
