<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AdminController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});

Route::prefix('products')->name('products.')->controller(ProductController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/{product}/edit', 'edit')->name('edit');
});

Route::prefix('categories')->name('categories.')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/{category}/edit', 'edit')->name('edit');
});

Route::prefix('users')->name('users.')->controller(UserController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{user}/edit', 'edit')->name('edit');
});

Route::prefix('contacts')->name('contacts.')->controller(ContactController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});