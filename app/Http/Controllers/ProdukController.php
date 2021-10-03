<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Image;
use App\Models\Promo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Validator;
use Auth;

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
            'nama' => 'required|min:3',
            'harga' => 'required|numeric|digits_between:1,6',
            'stok' => 'required|numeric',
            // 'promo_id' => 'required',
            'gambar' => 'required|max:5000'
        ]);

        $produk = new Produk([
            'penjual_id' => Auth::user()->id,
            'nama' => $request->nama,
            'promo_id' => $request->promo_id,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'keterangan' => $request->keterangan,
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
                $file->move($this->path_file('/gambar'),$imageName);
                Image::create([
                    'produk_id' => $produk->id,
                    'path_image' => asset('gambar/' . $imageName),
                ]);
            }
        }
        return redirect('/produk')->with('sukses','Data berhasil diinput');
    }

    public function edit(Request $request, $id)
    {
        // $request->validate([
        //     'nama' => 'required|min:3',
        //     'harga' => 'required|numeric|digits_between:1,6',
        //     'stok' => 'required|numeric',
        //     // 'promo_id' => 'required',
        //     'gambar' => 'required|max:5000'
        // ]);

        $produk = Produk::findOrFail($id);
        if ($request->hasFile("gambar")) {
            if (File::exists($this->path_file("/gambar/" . $produk->gambar))) {
                File::delete($this->path_file("/gambar/" . $produk->gambar));
            }
            $file = $request->file("gambar");
            $produk->gambar = time() . "_" . $file->getClientOriginalName();
            $file->move($this->path_file("/gambar"), $produk->gambar);
            $request['gambar'] = asset('/gambar' . $produk->gambar);
        }

        $produk->update([
            "nama" => $request->nama,
            'promo_id' => $request->promo_id,
            "harga" => $request->harga,
            "stok" => $request->stok,
            "harga_promo" => $request->harga_promo,
            "keterangan" => $request->keterangan,
            "gambar" => asset('/gambar' . $produk->gambar),
        ]);

        if ($request->promo_id!=""){
            $produk['harga_promo'] = $request->harga-$request->harga*$produk->promo->potongan/100;
        } elseif ($request->promo_id="") {
            $produk['harga_promo'] = "";
        }

        $produk->save();

        if ($request->hasFile("images")) {
            $files = $request->file("images");
            foreach ($files as $file) {
                $imageName = time() . "_" . $file->getClientOriginalName();
                $request["produk_id"] = $id;
                $request["path_image"] = asset('images/' . $imageName);
                $file->move($this->path_file("/images"), $imageName);
                Image::create($request->all());
            }
        }
        return redirect('/produk')->with('sukses', 'Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $produks = Produk::findOrFail($id);

        if (File::exists($this->path_file("/gambar/" . $produks->gambar))) {
            File::delete($this->path_file("/gambar/" . $produks->gambar));
        }
        $images = Image::where("produk_id", $produks->id)->get();
        foreach ($images as $image) {
            if (File::exists($this->path_file("/images/" . $image->image))) {
                File::delete($this->path_file("/images/" . $image->image));
            }
        }
        $produks->delete();
        return redirect('/produk')->with('sukses', 'Data berhasil dihapus');
    }

    public function destroyAdmin($id)
    {
        $produks = Produk::findOrFail($id);

        if (File::exists($this->path_file("/gambar/" . $produks->gambar))) {
            File::delete($this->path_file("/gambar/" . $produks->gambar));
        }
        $images = Image::where("produk_id", $produks->id)->get();
        foreach ($images as $image) {
            if (File::exists($this->path_file("/images/" . $image->image))) {
                File::delete($this->path_file("/images/" . $image->image));
            }
        }
        $produks->delete();
        return redirect('admin/produk')->with('sukses', 'Data berhasil dihapus');
    }

    public function deleteimage($id)
    {
        $images=Image::findOrFail($id);
        if(File::exists($this->path_file("/gambar/".$images->image))) {
            File::delete($this->path_file("/gambar/".$images->image));
        }

        Image::find($id)->delete();
        return back();
    }

    private function path_file($value)
    {
        return public_path($value);
    }
}
