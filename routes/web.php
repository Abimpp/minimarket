<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UmumController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\RoleMiddleware;

Route::get('', function () {
    return redirect('/login');
});


Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);


Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth');


Route::get('/admin', [AdminController::class, 'index'])
    ->middleware(['auth', RoleMiddleware::class . ':admin']);


Route::get('/umum', [UmumController::class, 'index'])
    ->middleware(['auth', RoleMiddleware::class . ':umum']);
