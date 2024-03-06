<?php

use App\Http\Controllers\GalleryController;
use App\Http\Controllers\UploaderFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/uploader/album/{album}', [UploaderFileController::class, 'addPhotos'])
    ->whereNumber('album')
    ->middleware('auth:sanctum');

Route::get('/gallery', [GalleryController::class, 'sharedPhotos'])
    ->middleware('auth:sanctum');