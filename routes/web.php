<?php

use App\Http\Controllers\Customer\ReviewController;
use App\Http\Controllers\Employee\VoucherController;
use App\Utils\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// CUSTOMER routes

// Route::middleware('auth.customer')->group(function() {

Route::middleware(['set.current.customer'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Customer\HomeController::class, 'index'])->name('home');
    Route::post('/', [\App\Http\Controllers\Customer\HomeController::class, 'applyFilter'])->name('filter.apply');
    Route::get('/product/{product}', [App\Http\Controllers\Customer\ProductController::class, 'show'])->name('product.show');
});

// Route::post('/user/cart/{product}/quantity/{quantity}', [App\Http\Controllers\Customer\CustomerController::class, 'changeQuantity']);

Route::middleware(['auth.user', 'auth.customer'])->group(function () {

    Route::get('/cart', [App\Http\Controllers\Customer\CartController::class, 'show'])->name('cart');
    Route::get('/favourites', [App\Http\Controllers\Customer\FavouritesController::class, 'show'])->name('favourites.show');

    Route::middleware('validate.voucher')->group(function () {
        Route::post('/users/cart/voucher', [App\Http\Controllers\Customer\CartController::class, 'addVoucher'])->name('user.add.cart.voucher');
    });
    Route::delete('/users/cart/voucher', [App\Http\Controllers\Customer\CartController::class, 'deleteVoucher']);

    Route::middleware(['check.product.exists'])->group(function () {
        Route::post('/user/favourites/{product}/toggle', [App\Http\Controllers\Customer\FavouritesController::class, 'toggleFavourite'])->name('user.toggle-favourite');
        Route::delete('/user/favourites/{product}', [App\Http\Controllers\Customer\FavouritesController::class, 'removeFromFavourites'])->name('user.remove-favourite');
        Route::post('/user/cart/{product}/quantity/increment', [App\Http\Controllers\Customer\CartController::class, 'incrementCartItemQuantity'])->where('product', '[0-9]+')->name('user.inc-cart-item');
        Route::post('/user/cart/{product}/quantity/decrement', [App\Http\Controllers\Customer\CartController::class, 'decrementCartItemQuantity'])->where('product', '[0-9]+')->name('user.dec-cart-item');
        Route::delete('/user/cart/{product}', [App\Http\Controllers\Customer\CartController::class, 'deleteItem'])->name('user.del-cart-item');
    });



});


// Route::post('/user/cart/{product}/quantity/{quantity}', [App\Http\Controllers\Customer\CustomerController::class, 'addToCart'])->name('user.add-to-cart');
Route::prefix('account')->group(function () {
    Route::get('/', [App\Http\Controllers\Customer\CustomerController::class, 'index'])->name('account.index');
    Route::get('/edit', [App\Http\Controllers\Customer\CustomerController::class, 'edit'])->name('account.edit');
    Route::put('/edit', [App\Http\Controllers\Customer\CustomerController::class, 'update']);
    Route::get('/delete', [App\Http\Controllers\Customer\CustomerController::class, 'delete'])->name('account.delete');
    Route::delete('/delete', [App\Http\Controllers\Customer\CustomerController::class, 'destroy']);
});
// });



// Employee routes middleware('auth.customer')->
Route::prefix('/employee')->group(function () {
    Route::get('/', [App\Http\Controllers\Employee\EmployeeController::class, 'dashboard'])->name('employee.dashboard');
    Route::resource('/employees', App\Http\Controllers\Employee\EmployeeController::class);
    Route::resource('/customers', App\Http\Controllers\Employee\CustomerController::class);
    Route::resource('/categories', App\Http\Controllers\Employee\CategoryController::class);
    Route::resource('/products', App\Http\Controllers\Employee\ProductController::class);
    Route::resource('/vouchers', App\Http\Controllers\Employee\VoucherController::class);
    Route::resource('/orders', App\Http\Controllers\Employee\OrderController::class);
    Route::resource('/reports', App\Http\Controllers\Employee\ReportController::class);

    Route::put('/vouchers/{voucher}/toogle-active', [VoucherController::class, 'toggleActive']);

});

// Route::resource('/reviews', App\Http\Controllers\User\ReviewController::class);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::post('/product/{product}/reviews', [App\Http\Controllers\Customer\ReviewController::class, 'create'])->name('products.reviews.create');
Route::put('/products/{product}/reviews/user/{user}', [ReviewController::class, 'update'])->name('products.reviews.update');


Route::get('/home', function () {
    return redirect()->route('home');
});
Route::any('{any}', function (Request $request) {

    // if ($request->isXmlHttpRequest()) {
    //     return (new Response('fail', 'Something went wrong!', 400))->get();
    // }
    abort(404, 'The requested page was not found!');
})->where('any', '.*');
