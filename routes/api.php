<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);
Route::post('password/email',[AuthController::class,'sendResetLinkEmail']); 
Route::post('password/reset',[AuthController::class,'reset'])->middleware('signed')->name('password.reset');

Route::group(["middleware" => ["auth:sanctum"]], function () {
    Route::get("profile", [AuthController::class, 'profile']);
    Route::get("logout", [AuthController::class, 'logout']);
    Route::post('email/verify/send',[AuthController::class,'sendMail']);
    Route::post('email/verify',[AuthController::class,'verify'])->middleware('signed')->name('verify-email');
});