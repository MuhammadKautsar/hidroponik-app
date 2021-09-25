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
        $data_order = Order::find($id);
        $data_order->harga_jasa_pengiriman = $request->input('harga_jasa_pengiriman');
        $data_order->status_order = $request->input('status_order');
        $data_order->update();
        return redirect('/pesanan');
    }
}
