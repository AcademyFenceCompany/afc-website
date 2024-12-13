<?php

use App\Http\Controllers\ProductByMeshSizeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SingleProductController;







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
Route::get('/weldedwire', [ProductController::class, 'showWeldedWire'])->name('weldedwire');
Route::get('/wwf-product', [ProductByMeshSizeController::class, 'showMeshSizeProducts'])->name('meshsize.products');

Route::get('/product/{id}', [SingleProductController::class, 'show'])->name('product.show');


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
Route::view('/checkout', 'cart.checkout')->name('cart.checkout');
Route::view('/fenceinstallation', 'pages.fenceinstallation')->name('fenceinstallation');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Ecommerce API: Cart/checkout/...

Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/remove-item', [CartController::class, 'removeItem'])->name('cart.removeItem');
Route::post('/cart/remove-selected', [CartController::class, 'removeSelectedItems'])->name('cart.removeSelected');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');







require __DIR__.'/auth.php';
