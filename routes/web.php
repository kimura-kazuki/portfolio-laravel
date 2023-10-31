<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

// URL::forceScheme('https');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'dashboardRoute' => optional(auth()->user())->role_name == ('SystemAdmin' || 'Admin') ? 'admin.index' : 'dashboard',
    ]);
})->name('home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

// user profile （全アカウント共通）
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'can:all',
])->group(function () {
    // user profile
    Route::group(['prefix' => '', 'namespace' => 'App\Http\Controllers\Auth', 'as' => 'auth.'], function () {
        Route::put('user/profile-information2', 'UserProfileController@update')->name('user-profile-information2.update');
        Route::put('user/company', 'UserProfileController@companyUpdate')->name('user-company.update');
        Route::put('user/bank-account-information', 'UpdateBankAccountInformationController@update')->name('user-bank-account-information.update');
        Route::put('user/introducer_code', 'UpdateIntroducerCodeController@update')->name('user-introducer-code.update');
        Route::put('user/line-information', 'UpdateLineAccountController@update')->name('user-line-information.update');
    });
});
