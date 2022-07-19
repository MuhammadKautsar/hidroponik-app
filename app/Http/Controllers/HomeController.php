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
        $jumlah_pesanan = Order::all()->count();
        $jumlah_promo = Promo::all()->count();
        $jumlah_laporan = Report::all()->count();
        $jumlah_user = User::all()->count();
        $jumlah_ulasan = Feedback::all()->count();

        $admin = User::all()->where('level', 'admin')->count();
        $penjual = User::all()->where('level', 'penjual')->count();
        $pembeli = User::all()->where('level', 'pembeli')->count();

        $belum = Order::all()->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Belum')->count();
        $diproses = Order::all()->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Diproses')->count();
        $dikirim = Order::all()->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Dikirim')->count();
        $selesai = Order::all()->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Selesai')->count();
        $batal = Order::all()->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Batal')->count();

        $feedbacks = DB::table('produks')
            ->where('penjual_id', '=', Auth::user()->id)
            ->where('produks.deleted_at', '=', null)
            ->join('feedbacks', 'feedbacks.produk_id', '=', 'produks.id')
            ->where('feedbacks.deleted_at', '=', null)->get();

        $ulasan = $feedbacks->count();

        $ordersel_feb  = Order::whereMonth('created_at', '02')->where('status_order', 'Selesai')->count();
        $ordersel_mar  = Order::whereMonth('created_at', '03')->where('status_order', 'Selesai')->count();
        $ordersel_apr  = Order::whereMonth('created_at', '04')->where('status_order', 'Selesai')->count();
        $ordersel_mei  = Order::whereMonth('created_at', '05')->where('status_order', 'Selesai')->count();
        $ordersel_jun  = Order::whereMonth('created_at', '06')->where('status_order', 'Selesai')->count();
        $ordersel_jul  = Order::whereMonth('created_at', '07')->where('status_order', 'Selesai')->count();

        $orderbat_feb  = Order::whereMonth('created_at', '02')->where('status_order', 'Batal')->count();
        $orderbat_mar  = Order::whereMonth('created_at', '03')->where('status_order', 'Batal')->count();
        $orderbat_apr  = Order::whereMonth('created_at', '04')->where('status_order', 'Batal')->count();
        $orderbat_mei  = Order::whereMonth('created_at', '05')->where('status_order', 'Batal')->count();
        $orderbat_jun  = Order::whereMonth('created_at', '06')->where('status_order', 'Batal')->count();
        $orderbat_jul  = Order::whereMonth('created_at', '07')->where('status_order', 'Batal')->count();

        $produk_feb  = Produk::whereMonth('created_at', '02')->count();
        $produk_mar  = Produk::whereMonth('created_at', '03')->count();
        $produk_apr  = Produk::whereMonth('created_at', '04')->count();
        $produk_mei  = Produk::whereMonth('created_at', '05')->count();
        $produk_jun  = Produk::whereMonth('created_at', '06')->count();
        $produk_jul  = Produk::whereMonth('created_at', '07')->count();

        $pendapatan_feb  = Order::whereMonth('created_at', '02')->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Selesai')->sum('total_harga');
        $pendapatan_mar  = Order::whereMonth('created_at', '03')->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Selesai')->sum('total_harga');
        $pendapatan_apr  = Order::whereMonth('created_at', '04')->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Selesai')->sum('total_harga');
        $pendapatan_mei  = Order::whereMonth('created_at', '05')->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Selesai')->sum('total_harga');
        $pendapatan_jun  = Order::whereMonth('created_at', '06')->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Selesai')->sum('total_harga');
        $pendapatan_jul  = Order::whereMonth('created_at', '07')->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Selesai')->sum('total_harga');

        $orderselpen_feb  = Order::whereMonth('created_at', '02')->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Selesai')->count();
        $orderselpen_mar  = Order::whereMonth('created_at', '03')->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Selesai')->count();
        $orderselpen_apr  = Order::whereMonth('created_at', '04')->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Selesai')->count();
        $orderselpen_mei  = Order::whereMonth('created_at', '05')->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Selesai')->count();
        $orderselpen_jun  = Order::whereMonth('created_at', '06')->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Selesai')->count();
        $orderselpen_jul  = Order::whereMonth('created_at', '07')->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Selesai')->count();

        $orderbatpen_feb  = Order::whereMonth('created_at', '02')->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Batal')->count();
        $orderbatpen_mar  = Order::whereMonth('created_at', '03')->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Batal')->count();
        $orderbatpen_apr  = Order::whereMonth('created_at', '04')->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Batal')->count();
        $orderbatpen_mei  = Order::whereMonth('created_at', '05')->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Batal')->count();
        $orderbatpen_jun  = Order::whereMonth('created_at', '06')->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Batal')->count();
        $orderbatpen_jul  = Order::whereMonth('created_at', '07')->where('penjual_id', '=', Auth::user()->id)->where('status_order', 'Batal')->count();

        return view('dashboard', compact(
            'jumlah_produk', 'jumlah_pesanan', 'jumlah_promo', 'jumlah_laporan', 'jumlah_user', 'jumlah_ulasan',

            'belum', 'diproses', 'dikirim', 'selesai', 'batal', 'ulasan',

            'admin', 'penjual', 'pembeli',

            'ordersel_feb', 'ordersel_mar', 'ordersel_apr', 'ordersel_mei', 'ordersel_jun', 'ordersel_jul',

            'orderbat_feb', 'orderbat_mar', 'orderbat_apr', 'orderbat_mei', 'orderbat_jun', 'orderbat_jul',

            'produk_feb', 'produk_mar', 'produk_apr', 'produk_mei', 'produk_jun', 'produk_jul',

            'pendapatan_feb', 'pendapatan_mar', 'pendapatan_apr', 'pendapatan_mei', 'pendapatan_jun', 'pendapatan_jul',

            'orderselpen_feb', 'orderselpen_mar', 'orderselpen_apr', 'orderselpen_mei', 'orderselpen_jun', 'orderselpen_jul',

            'orderbatpen_feb', 'orderbatpen_mar', 'orderbatpen_apr', 'orderbatpen_mei', 'orderbatpen_jun', 'orderbatpen_jul',
        ));
    }
}
