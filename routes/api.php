<?php

use App\Http\Controllers\API\InqueryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\BlogController;
use App\Http\Controllers\API\ContactController;
use App\Http\Controllers\API\DestinationController;
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
    // Route::post('change-password', [AuthController::class, 'changePassword']);
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
    Route::post('verify-email', [AuthController::class, 'verifyEmail']);
    Route::post('resend-verification-email', [AuthController::class, 'resendVerificationEmail']);
});


Route::group(['middleware' => ['auth:api']],  function () {
    Route::prefix('bookings')->group(function () {
        Route::post('/create', [BookingController::class, 'store']);
        Route::get('/', [BookingController::class, 'index']);
        Route::get('/{booking}', [BookingController::class, 'show']);
        Route::put('/{booking}/cancel', [BookingController::class, 'cancel']);
    });

    Route::get('upcoming-trips', [BookingController::class, 'upcomingTrips']);
    Route::get('active-bookings', [BookingController::class, 'activeBookings']);
    Route::get('recent-bookings', [BookingController::class, 'recentBookings']);
    Route::get('total-spent', [BookingController::class, 'totalSpent']);

    // Route::prefix('dashboard')->controller(UserController::class)->group(function () {
    //     Route::get('/','getDashboardContent');
    // });
});

Route::prefix('packages')->controller(PackageController::class)->group(function () {
    Route::get('/', 'index')->name('package.index');
    Route::get('/destination/{id}', 'getPackageByDestination')->name('package.index');

    Route::get('/essentialItems', 'getAllEssentialItems')->name('package.essentialItems');
    Route::get('/upcoming', 'getUpcomingPackages');
    Route::get('/{slug}', 'show')->name('package.show');
});

Route::prefix('destinations')->controller(DestinationController::class)->group(function () {
    Route::get('/', 'index')->name('destination.index');
    Route::get('/nested', 'nestedIndex')->name('destination.nestedIndex');
    Route::get('/{slug}', 'getDestination')->name('destination.index');
});

Route::prefix('')->controller(HomepageController::class)->group(function () {
    // Route::get('/','index')->name('destination.index');
    // Route::get('/homepageTrips/{id}','getHomepageTrips')->name('home.homepageTrips');
    Route::get('/popularTrips', 'getPopularTrips')->name('home.popularTrips');
    Route::get('/upcomingDepartures', 'getUpcomingDepartures')->name('home.upcomingDepartures');
    Route::get('/recommendedPackages', 'getRecommendedPackages')->name('home.recommendedPackages');
    Route::get('/activities', 'getActivities')->name('home.getActivities');
});

Route::prefix('guides')->controller(GuideController::class)->group(function () {
    Route::get('/', 'index')->name('guide.index');
    Route::get('/{guide}', 'show')->name('guide.show');
});



Route::get('blogs', [BlogController::class, 'index']);
Route::get('blog-categories', [BlogController::class, 'indexCategories']);
Route::get('blogs/{id}', [BlogController::class, 'show']);
Route::post('send-pdf', [BlogController::class, 'sendPdf']);

Route::get('booking-payment/{id}', [BookingController::class, 'downloadPaymentSlip']);

Route::get('fixed-departures', [PackageController::class, 'getFixDepartures']);

Route::get('regions', [UserController::class, 'getRegions']);


Route::post('contacts', [ContactController::class, 'store']);

Route::post('inquiry', [InqueryController::class, 'store']);  // Get Inquery API
