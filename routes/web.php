<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Livewire\ListUsers;
use App\Models\Produk;
use App\Models\User;
use App\Models\Order;

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

Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => ['auth','cekLevel:admin,superadmin']], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	//  Route::get('pengguna', [UserController::class, 'pengguna'])->name('users');
     Route::get('admin/pengguna', ListUsers::class)->name('users');
	 Route::post('/pengguna/create', 'App\Http\Controllers\UserController@create');
	 Route::get('pengguna/{id}/delete', [UserController::class, 'destroy']);
	 Route::get('/pengguna/status/{user_id}/{status_code}', [UserController::class, 'updateStatus'])->name('users.status.update');
	 Route::get('/promo', 'App\Http\Controllers\PromoController@index')->name('promos');
	 Route::post('/promo/create', 'App\Http\Controllers\PromoController@create');
	 Route::post('/promo/{id}/update', 'App\Http\Controllers\PromoController@update');
	 Route::get('/promo/{id}/delete', 'App\Http\Controllers\PromoController@hapus');
	 Route::get('/laporan', 'App\Http\Controllers\ReportController@index')->name('reports');
	 Route::get('/laporan/{id}/delete', [ReportController::class, 'destroy']);
	 Route::get('/pesanan', 'App\Http\Controllers\OrderController@index')->name('orders');
	 Route::get('/ulasan', 'App\Http\Controllers\FeedbackController@index')->name('feedbacks');
	 Route::get('/produk', [ProdukController::class, 'index'])->name('products');
	Route::post('/produk/create', [ProdukController::class, 'store']);
	Route::put('/produk/{id}/update', [ProdukController::class, 'edit']);
	Route::delete('/produk/{id}/delete', [ProdukController::class, 'destroy']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::group(['middleware' => ['auth','cekLevel:penjual,admin,superadmin']], function () {
	Route::get('/produk', [ProdukController::class, 'index'])->name('products');
	Route::get('/produks', [ProdukController::class, 'indexAdmin'])->name('produks');
	Route::post('/produk/create', [ProdukController::class, 'store']);
	Route::put('/produk/{id}/update', [ProdukController::class, 'edit']);
	Route::delete('/produk/{id}/delete', [ProdukController::class, 'destroy']);
	Route::delete('/produks/{id}/delete', [ProdukController::class, 'destroyAdmin']);
	Route::get('/deleteimage/{id}', [ProdukController::class, 'deleteimage']);
	Route::get('/pesanan', 'App\Http\Controllers\OrderController@index')->name('orders');
	Route::get('/order', 'App\Http\Controllers\OrderController@indexAdmin')->name('pesanan');
	Route::post('/pesanan/{id}/update', 'App\Http\Controllers\OrderController@update');
	Route::get('/laporan', 'App\Http\Controllers\ReportController@index')->name('reports');
	Route::get('/ulasan', 'App\Http\Controllers\FeedbackController@index')->name('feedbacks');
    Route::get('/umpanbalik', 'App\Http\Controllers\FeedbackController@indexAdmin')->name('umpanbalik');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
});
