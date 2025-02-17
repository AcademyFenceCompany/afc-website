<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryToProductController;
use App\Http\Controllers\getProductsByCategory;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AddressController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store'])
        ->name('register');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});



//AMS ROUTES
Route::middleware('auth')->group(function () {
    Route::get('/ams-activity', [ActivityController::class, 'index'])->name('ams.activity');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


    Route::middleware(['auth', 'role:God'])->group(function () {
        Route::get('/user-management', [UserManagementController::class, 'index'])->name('user.management');
        Route::post('/user', [UserManagementController::class, 'store'])->name('user.store');
        Route::get('/user/{id}/edit', [UserManagementController::class, 'edit'])->name('user.edit');
        Route::put('/user/{id}', [UserManagementController::class, 'update'])->name('user.update');
        Route::delete('/user/{id}', [UserManagementController::class, 'destroy'])->name('user.destroy');
        Route::post('/user/{id}/toggle-status', [UserManagementController::class, 'toggleStatus'])->name('user.toggle-status');
    });
});

Route::middleware(['auth'])->group(function () {
    // Product routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/api/products/{categoryId}', [ProductController::class, 'getProductsByCategory']);
    Route::post('/products/{product}/delete-image/{type}', [ProductController::class, 'deleteImage'])
    ->name('products.deleteImage');
});



// Customer Routes
Route::prefix('customers')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::post('/', [CustomerController::class, 'store'])->name('customers.store');
});

// Shipping Routes
Route::prefix('shipping')->group(function () {
    Route::get('/shippers', [ShipperController::class, 'index'])->name('shippers.index');
    Route::get('/shippers/add', [ShipperController::class, 'create'])->name('shippers.add');

});


// API Routes
Route::prefix('api')->group(function () {
    // Customer Search
    Route::get('/customers/search', [CustomerController::class, 'search'])->name('customers.search');
    // Address Management
    Route::get('/addresses/{address}', [AddressController::class, 'show']);
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::put('/addresses/{address}', [AddressController::class, 'update']);
    Route::delete('/addresses/{address}', [AddressController::class, 'destroy']);
});

Route::get('/orders/{orderId}', [ActivityController::class, 'show'])->name('orders.show');
Route::view('/office-sheets', 'ams.office_sheets.index_office_sheets')->name('office-sheets');

