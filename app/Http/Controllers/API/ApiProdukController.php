<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Image;

use App\Models\Promo;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

// FIXME: ini adalah contoh pembuatan controller
class ApiProdukController extends Controller
{
    public function index()
    {
        $showData = array();

        $today = strtotime(now());
        $data = Produk::orderBy('updated_at', 'DESC')->get();
        foreach ($data as $row) {

            if ($row->penjual->status != 1) continue;

            $gambar = array();
            foreach ($row->images as $image) {
                array_push($gambar, $image->path_image);
            }
            // delete promo yang udah expired
            if ($row->promo_id) {
                $end =  strtotime($row->promo->akhir_periode);
                if ($today > $end) {
                    $row->promo->delete();
                    $row->update(['promo_id' => NULL]);
                }
            }
            array_push($showData, [
                'id' => $row->id . '', // string
                'nama' => $row->nama, // string
                'gambar' => $gambar, // list/array
                'harga' => $row->harga, // number
                'stok' => $row->stok, // number
                'keterangan' => $row->keterangan, // string
                'penjual' => $row->penjual->username, // string
                'filter' => $row->promo_id ? 'Promo' : 'Biasa', // string
                'potongan' => $row->promo_id ? $row->promo->potongan : 0,
                'periode_awal' => $row->promo_id ? $row->promo->awal_periode : '',
                'periode_akhir' => $row->promo_id ? $row->promo->akhir_periode : '',
                'promo_nama' => $row->promo_id ? $row->promo->nama : '',
                'promo_id' => $row->promo_id,
                'total_feedback' => $row->total_feedback,
                'penjual_id' => $row->penjual_id . ''
            ]);
        }

        return response()->json($showData); //result.data
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'harga' => 'required|numeric|digits_between:1,6',
            'stok' => 'required|numeric',
            'penjual_id' => 'required',
            'promo_id' => 'numeric',
            'keterangan' => 'string',
            //gambar
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }
        $data = $request->validate(
            [
                'nama' => 'required',
                'harga' => 'required|numeric|digits_between:1,6',
                'stok' => 'required|numeric',
                'penjual_id' => 'required',
                'promo_id' => 'numeric',
                'keterangan' => 'string',
                //gambar
            ]
        );
        $data['total_feedback'] = 0;
        $produk = Produk::create($data);
        dd($request->file('gambar'));
        if ($request->hasFile('gambar')) {
            $files = $request->file('gambar');
            foreach ($files as $file) {

                // $file = $request->file('gambar');
                $imgName = time() . '_' . $file->getClientOriginalName();
                $file->move($this->path_file('/uploads'), $imgName);
                Image::create([
                    'produk_id' => $produk->id,
                    'path_image' => asset('uploads/' . $imgName),
                ]);
            }
        }


        return response()->json(['message' => 'berhasil menambahkan produk', 'file' => $request->file('gambar')]);
    }


    public function show(Produk $produk)
    {
        $gambar = array();
        foreach ($produk->images as $image) {
            array_push($gambar,  $image->path_image);
        }
        $today = strtotime(now());
        if ($produk->promo_id) {
            $end =  strtotime($produk->promo->akhir_periode);
            if ($today > $end) {
                $produk->promo->delete();
                $produk->update(['promo_id' => NULL]);
            }
        }
        $showData = [
            'id' => $produk->id . '', // string
            'nama' => $produk->nama, // string
            'gambar' => $gambar, // list/array
            'harga' => $produk->harga, // number
            'stok' => $produk->stok, // number
            'keterangan' => $produk->keterangan, // string
            'penjual' => $produk->penjual->username, // string
            'filter' => $produk->promo_id ? 'Promo' : 'Biasa', // string
            'potongan' => $produk->promo_id ? $produk->promo->potongan : 0,
            'promo_nama' => $produk->promo_id ? $produk->promo->nama : '',
            'promo_id' => $produk->promo_id,
            'periode_awal' => $produk->promo_id ? $produk->promo->awal_periode : '',
            'periode_akhir' => $produk->promo_id ? $produk->promo->akhir_periode : '',
            'total_feedback' => $produk->total_feedback,
            'penjual_id' => $produk->penjual_id . ''
        ];
        return response()->json($showData);
    }


    public function destroy(Produk $produk)
    {
        if ($produk->orders->count() == 0) {
            $produk->delete();
            return response()->json(['message' => 'berhasil mendelete produk']);
        }

        if ($produk->orders()->where('status_checkout', '=', 'Beli')->whereIn('status_order', ['Belum', 'Diproses', 'Dikirim'])->first()) {
            return response()->json(['message' => 'tidak dapat menghapus']);
        } else {
            $produk->delete();
            return response()->json(['message' => 'berhasil mendelete produk']);

        }
    }

    public function update(Produk $produk)
    {
        $data = request()->all();
        if ($data['promo_id'])
            if ($data['promo_id'] == '') {
                $data['promo_id'] = NULL;
            }
        $produk->update($data);


        if (request()->hasFile('gambar')) {
            Image::where('produk_id', $produk->id)->delete();
            $files = request()->file('gambar');
            foreach ($files as $file) {

                // $file = $request->file('gambar');
                $imgName = time() . '_' . $file->getClientOriginalName();
                $file->move($this->path_file('/uploads'), $imgName);
                Image::create([
                    'produk_id' => $produk->id,
                    'path_image' => asset('uploads/' . $imgName),
                ]);
            }
        }


        return response()->json(['message' => 'berhasil mengupdate']);
    }

    public function getProdukByPenjualId(User $user)
    {
        $showData = [];
        $today = strtotime(now());
        foreach ($user->produks as $produk) {
            # code...
            $gambar = array();
            foreach ($produk->images as $image) {
                array_push($gambar,  $image->path_image);
            }
            if ($produk->promo_id) {
                $end =  strtotime($produk->promo->akhir_periode);
                if ($today > $end) {
                    $produk->promo->delete();
                    $produk->update(['promo_id' => NULL]);
                }
            }
            array_push($showData, [
                'id' => $produk->id . '', // string
                'nama' => $produk->nama, // string
                'gambar' => $gambar, // list/array
                'harga' => $produk->harga, // number
                'stok' => $produk->stok, // number
                'keterangan' => $produk->keterangan, // string
                'penjual' => $produk->penjual->username, // string
                'filter' => $produk->promo_id ? 'Promo' : 'Biasa', // string
                'promo_id' => $produk->promo_id,
                'potongan' => $produk->promo_id ? $produk->promo->potongan : 0,
                'promo_nama' => $produk->promo_id ? $produk->promo->nama : '',
                'periode_awal' => $produk->promo_id ? $produk->promo->awal_periode : '',
                'periode_akhir' => $produk->promo_id ? $produk->promo->akhir_periode : '',
                'total_feedback' => $produk->total_feedback,
                'penjual_id' => $produk->penjual_id . ''
            ]);
        }
        return response()->json($showData);
    }
    private function path_file($value)
    {
        return public_path($value);
    }
}
