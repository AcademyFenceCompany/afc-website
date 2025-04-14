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
use App\Http\Controllers\WoodFenceMysql2Controller;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\StateMarkupController;
use App\Http\Controllers\Ams\OrderController;
use App\Models\Order;
use App\Models\Customer;
use App\Http\Controllers\CategoryPageController;
use App\Http\Controllers\Ams\ProductQueryController;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Ams\CategoryController;
use App\Http\Controllers\SolidBoardController;
use App\Http\Controllers\BoardonBoardController;
use App\Http\Controllers\TongueGrooveController;
use App\Http\Controllers\PostRailController;
use App\Http\Controllers\StockadeFenceController;
use App\Http\Controllers\WoodPostCapsController;
use App\Http\Controllers\AluminumFenceController;

// AMS Routes
Route::prefix('ams')->middleware('auth')->group(function () {
    // Product Routes
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/by-category/{category}', [ProductController::class, 'getByCategory'])->name('products.by.category');
    
    // Product Query routes for demodb testing
    Route::prefix('product-query')->name('ams.product-query.')->group(function () {
        Route::get('/', [ProductQueryController::class, 'index'])->name('index');
        Route::get('/search', [ProductQueryController::class, 'search'])->name('search');
        Route::get('/category/{id}', [ProductQueryController::class, 'loadCategory'])->name('category');
        Route::get('/{id}/edit', [ProductQueryController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [ProductQueryController::class, 'update'])->name('update');
    });

    // MySQL Category Management
    Route::resource('mysql-categories', \App\Http\Controllers\Ams\CategoryController::class)->names('ams.mysql-categories');
    Route::resource('mysql-majorcategories', \App\Http\Controllers\Ams\MajorCategoryController::class)->names('ams.mysql-majorcategories');
 
    // Other AMS routes...
    Route::get('/orders/create', [OrderController::class, 'create'])->name('ams.orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('ams.orders.store');
    Route::get('/orders/categories', [OrderController::class, 'categories'])->name('ams.orders.categories');
    Route::get('/orders/categories/{category}', [OrderController::class, 'showCategory'])->name('ams.orders.category.show');
    Route::get('/orders/products', [OrderController::class, 'getProducts'])->name('ams.orders.products');
    Route::get('/orders/products/all', [OrderController::class, 'getAllProducts'])->name('ams.orders.all-products');
    Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('ams.orders.update-status');
    Route::get('/customers/{customer}/addresses', [OrderController::class, 'getCustomerAddresses'])->name('ams.customers.addresses');
    
    // Customer Address Routes
    Route::prefix('/customers/{customer}/addresses')->group(function () {
        Route::post('/', [OrderController::class, 'storeAddress'])->name('ams.customers.addresses.store');
        Route::put('/{address}', [OrderController::class, 'updateAddress'])->name('ams.customers.addresses.update');
        Route::delete('/{address}', [OrderController::class, 'deleteAddress'])->name('ams.customers.addresses.delete');
    });
    
    // Debug route
    Route::get('/debug/products', function() {
        $products = \App\Models\Product::with(['details', 'familyCategory'])->get();
        return response()->json([
            'total' => $products->count(),
            'categories' => \App\Models\FamilyCategory::pluck('name'),
            'sample' => $products->first()
        ]);
    });

    // Temporary debug route for demodb inspection
    Route::get('/debug/demodb', function() {
        // Get all tables in demodb
        $tables = DB::connection('mysql_second')->select('SHOW TABLES');
        
        // Get the structure of productsqry view if it exists
        $productsqryColumns = [];
        try {
            $productsqryColumns = DB::connection('mysql_second')
                ->select('DESCRIBE productsqry');
        } catch (\Exception $e) {
            $productsqryColumns = ['error' => $e->getMessage()];
        }
        
        // Get sample data from productsqry
        $sampleData = [];
        try {
            $sampleData = DB::connection('mysql_second')
                ->select('SELECT * FROM productsqry LIMIT 1');
        } catch (\Exception $e) {
            $sampleData = ['error' => $e->getMessage()];
        }
        
        // Show all tables and views in the database
        $allViews = [];
        try {
            $allViews = DB::connection('mysql_second')
                ->select("SHOW FULL TABLES WHERE TABLE_TYPE LIKE 'VIEW'");
        } catch (\Exception $e) {
            $allViews = ['error' => $e->getMessage()];
        }
        
        return response()->json([
            'tables' => $tables,
            'views' => $allViews,
            'productsqry_structure' => $productsqryColumns,
            'sample_data' => $sampleData
        ]);
    });
});

Route::get('/', function () {
    return view('index');
})->name('home');

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
Route::view('/contact', 'pages/contact')->name('contact');
Route::view('/product-cat', 'categories/products-cat');
Route::view('/product-cats', 'categories/products-cats');
// Route::view('/woodfence', 'categories/woodfence');


Route::get('/product/{id}', [SingleProductController::class, 'show'])->name('product.show');
Route::get('/product/details/{id}', [SingleProductController::class, 'fetchProductDetails']);

Route::get('/weldedwire', [ProductController::class, 'showWeldedWire'])->name('weldedwire');
Route::get('/wwf-product', [ProductByMeshSizeController::class, 'showMeshSizeProducts'])->name('meshsize.products');

Route::get('/wood-fence', [WoodFenceMysql2Controller::class, 'index'])->name('woodfence');
Route::get('/wood-fence/specs/{id}/{spacing?}', [WoodFenceMysql2Controller::class, 'specs'])
    ->where('spacing', '.*') // Allow special characters in spacing
    ->name('woodfence.specs');
Route::get('/wood-fence/specs', [WoodFenceMysql2Controller::class, 'specsAll'])
    ->name('woodfence.specs.all');
Route::get('/wood-fence/solid-board', [SolidBoardController::class, 'index'])
    ->name('solid-board');
Route::get('/wood-fence/board-on-board/{spacing?}', [BoardonBoardController::class, 'index'])
    ->where('spacing', '.*') // Allow special characters in spacing
    ->name('board-on-board');
Route::get('/wood-fence/tongue-groove', [TongueGrooveController::class, 'index'])->name('tongue-groove');
Route::get('/wood-fence/post-rail', [PostRailController::class, 'index'])->name('postrail.index');
Route::get('/wood-fence/post-rail/{style?}', [PostRailController::class, 'index'])->name('postrail.style');
Route::get('/wood-fence/stockade', [StockadeFenceController::class, 'index'])->name('stockade.index');
Route::get('/wood-fence/wood-post-caps', [WoodPostCapsController::class, 'index'])->name('woodpostcaps.index');
Route::get('/wood-fence/wood-post-caps/{style?}', [WoodPostCapsController::class, 'index'])->name('woodpostcaps.style');

// Aluminum Fence Routes
Route::get('/aluminum-fence', [AluminumFenceController::class, 'main'])->name('aluminumfence.main');
Route::get('/aluminum-fence/onguard', [AluminumFenceController::class, 'index'])->name('aluminumfence.index');
Route::get('/aluminum-fence/onguard/pickup', [AluminumFenceController::class, 'pickup'])->name('aluminumfence.pickup');
Route::get('/aluminum-fence/onguard/{type}/{model}', [AluminumFenceController::class, 'productDetails'])->name('aluminumfence.product');
Route::get('/aluminum-fence/filter', [AluminumFenceController::class, 'filterProducts'])->name('aluminumfence.filter');
Route::get('/aluminum-fence/onguard/{style?}', [AluminumFenceController::class, 'index'])->name('aluminumfence.style');

// Cart Routes
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/remove', [CartController::class, 'removeItem'])->name('cart.remove');

// Category Pages Routes
Route::get('/category/{slug}', [CategoryPageController::class, 'show'])->name('category.show');

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
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');


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



//Shipping API's 
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
// Route::post('/checkout/shipping-cost', [CheckoutController::class, 'calculateShippingCost'])->name('checkout.shipping-cost');

Route::get('/shipping-markup', [StateMarkupController::class, 'index'])->name('shipping-markup');;
Route::post('/shipping-markup/{id}/update', [StateMarkupController::class, 'update'])->name('shipping-markup.update');
Route::get('/api/state-markup/{state}', [StateMarkupController::class, 'getMarkup']);



require __DIR__ . '/auth.php';
