<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\FornecedorController;
use Illuminate\Support\Facades\Route;


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('dashboard')->group(function(){
        Route::resource('fornecedores', FornecedorController::class);
    });
});

Auth::routes();
