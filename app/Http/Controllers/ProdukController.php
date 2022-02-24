<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Image;
use App\Models\Promo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{

    public function index(Request $request)
    {
        if($request->has('search')){
            $data_product=Produk::where('nama','LIKE','%'.$request->search.'%')->paginate(4);
        }else{
            $data_product=Produk::paginate(4);
        }
        $images = Image::all();
        $promo = Promo::all();
        return view('pages.products', compact('data_product', 'promo'));
    }

    public function indexAdmin(Request $request)
    {
        if($request->has('search')){
            $data_product=Produk::where('nama','LIKE','%'.$request->search.'%')->paginate(4);
        }else{
            $data_product=Produk::paginate(4);
        }
        $images = Image::all();
        return view('admin.produk', compact('data_product'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'nama' => 'required|min:3|max:20',
            'harga' => 'required|numeric|digits_between:1,6',
            'stok' => 'required|numeric',
            'jumlah_per_satuan' => 'numeric',
            'gambar' => 'required|max:5000'
        ]);

        $produk = new Produk([
            'penjual_id' => Auth::user()->id,
            'nama' => $request->nama,
            'promo_id' => $request->promo_id,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'keterangan' => $request->keterangan,
            'satuan' => $request->satuan,
            'jumlah_per_satuan' => $request->jumlah_per_satuan,
            'total_feedback' => 0,
        ]);

        if ($request->promo_id!=""){
            $produk['harga_promo'] = $request->harga-$request->harga*$produk->promo->potongan/100;
        } elseif ($request->promo_id="") {
            $produk['harga_promo'] = "";
        }

        $produk->save();

        if($request->hasFile('gambar')){
            $files=$request->file('gambar');
            foreach($files as $file){
                $imageName=time().'_'.$file->getClientOriginalName();
                $request['produk_id']=$produk->id;
                $request['path_image']=$imageName;
                $file->move($this->path_file('/uploads'),$imageName);
                Image::create([
                    'produk_id' => $produk->id,
                    'path_image' => asset('uploads/' . $imageName),
                ]);
            }
        }
        return redirect('/produk')->with('sukses','Data berhasil diinput');
    }

    public function edit($id)
    {
        $data_product = Produk::findOrFail($id);
        $promo = Promo::all();
        return view('pages.edit', compact('data_product','promo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|min:3',
            'harga' => 'required|numeric|digits_between:1,6',
            'stok' => 'required|numeric',
            'jumlah_per_satuan' => 'numeric',
            // 'gambar' => 'required|max:5000'
        ]);

        $produk = Produk::findOrFail($id);

        $produk->update([
            "nama" => $request->nama,
            'promo_id' => $request->promo_id,
            "harga" => $request->harga,
            "stok" => $request->stok,
            "satuan" => $request->satuan,
            "jumlah_per_satuan" => $request->jumlah_per_satuan,
            "harga_promo" => $request->harga_promo,
            "keterangan" => $request->keterangan,
            // "gambar" => asset('/gambar' . $produk->gambar),
        ]);

        if ($request->promo_id!=""){
            $produk['harga_promo'] = $request->harga-$request->harga*$produk->promo->potongan/100;
        } elseif ($request->promo_id="") {
            $produk['harga_promo'] = "";
        }

        $produk->save();

        if ($request->hasFile("gambar")) {
            $files = $request->file("gambar");
            foreach ($files as $file) {
                $imageName = time() . "_" . $file->getClientOriginalName();
                $request["produk_id"] = $id;
                $request["path_image"] = asset('uploads/' . $imageName);
                $file->move($this->path_file("/uploads"), $imageName);
                Image::create($request->all());
            }
        }
        return redirect('/produk')->with('sukses', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->orders->count() == 0) {
            $produk->delete();
            return redirect('/produk')->with('sukses', 'Produk berhasil dihapus');
        }

        if ($produk->orders()->whereIn('status_order', ['Belum', 'Diproses', 'Dikirim'])->first()) {
            return redirect('/produk')->with('error', 'Produk tidak berhasil dihapus karena sedang ada order yang diproses');
        } else {
            $produk->delete();
            return redirect('/produk')->with('sukses', 'Produk berhasil dihapus');
        }
    }

    public function destroyAdmin($id)
    {
        $produk = Produk::findOrFail($id);

        if ($produk->orders->count() == 0) {
            $produk->delete();
            return redirect('admin/produk')->with('sukses', 'Produk berhasil dihapus');
        }

        if ($produk->orders()->whereIn('status_order', ['Belum', 'Diproses', 'Dikirim'])->first()) {
            return redirect('admin/produk')->with('error', 'Produk tidak berhasil dihapus karena sedang ada order yang diproses');
        } else {
            $produk->delete();
            return redirect('admin/produk')->with('sukses', 'Produk berhasil dihapus');
        }
    }

    public function deleteimage($id)
    {
        $images=Image::findOrFail($id);
        if(File::exists("/uploads/".$images->path_image)) {
            File::delete("/uploads/".$images->path_image);
        }

        Image::find($id)->delete();
        return back();
    }

    private function path_file($value)
    {
        return public_path($value);
    }
}
