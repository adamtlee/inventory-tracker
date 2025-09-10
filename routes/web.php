<?php

use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

// Landing page routes
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('/login', [LandingController::class, 'login'])->name('landing.login');
Route::post('/register', [LandingController::class, 'register'])->name('landing.register');
Route::post('/logout', [LandingController::class, 'logout'])->name('landing.logout');
