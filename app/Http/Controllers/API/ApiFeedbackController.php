<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Produk;
use App\Models\Feedback;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiFeedbackController extends Controller
{
    public function index()
    {
        $showData = array();
        $data = Feedback::orderBy('updated_at', 'DESC')->get();

        foreach ($data as $row) {
            $gambar = array();
            foreach ($row->produk->images as $image) {
                array_push($gambar, $image->path_image);
            }
            array_push($showData, [
                'id' => $row->id . '',
                'tanggal' => $row->created_at->format('d-m-Y'),
                'produk' => [
                    'id' => $row->produk->id,
                    'nama' => $row->produk->nama,
                    'gambar' => $gambar
                ],
                'pembeli' => $row->user->nama_lengkap,
                'foto_profil' => $row->user->profile_image,
                'komentar' => $row->komentar,
                'rating' => $row->rating
            ]);
        }

        return response()->json($showData); //result.data
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required',
            'user_id' => 'required',
            'order_id' => 'required',
            'komentar' => 'required',
            'rating' => 'required|numeric'
        ]);


        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }


        $data = $request->validate(
            [
                'produk_id' => 'required',
                'user_id' => 'required',
                'komentar' => 'required',
                'rating' => 'required|numeric'
            ]
        );

        $idOrder = $request->validate(
            [
                'order_id' => 'required',
            ]
        );
        $order = Order::find($idOrder['order_id']);
        $order->update(['status_feedback' => 1]);
        $feedback = Feedback::create($data);

        $total = 0;
        $feeds = Feedback::where('produk_id', '=', $feedback->produk_id)->get();
        foreach ($feeds as $row) {
            $total += $row->rating;
        }

        $rata = ($total === 0) ? 0 : floatval($total) / count($feeds);
        $feedback->produk->update(['total_feedback' => $rata]);

        return response()->json(['message' => 'berhasil menambahkan Feedback']);
    }


    public function show(Feedback $feedback)
    {
        $gambar = array();
        foreach ($feedback->produk->images as $image) {
            array_push($gambar, $image->path_image);
        }
        $showData = [
            'id' => $feedback->id . '',
            'tanggal' => $feedback->created_at->format('d-m-Y'),
            'produk' => [
                'id' => $feedback->produk->id,
                'nama' => $feedback->produk->nama,
                'gambar' => $gambar
            ],
            'pembeli' => $feedback->user->nama_lengkap,
            'foto_profil' => $feedback->user->profile_image,
            'komentar' => $feedback->komentar,
            'rating' => $feedback->rating
        ];
        return response()->json($showData);
    }


    public function destroy(Feedback $feedback)
    {
        $total = 0;

        $feeds = Feedback::where('produk_id', '=', $feedback->produk_id)->where('id', '!=', $feedback->id)->get();
        foreach ($feeds as $row) {
            $total += $row->rating;
        }

        $rata = ($total === 0) ? 0 : floatval($total) / count($feeds);
        $feedback->produk->update(['total_feedback' => $rata]);
        $feedback->delete();
        return response()->json(['message' => 'berhasil mendelete feedback']);
    }

    public function update(Feedback $order)
    {
        $data = request()->all();
        $order->update($data);

        return response()->json(['message' => 'berhasil mengupdate feedback']);
    }

    public function getFeedbackByProdukId(Produk $produk)
    {
        $showData = array();

        foreach ($produk->feedbacks as $row) {
            $gambar = array();
            foreach ($produk->images as $image) {
                array_push($gambar, $image->path_image);
            }
            array_push($showData, [
                'id' => $row->id . '',
                'tanggal' => $row->created_at->format('d-m-Y'),
                'produk' => [
                    'id' => $produk->id,
                    'nama' => $produk->nama,
                    'gambar' => $gambar
                ],
                'pembeli' => $row->user->nama_lengkap,
                'foto_profil' => $row->user->profile_image,
                'komentar' => $row->komentar,
                'rating' => $row->rating
            ]);
        }
        return response()->json($showData);
    }
}
