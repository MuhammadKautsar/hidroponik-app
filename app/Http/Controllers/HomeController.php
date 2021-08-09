<?php

namespace App\Http\Controllers;
use App\Models\Produk;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Report;
use App\Models\User;
use App\Models\Feedback;

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
        $jumlah_ulasan = Feedback::all()->count();

        $belum = Order::where('status_order', 'Belum')->count();
        $diproses = Order::where('status_order', 'Diproses')->count();
        $dikirim = Order::where('status_order', 'Dikirim')->count();
        $selesai = Order::where('status_order', 'Selesai')->count();
        $batal = Order::where('status_order', 'Batal')->count();
        $ulasan = Feedback::all()->count();

        return view('dashboard', compact(
            'jumlah_produk', 
            'jumlah_pesanan', 
            'jumlah_promo', 
            'jumlah_laporan', 
            'jumlah_user',
            'jumlah_ulasan',  
            'belum',
            'diproses',
            'dikirim',
            'selesai',
            'batal',
            'ulasan',
        ));
    }

    public function penjual()
    {
        return view('penjual.dashboard');
    }
}