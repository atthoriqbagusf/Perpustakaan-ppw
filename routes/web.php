<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BukuImageController;
use App\Http\Controllers\UserController;

Auth::routes([
    'register' => false,
    'reset' => false,
]);

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->name('logout');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return redirect()->route('dashboard');
})->middleware('auth')->name('home');

Route::get('/buku', [BookController::class, 'index'])->name('buku.index');
Route::get('/buku/search', [BookController::class, 'search'])->name('buku.search');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [BookController::class, 'index'])->name('dashboard');

    Route::get('/buku/create', [BookController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BookController::class, 'store'])->name('buku.store');
    Route::get('/buku/{id}/edit', [BookController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{id}', [BookController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{id}', [BookController::class, 'destroy'])->name('buku.destroy');

    Route::post('/buku/{buku}/images', [BukuImageController::class, 'store'])->name('buku.images.store');
    Route::delete('/buku-images/{bukuImage}', [BukuImageController::class, 'destroy'])->name('buku-images.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('users', UserController::class)->except('show');
});