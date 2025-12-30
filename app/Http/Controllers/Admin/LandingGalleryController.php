<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LandingGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingGalleryController extends Controller
{
    public function index()
    {
        $galleries = LandingGallery::latest()->get();
        return view('admin.landing_gallery.index', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:51200', // Max 50MB
        ]);

        $file = $request->file('file');
        $mime = $file->getMimeType();

        // Tentukan tipe file (video atau image)
        $type = str_contains($mime, 'video') ? 'video' : 'image';

        // Simpan file
        $path = $file->store('landing_content', 'public');

        LandingGallery::create([
            'file_path' => $path,
            'file_type' => $type
        ]);

        return back()->with('success', 'Konten berhasil diupload!');
    }

    public function destroy($id)
    {
        $item = LandingGallery::findOrFail($id);

        // Hapus file dari storage
        if(Storage::disk('public')->exists($item->file_path)){
            Storage::disk('public')->delete($item->file_path);
        }

        $item->delete();
        return back()->with('success', 'Konten dihapus.');
    }
}
