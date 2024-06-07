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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/account', [App\Http\Controllers\User\UserController::class, 'index'])->name('account.index');
Route::get('/account/edit', [App\Http\Controllers\User\UserController::class, 'edit'])->name('account.edit');
Route::put('/account/edit', [App\Http\Controllers\User\UserController::class, 'update']);
Route::get('/account/delete', [App\Http\Controllers\User\UserController::class, 'delete'])->name('account.delete');
Route::delete('/account/delete', [App\Http\Controllers\User\UserController::class, 'destroy'])->name('account.delete');


Route::get('/admin', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.index');

Route::resource('/admin/employee',App\Http\Controllers\Admin\EmployeeController::class);
Route::resource('/admin/customer',App\Http\Controllers\Admin\CustomerController::class);
Route::resource('/admin/category',App\Http\Controllers\Admin\CategoryController::class);
Route::resource('/admin/product',App\Http\Controllers\Admin\ProductController::class);
