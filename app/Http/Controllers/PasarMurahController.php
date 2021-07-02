<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasarMurah;
use Illuminate\Support\Facades\File;

class PasarMurahController extends Controller
{
    public function index()
    {
        $pasar_murah = PasarMurah::all();
        return view('pages.pasar_murah', compact('pasar_murah'));
    }

    public function create(Request $request)
    {
        $pasar_murah = new PasarMurah;
        if($request->hasfile('gambar'))
        {
            $file = $request->file('gambar');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/pasar_murahs/', $filename);
            $pasar_murah->gambar = $filename;
        }
        $pasar_murah->nama = $request->input('nama');
        $pasar_murah->lokasi = $request->input('lokasi');
        $pasar_murah->waktu = $request->input('waktu');
        $pasar_murah->keterangan = $request->input('keterangan');
        $pasar_murah->save();
        return redirect('/pasar_murah')->with('sukses','Data berhasil diinput');
    }

    public function update(Request $request, $id)
    {
        $pasar_murah = PasarMurah::find($id);
        if($request->hasfile('gambar'))
        {
            $destination = 'uploads/pasar_murahs/'.$pasar_murah->gambar;
            if(File::exists($destination))
            {
                File::delete($destination);
            }
            $file = $request->file('gambar');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/pasar_murahs/', $filename);
            $pasar_murah->gambar = $filename;
        }
        $pasar_murah->nama = $request->input('nama');
        $pasar_murah->lokasi = $request->input('lokasi');
        $pasar_murah->waktu = $request->input('waktu');
        $pasar_murah->keterangan = $request->input('keterangan');
        $pasar_murah->update();
        return redirect('/pasar_murah')->with('sukses','Data berhasil diupdate');
    }

    public function destroy($id)
    {
        $pasar_murah = PasarMurah::find($id);
        $destination = 'uploads/pasar_murahs/'.$pasar_murah->gambar;
        if(File::exists($destination))
        {
            File::delete($destination);
        }
        $pasar_murah->delete();
        return redirect('/pasar_murah')->with('sukses','Data berhasil dihapus');
    }
}
