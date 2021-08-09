<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasarMurahController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin;

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

Route::get('/pasar_murah', [PasarMurahController::class, 'index'])->name('pasar_murah');
Route::post('/pasar_murah/create', [PasarMurahController::class, 'create']);
Route::post('/pasar_murah/{id}/update', 'App\Http\Controllers\PasarMurahController@update');
Route::get('/pasar_murah/{id}/delete', [PasarMurahController::class, 'destroy']);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/dashboard', 'App\Http\Controllers\HomeController@penjual')->name('dashboard');

Route::get('/welcome', [PenjualController::class, 'welcome']);
Route::get('/daftar', [PenjualController::class, 'register']);
Route::get('/masuk', [PenjualController::class, 'login']);

Route::group(['middleware' => ['auth','cekLevel:admin']], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	 Route::get('pembeli', [UserController::class, 'pembeli'])->name('buyers');
	 Route::get('penjual', [UserController::class, 'penjual'])->name('sellers');
	 Route::post('/penjual/create', 'App\Http\Controllers\UserController@create');
	 Route::get('penjual/{id}/delete', [UserController::class, 'destroy']);
	 Route::get('/promo', 'App\Http\Controllers\PromoController@index')->name('promos');
	 Route::post('/promo/create', 'App\Http\Controllers\PromoController@create');
	 Route::post('/promo/{id}/update', 'App\Http\Controllers\PromoController@update');
	 Route::get('/promo/{id}/delete', 'App\Http\Controllers\PromoController@hapus');
	 Route::get('/laporan', 'App\Http\Controllers\ReportController@index')->name('reports');
	 Route::get('/laporan/{id}/delete', [ReportController::class, 'destroy']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::group(['middleware' => ['auth','cekLevel:admin,user']], function () {
	Route::get('/produk', [ProdukController::class, 'index'])->name('products');
	Route::post('/produk/create', [ProdukController::class, 'store']);
	Route::put('/produk/{id}/update', [ProdukController::class, 'edit']);
	Route::delete('/produk/{id}/delete', [ProdukController::class, 'destroy']);
	Route::delete('/deleteimage/{id}', [ProdukController::class, 'deleteimage']);
	Route::delete('/deletecover/{id}', [ProdukController::class, 'deletecover']);
	Route::get('/pesanan', 'App\Http\Controllers\OrderController@index')->name('orders');
	Route::post('/pesanan/{id}/update', 'App\Http\Controllers\OrderController@update');
	Route::get('/laporan', 'App\Http\Controllers\ReportController@index')->name('reports');
	Route::get('/ulasan', 'App\Http\Controllers\FeedbackController@index')->name('feedbacks');
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
});

// Route::group(['middleware' => ['auth','cekLevel:user']], function () {
// 	Auth::routes();
// 	Route::get('/dashboard', 'App\Http\Controllers\HomeController@penjual')->name('dashboard');
// });

Route::get('/post', [PostController::class, 'index']);
Route::post('/post/create', [PostController::class, 'store']);
Route::delete('/delete/{id}', [PostController::class, 'destroy']);
Route::get('/edit/{id}', [PostController::class, 'edit']);

Route::delete('/deleteimage/{id}', [PostController::class, 'deleteimage']);
Route::delete('/deletecover/{id}', [PostController::class, 'deletecover']);

Route::put('/update/{id}', [PostController::class, 'update']);

Route::prefix('admin')->group(function(){
	Route::get('/', function () {
		return view('back.welcome');
	});
	// Route::get('/register', function () {
	// 	return view('back.auth.register');
	// });
	Route::get('/login', [Admin\Auth\LoginController::class, 'loginForm'])->name('admin.login');
	Route::post('/login', [Admin\Auth\LoginController::class, 'login'])->name('admin.login');
	Route::get('/home', [Admin\HomeController::class, 'index'])->name('admin.home');
	Route::get('/logout', [Admin\Auth\LoginController::class, 'logout'])->name('admin.logout');
	Route::get('/produk', [ProdukController::class, 'indexAdmin'])->name('admin.products');
});