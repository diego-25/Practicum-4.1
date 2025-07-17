<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InstitucionController;
use App\Http\Controllers\ObjetivoController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProyectoController;

/*
|--------------------------------------------------------------------------
| Rutas públicas
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

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
| Perfil –
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile',   [ProfileController::class, 'edit'])  ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Usuarios
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:Control|Tecnico|Funcional'])->group(function () {
    Route::resource('usuarios', UserController::class);
});

/*
|--------------------------------------------------------------------------
| Objetivos
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Control'])->group(function () {
    Route::resource('objetivos', ObjetivoController::class);
});

/*
|--------------------------------------------------------------------------
| Instituciones
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Control'])->group(function () {
    Route::resource('instituciones', InstitucionController::class);
});

/*
|--------------------------------------------------------------------------
| Programas
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Control'])->group(function () {
    Route::resource('programas', ProgramaController::class);
});

/*
|--------------------------------------------------------------------------
| Programas
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Control'])->group(function () {
    Route::resource('planes', PlanController::class);
});

/*
|--------------------------------------------------------------------------
| Programas
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:Control'])->group(function () {
    Route::resource('proyectos', ProyectoController::class);
});
/*
|--------------------------------------------------------------------------
| Rutas de autenticación de Breeze
|--------------------------------------------------------------------------
*/
require __DIR__.'/auth.php';