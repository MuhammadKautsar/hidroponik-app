<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function index()
    {
        return view('images.upload');
    }

    public function post(Request $request)
    {
        // $image = new Image([
        //     'produk_id' => Auth::user()->id,
        //     'path_image' => $request->nama,
        // ]);

        $image_name = $request->image->getClientOriginalName();
        $request->image->move(public_path('new_images'),$image_name);
        Image::create([
            'produk_id' => 1,
            'path_image' => asset('/new_images/' . $image_name),
        ]);

        // $image->save();
        return response()->json(['uploaded'=>'/new_images/'.$image_name]);
    }

    // public function store(Request $request)
    // {

    //     $request->validate([
    //         'nama' => 'required|min:3|max:20',
    //         'harga' => 'required|numeric|digits_between:1,6',
    //         'stok' => 'required|numeric',
    //         // 'promo_id' => 'required',
    //         'gambar' => 'required|max:5000'
    //     ]);

    //     $produk = new Produk([
    //         'penjual_id' => Auth::user()->id,
    //         'nama' => $request->nama,
    //         'promo_id' => $request->promo_id,
    //         'harga' => $request->harga,
    //         'stok' => $request->stok,
    //         'keterangan' => $request->keterangan,
    //         'total_feedback' => 0,
    //     ]);

    //     if ($request->promo_id!=""){
    //         $produk['harga_promo'] = $request->harga-$request->harga*$produk->promo->potongan/100;
    //     } elseif ($request->promo_id="") {
    //         $produk['harga_promo'] = "";
    //     }

    //     $produk->save();

    //     if($request->hasFile('gambar')){
    //         $files=$request->file('gambar');
    //         foreach($files as $file){
    //             $imageName=time().'_'.$file->getClientOriginalName();
    //             $request['produk_id']=$produk->id;
    //             $request['path_image']=$imageName;
    //             $file->move($this->path_file('/uploads'),$imageName);
    //             Image::create([
    //                 'produk_id' => $produk->id,
    //                 'path_image' => asset('uploads/' . $imageName),
    //             ]);
    //         }
    //     }
    //     return redirect('/produk')->with('sukses','Data berhasil diinput');
    // }
}
