<?php

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
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// store
Route::get('/store', [App\Http\Controllers\StoreController::class, 'index'])->name('store');
Route::post('/addStore', [App\Http\Controllers\StoreController::class, 'store'])->name('addStore');
Route::get('/deletestore/{id}', [App\Http\Controllers\StoreController::class, 'destroy'])->name('deletestore');

// sales
Route::get('/sales', [App\Http\Controllers\SaleController::class, 'index'])->name('sales');
Route::post('/storeSale', [App\Http\Controllers\SaleController::class, 'store'])->name('storeSale');
Route::get('/deletesale/{id}', [App\Http\Controllers\SaleController::class, 'destroy'])->name('deletesale');
Route::get('/updatesale/{id}/{sale_date}/{sale_amount}/{sale_quantity}', [App\Http\Controllers\SaleController::class, 'update'])->name('updateSale');
Route::get('/getvaluesforsale/{id}', [App\Http\Controllers\SaleController::class, 'getValues'])->name('getvaluesforsale');
Route::get('/getprice/{id}', [App\Http\Controllers\SaleController::class, 'getPrice']);

// inventory
Route::get('/inventory', [App\Http\Controllers\InventoryController::class, 'index'])->name('inventory');
Route::post('/storeProduct', [App\Http\Controllers\InventoryController::class, 'store'])->name('storeProduct');
Route::get('/deleteproduct/{id}', [App\Http\Controllers\InventoryController::class, 'destroy'])->name('deleteproduct');
Route::get('/updateproduct/{id}/{product_name}/{product_quantity}/{product_price}', [App\Http\Controllers\InventoryController::class, 'update'])->name('updateProduct');
Route::get('/getvaluesforupdate/{id}', [App\Http\Controllers\InventoryController::class, 'getValues'])->name('getvaluesforupdate');

// expenses
Route::get('/expenses', [App\Http\Controllers\ExpenseController::class, 'index'])->name('expenses');
Route::post('/storeExpense', [App\Http\Controllers\ExpenseController::class, 'store'])->name('storeExpense');
Route::get('/deleteexpense/{id}', [App\Http\Controllers\ExpenseController::class, 'destroy'])->name('deleteexpense');
Route::get('/updateexpense/{id}/{expense_type}/{expense_amount}/{expense_date}', [App\Http\Controllers\ExpenseController::class, 'update'])->name('updateExpense');
Route::get('/getexpensevalues/{id}', [App\Http\Controllers\ExpenseController::class, 'getValues'])->name('getexpensevalues');
