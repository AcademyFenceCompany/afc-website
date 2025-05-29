<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TForceController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\ProductByMeshSizeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\SingleProductController;
use App\Http\Controllers\WoodFenceController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RLCarriersController;
use App\Http\Controllers\Shipping2Controller;
use App\Http\Controllers\UPSController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Shipping apis
Route::post('/ups-rates', [ShippingController::class, 'getShippingRates']);
Route::post('/tforce-rates', [TForceController::class, 'getRate']);
Route::post('/rl-carriers-rates', [RLCarriersController::class, 'getRates']);
// Testing Shipping2 API
Route::get('/shipping2', [Shipping2Controller::class, 'getShippingRates'])->name('shipping2.getShippingRates');
//Route::post('/shipping2', [UPSController::class, 'getRates'])->name('shipping2.getShippingRates');

//Authorize.net payment api
//Route::post('/charge', [PaymentController::class, 'chargeCreditCard']);
// Dummy payment data for testing
Route::get('/charge', function () {
    $dummyData = [
        'card_number' => '4111111111111111',
        'expiration_date' => '12/25',
        'cvv' => '123',
        'amount' => 100.00,
        'currency' => 'USD',
        'description' => 'Test payment'
    ];
    // Call the controller method with dummy data
    return app(\App\Http\Controllers\PaymentController::class)->chargeCreditCard(new \Illuminate\Http\Request($dummyData));
});

