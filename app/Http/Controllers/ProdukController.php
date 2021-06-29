<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{

    public function index()
    {
        $data_product=Produk::all();
        return view('pages.products', compact('data_product'));
    }


    public function create(Request $request)
    {
        $this->validate($request, [
            'gambar' => 'required',
            'nama' => 'required|string',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
        ]);

        $gambar = $request->file('gambar')->getClientOriginalName();
        $request->file('gambar')->move('uploads', $gambar);

        $data = [
            'gambar' => url('uploads/'.$gambar),
            'nama' => $request->input('nama'),
            'harga' => $request->input('harga'),
            'stok' => $request->input('stok')
        ];

        $produk = Produk::create($data);

        return response()->json($data);
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Produk $produk)
    {
        $data = Produk::all();

        return response()->json($data);
    }


    public function edit(Produk $produk)
    {
        //
    }


    public function update(Request $request, Produk $produk)
    {
        //
    }


    public function destroy(Produk $produk)
    {
        //
    }
}
