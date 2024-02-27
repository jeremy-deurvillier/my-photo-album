<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [DashboardController::class, 'statistics'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/albums', [AlbumController::class, 'collection'])
    ->middleware(['auth', 'verified'])->name('albums');

Route::post('/albums', [AlbumController::class, 'create'])
    ->middleware(['auth', 'verified'])->name('album.create');

Route::patch('/albums/{album}', [AlbumController::class, 'update'])
    ->middleware(['auth', 'verified'])->name('album.update');

Route::delete('/albums/{album}', [AlbumController::class, 'delete'])
    ->middleware(['auth', 'verified'])->name('album.delete');

Route::get('/albums/{album}', [AlbumController::class, 'single'])
    ->middleware(['auth', 'verified'])->name('album.read');

Route::post('/albums/{album}', [AlbumController::class, 'addPhotos'])
    ->middleware(['auth', 'verified'])->name('photos.add');

Route::get('/photos/{photo}', [AlbumController::class, 'showPhoto'])
    ->middleware('auth', 'verified')->name('file.show');

Route::delete('/photos/{photo}', [AlbumController::class, 'deletePhoto'])
    ->middleware(['auth', 'verified'])->name('photo.delete');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
