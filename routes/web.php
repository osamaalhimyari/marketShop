<?php

use App\Http\Controllers\admin\AdminProductsCotroller;
use App\Http\Controllers\AuthCotroller;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\CurrencyController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\HomePageCotroller;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\OrderCotroller;
use App\Http\Controllers\SiteMapController;
use App\Http\Middleware\GetConfigs;
use App\Http\Middleware\HandleRedirectException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;

// admin routes


Route::group([
    'middleware' => [GetConfigs::class]

], function () {

    Route::get('/', [HomePageCotroller::class, 'getAllProducts'])->name('homePage');
    Route::get('/lang', [LanguageController::class, 'change'])->name('user.lang');
    Route::get('/login', [AuthCotroller::class, 'goLoginPage'])->name('login');
    Route::get('/product', [HomePageCotroller::class, 'getProduct'])->name('product');
    Route::get('/cart', function () {
        return view('pages.cartPage'); // Assuming the view is in resources/views/cart.blade.php
    })->name('cart');
    Route::view('/history', view: 'pages.HistoryPage')->name('history');
    Route::post('/order', [OrderCotroller::class, 'storeOrder'])->name('order');
    Route::post('/login', [AuthCotroller::class, 'login']);
});
Route::group([
    'prefix' => 'admin',
    'middleware' => [
        GetConfigs::class,
        'auth',
    ]

], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('admin-dashboard');

    Route::get('/controll-Products', [AdminProductsCotroller::class, 'getAllProducts'])->name('admin-controll-Products');
    Route::delete('/delete-Product', action: [AdminProductsCotroller::class, 'deleteProduct'])->name('admin-delete-Product');
    Route::get('/show-Product', [AdminProductsCotroller::class, 'getProduct'])->name('admin-show-Product');
    Route::post('/update-Products', [AdminProductsCotroller::class, 'updateProduct'])->name('admin-update-Products');
    Route::post('/add-Product', [AdminProductsCotroller::class, 'addProduct'])->name('admin-add-Product');
    // Route::get('/admin-add-product',[AdminProductsCotroller::class , 'goToAddPage'])->name('admin-add-product-Page');
    Route::get('/logout', [AuthCotroller::class, 'logout'])->name('logout');
    Route::delete('/delete-image', [AdminProductsCotroller::class, 'deleteImage'])->name('delete-image');
    // 

    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    // currency
    Route::get('/currencies', [CurrencyController::class, 'index'])->name('currencies.index');
    Route::get('/currencies/config', [CurrencyController::class, 'setDefault'])->name('currencies.setDefault');
    Route::post('/currencies', [CurrencyController::class, 'store'])->name('currencies.store');
    Route::put('/currencies/{id}', [CurrencyController::class, 'update'])->name('currencies.update');
    Route::delete('/currencies/{id}', [CurrencyController::class, 'destroy'])->name('currencies.destroy');
    //
    Route::get('/orders', [OrderController::class, 'getCartData'])->name('orders.index');
    Route::post('/orders/status', [OrderController::class, 'updateStatus'])->name('orders.status');


    Route::post('/upload-image', [AdminProductsCotroller::class, 'uploadImage'])->name('upload.image');

    // 
    Route::get('/generate-sitemap', function () {
        Artisan::call('sitemap:generate');
        return "Sitemap generated successfully!";
    });
    Route::get('/run-artisan', function () {
        // Artisan::call('sitemap:generate');
        Artisan::call('optimize');
        Artisan::call('config:cache');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('optimize');
        return "php artisan  runned successfully!";
    });

    Route::get('test', function () {
        return view('test'); // Assuming the view is in resources/views/cart.blade.php
    })->name('test');
});

Route::get('/migrate', function () {
    // Artisan::call('migrate');
    Artisan::call('migrate');
    return "migrate  runned successfully!";
});
Route::get('/run-artisan2', function () {
    // Artisan::call('sitemap:generate');
    Artisan::call('optimize');
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    Artisan::call('route:clear');
    Artisan::call('optimize');
    return "php artisan  runned successfully!";
});
// 
Route::get('/storage', function (Request $request) {
    // Get the 'img' query parameter from the URL
    $filename = $request->query('img');

    // Ensure the filename is provided
    if (!$filename) {
        abort(404, 'File not specified');
    }

    // Build the path to the file in the storage directory
    $path = storage_path('app/public/' . str_replace('/', DIRECTORY_SEPARATOR, $filename));

    // Check if the file exists
    if (!File::exists($path)) {
        abort(404, 'File not found');
    }

    // Get the file contents and MIME type
    $file = File::get($path);
    $type = File::mimeType($path);

    // Return the file with the correct MIME type
    return response($file, 200)->header("Content-Type", $type);
});
// others
Route::get('/sitemap.xml', [SiteMapController::class, 'index']);
