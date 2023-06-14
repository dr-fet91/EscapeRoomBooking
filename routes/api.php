<?php

use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\EscapeRoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('escape-rooms')->group(function () {
    Route::get('/', [EscapeRoomController::class, 'index']);
    Route::get('/{escapeRoom}', [EscapeRoomController::class, 'show']);
    Route::get('/{escapeRoom}/time-slots', [EscapeRoomController::class, 'getTimeSlotsByEscapeRoom']);
});


Route::post('/login', [AuthenticateController::class, 'authenticate']);

Route::middleware('auth:sanctum')->group(function () {
    // Routes that require authentication
    Route::post('/logout', [AuthenticateController::class, 'logout']);
    
    Route::prefix('bookings')->group(function () {
        Route::get('/', [BookingController::class, 'index']);
        Route::post('/', [BookingController::class, 'store']);
        Route::delete('/{booking}', [BookingController::class, 'destroy']);
    });
});

//Route::apiResource('/escape-rooms', EscapeRoomController::class);