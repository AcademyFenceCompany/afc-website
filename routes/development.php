<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AcademyTestController;
use App\Http\Controllers\Ams\InstallJobsController;
use App\Http\Controllers\Ams\ProductReportController;
use App\Http\Controllers\Ams\ActivityLogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Shipping2Controller;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ShoppingCartController;
//==================== Development Routes (Colin) ====================//
// AMS Routes
Route::prefix('ams')->middleware('auth')->group(function () {
    // Development route for testing: Colin
    Route::get('/install_upload', [InstallJobsController::class, 'index'])->name('ams.install_upload');
    Route::get('/product-reports', [ProductReportController::class, 'index'])->name('ams.product-report');
    Route::post('/install_upload', [InstallJobsController::class, 'add'])->name('ams.install_upload');
    Route::post('/products-report/filter', [ProductReportController::class, 'getProductByFilter'])->name('ams.product-report.filter');
    Route::post('/products-report/edit', [ProductReportController::class, 'update'])->name('ams.product-report.edit');
    Route::get('/log', [ActivityLogController::class, 'getAllLogs'])->name('ams.activity-log');
    Route::get('/shippingrate', [Shipping2Controller::class, 'index'])->name('ams.getshippingrate');
    Route::get('/', [Shipping2Controller::class, 'index'])->name('ams.getshippingrate');
    Route::get('/activity', [ActivityController::class, 'getorders'])->name('ams.orders');
    
});
// Development route for testing: Colin
Route::get('/subcatlist/{id}', [ProductReportController::class, 'getCategoryById'])->name('ams.subcat-list');
Route::get('/products-report/cat/{id}', [ProductReportController::class, 'getProductsByCategoryId'])->name('ams.getAllByCatId');
Route::get('/products-report/search/{str}', [ProductReportController::class, 'getProductBySearch'])->name('ams.getAllBySearch');
Route::get('/products-report/{id}', [ProductReportController::class, 'getById'])->name('ams.product-report.id');

Route::get('/getcustomer/{id}', [CustomerController::class, 'getCustomerById'])->name('ams.getCustomerById');
Route::get('/search-customer/{str}', [CustomerController::class, 'search2'])->name('ams.search-customer');
Route::get('/getcustomers', [CustomerController::class, 'getCustomers'])->name('ams.getCustomers');

//Route::get('/product-report/{id}', [ProductReportController::class, 'getById'])->name('ams.product-report.id');


Route::get('/post-caps', function () {
    return view('categories/post-caps');
})->name('post-caps');

Route::get('/temp-construction-fence', function () {
    return view('categories/temp-construction-fence');
})->name('temp-construction-fence');


