<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Backend\AdminController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Backend\SubCategoryController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\ColorController;
use App\Http\Controllers\Backend\ProductController;

// Route::get('/', function(){
//      return 'hello';
// })->name('home');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| For Backend Controller
|--------------------------------------------------------------------------
|
| This value is the name of your application, which will be used when the
| framework needs to place the application's name in a notification or
| other UI elements where an application name needs to be displayed.
|
*/


Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'admin']], function(){
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    //__  Create Admin  __//
    Route::get('/list', [AdminController::class, 'list'])->name('admin.list');
    Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/get-data', [AdminController::class, 'getData'])->name('admin.getData');
    Route::post('/edit-data', [AdminController::class, 'editData'])->name('admin.editData');
    Route::post('/update-data', [AdminController::class, 'updateData'])->name('admin.updateData');
    Route::post('/delete-data', [AdminController::class, 'deleteData'])->name('admin.deleteData');

    //__  Category  __//
    Route::group(['prefix' => '/category'], function(){
        Route::get('/manage', [CategoryController::class, 'manage'])->name('category.manage');
        Route::post('/store', [CategoryController::class, 'store'])->name('category.store');
        Route::post('/update/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::get('/delete/{id}', [CategoryController::class, 'destroy'])->name('category.delete');
    });

    //__  SubCategory  __//
    Route::group(['prefix' => '/sub-category'], function(){
        Route::get('/manage', [SubCategoryController::class, 'manage'])->name('subCategory.manage');
        Route::post('/store', [SubCategoryController::class, 'store'])->name('subCategory.store');
        Route::post('/update/{id}', [SubCategoryController::class, 'update'])->name('subCategory.update');
        Route::get('/delete/{id}', [SubCategoryController::class, 'destroy'])->name('subCategory.delete');
    });

    //__  Brand  __//
    Route::group(['prefix' => '/brand'], function(){
        Route::get('/manage', [BrandController::class, 'manage'])->name('brand.manage');
        Route::post('/store', [BrandController::class, 'store'])->name('brand.store');
        Route::post('/update/{id}', [BrandController::class, 'update'])->name('brand.update');
        Route::get('/delete/{id}', [BrandController::class, 'destroy'])->name('brand.delete');
    });

    //__  Color  __//
    Route::group(['prefix' => '/color'], function(){
        Route::get('/manage', [ColorController::class, 'manage'])->name('color.manage');
        Route::post('/store', [ColorController::class, 'store'])->name('color.store');
        Route::post('/update/{id}', [ColorController::class, 'update'])->name('color.update');
        Route::get('/delete/{id}', [ColorController::class, 'destroy'])->name('color.delete');
    });

    //__  Product  __//
    Route::group(['prefix' => '/product'], function(){
        Route::get('/manage', [ProductController::class, 'manage'])->name('product.manage');
        Route::get('/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::get('/destroyImage/{id}', [ProductController::class, 'destroyImage'])->name('product.destroyImage');
        Route::get('/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');

        // api call
        Route::post('/get/category', [ProductController::class, 'getCategory'])->name('admin.get.category');
    });


});



/*
|--------------------------------------------------------------------------
| For Frontend Controller
|--------------------------------------------------------------------------
|
| This value is the name of your application, which will be used when the
| framework needs to place the application's name in a notification or
| other UI elements where an application name needs to be displayed.
|
*/

use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\ProductsController;
use App\Http\Controllers\Frontend\CartController;

Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::post('/get-product-filter', [ProductsController::class, 'getProductFilter'])->name('get.product.filter');
Route::get('/product/{catslug?}/{subslug?}', [ProductsController::class, 'getCategory'])->name('get.category');

// product details page
Route::get('/product-details/{slug}', [ProductsController::class, 'productDetails'])->name('product.details');

// for cart controller
Route::post('/product/add-to-cart', [CartController::class, 'productCart'])->name('product.cart');
Route::get('cart-show', [CartController::class, 'cartShow'])->name('cart.show');
Route::get('getCart-data', [CartController::class, 'getCartData'])->name("getCart.data");  // API call
Route::post('/cart/update-quantity', [CartController::class, 'updateCartQuantity'])->name('cart.updateQuantity'); // API call
Route::post('/delete/cart', [CartController::class, 'deleteCart'])->name('delete.cart'); // API call




