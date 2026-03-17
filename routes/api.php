<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ExhibitController;
use App\Http\Controllers\API\AnimalController;
use App\Http\Controllers\API\VisitorController;
use App\Http\Controllers\API\TicketController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\FeedingScheduleController;
use App\Http\Controllers\API\TourController;
use App\Http\Controllers\API\TourRegistrationController;

Route::prefix('v1')->group(function () {

    // Exhibits
    Route::apiResource('exhibits', ExhibitController::class);
    Route::get('exhibits/{exhibit}/animals', [ExhibitController::class, 'animals']);
    Route::get('exhibits/featured', [ExhibitController::class, 'featured']);

    // Animals
    Route::apiResource('animals', AnimalController::class);
    Route::get('animals/{animal}/feeding-schedule', [AnimalController::class, 'feedingSchedule']);

    // Visitors
    Route::apiResource('visitors', VisitorController::class);
    Route::get('visitors/{visitor}/bookings', [VisitorController::class, 'bookings']);

    // Tickets
    Route::apiResource('tickets', TicketController::class);

    // Bookings
    Route::apiResource('bookings', BookingController::class);
    Route::patch('bookings/{booking}/cancel', [BookingController::class, 'cancel']);

    // Feeding Schedules
    Route::apiResource('feeding-schedules', FeedingScheduleController::class);
    Route::get('feeding-schedules/upcoming', [FeedingScheduleController::class, 'upcoming']);

    // Tours
    Route::apiResource('tours', TourController::class);
    Route::post('tours/{tour}/register', [TourController::class, 'register']);
    Route::get('tours/upcoming', [TourController::class, 'upcoming']);

    // Tour Registrations
    Route::apiResource('tour-registrations', TourRegistrationController::class);
});