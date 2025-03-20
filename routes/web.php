<?php

use App\Http\Controllers\AmenitiesController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\EventCategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RegionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PackageCategoryController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EssentialItemController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\InqueryController;
use App\Models\EssentialItem;

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

Auth::routes();

Route::get('/', function () {
    return redirect('/events');
});
Route::get('/mail', function () {
    return view('/pdf/user-payment-slip');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::get('users', [UserController::class, 'index'])->name('list-user');
    Route::get('users-create', [UserController::class, 'create'])->name('create-user');
    Route::get('users/{id}', [UserController::class, 'edit'])->name('edit-user');
    Route::post('users/{id}', [UserController::class, 'update'])->name('update-user');
    Route::get('users/{id}/show', [UserController::class, 'show'])->name('show-user');
    Route::post('users', [UserController::class, 'store'])->name('store-user');
    Route::post('users/{id}/status', [UserController::class, 'changeStatus'])->name('status-user');

    Route::get('event-categories', [EventCategoryController::class, 'index'])->name('list-event-categories');
    Route::post('event-categories', [EventCategoryController::class, 'store'])->name('store-event-category');
    Route::get('event-categories-create', [EventCategoryController::class, 'create'])->name('create-event-category');
    Route::get('event-categories/{id}', [EventCategoryController::class, 'edit'])->name('edit-event-category');
    Route::post('event-categories/{id}', [EventCategoryController::class, 'update'])->name('update-event-category');
    Route::get('event-categories/{id}/view', [EventCategoryController::class, 'view'])->name('view-event-category');

    Route::post('change-password', [UserController::class, 'changePassword'])->name('change-password');

    Route::get('blogs', [BlogController::class, 'index'])->name('list-blogs');
    Route::get('blogs-create', [BlogController::class, 'create'])->name('create-blog');
    Route::post('blogs', [BlogController::class, 'store'])->name('store-blog');
    Route::get('blogs/{id}', [BlogController::class, 'edit'])->name('edit-blog');
    Route::post('blogs/{id}', [BlogController::class, 'update'])->name('update-blog');
    Route::delete('blogs/{id}', [BlogController::class, 'destroy'])->name('delete-blog');

    Route::get('events', [EventController::class, 'index'])->name('event.index');
    Route::get('event', [EventController::class, 'create'])->name('event.create');
    Route::post('event', [EventController::class, 'store'])->name('event.store');
    Route::get('event/{id}/edit', [EventController::class, 'edit'])->name('event.edit');
    Route::post('event/{id}', [EventController::class, 'update'])->name('event.update');
    Route::get('event/{id}', [EventController::class, 'show'])->name('event.show');
    Route::delete('event/{id}', [EventController::class, 'destroy'])->name('event.destroy');

});

Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

Route::get('payment-success', [App\Http\Controllers\API\BookingController::class, 'checkoutSuccess']);
Route::get('failed-payment', [App\Http\Controllers\API\BookingController::class, 'checkoutFailure']);

Route::get('verify-email/{token}', [ProfileController::class, 'verifyEmail'])->name('profile.verify-email');

Route::get('contacts',[ContactController::class,'index'])->name('contacts');
Route::get('contacts/{id}',[ContactController::class,'show'])->name('contacts.show');

Route::get('bookings',[BookingController::class,'index'])->name('bookings');
Route::get('bookings/{id}',[BookingController::class,'show'])->name('bookings.show');

