<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomRequestController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserShowController;
use App\Http\Controllers\UserShowController as ControllersUserShowController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('password/email', [AuthController::class, 'sendResetLinkEmail']);
Route::post('password/reset', [AuthController::class, 'reset'])->middleware('signed')->name('password.reset');

Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::get("profile", [AuthController::class, 'profile']);
    Route::get("logout", [AuthController::class, 'logout']);
    Route::post('email/verify/send', [AuthController::class, 'sendMail']);
    Route::post('email/verify', [AuthController::class, 'verify'])->middleware('signed')->name('verify-email');
});

Route::get('user', UserShowController::class);
Route::get('dashboard', DashboardController::class);


Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('category', CategoryController::class);
    Route::resource('custom_request', CustomRequestController::class);
    Route::resource('service', ServiceController::class);
});

Route::middleware(['auth:sanctum', 'AdminMiddleware'])->get('/admin/users', [UserController::class, 'getAllUsers']);