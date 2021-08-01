<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    function post(Request $request)
    {
        $order = new order;
        $order->produk = $request->produk;
        $order->jumlah = $request->jumlah;
        $order->alamat = $request->alamat;
        $order->total = $request->total;
        $order->status = $request->status;

        $order->save();

        return response()->json(
            [
                "message" => "Succsess",
                "data" => $order
            ]
        );
    }

    function get()
    {
        $data = order::all();

        return response()->json(
            [
                "message" => "Succsess",
                "data" => $data
            ]
        );
    }

    function getById($id)
    {
        $data = order::where('id', $id)->get();

        return response()->json(
            [
                "message" => "Succsess",
                "data" => $data
            ]
        );
    }

    function put($id, Request $request)
    {
        $order = order::where('id', $id)->first();
        if($order){
            $order->produk = $request->produk ? $request->produk : $order->produk;
            $order->jumlah = $request->jumlah ? $request->jumlah : $order->jumlah;
            $order->alamat = $request->alamat ? $request->alamat :$order->alamat;
            $order->total = $request->total ? $request->total :$order->total;
            $order->status = $request->status ? $request->status :$order->status;

            $order->save();
            return response()->json(
                [
                    "message" => "PUT Method Succsess ",
                    "data" => $order
                ]
            );
        }
        return response()->json(
            [
                "message" => "order with id " . $id . " not found"
            ], 400
        );
    }

    function delete($id)
    {
        $order = order::where('id', $id)->first();
        if($order) {
            $order->delete();
            return response()->json(
                [
                    "message" => "DELETE order id " . $id . " Success"
                ]
            );
        }
        return response()->json(
            [
                "message" => "order with id " . $id . " not found"
            ], 400
        );
    }

    public function index()
    {
        $data_order=Order::all();
        return view('pages.orders', compact('data_order'));
    }

    public function update(Request $request, $id)
    {
        $data_order = Order::find($id);
        $data_order->status = $request->input('status');
        $data_order->update();
        return redirect('/pesanan');
    }
}
