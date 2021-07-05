<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasarMurahController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;

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

Route::get('students', [StudentController::class, 'index']);
Route::get('add-student', [StudentController::class, 'create']);
Route::post('add-student', [StudentController::class, 'store']);
Route::get('edit-student/{id}', [StudentController::class, 'edit']);
Route::put('update-student/{id}', [StudentController::class, 'update']);

Route::delete('delete-student/{id}', [StudentController::class, 'destroy']);

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/dashboard', 'App\Http\Controllers\HomeController@penjual')->name('dashboard');

Route::group(['middleware' => ['auth','cekLevel:admin']], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	 Route::get('icons', function () {return view('pages.icons');})->name('icons'); 
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');
	 Route::get('pembeli', [UserController::class, 'pembeli'])->name('buyers');
	 Route::get('penjual', [UserController::class, 'penjual'])->name('sellers');
	 Route::get('/produk', [ProdukController::class, 'index'])->name('products');
	 Route::get('/pesanan', 'App\Http\Controllers\OrderController@index')->name('orders');
	 Route::get('/promo', 'App\Http\Controllers\PromoController@index')->name('promos');
	 Route::post('/promo/create', 'App\Http\Controllers\PromoController@create');
	 Route::post('/promo/{id}/update', 'App\Http\Controllers\PromoController@update');
	 Route::get('/promo/{id}/delete', 'App\Http\Controllers\PromoController@hapus');
	 Route::get('/laporan', 'App\Http\Controllers\ReportController@index')->name('reports');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Route::group(['middleware' => ['auth','cekLevel:admin,user']], function () {
	Route::get('/produk', [ProdukController::class, 'index'])->name('products');
});

