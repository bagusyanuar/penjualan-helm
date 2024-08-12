<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::match(['post', 'get'],'/', [\App\Http\Controllers\Web\LoginController::class, 'login'])->name('login');
Route::get('/logout', [\App\Http\Controllers\Web\LoginController::class, 'logout'])->name('logout');

Route::get('/dashboard', [\App\Http\Controllers\Web\DashboardController::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'user'], function (){
    Route::get('/', [\App\Http\Controllers\Web\UserController::class, 'index'])->name('user');
    Route::match(['post', 'get'],'/create', [\App\Http\Controllers\Web\UserController::class, 'add'])->name('user.create');
    Route::match(['post', 'get'],'/{id}/edit', [\App\Http\Controllers\Web\UserController::class, 'edit'])->name('user.edit');
    Route::post('/{id}/delete', [\App\Http\Controllers\Web\UserController::class, 'delete'])->name('user.delete');
});

Route::group(['prefix' => 'category'], function (){
    Route::get('/', [\App\Http\Controllers\Web\CategoriesController::class, 'index'])->name('category');
    Route::match(['post', 'get'],'/create', [\App\Http\Controllers\Web\CategoriesController::class, 'add'])->name('category.create');
    Route::match(['post', 'get'],'/{id}/edit', [\App\Http\Controllers\Web\CategoriesController::class, 'edit'])->name('category.edit');
    Route::post('/{id}/delete', [\App\Http\Controllers\Web\CategoriesController::class, 'delete'])->name('category.delete');
});

Route::group(['prefix' => 'product'], function (){
    Route::get('/', [\App\Http\Controllers\Web\ProductController::class, 'index'])->name('product');
    Route::match(['post', 'get'],'/create', [\App\Http\Controllers\Web\ProductController::class, 'add'])->name('product.create');
    Route::match(['post', 'get'],'/{id}/edit', [\App\Http\Controllers\Web\ProductController::class, 'edit'])->name('product.edit');
    Route::post('/{id}/delete', [\App\Http\Controllers\Web\ProductController::class, 'delete'])->name('product.delete');
});

Route::group(['prefix' => 'shipping'], function (){
    Route::get('/', [\App\Http\Controllers\Web\ShippingController::class, 'index'])->name('shipping');
    Route::match(['post', 'get'],'/create', [\App\Http\Controllers\Web\ShippingController::class, 'add'])->name('shipping.create');
    Route::match(['post', 'get'],'/{id}/edit', [\App\Http\Controllers\Web\ShippingController::class, 'edit'])->name('shipping.edit');
    Route::post('/{id}/delete', [\App\Http\Controllers\Web\ShippingController::class, 'delete'])->name('shipping.delete');
});

Route::group(['prefix' => 'order'], function (){
    Route::get('/', [\App\Http\Controllers\Web\OrderController::class, 'index'])->name('order');
    Route::match(['post', 'get'],'/{id}/pesanan-baru', [\App\Http\Controllers\Web\OrderController::class, 'detail_new'])->name('order.new');
    Route::match(['post', 'get'],'/{id}/pesanan-packing', [\App\Http\Controllers\Web\OrderController::class, 'detail_packing'])->name('order.packing');
    Route::match(['post', 'get'],'/{id}/pesanan-di-kirim', [\App\Http\Controllers\Web\OrderController::class, 'detail_sent'])->name('order.sent');
    Route::match(['post', 'get'],'/{id}/pesanan-selesai', [\App\Http\Controllers\Web\OrderController::class, 'detail_finish'])->name('order.finish');
//    Route::match(['post', 'get'],'/create', [\App\Http\Controllers\Web\OrderController::class, 'add'])->name('shipping.create');
//    Route::match(['post', 'get'],'/{id}/edit', [\App\Http\Controllers\Web\OrderController::class, 'edit'])->name('shipping.edit');
//    Route::post('/{id}/delete', [\App\Http\Controllers\Web\OrderController::class, 'delete'])->name('shipping.delete');
});

Route::get('/report-order', [\App\Http\Controllers\Web\ReportController::class, 'report_order'])->name('report.order');
Route::get('/report-order/print', [\App\Http\Controllers\Web\ReportController::class, 'print_report_order'])->name('report.order.print');
Route::get('/report-stock', [\App\Http\Controllers\Web\ReportController::class, 'report_stock'])->name('report.stock');
Route::get('/report-stock/print', [\App\Http\Controllers\Web\ReportController::class, 'print_report_stock'])->name('report.stock.print');
Route::get('/report-customer', [\App\Http\Controllers\Web\ReportController::class, 'report_customer'])->name('report.customer');
Route::get('/report-customer/print', [\App\Http\Controllers\Web\ReportController::class, 'print_report_customer'])->name('report.customer.print');
