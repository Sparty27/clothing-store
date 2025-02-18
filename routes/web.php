<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Site\OrderController;
use App\Http\Controllers\Site\ProductController;
use App\Http\Controllers\Site\SiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::controller(SiteController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});

Route::prefix('/products')->name('products.')->controller(ProductController::class)->group(function() {
    Route::get('/{product:slug}', 'show')->name('show');
});

Route::name('profile.')->controller(HomeController::class)->middleware('auth')->group(function () {
    Route::get('/home', 'home');
    Route::get('/profile', 'home')->name('home');
    Route::get('/profile/orders', 'orders')->name('orders');
    Route::get('/profile/settings', 'settings')->name('settings');
});

Route::name('orders.')->controller(OrderController::class)->group(function() {
    Route::get('/checkout', 'checkout')->name('checkout')->middleware('basket.not.empty');
    // Route::get('/thank', 'thank')->name('thank');
});