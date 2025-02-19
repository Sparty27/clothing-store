<?php

use App\Http\Controllers\Site\MonobankController;
use App\Http\Middleware\MonobankPayment;
use Illuminate\Support\Facades\Route;

Route::name('monobank.')->prefix('monobank')->controller(MonobankController::class)->group(function() {
    Route::get('status/{order}', 'check')->name('check')->middleware(MonobankPayment::class);
    Route::post('webhook/{order}', 'webhook')->name('webhook');
});