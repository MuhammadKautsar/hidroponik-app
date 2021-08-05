<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\UploadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('upload', [UploadController::class, 'upload']);

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('/products', [ProductController::class, 'get']);
    Route::get('/products/{id}', [ProductController::class, 'getById']);

    Route::post('/product', [ProductController::class, 'post']);

    Route::put('/product/{id}', [ProductController::class, 'put']);

    Route::delete('/product/{id}', [ProductController::class, 'delete']);   

});


Route::post('/produk', [ProdukController::class, 'create']);
Route::get('/produks', [ProdukController::class, 'show']);
Route::put('/produk/{id}', [ProdukController::class, 'put']);
Route::delete('/produk/{idproduk}', [ProdukController::class, 'delete']);


Route::get('/orders', [OrderController::class, 'get']);
Route::get('/orders/{id}', [OrderController::class, 'getById']);

Route::post('/order', [OrderController::class, 'post']);

Route::put('/order/{id}', [OrderController::class, 'put']);

Route::delete('/order/{id}', [OrderController::class, 'delete']);


Route::get('/promos', [PromoController::class, 'get']);
Route::get('/promos/{id}', [PromoController::class, 'getById']);

Route::post('/promo', [PromoController::class, 'post']);

Route::put('/promo/{id}', [PromoController::class, 'put']);

Route::delete('/promo/{id}', [PromoController::class, 'delete']);


Route::get('/reports', [ReportController::class, 'get']);
Route::get('/reports/{id}', [ReportController::class, 'getById']);

Route::post('/report', [ReportController::class, 'post']);

Route::put('/report/{id}', [ReportController::class, 'put']);

Route::delete('/report/{id}', [ReportController::class, 'delete']);

Route::post('/feedback', [FeedbackController::class, 'post']);

Route::get('/users', [UserController::class, 'get']);