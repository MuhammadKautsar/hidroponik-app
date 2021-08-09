<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Auth;

class ProdukController extends Controller
{

    public function index()
    {
        $data_product=Produk::all();
        $images = Image::all();
        return view('pages.products', compact('data_product'));
    }

    public function indexAdmin()
    {
        $data_product=Produk::all();
        return view('back.products', compact('data_product'));
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
        if($request->hasFile('gambar')){
            $file=$request->file('gambar');
            $imageName=time().'_'.$file->getClientOriginalName();
            $file->move(\public_path('gambar/'),$imageName);

            $produk = new Produk([
                'penjual_id' => Auth::user()->id,
                'nama' => $request->nama,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'gambar' => $imageName,
            ]);
            $produk->save();
        }

        if($request->hasFile('images')){
            $files=$request->file('images');
            foreach($files as $file){
                $imageName=time().'_'.$file->getClientOriginalName();
                $request['produk_id']=$produk->id;
                $request['path_image']=$imageName;
                $file->move(\public_path('/images'),$imageName);
                Image::create($request->all());
            }
        }
        return redirect('/produk')->with('sukses','Data berhasil diinput');
    }


    public function show(Produk $produk)
    {
        $data = Produk::all();

        return response()->json($data);
    }


    public function edit(Request $request, $id)
    {
        $produk=Produk::findOrFail($id);
        if($request->hasFile("gambar")){
            if(File::exists("gambar/".$produk->gambar)){
                File::delete("gambar/".$produk->gambar);
            }
            $file=$request->file("gambar");
            $produk->gambar=time()."_".$file->getClientOriginalName();
            $file->move(\public_path("gambar"),$produk->gambar);
            $request['gambar']=$produk->gambar;
        }

        $produk->update([
            "nama" => $request->nama,
            "harga" => $request->harga,
            "stok" => $request->stok,
            "gambar" => $produk->gambar,
        ]);

        if($request->hasFile("images")){
            $files=$request->file("images");
            foreach($files as $file){
                $imageName=time()."_".$file->getClientOriginalName();
                $request["produk_id"]=$id;
                $request["image"]=$imageName;
                $file->move(\public_path("images"),$imageName);
                Image::create($request->all());
            }
        }
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


    public function destroy($id)
    {
        $produks=Produk::findOrFail($id);

        if(File::exists("gambar/".$produks->gambar)){
            File::delete("gambar/".$produks->gambar);
        }
        $images=Image::where("produk_id",$produks->id)->get();
        foreach($images as $image){
            if(File::exists("images/".$image->image)) {
                File::delete("images/".$image->image);
            }
        }
        $produks->delete();
        return redirect('/produk')->with('sukses','Data berhasil dihapus');
    }

    public function deleteimage($id)
    {
        $images=Image::findOrFail($id);
        if(File::exists("images/".$images->image)) {
            File::delete("images/".$images->image);
        }

        Image::find($id)->delete();
        return back();
    }

    public function deletecover($id)
    {
        $gambar=Produk::findOrFail($id)->gambar;
        if(File::exists("gambar/".$gambar)) {
            File::delete("gambar/".$gambar);
        }
        return back();
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
