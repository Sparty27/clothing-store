<?php

use App\Http\Controllers\TelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/'.env('TELEGRAM_BOT_TOKEN').'/webhook', [TelegramController::class, 'webhook'])->name('webhook');