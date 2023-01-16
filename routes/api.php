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
Route::get('accommodations', [AccommodationController::class, 'index']);
Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('logout', [AuthController::class, 'logout']);
    Route::post('getUser', [AuthController::class, 'getUser']);
    Route::get('accommodations', [AccommodationController::class, 'index']);
    Route::get('accommodations/{id}', [AccommodationController::class, 'show']);
    Route::post('accommodations/create', [AccommodationController::class, 'store']);
    Route::put('accommodations/update/{accommodation}',  [AccommodationController::class, 'update']);
    Route::delete('accommodations/delete/{accommodation}',  [AccommodationController::class, 'destroy']);
});
// Tymon\JWTAuth\Exceptions\JWTException: The token could not be parsed from the request in file C:\Users\User\Documents\SQI\level 3\accomodation-mgt\vendor\tymon\jwt-auth\src\JWT.php on line 179
