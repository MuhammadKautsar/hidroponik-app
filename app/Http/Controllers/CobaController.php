<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CobaController extends Controller
{
    public function index()
    {
        return view('images.coba');
    }

    public function storeData(Request $request)
	{
		try {
			$produk = new Produk;
            $produk->penjual_id = Auth::user()->id;
            $produk->nama = $request->nama;
            $produk->promo_id = null;
            $produk->harga = $request->harga;
            $produk->stok = $request->stok;
            $produk->keterangan = $request->keterangan;
            $produk->total_feedback = 0;
            $produk->harga_promo = null;
            $produk->save();
            $produk_id = $produk->id; // this give us the last inserted record id
		}
		catch (\Exception $e) {
			return response()->json(['status'=>'exception', 'msg'=>$e->getMessage()]);
		}
		return response()->json(['status'=>"success", 'produk_id'=>$produk_id]);
	}

    public function storeImage(Request $request)
	{
		if($request->file('file')){

            $img = $request->file('file');

            //here we are geeting produkid alogn with an image
            $produkid = $request->produkid;

            // $produk = new Produk;

            $imageName = strtotime(now()).rand(11111,99999).'.'.$img->getClientOriginalExtension();
            $produk_image = new Image;
            $produk_image->produk_id = $produkid;
            $original_name = $img->getClientOriginalName();
            $produk_image->path_image = $imageName;

            if(!is_dir(public_path() . '/uploads/images/')){
                mkdir(public_path() . '/uploads/images/', 0777, true);
            }

        $request->file('file')->move(public_path() . '/uploads/images/', $imageName);

        // we are updating our image column with the help of produk id
        // $produk_image->where('id', $produkid)->update(['path_image'=>$imageName]);

        return response()->json(['status'=>"success",'imgdata'=>$original_name,'produkid'=>$produkid]);
        }
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
