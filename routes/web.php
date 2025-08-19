<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TacheController;
use Illuminate\Support\Facades\Route;

// Page d'accueil


// Profil utilisateur
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/profile', [ProfileController::class, 'show'])
     ->name('profile.show')
     ->middleware('auth');
Route::get('/profile/edit', function () {
    return view('profile.edit');
})->name('profile.edit');

// Gestion des utilisateurs (admin)
Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});
    Route::post('/taches', [TacheController::class, 'store'])->name('taches.store');
    // Gestion des tâches
    Route::middleware(['auth'])->group(function () {
    // Routes spécifiques d'abord
    Route::get('/taches/futures', [TacheController::class, 'futures'])->name('taches.futures');
    Route::get('/taches/accomplies', [TacheController::class, 'accomplies'])->name('taches.accomplies');
    Route::post('/taches/{id}/accomplir', [TacheController::class, 'accomplir'])->name('taches.accomplir');
    Route::post('/taches/{id}/reporter', [TacheController::class, 'reporter'])->name('taches.reporter');
    

    // Si vous utilisez Route::resource()
Route::resource('taches', TacheController::class)->middleware(['auth']);

// OU si vous utilisez des routes séparées
Route::get('/taches/create', [TacheController::class, 'create'])->name('taches.create')->middleware('auth');
Route::post('/taches', [TacheController::class, 'store'])->name('taches.store')->middleware('auth');


    // Route resource en dernier
    Route::resource('taches', TacheController::class)->except(['show']);
});

Route::get('/taches/accomplies', [TacheController::class, 'accomplies'])->name('taches.accomplies');
Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/home', function () {
    return view('taches.index'); // ou le chemin de votre vue d'accueil
})->name('home')->middleware('auth');
Route::get('/', function () {
    return view('taches.index'); // Doit correspondre au nom du fichier sans l'extension
});
// Remplacez la Closure par l'appel au contrôleur

Route::get('/', [TacheController::class, 'index'])->name('taches.index');
require __DIR__.'/auth.php';