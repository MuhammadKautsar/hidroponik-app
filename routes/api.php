<?php

use App\Http\Controllers\API\ApiAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiProdukController;
use App\Http\Controllers\API\ApiOrderController;
use App\Http\Controllers\API\ApiFeedbackController;


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

// baru terbuat





// register sama login
Route::prefix('register')->group(function () {
    Route::post('', [ApiAuthController::class, 'register'])->name('register');
    Route::post('alamat/{user}', [ApiAuthController::class, 'storeAlamat'])->name('registerAlamat');
});
Route::post('login', [ApiAuthController::class, 'login'])->name('login');
Route::post('user/profil/{user}', [ApiAuthController::class, 'updateProfil'])->name('updateProfil');
Route::post('logout/{user}', [ApiAuthController::class, 'logout'])->name('logout');


// hasil
// /api/produks (tampilin semua data) -> GET
// /api/produks (create data) -> POST
// /api/produks/{produk} (tampilin data spesifik) -> GET
// /api/produks/{produk} (edit data spesifik) -> PUT/PATCh
// /api/produks/{produk} (delete data spesifik) -> DELETE
Route::resource('produks', ApiProdukController::class)->except(['create', 'edit']);
Route::get('produk/{user}', [ApiProdukController::class, 'getProdukByPenjualId'])->name('getProdukByPenjualId');


// Order
Route::resource('orders', ApiOrderController::class)->except(['create', 'edit']);
Route::prefix('order')->group(function () {
    Route::get('{user}', [ApiOrderController::class, 'getOrderByPembeliId'])->name('getOrderByPembeliId');
    Route::get('penjual/{user}', [ApiOrderController::class, 'getOrderByPenjualId'])->name('getOrderByPenjualId');
    Route::get('total/{user}', [ApiOrderController::class, 'getJumlahOrderPembeli'])->name('getJumlahOrderPembeli');
    Route::prefix('status')->group(function () {
        Route::get('checkout/{status}/{user}', [ApiOrderController::class, 'getOrderByCheckout'])->name('getOrderByCheckout');
        Route::post('checkout/{order}', [ApiOrderController::class, 'changeCheckoutStatus'])->name('changeCheckoutStatus');

        Route::get('order/{status}/{user}', [ApiOrderController::class, 'getOrderByOrder'])->name('getOrderByOrder');
        Route::post('order/{order}', [ApiOrderController::class, 'changeOrderStatus'])->name('changeOrderStatus');
    });
});

// Feedback
Route::resource('feedbacks', ApiFeedbackController::class)->except(['create', 'edit']);
Route::get('feedback/{produk}', [ApiFeedbackController::class, 'getFeedbackByProdukId'])->name('getFeedbackByProdukId');
