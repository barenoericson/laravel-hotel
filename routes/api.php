<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;


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

Route::post('/register', [AuthenticationController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::get('/get-users', [UserController::class, 'getUsers']);
    Route::post('/add-user', [UserController::class, 'addUser']);
    Route::put('/edit-user/{id}', [UserController::class, 'editUser']);
    Route::delete('/delete-user/{id}', [UserController::class, 'deleteUser']);

    Route::get('/get-rooms', [RoomController::class, 'getRooms']);
    Route::post('/add-rooms', [RoomController::class, 'addRoom']);
    Route::put('/edit-room/{id}', [RoomController::class, 'editRoom']);
    Route::delete('/delete-room/{id}', [RoomController::class, 'deleteRoom']);

    Route::get('/get-bookings', [BookingController::class, 'getBookings']);
    Route::post('/add-bookings', [BookingController::class, 'addBooking']);
    Route::put('/edit-bookings/{id}', [BookingController::class, 'editBooking']);
    Route::delete('/delete-bookings/{id}', [BookingController::class, 'deleteBooking']);

    Route::post('/logout', [AuthenticationController::class, 'logout']);
});
