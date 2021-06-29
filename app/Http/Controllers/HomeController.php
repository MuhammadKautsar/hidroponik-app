<?php

namespace App\Http\Controllers;
use App\Models\Produk;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Report;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $jumlah_produk = Produk::all()->count();
        $jumlah_pesanan = Order::all()->count();
        $jumlah_promo = Promo::all()->count();
        $jumlah_laporan = Report::all()->count();
        $jumlah_user = User::all()->count();
        return view('dashboard', compact('jumlah_produk', 'jumlah_pesanan', 'jumlah_promo', 'jumlah_laporan', 'jumlah_user'));
    }
}
