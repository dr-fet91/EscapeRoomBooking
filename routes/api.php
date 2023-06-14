<?php

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


Route::prefix('escape-rooms')->group(function(){
    Route::get('/', [EscapeRoomController::class, 'index']);
    Route::get('/{escapeRoom}', [EscapeRoomController::class, 'show']);
    Route::get('/{escapeRoom}/time-slots', [EscapeRoomController::class, 'getTimeSlotsByEscapeRoom']);
});

//Route::apiResource('/escape-rooms', EscapeRoomController::class);