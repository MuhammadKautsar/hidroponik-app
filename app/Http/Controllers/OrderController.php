<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Produk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function cetakPesanan()
    {
        $data_order=Order::orderBy('created_at', 'desc')->get();
        view()->share('data_order', $data_order);
        $pdf = PDF::loadview('pdf.cetak-pesanan');
        return $pdf->stream('data-pesanan.pdf');
    }

    public function cetakPesananPenjual()
    {
        $data_order=Order::where('penjual_id', '=', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        view()->share('data_order', $data_order);
        $pdf = PDF::loadview('pdf.cetak-pesanan-penjual');
        return $pdf->stream('data-pesanan-penjual.pdf');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'harga_jasa_pengiriman' => 'required|numeric',
            'status_order' => 'required',
        ]);

        $data_order = Order::find($id);
        if($request->input('harga_jasa_pengiriman') > 10000){
            return back()->with('status', 'Harga ongkir melebihi batas maksimum');
        }
        elseif ($request->input('harga_jasa_pengiriman') < 0) {
            return back()->with('status', 'Harga ongkir tidak mencapai minimal');
        }
        elseif ($request->input('harga_jasa_pengiriman') == 0 && $request->input('status_order') != 'Batal') {
            return back()->with('status', 'Harga ongkir belum diisi');
        }
        else{
            $data_order->harga_jasa_pengiriman = $request->input('harga_jasa_pengiriman');
        }

        if ($request->input('status_order') == 'Batal') {
            // $request->validate([
            //     'alasan' => 'required',
            // ]);
            if ($request->input('alasan') == '') {
                return back()->with('status', 'Alasan batal belum diisi');
            }
            else{
                $data_order->alasan = $request->input('alasan');
            }
        }

        $data_order->status_order = $request->input('status_order');
        $data_order->update();
        return redirect('/pesanan');
    }
}
