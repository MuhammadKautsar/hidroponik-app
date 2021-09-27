<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;
use File;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search')){
            $promo=Promo::where('nama','LIKE','%'.$request->search.'%')->paginate(4);
        }else{
            $promo=Promo::paginate(4);
        }
        return view('pages.promos', compact('promo'));
    }

    public function create(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'potongan' => 'required|numeric',
            'awal_periode' => 'required',
            'akhir_periode' => 'required',
        ]);

        $promo = new Promo;
        if($request->hasfile('gambar'))
        {
            $file = $request->file('gambar');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/promos/', $filename);
            $promo->gambar = $filename;
        }
        $promo->nama = $request->input('nama');
        $promo->potongan = $request->input('potongan');
        $promo->awal_periode = $request->input('awal_periode');
        $promo->akhir_periode = $request->input('akhir_periode');
        $promo->keterangan = $request->input('keterangan');
        $promo->save();
        return redirect('admin/promo')->with('sukses','Data berhasil diinput');
    }

    public function update(Request $request, $id)
    {
        $promo = Promo::find($id);
        if($request->hasfile('gambar'))
        {
            $destination = 'uploads/promos/'.$promo->gambar;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $file = $request->file('gambar');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/promos/', $filename);
            $promo->gambar = $filename;
        }
        $promo->nama = $request->input('nama');
        $promo->potongan = $request->input('potongan');
        $promo->awal_periode = $request->input('awal_periode');
        $promo->akhir_periode = $request->input('akhir_periode');
        $promo->keterangan = $request->input('keterangan');
        $promo->update();
        return redirect('admin/promo')->with('sukses','Data berhasil diupdate');
    }

    public function hapus($id)
    {
        $promo = Promo::find($id);
        $destination = 'uploads/promos/'.$promo->gambar;
        if(File::exists($destination))
        {
            File::delete($destination);
        }
        $promo->delete($promo);
        return redirect('admin/promo')->with('sukses','Data berhasil dihapus');
    }
}
