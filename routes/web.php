<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

Route::get('/resources/images/{filename}', function ($filename) {
    $path = resource_path('images/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return Response::make($file, 200)->header("Content-Type", $type);
});

Route::get('/resources/brochures/{filename}', function ($filename) {
    $path = resource_path('brochures/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    return Response::make($file, 200)->header("Content-Type", $type);
});
Route::view('/', 'index');
Route::view('/contact', 'pages/contact')->name('contact');
Route::view('/product-cat', 'categories/products-cat');
Route::view('/product-cats', 'categories/products-cats');

Route::get('/about', function () {
    return view('pages.about', [
        'title' => 'About Us',
        'header' => 'About Us'
    ]);
})->name('about');

Route::get('/policy', function () {
    return view('pages.policy', [
        'title' => 'Policies, Terms & Conditions', 'header' => 'Policies & Terms',
        'header' => 'Policies, Terms & Conditions', 'header' => 'Policies & Terms'
    ]);
})->name('policy');
Route::get('/brochures', function () {
    return view('pages.brochures', [
        'title' => 'Brochures', 'header' => 'Brochures'
    ]);
})->name('brochures');
Route::view('/empty-cart','cart/empty')->name('empty-cart');
Route::view('/cart', 'cart.index')->name('cart.index');




