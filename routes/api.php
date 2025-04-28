<?php

use App\Http\Controllers\API\InqueryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\DestinationController;
use App\Http\Controllers\API\EventController;
use App\Http\Controllers\API\GuideController;
use App\Http\Controllers\API\HomepageController;
use App\Http\Controllers\API\PackageController;
use App\Http\Controllers\API\UserController;

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

Route::post('google/callback', [AuthController::class, 'handleGoogleCallback']);

Route::group(['middleware' => ['auth:api'], 'prefix' => 'auth'],  function () {
    Route::get('/user', function () {
        return ["message" => "user"];
    });
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('me', [AuthController::class, 'me']);
    Route::post('update-profile', [AuthController::class, 'updateProfile']);
    Route::post('change-password', [AuthController::class, 'changePassword']);
});

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('verify-otp', [AuthController::class, 'verifyOtp']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);
});


Route::group(['middleware' => ['auth:api']],  function () {
    Route::prefix('bookings')->group(function () {
        Route::post('/create', [BookingController::class, 'store']);
        Route::get('/', [BookingController::class, 'index']);
        Route::get('/{booking}', [BookingController::class, 'show']);
    });
});

Route::prefix('events')->controller(EventController::class)->group(function () {
    Route::get('/', 'index')->name('event.index');
    Route::get('/{id}', 'show')->name('event.index');
});


Route::get('blogs', [BlogController::class, 'index']);
Route::get('blog-categories', [BlogController::class, 'indexCategories']);
Route::get('blogs/{id}', [BlogController::class, 'show']);
Route::post('send-pdf', [BlogController::class, 'sendPdf']);

Route::get('booking-payment/{id}', [BookingController::class, 'downloadPaymentSlip']);

Route::get('regions', [UserController::class, 'getRegions']);

Route::post('contacts', [ContactController::class, 'store']);
