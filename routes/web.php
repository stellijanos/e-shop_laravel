<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

Route::get('/', [\App\Http\Controllers\Customer\HomeController::class, 'index'])->name('home');
Route::get('/favourites', [App\Http\Controllers\Customer\HomeController::class, 'favourites'])->name('favourites');
Route::get('/cart', [App\Http\Controllers\Customer\HomeController::class, 'cart'])->name('cart');
Route::get('/product/{product}', [App\Http\Controllers\Customer\ProductController::class, 'show'])->name('product');
Route::post('/user/cart/{product}/quantity/{quantity}', [App\Http\Controllers\Customer\CustomerController::class, 'changeQuantity']);

Route::prefix('account')->group(function () {
    Route::get('/', [App\Http\Controllers\Customer\CustomerController::class, 'index'])->name('account.index');
    Route::get('/edit', [App\Http\Controllers\Customer\CustomerController::class, 'edit'])->name('account.edit');
    Route::put('/edit', [App\Http\Controllers\Customer\CustomerController::class, 'update']);
    Route::get('/delete', [App\Http\Controllers\Customer\CustomerController::class, 'delete'])->name('account.delete');
    Route::delete('/delete', [App\Http\Controllers\Customer\CustomerController::class, 'destroy'])->name('account.delete');
    Route::post('/favourite/{product}', [App\Http\Controllers\Customer\CustomerController::class, 'favourite']);
    Route::post('/add-to-cart/{product}', [App\Http\Controllers\Customer\CustomerController::class, 'addToCart']);
});

Route::get('/admin', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.index');


Route::get('/employees', function () {
    echo 'Janos legyen!';
})->name('employees');



Route::resource('/admin/employee', App\Http\Controllers\Admin\EmployeeController::class);
Route::resource('/admin/customer', App\Http\Controllers\Admin\CustomerController::class);
Route::resource('/admin/category', App\Http\Controllers\Admin\CategoryController::class);
Route::resource('/admin/product', App\Http\Controllers\Admin\ProductController::class);
// Route::resource('/reviews', App\Http\Controllers\User\ReviewController::class);

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
Route::post('/product/{product}/reviews', [App\Http\Controllers\Customer\ReviewController::class, 'create'])->name('products.reviews.create');


Route::any('{any}', function () {
    abort(404, 'The requested page was not found!');
})->where('any', '.*');
