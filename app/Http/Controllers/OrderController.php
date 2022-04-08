<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Produk;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search')){
            $data_order=Order::where('status_order','LIKE','%'.$request->search.'%')->paginate(5);
        }else{
            $data_order=Order::all();
        }
        $data_product=Produk::all();
        return view('pages.orders', compact('data_order', 'data_product'));
    }

    public function indexAdmin(Request $request)
    {
        if($request->has('search')){
            $data_order=Order::where('status_order','LIKE','%'.$request->search.'%')->paginate(5);
        }else{
            $data_order=Order::paginate(5);
        }
        return view('admin.pesanan', compact('data_order'));
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

        $data_order->status_order = $request->input('status_order');
        $data_order->update();
        return redirect('/pesanan');
    }
}
