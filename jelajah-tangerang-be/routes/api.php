<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\VerifyEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Bisa diakses Guest)
|--------------------------------------------------------------------------
*/

// Group Route Artikel
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);

// Group Route Destinasi
Route::get('/destinations', [DestinationController::class, 'index']);
Route::get('/destinations/{slug}', [DestinationController::class, 'show']);

// Group Route Kategori
Route::get('/categories', [CategoryController::class, 'index']);

// Auth Public
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| VERIFICATION ROUTES
|--------------------------------------------------------------------------
*/
// Verifikasi Email (Klik link dari email)
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
      ->middleware(['signed', 'throttle:6,1'])
      ->name('verification.verify');

// Kirim Ulang Email Verifikasi
Route::post('/email/verification-notification', [VerifyEmailController::class, 'resend'])
      ->middleware(['throttle:6,1'])
      ->name('verification.send');


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (Harus Login / Punya Token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

      // User Biasa
      Route::post('/logout', [AuthController::class, 'logout']);
      Route::get('/me', [AuthController::class, 'me']);
      Route::post('/reviews', [ReviewController::class, 'store']); // User kirim review

      /*
    |--------------------------------------------------------------------------
    | ROLE: EDITOR & SUPER ADMIN (Manage Content)
    |--------------------------------------------------------------------------
    | Boleh Tambah & Edit Data (Artikel/Destinasi)
    */
      Route::group(['middleware' => ['role:super_admin|editor']], function () {
            // Kelola Destinasi
            Route::post('/destinations', [DestinationController::class, 'store']);
            Route::post('/destinations/{id}', [DestinationController::class, 'update']); // Pakai POST method spoofing buat file upload

            // Kelola Artikel
            Route::post('/articles', [ArticleController::class, 'store']);
            Route::post('/articles/{id}', [ArticleController::class, 'update']);
      });

      /*
    |--------------------------------------------------------------------------
    | ROLE: SUPER ADMIN ONLY (Dangerous Actions)
    |--------------------------------------------------------------------------
    | Boleh Hapus Data Fatal
    */
      Route::group(['middleware' => ['role:super_admin']], function () {
            Route::delete('/destinations/{id}', [DestinationController::class, 'destroy']);
            Route::delete('/articles/{id}', [ArticleController::class, 'destroy']);

            // Nanti bisa tambah Route User Management disini
            // Route::delete('/users/{id}', [UserController::class, 'destroy']);
      });
});
