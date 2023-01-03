<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RatingController;
use App\Http\Controllers\API\MessagingController;
use App\Http\Controllers\API\ResolutionController;
use App\Http\Controllers\API\AccommodationController;
use App\Http\Controllers\API\AccommodationTourController;

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
    // Accommodation
    Route::get('accommodations', [AccommodationController::class, 'index']);
    Route::get('accommodations/{id}', [AccommodationController::class, 'show']);
    Route::post('accommodations/create', [AccommodationController::class, 'store']);
    Route::put('accommodations/update/{accommodation}',  [AccommodationController::class, 'update']);
    Route::delete('accommodations/delete/{accommodation}',  [AccommodationController::class, 'destroy']);
    // Accommodation Tour
    Route::get('accommodation_tours', [AccommodationTourController::class, 'index']);
    Route::get('accommodation_tours/{id}', [AccommodationTourController::class, 'show']);
    Route::post('accommodation_tours/create', [AccommodationTourController::class, 'store']);
    Route::put('accommodation_tours/update/{tour}',  [AccommodationTourController::class, 'update']);
    Route::delete('accommodation_tours/delete/{tour}',  [AccommodationTourController::class, 'destroy']);
    // Messaging
    Route::get('messaging', [MessagingController::class, 'index']);
    Route::get('messaging/{id}', [MessagingController::class, 'show']);
    Route::post('messaging/create', [MessagingController::class, 'store']);
    Route::put('messaging/update/{message}',  [MessagingController::class, 'update']);
    Route::delete('messaging/delete/{message}',  [MessagingController::class, 'destroy']);
    // Rating
    Route::get('ratings', [RatingController::class, 'index']);
    Route::get('ratings/{id}', [RatingController::class, 'show']);
    Route::post('ratings/create', [RatingController::class, 'store']);
    Route::put('ratings/update/{rate}',  [RatingController::class, 'update']);
    Route::delete('ratings/delete/{rate}',  [RatingController::class, 'destroy']);
    // Resolution
    Route::get('resolutions', [ResolutionController::class, 'index']);
    Route::get('resolutions/{id}', [ResolutionController::class, 'show']);
    Route::post('resolutions/create', [ResolutionController::class, 'store']);
    Route::put('resolutions/update/{resolution}',  [ResolutionController::class, 'update']);
    Route::delete('resolutions/delete/{resolution}',  [ResolutionController::class, 'destroy']);
});
