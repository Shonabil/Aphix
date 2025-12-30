<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LandingGallery; // <--- 1. Wajib import model ini
use App\Models\PlayerOfTheMonth;

class DashboardController extends Controller
{
    public function index()
    {
        $landingContent = LandingGallery::latest()->get();
        $pom = PlayerOfTheMonth::all();

        return view('dashboard.index', compact('landingContent', 'pom'));
    }

    // Fungsi halaman daftar (hanya user login)
    // public function daftar()
    // {
    //     return view('dashboard.daftar');
    // }

    // Fungsi redirect WhatsApp
    public function chatWa()
    {
        return redirect()->away(
            'https://wa.me/62895803499012?text=Assalamualaikum%20Coach...'
        );
    }
}