Route::get('/theme', function () {
    return view('theme');
})->name('theme');
Route::get('/gallery', function () {
    $majCategories = \DB::table('majorcategories')->where('enabled', 1)->get();
    $subCategories = \DB::table('categories')->where('majorcategories_id', 1)->get();
    $height = 100; //$h;
    return view('gallery', compact('majCategories', 'subCategories', 'height'));
})->name('gallery');
Route::get('/codes-and-permits', function () {
    $majCategories = \DB::table('majorcategories')->where('enabled', 1)->get();
    $subCategories = \DB::table('categories')->where('majorcategories_id', 1)->get();
    $height = 100; //$h;
    return view('codesandpermits', compact('majCategories', 'subCategories', 'height'));
})->name('gallery');
Route::get('/category', function(){
        
    $majCategories = \DB::table('majorcategories')->where('enabled', 1)->get();
    $subCategories = \DB::table('categories')->where('majorcategories_id', 1)->get();
    $fenceCategories = [
        ['id' => 1, 'name' => 'Wooden Fences', 'description' => 'Durable and classic wooden fences.'],
        ['id' => 2, 'name' => 'Vinyl Fences', 'description' => 'Low-maintenance and long-lasting vinyl fences.'],
        ['id' => 3, 'name' => 'Chain Link Fences', 'description' => 'Affordable and secure chain link fences.'],
        ['id' => 4, 'name' => 'Wrought Iron Fences', 'description' => 'Elegant and sturdy wrought iron fences.'],
        ['id' => 5, 'name' => 'Bamboo Fences', 'description' => 'Eco-friendly and stylish bamboo fences.'],
        ['id' => 6, 'name' => 'Aluminum Fences', 'description' => 'Lightweight and rust-resistant aluminum fences.'],
        ['id' => 7, 'name' => 'Composite Fences', 'description' => 'Sustainable and attractive composite fences.'],
        ['id' => 8, 'name' => 'Electric Fences', 'description' => 'High-security electric fences for protection.'],
        ['id' => 9, 'name' => 'Privacy Fences', 'description' => 'Tall and solid privacy fences for seclusion.'],
        ['id' => 10, 'name' => 'Garden Fences', 'description' => 'Decorative garden fences for landscaping.'],

    ];
    return view('subcategory', compact('majCategories', 'subCategories', 'fenceCategories'));

})->name('category');
Route::get('/productdesc', function(){
        
    $majCategories = \DB::table('majorcategories')->where('enabled', 1)->get();
    $subCategories = \DB::table('categories')->where('majorcategories_id', 1)->get();
    $fenceCategories = [
        ['id' => 1, 'name' => 'Wooden Fences', 'description' => 'Durable and classic wooden fences.'],
        ['id' => 2, 'name' => 'Vinyl Fences', 'description' => 'Low-maintenance and long-lasting vinyl fences.'],
        ['id' => 3, 'name' => 'Chain Link Fences', 'description' => 'Affordable and secure chain link fences.'],
        ['id' => 4, 'name' => 'Wrought Iron Fences', 'description' => 'Elegant and sturdy wrought iron fences.'],
        ['id' => 5, 'name' => 'Bamboo Fences', 'description' => 'Eco-friendly and stylish bamboo fences.'],
        ['id' => 6, 'name' => 'Aluminum Fences', 'description' => 'Lightweight and rust-resistant aluminum fences.'],
        ['id' => 7, 'name' => 'Composite Fences', 'description' => 'Sustainable and attractive composite fences.'],
        ['id' => 8, 'name' => 'Electric Fences', 'description' => 'High-security electric fences for protection.'],
        ['id' => 9, 'name' => 'Privacy Fences', 'description' => 'Tall and solid privacy fences for seclusion.'],
        ['id' => 10, 'name' => 'Garden Fences', 'description' => 'Decorative garden fences for landscaping.'],

    ];
    return view('productdesc', compact('majCategories', 'subCategories', 'fenceCategories'));

})->name('category');

// Route for shopping cart
Route::prefix('cart2')->group(function () {
    Route::get('/cart', function () {
        $majCategories = \DB::table('majorcategories')->where('enabled', 1)->get();
        $subCategories = \DB::table('categories')->where('majorcategories_id', 1)->get();
        return view('cart.checkout2', compact('majCategories', 'subCategories',));
    })->name('cart2.index');
    Route::get('/thankyou', function () {
        $majCategories = \DB::table('majorcategories')->where('enabled', 1)->get();
        $subCategories = \DB::table('categories')->where('majorcategories_id', 1)->get();
        return view('thankyou');
    })->name('checkout2.success');

    Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('cart2.checkout2');
    Route::get('/checkout', [ShoppingCartController::class, 'processCheckout'])->name('cart2.checkout2');
    Route::get('/get-cart', [ShoppingCartController::class, 'getCart'])->name('cart2.getCart');
    Route::get('/add-to-cart/p/{id}', [ShoppingCartController::class, 'addItem'])->name('cart2.addToCart');
    Route::get('/update-qty/p/{id}/q/{qty}', [ShoppingCartController::class, 'updateItem'])->name('cart2.updateItem');
});
Route::get('/shipping2', [Shipping2Controller::class, 'getShippingRates'])->name('shipping2.getShippingRates');
// Route for the login page. This route needs to be relocated to the auth routes file.
Route::get('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');



Route::get('/', [AcademyTestController::class, 'index'])->name('homepage');