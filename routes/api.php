<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return response()->json([
        'app_name' => 'sadean_helm_app',
        'app_version' => 'v1.0'
    ], 200);
});

Route::post('/register', [\App\Http\Controllers\API\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\API\AuthController::class, 'login']);

//Ro
Route::group(['middleware' => ['jwt.verify']], function () {

    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [\App\Http\Controllers\API\CategoriesController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\API\CategoriesController::class, 'findByID']);
        Route::get('/{id}/product', [\App\Http\Controllers\API\CategoriesController::class, 'productByCategoryID']);
    });

    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [\App\Http\Controllers\API\ProductController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\API\ProductController::class, 'findByID']);
    });

    Route::group(['prefix' => 'cart'], function (){
        Route::match(['post', 'get'], '/', [\App\Http\Controllers\Api\CartController::class, 'index']);
        Route::post( '/checkout', [\App\Http\Controllers\Api\CartController::class, 'checkout']);
        Route::post('/{id}/delete', [\App\Http\Controllers\Api\CartController::class, 'destroy']);
    });

    Route::group(['prefix' => 'order'], function (){
        Route::get('/', [\App\Http\Controllers\Api\OrderController::class, 'index']);
        Route::get('/{id}', [\App\Http\Controllers\Api\OrderController::class, 'findByID']);
    });

});
