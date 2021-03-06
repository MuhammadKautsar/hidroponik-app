<?php

use App\Http\Livewire\Location;
use App\Http\Livewire\ListUsers;
use App\Http\Livewire\ListOrders;
use App\Http\Livewire\ListProduk;
use App\Http\Livewire\ListPromos;
use App\Http\Livewire\ListPesanan;
use App\Http\Livewire\ListReports;
use App\Http\Livewire\ListProducts;
use App\Http\Livewire\ListFeedbacks;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\ListUmpanbalik;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;

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

Route::get('/informasi', function () {
    return view('informasi');
});

Route::get('/privacy-policy', function () {
    return view('privacy_policy');
});

Auth::routes(['verify'=>true]);

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => ['auth','verified','cekLevel:admin,superadmin']], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
     Route::get('admin/pengguna', ListUsers::class)->name('users');
	 Route::get('pengguna/{id}/delete', [UserController::class, 'destroy']);
	 Route::get('/pengguna/status/{user_id}/{status_code}', [UserController::class, 'updateStatus'])->name('users.status.update');
     Route::get('admin/pesanan', ListPesanan::class)->name('pesanan');
     Route::get('admin/promo', ListPromos::class)->name('promos');
	 Route::post('/promo/create', 'App\Http\Controllers\PromoController@create');
	 Route::post('/promo/{id}/update', 'App\Http\Controllers\PromoController@update');
	 Route::get('/promo/{id}/delete', 'App\Http\Controllers\PromoController@hapus');
     Route::get('admin/laporan', ListReports::class)->name('reports');
	 Route::get('/laporan/{id}/delete', [ReportController::class, 'destroy']);
     Route::get('admin/ulasan', Listumpanbalik::class)->name('umpanbalik');
     Route::get('/umpanbalik/{id}/delete', 'App\Http\Controllers\FeedbackController@destroyAdmin');
     Route::get('admin/produk', ListProduk::class)->name('produks');
     Route::get('/produks/{id}/delete', [ProdukController::class, 'destroyAdmin']);
     Route::get('admin/cetak-pesanan', [OrderController::class, 'cetakPesanan'])->name('cetak-pesanan');
     Route::get('admin/lokasi', Location::class)->name('location');
});

Route::group(['middleware' => ['auth','verified','cekLevel:penjual']], function () {
    Route::get('/produk', ListProducts::class)->name('products');
	Route::post('/produk/create', [ProdukController::class, 'store']);
	Route::put('/produk/{id}/update', [ProdukController::class, 'update']);
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit'])->name('edits');
	Route::get('/produk/{id}/delete', [ProdukController::class, 'destroy']);
	Route::get('/deleteimage/{id}', [ProdukController::class, 'deleteimage']);
    Route::get('/pesanan', ListOrders::class)->name('orders');
	Route::post('/pesanan/{id}/update', 'App\Http\Controllers\OrderController@update');
    Route::get('/ulasan', ListFeedbacks::class)->name('feedbacks');
    Route::get('/ulasan/{id}/delete', 'App\Http\Controllers\FeedbackController@destroy');
    Route::get('/cetak-pesanan', [OrderController::class, 'cetakPesananPenjual'])->name('cetak-pesanan-penjual');
    Route::get('/aturan', function () {
        return view('aturan');
    });
});

Route::group(['middleware' => ['auth','verified']], function () {
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
    Route::post('/getkecamatan', [ProfileController::class, 'getkecamatan'])->name('getkecamatan');
});
