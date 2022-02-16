<?php

namespace App\Http\Controllers;
use App\Models\Produk;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Report;
use App\Models\User;
use App\Models\Feedback;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $jumlah_produk = Produk::all()->count();
        $jumlah_pesanan = Order::all()->where('status_checkout', 'Beli')->count();
        $jumlah_promo = Promo::all()->count();
        $jumlah_laporan = Report::all()->count();
        $jumlah_user = User::all()->count();
        $jumlah_ulasan = Feedback::all()->count();

        $orders = DB::table('produks')
            ->where('penjual_id', '=', Auth::user()->id)
            ->where('produks.deleted_at', '=', null)
            ->join('order_mappings', 'order_mappings.produk_id', '=', 'produks.id')
            ->where('order_mappings.status_checkout', 'Beli')
            ->where('order_mappings.deleted_at', '=', null)->get();

        $belum = $orders->where('status_order', 'Belum')->count();
        $diproses = $orders->where('status_order', 'Diproses')->count();
        $dikirim = $orders->where('status_order', 'Dikirim')->count();
        $selesai = $orders->where('status_order', 'Selesai')->count();
        $batal = $orders->where('status_order', 'Batal')->count();

        $feedbacks = DB::table('produks')
            ->where('penjual_id', '=', Auth::user()->id)
            ->where('produks.deleted_at', '=', null)
            ->join('feedbacks', 'feedbacks.produk_id', '=', 'produks.id')
            ->where('feedbacks.deleted_at', '=', null)->get();


        $ulasan = $feedbacks->count();

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
}
