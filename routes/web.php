<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntidadController;

Route::get('/', function () {
    return view('inicio');
})->name('inicio');

// Redirecion sea al inicio
Route::get('/home', function () {
    return redirect()->route('inicio');
});

// Ruta para el modulo entidades
Route::resource('entidades', EntidadController::class);