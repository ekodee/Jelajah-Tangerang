<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\VerifyEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Group Route Artikel
Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);

// Group Route Destinasi
Route::get('/destinations', [DestinationController::class, 'index']);
Route::get('/destinations/{slug}', [DestinationController::class, 'show']);

// Group Route Kategori
Route::get('/categories', [CategoryController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (Harus Login)
Route::middleware('auth:sanctum')->group(function () {
      Route::post('/logout', [AuthController::class, 'logout']);
      Route::get('/me', [AuthController::class, 'me']);

      // Pindahkan route post review ke sini agar aman
      Route::post('/reviews', [ReviewController::class, 'store']);
});

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'verify'])
      ->middleware(['signed', 'throttle:6,1'])
      ->name('verification.verify');

Route::post('/email/verification-notification', [VerifyEmailController::class, 'resend'])
      ->middleware(['throttle:6,1'])
      ->name('verification.send');
