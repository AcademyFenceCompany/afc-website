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
use App\Http\Controllers\WoodFenceController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ShipperController;
use App\Http\Controllers\CategoryController;


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

Route::get('/resources/office_sheets/{filename}', function ($filename) {
    $path = resource_path('office_sheets/' . $filename);

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
// Route::view('/woodfence', 'categories/woodfence');


Route::get('/product/{id}', [SingleProductController::class, 'show'])->name('product.show');
Route::get('/product/details/{id}', [SingleProductController::class, 'fetchProductDetails']);

Route::get('/weldedwire', [ProductController::class, 'showWeldedWire'])->name('weldedwire');
Route::get('/wwf-product', [ProductByMeshSizeController::class, 'showMeshSizeProducts'])->name('meshsize.products');

Route::get('/wood-fence', [WoodFenceController::class, 'index'])->name('woodfence');
Route::get('/wood-fence/{subcategoryId}/children', [WoodFenceController::class, 'getSubcategoryChildren'])->name('woodfence.children');
Route::get('/wood-fence/specs/{subcategoryId}/{spacing}', [WoodFenceController::class, 'getProductsGroupedByStyle'])
    ->where('spacing', '.*') // Allow special characters in spacing
    ->name('woodfence.specs');

// Route::get('/wood-fence', [WoodFenceController::class, 'index'])->name('woodfence');
// Route::get('wood-fence/specs/{subcategoryId}/{spacing}', [WoodFenceController::class, 'getProductsGroupedByStyle'])
//     ->where('spacing', '.*')  // Allow any character in spacing
//     ->name('woodfence.specs');
// Route::get('wood-fence/specs/{subcategoryId}/{spacing}/{style}/all', 
//     [WoodFenceController::class, 'getAllStyleProducts'])
//     ->name('woodfence.specs.all');
// Route::get('wood-fence/specs/{subcategoryId}', [WoodFenceController::class, 'getProductsGroupWoSpacing'])
//     ->name('woodfence.specs');


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
        'title' => 'Policies, Terms & Conditions',
        'header' => 'Policies & Terms',
        'header' => 'Policies, Terms & Conditions',
        'header' => 'Policies & Terms'
    ]);
})->name('policy');

Route::get('/privacy-policy', function () {
    return view('pages.privacypolicy', [
        'title' => 'Privacy Policy',
        'header' => 'Privacy Policy',
        'header' => 'Privacy Policy',
        'header' => 'Privacy Policy'
    ]);
})->name('privacypolicy');

Route::get('/brochures', function () {
    return view('pages.brochures', [
        'title' => 'Brochures',
        'header' => 'Brochures'
    ]);
})->name('brochures');
Route::view('/empty-cart', 'cart/empty')->name('empty-cart');
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
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');


// AMS Routes
Route::get('/ams', function () {
    return redirect()->route('ams.activity');
})->middleware('auth')->name('ams.home');


Route::get('/ams/activity', function () {
    return view('ams.activity');
})->name('ams.activity');

Route::get('/ams/products/add', [ProductController::class, 'create'])->name('ams.products.add');

Route::get('/users', [UserManagementController::class, 'index'])->name('user.index');
Route::put('/user/{id}', [UserManagementController::class, 'update']);



// Family Category Tree - AMS
Route::get('/categories', [CategoriesController::class, 'showTree'])->name('categories.display');
Route::get('/categories/{category}/products', [CategoriesController::class, 'getProducts']);


// Shipping
Route::get('/shippers/{page}', [ShipperController::class, 'showView'])
    ->whereIn('page', [
        'index_shippers',
        'add_shippers',
        'add_shippers_contacts',
        'delivery_status',
        'shipping_markup'
    ])->name('shippers.view');

require __DIR__ . '/auth.php';


Route::get('/categories/create', [CategoriesController::class, 'create'])->name('categories.create');



Route::get('/categories/create', [CategoriesController::class, 'create'])->name('categories.create');
Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');







