<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\RoomsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InstitutionController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/institution', [InstitutionController::class, 'select'])->name('institution.select')->middleware('auth');


Route::get('/bookings', [BookingsController::class, 'index'])->name('bookings.index')->middleware('auth');
Route::get('/bookings/create', [BookingsController::class,'create'])->name('bookings.create')->middleware('auth');
Route::post('bookings', [BookingsController::class,'store'])->name('bookings.store')->middleware('auth');
Route::get('/bookings/{id}', [BookingsController::class,'show'])->name('bookings.show')->middleware('auth');
Route::delete('/bookings/{id}', [BookingsController::class,'destroy'])->name('bookings.delete')->middleware('auth');


Route::get('/rooms', [RoomsController::class, 'index'])->name('rooms.index')->middleware('auth');
Route::get('/rooms/create', [RoomsController::class,'create'])->name('rooms.create')->middleware('auth');
Route::post('rooms', [RoomsController::class,'store'])->name('rooms.store')->middleware('auth');
Route::get('/rooms/{roomID}', [RoomsController::class,'show'])->name('rooms.show')->middleware('auth');
Route::delete('/rooms/{roomID}', [RoomsController::class,'destroy'])->name('rooms.delete')->middleware('auth');


