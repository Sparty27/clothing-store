<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('index', function (BreadcrumbTrail $trail) {
    $trail->push('Головна', route('index'));
});

Breadcrumbs::for('checkout', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Замовлення', route('orders.checkout'));
});

Breadcrumbs::for('profile', function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('Профіль', route('profile.home'));
});

// Breadcrumbs::for('profile.orders', function (BreadcrumbTrail $trail) {
//     $trail->parent('profile');
//     $trail->push('Мої покупки', route('profile.orders'));
// });

// Breadcrumbs::for('profile.settings', function (BreadcrumbTrail $trail) {
//     $trail->parent('profile');
//     $trail->push('Налаштування профілю', route('profile.settings'));
// });

// Breadcrumbs::for('catalog', function (BreadcrumbTrail $trail) {
//     $trail->parent('home');
//     $trail->push('Каталог', route('catalog'));
// });

// Breadcrumbs::for('category', function (BreadcrumbTrail $trail, $category) {
//     $trail->parent('catalog');
//     if ($category) {
//         $trail->push($category !== null ? $category->name : 'Категорії', route('catalog', $category));
//     }
// });

Breadcrumbs::for('product', function (BreadcrumbTrail $trail, $product) {
    $trail->parent('index');
    $trail->push($product->name, route('products.show', $product->slug));
});