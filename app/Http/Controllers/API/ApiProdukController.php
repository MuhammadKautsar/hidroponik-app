<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Image;

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
        $data = Produk::orderBy('updated_at', 'DESC')->get();

        // Model::find($id)
        // Model::all()
        // Model::orderBy('updated_at', 'DESC')->get()

        foreach ($data as $row) {
            $gambar = array();
            foreach ($row->images as $image) {
                array_push($gambar, $image->path_image);
            }
            array_push($showData, [
                'id' => $row->id . '', // string
                'nama' => $row->nama, // string
                'gambar' => $gambar, // list/array
                'harga' => $row->harga, // number
                'stok' => $row->stok, // number
                'penjual' => $row->penjual->username, // string
                'filter' => $row->promo_id ? 'Promo' : 'Biasa', // string
                'potongan' => $row->promo_id ? $row->promo->potongan : 0,
                'periode' => $row->promo_id ? $row->promo->periode : '',
                'total_feedback' => $row->total_feedback,
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
            'keterangan' => 'required',
            'penjual_id' => 'required',
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
                'keterangan' => 'required',
                'penjual_id' => 'required',
                //gambar
            ]
        );
        $data['total_feedback'] = 0;
        $produk = Produk::create($data);

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
        $showData = [
            'id' => $produk->id . '', // string
            'nama' => $produk->nama, // string
            'gambar' => $gambar, // list/array
            'harga' => $produk->harga, // number
            'stok' => $produk->stok, // number
            'penjual' => $produk->penjual->username, // string
            'filter' => $produk->promo_id ? 'Promo' : 'Biasa', // string
            'potongan' => $produk->promo_id ? $produk->promo->potongan : 0,
            'periode' => $produk->promo_id ? $produk->promo->periode : '',
            'total_feedback' => $produk->total_feedback,
        ];
        return response()->json($showData);
    }


    public function destroy(Produk $produk)
    {
        $produk->delete();
        return response()->json(['message' => 'berhasil mendelete produk']);
    }

    public function update(Produk $produk)
    {
        $data = request()->all();
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
        foreach ($user->produks as $produk) {
            # code...
            $gambar = array();
            foreach ($produk->images as $image) {
                array_push($gambar,  $image->path_image);
            }
            array_push($showData, [
                'id' => $produk->id . '', // string
                'nama' => $produk->nama, // string
                'gambar' => $gambar, // list/array
                'harga' => $produk->harga, // number
                'stok' => $produk->stok, // number
                'penjual' => $produk->penjual->username, // string
                'filter' => $produk->promo_id ? 'Promo' : 'Biasa', // string
                'potongan' => $produk->promo_id ? $produk->promo->potongan : 0,
                'periode' => $produk->promo_id ? $produk->promo->periode : '',
                'total_feedback' => $produk->total_feedback,
            ]);
        }
        return response()->json($showData);
    }
    private function path_file($value)
    {
        // TODO: saat upload ke server mtsn. comment line dibawah ini dan uncomment yang bagian ada public_htmlnya
        return public_path($value);
        // return public_path('../../public_html/hidroponik' . $value);
    }
}
