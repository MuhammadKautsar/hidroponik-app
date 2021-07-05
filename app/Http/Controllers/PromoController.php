<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promo;

class PromoController extends Controller
{
    function post(Request $request)
    {
        $promo = new promo;
        $promo->nama = $request->nama;
        $promo->potongan = $request->potongan;
        $promo->periode = $request->periode;
        $promo->keterangan = $request->keterangan;

        $promo->save();

        return response()->json(
            [
                "message" => "Succsess",
                "data" => $promo
            ]
        );
    }

    function get()
    {
        $data = promo::all();

        return response()->json(
            [
                "message" => "Succsess",
                "data" => $data
            ]
        );
    }

    function getById($id)
    {
        $data = promo::where('id', $id)->get();

        return response()->json(
            [
                "message" => "Succsess",
                "data" => $data
            ]
        );
    }

    function put($id, Request $request)
    {
        $promo = promo::where('id', $id)->first();
        if($promo){
            $promo->nama = $request->nama ? $request->nama : $promo->nama;
            $promo->potongan = $request->potongan ? $request->potongan : $promo->potongan;
            $promo->periode = $request->periode ? $request->periode :$promo->periode;
            $promo->keterangan = $request->keterangan ? $request->keterangan :$promo->keterangan;

            $promo->save();
            return response()->json(
                [
                    "message" => "PUT Method Succsess ",
                    "data" => $promo
                ]
            );
        }
        return response()->json(
            [
                "message" => "promo with id " . $id . " not found"
            ], 400
        );
    }

    function delete($id)
    {
        $promo = promo::where('id', $id)->first();
        if($promo) {
            $promo->delete();
            return response()->json(
                [
                    "message" => "DELETE promo id " . $id . " Success"
                ]
            );
        }
        return response()->json(
            [
                "message" => "promo with id " . $id . " not found"
            ], 400
        );
    }

    public function index()
    {
        $promo=Promo::all();
        return view('pages.promos', compact('promo'));
    }

    public function create(Request $request)
    {
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
        $promo->periode = $request->input('periode');
        $promo->keterangan = $request->input('keterangan');
        $promo->save();
        return redirect('/promo')->with('sukses','Data berhasil diinput');
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
        $promo->periode = $request->input('periode');
        $promo->keterangan = $request->input('keterangan');
        $promo->update();
        return redirect('/promo')->with('sukses','Data berhasil diupdate');
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
        return redirect('/promo')->with('sukses','Data berhasil dihapus');
    }
}
