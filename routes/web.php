<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => ['auth','cekLevel:admin,superadmin']], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	 Route::get('pengguna', [UserController::class, 'pengguna'])->name('users');
	 Route::post('/pengguna/create', 'App\Http\Controllers\UserController@create');
	 Route::get('pengguna/{id}/delete', [UserController::class, 'destroy']);
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

	Route::get('/dashboard', function () {
        $data_product = Produk::with('penjual')->get();
        return view('penjual.dashboard', ['data_product' => $data_product]);
    })->name('dashboard');

	Route::get('/order', function () {
		$data_product = Produk::with('penjual')->get();
        $data_order = Order::with('produk')->get();
        return view('penjual.orders', compact('data_product', 'data_order'));
    })->name('order');

	Route::get('/produk', [ProdukController::class, 'index'])->name('products');
	Route::get('/produks', [ProdukController::class, 'indexAdmin'])->name('produks');
	Route::post('/produk/create', [ProdukController::class, 'store']);
	Route::put('/produk/{id}/update', [ProdukController::class, 'edit']);
	Route::delete('/produk/{id}/delete', [ProdukController::class, 'destroy']);
	Route::delete('/produks/{id}/delete', [ProdukController::class, 'destroyAdmin']);
	Route::delete('/deleteimage/{id}', [ProdukController::class, 'deleteimage']);
	Route::delete('/deletecover/{id}', [ProdukController::class, 'deletecover']);
	Route::get('/pesanan', 'App\Http\Controllers\OrderController@index')->name('orders');
	Route::get('/order', 'App\Http\Controllers\OrderController@indexAdmin')->name('pesanan');
	Route::post('/pesanan/{id}/update', 'App\Http\Controllers\OrderController@update');
	Route::get('/laporan', 'App\Http\Controllers\ReportController@index')->name('reports');
	Route::get('/ulasan', 'App\Http\Controllers\FeedbackController@index')->name('feedbacks');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
});
