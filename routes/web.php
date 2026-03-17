<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/exhibits', [FrontendController::class, 'exhibits'])->name('exhibits');
Route::get('/animals', [FrontendController::class, 'animals'])->name('animals');
Route::get('/visitors', [FrontendController::class, 'visitors'])->name('visitors');
Route::get('/bookings', [FrontendController::class, 'bookings'])->name('bookings');
Route::get('/tours', [FrontendController::class, 'tours'])->name('tours');
Route::get('/feeding-schedules', [FrontendController::class, 'feedingSchedules'])->name('feeding-schedules');