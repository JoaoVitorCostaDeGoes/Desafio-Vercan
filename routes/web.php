<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('dashboard')->group(function(){
        Route::resource('fornecedores', FornecedorController::class);
    });

    Route::get('/buscarCidadesPorEstado/{uf}', [HomeController::class, 'buscarCidades'])->name('buscarCidades');
});


