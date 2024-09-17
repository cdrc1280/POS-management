<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/users', UserController::class); //users.index
Route::resource('/orders', OrderController::class); //orders.index
Route::resource('/products', ProductController::class); //products.index
Route::resource('/suppliers', SupplierController::class); //suppliers.index
Route::resource('/companies', CompanyController::class); //company.index
Route::resource('/transcations', TransactionController::class); //transaction.index



// Route::post('user_store', [UserController::class, 'store'])->name('user.store');