<?php

use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('password')->name('password.')->middleware('guest')->controller(ResetPasswordController::class)->group(function () {
    Route::get('/request', 'showRequestForm')->name('request');
    Route::post('/request', 'sendResetCode')->name('request.post');
    
    Route::get('/verify', 'showVerifyForm')->name('verify');
    Route::post('/verify', 'verifyCode')->name('verify.post');
    
    Route::get('/reset', 'showResetForm')->name('reset');
    Route::post('/reset', 'resetPassword')->name('reset.post');
});

Auth::routes([
    'reset' => false,
    'verify' => false,
]);