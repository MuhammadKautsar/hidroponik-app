<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Livewire\ListUsers;
use App\Http\Livewire\ListPromos;
use App\Http\Livewire\ListFeedbacks;
use App\Http\Livewire\ListReports;
use App\Http\Livewire\ListOrders;
use App\Http\Livewire\ListProducts;
use App\Http\Livewire\ListProduk;
use App\Http\Livewire\ListPesanan;
use App\Http\Livewire\ListUmpanbalik;

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

Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => ['auth','cekLevel:admin,superadmin']], function () {
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
});

Route::group(['middleware' => ['auth','cekLevel:penjual']], function () {
    Route::get('/produk', ListProducts::class)->name('products');
	Route::post('/produk/create', [ProdukController::class, 'store']);
	Route::put('/produk/{id}/update', [ProdukController::class, 'update']);
    Route::get('/produk/{id}/edit', [ProdukController::class, 'edit']);
	Route::get('/produk/{id}/delete', [ProdukController::class, 'destroy']);
	Route::get('/deleteimage/{id}', [ProdukController::class, 'deleteimage']);
    Route::get('/pesanan', ListOrders::class)->name('orders');
	Route::post('/pesanan/{id}/update', 'App\Http\Controllers\OrderController@update');
    Route::get('/ulasan', ListFeedbacks::class)->name('feedbacks');
    Route::get('/ulasan/{id}/delete', 'App\Http\Controllers\FeedbackController@destroy');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});
