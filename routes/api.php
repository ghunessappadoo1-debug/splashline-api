<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ExhibitController;
use App\Http\Controllers\Api\AnimalController;
use App\Http\Controllers\Api\VisitorController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\FeedingScheduleController;
use App\Http\Controllers\Api\TourController;

Route::apiResource('exhibits', ExhibitController::class);
Route::apiResource('animals', AnimalController::class);
Route::apiResource('visitors', VisitorController::class);
Route::apiResource('tickets', TicketController::class);
Route::apiResource('bookings', BookingController::class);
Route::apiResource('feeding-schedules', FeedingScheduleController::class);
Route::apiResource('tours', TourController::class);