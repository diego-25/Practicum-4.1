<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InstitucionController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])
  ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Dashboard (requiere login y email verificado)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])
  ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Perfil – cualquier usuario autenticado
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile',   [ProfileController::class, 'edit'])  ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Usuarios – solo rol admin
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('usuarios', UserController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| Instituciones – solo rol Control
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Control'])->group(function () {
    Route::resource('instituciones', InstitucionController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| Rutas de autenticación de Breeze
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';