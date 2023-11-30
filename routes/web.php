<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use App\Models\Chirp;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', function () {
  return Inertia::render('Launchpad', [
    'chirps' => Chirp::with('user:id,name')->latest()->get(),
  ]);
})->middleware(['auth', 'verified'])
  ->name('Launchpad');

Route::resource('chirps', ChirpController::class)
  ->only(['index', 'store', 'update', 'destroy'])
  ->middleware(['auth', 'verified']);

Route::resource('likes', LikeController::class, [
  'parameters' => [
    'likes' => 'chirp',
  ],
])->middleware(['auth', 'verified']);

require __DIR__ . '/auth.php';
