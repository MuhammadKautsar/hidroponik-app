<?php

use App\Http\Controllers\API\ApiAuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ApiProdukController;
use App\Http\Controllers\API\ApiOrderController;
use App\Http\Controllers\API\ApiFeedbackController;
use App\Http\Controllers\API\ApiOrderMappingController;
use App\Http\Controllers\API\ApiReportController;
use App\Http\Controllers\API\ApiPromoController;
use App\Http\Controllers\API\ApiRefController;



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
Route::get('verifikasi/email/{user}', [ApiAuthController::class, 'verifikasiEmail'])->name('verifyEmail');
Route::post('user/profil/{user}', [ApiAuthController::class, 'updateProfil'])->name('updateProfil');
Route::post('logout/{user}', [ApiAuthController::class, 'logout'])->name('logout');
Route::post('report/user', [ApiReportController::class, 'reportUser'])->name('reportUser');

// hasil
// /api/produks (tampilin semua data) -> GET
// /api/produks (create data) -> POST
// /api/produks/{produk} (tampilin data spesifik) -> GET
// /api/produks/{produk} (edit data spesifik) -> PUT/PATCh
// /api/produks/{produk} (delete data spesifik) -> DELETE
Route::resource('produks', ApiProdukController::class)->except(['create', 'edit', 'update']);
Route::post('produks/edited/{produk}', [ApiProdukController::class, 'update']);
Route::get('produk/sort/{sortBy}', [ApiProdukController::class, 'sortProduk'])->name('sortProduk');
Route::get('produk/{user}', [ApiProdukController::class, 'getProdukByPenjualId'])->name('getProdukByPenjualId');


//Order Mapping
Route::resource('orderMaps', ApiOrderMappingController::class)->except(['create', 'edit']);
Route::prefix('orderMap')->group(function () {
    Route::prefix('status')->group(function () {
        Route::post('checkout/tambah/{order}', [ApiOrderMappingController::class, 'addQuantity'])->name('addQuantity');
        Route::post('checkout/kurang/{order}', [ApiOrderMappingController::class, 'minusQuantity'])->name('minusQuantity');
        Route::get('checkout/{status}/{user}', [ApiOrderMappingController::class, 'getOrderByCheckout'])->name('getOrderByCheckout');
        Route::post('checkout/{order}', [ApiOrderMappingController::class, 'changeCheckoutStatus'])->name('changeCheckoutStatus');
    });
});

// Order
Route::resource('orders', ApiOrderController::class)->except(['create', 'edit']);
Route::prefix('order')->group(function () {
    // Route::get('{user}', [ApiOrderController::class, 'getOrderByPembeliId'])->name('getOrderByPembeliId');
    // Route::get('penjual/{user}', [ApiOrderController::class, 'getOrderByPenjualId'])->name('getOrderByPenjualId');
    // Route::get('total/{user}', [ApiOrderController::class, 'getJumlahOrderPembeli'])->name('getJumlahOrderPembeli');
    Route::prefix('status')->group(function () {
        Route::get('checkout/beli/{user}', [ApiOrderController::class, 'getOrder'])->name('getOrder');
        Route::get('checkout/beli/{user}/selesai', [ApiOrderController::class, 'getOrderSelesai'])->name('getOrderSelesai');
        Route::get('checkout/beli/penjual/{user}', [ApiOrderController::class, 'getOrderPenjual'])->name('getOrderPenjual');
        Route::get('checkout/beli/penjual/{user}/selesai', [ApiOrderController::class, 'getOrderPenjualSelesai'])->name('getOrderPenjualSelesai');
        // Route::get('checkout/{status}/selesai/{user}', [ApiOrderController::class, 'getOrderByCheckoutSelesai'])->name('getOrderByCheckoutSelesai');

        // Route::get('order/{status}/{user}', [ApiOrderController::class, 'getOrderByOrder'])->name('getOrderByOrder');
        Route::post('order/{order}', [ApiOrderController::class, 'changeOrderStatus'])->name('changeOrderStatus');
    });
    Route::post('beli/{order}', [ApiOrderController::class, 'changeHargaPengiriman'])->name('changeHargaPengiriman');
});

// Feedback
Route::resource('feedbacks', ApiFeedbackController::class)->except(['create', 'edit']);
Route::get('feedback/{produk}', [ApiFeedbackController::class, 'getFeedbackByProdukId'])->name('getFeedbackByProdukId');

// PROMOS
Route::get('promos', [ApiPromoController::class, 'index'])->name('get_promo');

// TODO(yaumil): hehe
Route::prefix('ref')->group(function () {
    Route::get('kabupaten', [ApiRefController::class, 'getKabupaten'])->name('get_kabupaten');
    Route::get('kecamatan/{kabupaten}', [ApiRefController::class, 'getKecamatan'])->name('get_kecamatan');
});
// kasih feedback 
// tampilin list order by pembeli
// tampilin list order by penjual
// tampilin detail order