<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

//Auth Routes
Route::group(['namespace' => 'Auth'], function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');


    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');

    Route::group(['middleware' => 'guest'], function () {
        // Authentication Routes...
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->middleware('check.email');

        // Registration Routes...
        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [RegisterController::class, 'register']);

        Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('auth.verify');

        Route::get('verifyemail', function () {
            return view('verifyemail');
        });


        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm']);
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetEmail']);
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm']);
        Route::post('password/reset', [ResetPasswordController::class, 'verifyAndReset'])->name('password.reset');
    });
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
