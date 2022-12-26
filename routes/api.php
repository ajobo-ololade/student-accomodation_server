<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AccommodationController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('getUser', [AuthController::class, 'getUser']);
    Route::get('accommodations', [AccommodationController::class, 'index']);
    Route::get('accommodations/{id}', [AccommodationController::class, 'show']);
    Route::post('accommodations/create', [AccommodationController::class, 'store']);
    Route::put('accommodations/update/{accommodation}',  [AccommodationController::class, 'update']);
    Route::delete('accommodations/delete/{accommodation}',  [AccommodationController::class, 'destroy']);
});
