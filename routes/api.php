<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('login', [\App\Http\Controllers\Api\AuthenticateController::class, 'login']);
Route::post('signup', [\App\Http\Controllers\Api\AuthenticateController::class, 'signUp']);


Route::middleware('auth:api')->group(function () {
    Route::post('create/doctor', [App\Http\Controllers\Api\DoctorController::class, 'store'])->middleware(['admin']);
    Route::get('get/doctor/speciality', [App\Http\Controllers\Api\DoctorController::class, 'getDoctorSpeciality'])->middleware(['admin']);
    Route::get('edit/doctor', [App\Http\Controllers\Api\DoctorController::class, 'edit'])->middleware(['doctor']);
    Route::post('update/doctor', [App\Http\Controllers\Api\DoctorController::class, 'update'])->middleware(['doctor']);
    Route::get('get/doctor', [App\Http\Controllers\Api\DoctorController::class, 'getDoctors']);
    Route::post('create/booking', [App\Http\Controllers\Api\BookingController::class, 'createBooking']);
});
