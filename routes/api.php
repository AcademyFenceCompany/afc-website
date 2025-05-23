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


//Authorize.net payment api
Route::post('/charge', [PaymentController::class, 'chargeCreditCard']);
