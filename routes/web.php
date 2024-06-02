<?php

use App\Http\Controllers\AdminController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/account', [UserController::class, 'index'])->name('account.index');
Route::get('/account/edit', [UserController::class, 'edit'])->name('account.edit');
Route::put('/account/edit', [UserController::class, 'update']);
Route::get('/account/delete', [UserController::class, 'delete'])->name('account.delete');
Route::delete('/account/delete', [UserController::class, 'destroy'])->name('account.delete');


Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
Route::get('/admin/employees', [AdminController::class, 'employees'])->name('admin.employees.index');
