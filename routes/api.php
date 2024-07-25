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
    });
});
