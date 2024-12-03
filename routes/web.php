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
Route::view('/woodfence', 'categories/woodfence');

Route::get('/customerservice', function () {
    return view('pages.customerservice', [
        'title' => 'Customer Service',
        'header' => 'Customer Service'
    ]);
})->name('customerservice');

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

Route::get('/privacy-policy', function () {
    return view('pages.privacypolicy', [
        'title' => 'Privacy Policy', 'header' => 'Privacy Policy',
        'header' => 'Privacy Policy', 'header' => 'Privacy Policy'
    ]);
})->name('privacypolicy');

Route::get('/brochures', function () {
    return view('pages.brochures', [
        'title' => 'Brochures', 'header' => 'Brochures'
    ]);
})->name('brochures');
Route::view('/empty-cart','cart/empty')->name('empty-cart');
Route::view('/cart', 'cart.index')->name('cart.index');
Route::view('/checkout', 'cart.checkout')->name('cart.checkout');
Route::view('/fenceinstallation', 'pages.fenceinstallation')->name('fenceinstallation');






