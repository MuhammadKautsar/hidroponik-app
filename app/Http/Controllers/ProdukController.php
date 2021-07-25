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


    // public function create(Request $request)
    // {
    //     $this->validate($request, [
    //         'gambar' => 'required',
    //         'nama' => 'required|string',
    //         'harga' => 'required|numeric',
    //         'stok' => 'required|numeric',
    //     ]);

    //     $gambar = $request->file('gambar')->getClientOriginalName();
    //     $request->file('gambar')->move('uploads', $gambar);

    //     $data = [
    //         'gambar' => $gambar,
    //         'nama' => $request->input('nama'),
    //         'harga' => $request->input('harga'),
    //         'stok' => $request->input('stok')
    //     ];

    //     $produk = Produk::create($data);

    //     return response()->json($data);
    // }

    public function create(Request $request)
    {
        $produk = new Produk;
        if($request->hasfile('gambar'))
        {
            $file = $request->file('gambar');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/', $filename);
            $produk->gambar = $filename;
        }
        $produk->nama = $request->input('nama');
        $produk->harga = $request->input('harga');
        $produk->stok = $request->input('stok');
        $produk->save();
        return response()->json($produk);
    }

    public function store(Request $request)
    {
        $produk = new Produk;
        if($request->hasfile('gambar'))
        {
            $file = $request->file('gambar');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/', $filename);
            $produk->gambar = $filename;
        }
        $produk->nama = $request->input('nama');
        $produk->harga = $request->input('harga');
        $produk->stok = $request->input('stok');
        $produk->save();
        return redirect('/produk')->with('sukses','Data berhasil diinput');
    }


    public function show(Produk $produk)
    {
        $data = Produk::all();

        return response()->json($data);
    }


    public function edit(Request $request, $id)
    {
        $produk = Produk::where('idproduk',$id);
        if($request->hasfile('gambar'))
        {
            $destination = 'uploads/'.$produk->gambar;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $file = $request->file('gambar');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/', $filename);
            $produk->gambar = $filename;
        }
        $produk->nama = $request->input('nama');
        $produk->harga = $request->input('harga');
        $produk->stok = $request->input('stok');
        $produk->update(['idproduk','gambar','nama','harga','stok']);
        return redirect('/produk')->with('sukses','Data berhasil diupdate');
    }

    
    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);

        if($request->hasfile('gambar'))
        {
            $destination = 'uploads/'.$produk->gambar;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $file = $request->file('gambar');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/', $filename);
            $produk->gambar = $filename;
        }

        $produk->nama = $request->input('nama');
        $produk->harga = $request->input('harga');
        $produk->stok = $request->input('stok');

        $produk->nama = $request->nama ? $request->nama : $produk->nama;
        $produk->harga = $request->harga ? $request->harga : $produk->harga;
        $produk->stok = $request->stok ? $request->stok :$produk->stok;

        $produk->update();
        return response()->json($produk);
        // return response()->json(
        //     [
        //         "message" => "PUT Method Succsess ",
        //         "data" => $produk
        //     ]
        // );
    }

    function put($id, Request $request)
    {
        $produk = Produk::where('id', $id)->first();
        if($produk){
            if($request->hasfile('gambar'))
                {
                    $destination = 'uploads/'.$produk->gambar;
                    if(File::exists($destination))
                    {
                        File::delete($destination);
                    }
                    $file = $request->file('gambar');
                    $extention = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extention;
                    $file->move('uploads/', $filename);
                    $produk->gambar = $filename;
                }
            $produk->nama = $request->nama ? $request->nama : $produk->nama;
            $produk->harga = $request->harga ? $request->harga : $produk->harga;
            $produk->stok = $request->stok ? $request->stok :$produk->stok;

            $produk->save();
            return response()->json(
                [
                    "message" => "PUT Method Succsess ",
                    "data" => $produk
                ]
            );
        }
        return response()->json(
            [
                "message" => "promo with id " . $id . " not found"
            ], 400
        );
    }


    public function destroy($idproduk)
    {
        $produk = Produk::where('idproduk',$idproduk);

        $produk->delete();
        return redirect('/produk')->with('sukses','Data berhasil dihapus');
    }

    // function put($idproduk, Request $request)
    // {
    //     $product = Produk::where('idproduk', $idproduk);
    //     if($product){
    //         //$product->gambar = $request->gambar ? $request->gambar : $product->gambar;
    //         $product->nama = $request->nama ? $request->nama : $product->nama;
    //         $product->harga = $request->harga ? $request->harga :$product->harga;
    //         $product->stok = $request->stok ? $request->stok :$product->stok;

    //         $product->save();
    //         return response()->json(
    //             [
    //                 "message" => "PUT Method Succsess ",
    //                 "data" => $product
    //             ]
    //         );
    //     }
    //     return response()->json(
    //         [
    //             "message" => "Product with idproduk " . $idproduk . " not found"
    //         ], 400
    //     );
    // }

    function delete($idproduk)
    {
        $product = Produk::where('idproduk', $idproduk);
        if($product) {
            $product->delete();
            return response()->json(
                [
                    "message" => "DELETE Product idproduk " . $idproduk . " Success"
                ]
            );
        }
        return response()->json(
            [
                "message" => "Product with idproduk " . $idproduk . " not found"
            ], 400
        );
    }
}
