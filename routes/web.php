<?php

use App\Http\Controllers\Admin\LandingGalleryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EraportController;
use App\Http\Controllers\User\UserEraportController;
use App\Http\Controllers\User\GalleryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PhotoController;
use App\Http\Controllers\Admin\PlayerOfTheMonthController;
use App\Http\Controllers\Auth\SocialAuthController; // Added SocialAuthController import

/*
|--------------------------------------------------------------------------
| PUBLIC (GUEST)
|--------------------------------------------------------------------------
*/
Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER (Siswa & Umum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // DASHBOARD & UTILS
    Route::get('/daftar', [DashboardController::class, 'daftar'])
        ->name('daftar');

    Route::get('/chat-wa', [DashboardController::class, 'chatWa'])
        ->name('chat.wa');

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // MENU USER: E-RAPORT
    Route::get('/e-raport', [UserEraportController::class, 'index'])
        ->name('eraport');

    // MENU USER: GALLERY & BELI FOTO
    Route::get('/gallery', [GalleryController::class, 'index'])
        ->name('gallery.index');
    Route::post('/gallery/checkout', [GalleryController::class, 'storeOrder'])
        ->name('gallery.checkout');

    // --- [BARU] MENU USER: PESANAN SAYA & DOWNLOAD ---
    Route::get('/my-orders', [GalleryController::class, 'myOrders'])
        ->name('my.orders');

    Route::get('/download/{order}/{photo}', [GalleryController::class, 'downloadPhoto'])
        ->name('photo.download');

});

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // DASHBOARD
        Route::get('/', [AdminController::class, 'index'])
            ->name('dashboard');

        // USER MANAGEMENT
        Route::get('/users', [AdminController::class, 'users'])
            ->name('users');
        Route::delete('/users/{id}', [AdminController::class, 'destroy'])
            ->name('users.destroy');

        // MANAJEMEN E-RAPORT
        Route::get('/e-raport', [EraportController::class, 'index'])
            ->name('eraport.index');
        Route::get('/e-raport/{user}', [EraportController::class, 'create'])
            ->name('eraport.create');
        Route::post('/e-raport/{user}', [EraportController::class, 'store'])
            ->name('eraport.store');

        // MANAJEMEN ORDER FOTO (UBAH STATUS PEMBAYARAN)
        Route::get('/orders', [OrderController::class, 'index'])
            ->name('orders.index');
        Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])
            ->name('orders.status');
        Route::delete('/orders/{id}', [OrderController::class, 'destroy'])
            ->name('orders.destroy');

        // MANAJEMEN FOTO (UPLOAD GALERI)
        Route::get('/photos', [PhotoController::class, 'index'])
            ->name('photos.index');
        Route::get('/photos/create', [PhotoController::class, 'create'])
            ->name('photos.create');
        Route::post('/photos', [PhotoController::class, 'store'])
            ->name('photos.store');
        Route::delete('/photos/{id}', [PhotoController::class, 'destroy'])
            ->name('photos.destroy');


          Route::get('/landing-gallery', [LandingGalleryController::class, 'index'])->name('landing_gallery.index');
    Route::post('/landing-gallery', [LandingGalleryController::class, 'store'])->name('landing_gallery.store');
    Route::delete('/landing-gallery/{id}', [LandingGalleryController::class, 'destroy'])->name('landing_gallery.destroy');


Route::resource('pom', PlayerOfTheMonthController::class)->except(['create', 'edit', 'show', 'update']);
});

/*
|--------------------------------------------------------------------------
| SOCIAL AUTH (GOOGLE) - NEW
|--------------------------------------------------------------------------
*/
Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);


/*
|--------------------------------------------------------------------------
| AUTH (BREEZE)
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';
