<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Validator;

class ApiOrderController extends Controller
{
    public function index()
    {
        $showData = array();
        $data = Order::orderBy('updated_at', 'DESC')->get();

        foreach ($data as $row) {
            $gambar = array();
            foreach ($row->produk->images as $image) {
                array_push($gambar, $image->path_image);
            }
            array_push($showData, [
                'id' => $row->id . '',
                'jumlah' => $row->jumlah,
                'total_harga' => $row->total_harga,
                'status_checkout' => $row->status_checkout,
                'status_order' => $row->status_order,
                'tanggal' => $row->created_at,
                'pembeli' => $row->pembeli->nama_lengkap,
                'produk' => [
                    'penjual' => $row->produk->penjual->nama_lengkap,
                    'nama' => $row->produk->nama,
                    'harga' => $row->produk->harga,
                    'stok' => $row->produk->stok,
                    'keterangan' => $row->produk->keterangan,
                    'total_feedback' => $row->produk->total_feedback,
                    'gambar' => $gambar,
                ]
            ]);
        }

        return response()->json($showData); //result.data
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'produk_id' => 'required',
            'pembeli_id' => 'required',
            'jumlah' => 'required|numeric',
            'total_harga' => 'required|numeric'
        ]);


        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }


        $data = $request->validate(
            [
                'produk_id' => 'required',
                'pembeli_id' => 'required',
                'jumlah' => 'required|numeric',
                'total_harga' => 'required|numeric'
            ]
        );
        $data['status_checkout'] = 'keranjang';
        $data['status_order'] = 'belum';

        $prevOrder = Order::where('produk_id', '=', $data['produk_id'])->where('pembeli_id', '=', $data['pembeli_id'])->first();
        if ($prevOrder) {
            $prevOrder->update(['jumlah' => $prevOrder->jumlah + $data['jumlah'], 'total_harga' => $prevOrder->total_harga + $data['total_harga']]);
        } else
            $order = Order::create($data);

        return response()->json(['message' => 'berhasil menambahkan Order']);
    }


    public function show(Order $order)
    {
        $gambar = array();
        foreach ($order->produk->images as $image) {
            array_push($gambar, $image->path_image);
        }
        $showData = [
            'id' => $order->id . '',
            'jumlah' => $order->jumlah,
            'total_harga' => $order->total_harga,
            'status_checkout' => $order->status_checkout,
            'status_order' => $order->status_order,
            'tanggal' => $order->created_at,
            'pembeli' => $order->pembeli->nama_lengkap,
            'produk' => [
                'penjual' => $order->produk->penjual->nama_lengkap,
                'nama' => $order->produk->nama,
                'harga' => $order->produk->harga,
                'stok' => $order->produk->stok,
                'keterangan' => $order->produk->keterangan,
                'total_feedback' => $order->produk->total_feedback,
                'gambar' => $gambar,
            ]
        ];
        return response()->json($showData);
    }


    public function destroy(Order $order)
    {
        if ($order->status_order === 'belum')
            $order->delete();
        return response()->json(['message' => 'berhasil mendelete order']);
    }

    public function update(Order $order)
    {
        $data = request()->all();
        $order->update($data);

        return response()->json(['message' => 'berhasil mengupdate order']);
    }

    public function getOrderByPembeliId(User $user)
    {
        $showData = array();

        foreach ($user->orders as $row) {
            $gambar = array();
            foreach ($row->produk->images as $image) {
                array_push($gambar, $image->path_image);
            }
            array_push($showData, [
                'id' => $row->id . '',
                'jumlah' => $row->jumlah,
                'total_harga' => $row->total_harga,
                'status_checkout' => $row->status_checkout,
                'status_order' => $row->status_order,
                'tanggal' => $row->created_at,
                'pembeli' => $row->pembeli->nama_lengkap,
                'produk' => [
                    'penjual' => $row->produk->penjual->nama_lengkap,
                    'nama' => $row->produk->nama,
                    'harga' => $row->produk->harga,
                    'stok' => $row->produk->stok,
                    'keterangan' => $row->produk->keterangan,
                    'total_feedback' => $row->produk->total_feedback,
                    'gambar' => $gambar,
                ]
            ]);
        }
        return response()->json($showData);
    }

    public function getOrderByPenjualId(User $user)
    {
        $showData = array();

        foreach ($user->produks as $row) {
            foreach ($row->orders as $order) {
                if ($order->status_checkout != 'Beli') continue;
                $gambar = array();
                foreach ($order->produk->images as $image) {
                    array_push($gambar, $image->path_image);
                }
                array_push($showData, [
                    'id' => $order->id . '',
                    'jumlah' => $order->jumlah,
                    'total_harga' => $order->total_harga,
                    'status_checkout' => $order->status_checkout,
                    'status_order' => $order->status_order,
                    'tanggal' => $order->created_at,
                    'pembeli' => $order->pembeli->nama_lengkap,
                    'produk' => [
                        'penjual' => $order->produk->penjual->nama_lengkap,
                        'nama' => $order->produk->nama,
                        'harga' => $order->produk->harga,
                        'stok' => $order->produk->stok,
                        'keterangan' => $order->produk->keterangan,
                        'total_feedback' => $order->produk->total_feedback,
                        'gambar' => $gambar,
                    ]
                ]);
            }
        }
        return response()->json($showData);
    }

    public function getOrderByCheckout($status, User $user)
    {
        $showData = array();

        $orders = Order::where('status_checkout', '=', $status)->where('pembeli_id', '=', $user->id)->get();
        foreach ($orders as $row) {
            $gambar = array();
            foreach ($row->produk->images as $image) {
                array_push($gambar, $image->path_image);
            }
            array_push($showData, [
                'id' => $row->id . '',
                'jumlah' => $row->jumlah,
                'total_harga' => $row->total_harga,
                'status_checkout' => $row->status_checkout,
                'status_order' => $row->status_order,
                'tanggal' => $row->created_at,
                'pembeli' => $row->pembeli->nama_lengkap,
                'produk' => [
                    'penjual' => $row->produk->penjual->nama_lengkap,
                    'nama' => $row->produk->nama,
                    'harga' => $row->produk->harga,
                    'stok' => $row->produk->stok,
                    'keterangan' => $row->produk->keterangan,
                    'total_feedback' => $row->produk->total_feedback,
                    'gambar' => $gambar,
                ]
            ]);
        }
        return response()->json($showData);
    }
    public function getOrderByOrder($status, User $user)
    {
        $showData = array();

        $orders = Order::where('status_order', '=', $status)->where('pembeli_id', '=', $user->id)->get();
        foreach ($orders as $row) {
            $gambar = array();
            foreach ($row->produk->images as $image) {
                array_push($gambar, $image->path_image);
            }
            array_push($showData, [
                'id' => $row->id . '',
                'jumlah' => $row->jumlah,
                'total_harga' => $row->total_harga,
                'status_checkout' => $row->status_checkout,
                'status_order' => $row->status_order,
                'tanggal' => $row->created_at,
                'pembeli' => $row->pembeli->nama_lengkap,
                'produk' => [
                    'penjual' => $row->produk->penjual->nama_lengkap,
                    'nama' => $row->produk->nama,
                    'harga' => $row->produk->harga,
                    'stok' => $row->produk->stok,
                    'keterangan' => $row->produk->keterangan,
                    'total_feedback' => $row->produk->total_feedback,
                    'gambar' => $gambar,
                ]
            ]);
        }
        return response()->json($showData);
    }

    public function getJumlahOrderPembeli(User $user)
    {

        return response()->json(['total' => count($user->orders->where('status_checkout', '=', 'keranjang')->all())]);
    }

    public function changeCheckoutStatus(Order $order)
    {
        $validator = Validator::make(request()->all(), [
            'status_checkout' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }
        $data = request()->validate(
            [
                'status_checkout' => 'required'
            ]
        );

        $order->update($data);
        if ($data['status_checkout'] == 'Beli') {
            $order->produk->update(['stok' => ($order->produk->stok - $order->jumlah)]);

            if ($order->produk->penjual->notificationTokens) {
                foreach ($order->produk->penjual->notificationTokens as $notif) {
                    $this->sendNotification($notif->notificationToken, 'Order Nih', 'Hai ' . $order->produk->penjual->nama_lengkap . ', ada yang beli ni');
                }
            }
        }

        return response()->json(['message' => 'berhasil merubah status checkout']);
    }
    public function changeOrderStatus(Order $order)
    {
        $validator = Validator::make(request()->all(), [
            'status_order' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }
        $data = request()->validate(
            [
                'status_order' => 'required'
            ]
        );

        $order->update($data);
        return response()->json(['message' => 'berhasil merubah status order']);
    }
    // notifikasi untuk si user hp
    private function sendNotification($to, $title, $body)
    {
        $post = [
            'to' => $to,
            'title' => $title,
            'body'   => $body,
        ];
        // persiapkan curl
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "https://exp.host/--/api/v2/push/send");

        // return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            $post
        );
        // $output contains the output string
        $output = curl_exec($ch);

        // tutup curl
        curl_close($ch);

        // menampilkan hasil curl
        return  $output;
    }
}
