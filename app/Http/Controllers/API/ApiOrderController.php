<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Order;
use App\Models\OrderMapping;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiOrderController extends Controller
{
    public function index()
    {
        $showData = array();
        $data = Order::orderBy('updated_at', 'DESC')->get();

        foreach ($data as $row) {

            $tempOrderMapping = [];

            foreach ($row->order_mappings as $om) {
                $gambar = array();
                foreach ($om->produk->images as $image) {
                    array_push($gambar, $image->path_image);
                }
                array_push($tempOrderMapping, [
                    'id' => $om->id . '',
                    'produk_id' => $om->produk_id . '',
                    'status_feedback' => $om->status_feedback,
                    'nama' => $om->produk->nama,
                    'jumlah' => $om->jumlah,
                    'harga' => $om->produk->harga,
                    'gambar' => $gambar,
                    'penjual_produk' => $om->produk->penjual->nama_lengkap,
                ]);
            }
            array_push($showData, [
                'id' => $row->id . '',
                'jumlah' => $row->jumlah,
                'total_harga' => $row->total_harga,
                'status_checkout' => $row->status_checkout,
                'status_order' => $row->status_order,
                'alasan' => $row->alasan,
                'tanggal' => $row->created_at->format('d F Y'),
                'jam' => $row->created_at->format('H:i'),
                'harga_jasa_pengiriman' => $row->harga_jasa_pengiriman,
                'pembeli' => $row->pembeli->nama_lengkap,
                'nomor_hp_pembeli' => $row->pembeli->nomor_hp,
                'email_pembeli' => $row->pembeli->email,
                'alamat_pembeli' => $row->pembeli->alamat,
                'kota_pembeli' => $row->pembeli->kota,
                'kecamatan_pembeli' => $row->pembeli->kecamatan,
                'penjual' => $row->penjual->nama_lengkap,
                'id_penjual' => $row->penjual_id,
                'nomor_hp_penjual' => $row->penjual->nomor_hp,
                'email_penjual' => $row->penjual->email,
                'alamat_penjual' => $row->penjual->alamat,
                'kota_penjual' => $row->penjual->kota,
                'kecamatan_penjual' => $row->penjual->kecamatan,
                'order_mapping' => $tempOrderMapping,
            ]);
        }

        return response()->json($showData); //result.data
    }

    public function store(Request $request)
    {
        // pengecekan
        $validator = Validator::make($request->all(), [
            'pembeli_id' => 'required',
            'order_mapping_id' => 'required|array',
            'order_mapping_id.*' => 'required|distinct',
        ]);
        //  (id amount produk_id)-> produk -> penjual_id

        // jika gagal keluar pemberitahuan
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }

        // mencari order mapping berdassarkan id
        $om = OrderMapping::with('produk')->whereIn('id', $request->order_mapping_id);

        // mengambil data id pembeli
        $data = $request->validate(
            ['pembeli_id' => 'required',]
        );
        $data['status_order'] = 'Belum';
        $data['harga_jasa_pengiriman'] = 0;
        $data['penjual_id'] = $om->get()[0]->produk->penjual_id;
        $data['total_harga'] = collect($om->get())
            ->reduce(
                function ($p, $item) {
                    $harga = $item->produk->harga;
                    $harga *= $item->jumlah;
                    $harga = $harga - ($harga * ($item->produk->promo_id ? $item->produk->promo->potongan : 0) / 100);
                    return $p + $harga;
                },
                0
            );

        $order = Order::create($data);

        if ($order->penjual->notificationTokens) {
            foreach ($order->penjual->notificationTokens as $notif) {
                $this->sendNotification($notif->notificationToken, 'Pesanan Datang', "Hai " . $order->penjual->nama_lengkap . ", Pesanan baru diterima, silahkan cek di aplikasi");
            }
        }

        $om->update(['order_id' => $order->id, 'status_checkout' => 'Beli']);

        foreach ($om->get() as $row) {
            $row->produk->update([
                'stok' => $row->produk->stok - $row->jumlah
            ]);

            if ($row->produk->stok <= 0) {
                $row->produk->order_mappings()->where('status_checkout', 'Keranjang')->delete();
            }
        }
        return response()->json(['message' => 'berhasil menambahkan Order']);
    }


    public function show(Order $order)
    {

        $tempOrderMapping = [];

        foreach ($order->order_mappings as $om) {
            $gambar = array();
            foreach ($om->produk->images as $image) {
                array_push($gambar, $image->path_image);
            }
            array_push($tempOrderMapping, [
                'id' => $om->id . '',
                'produk_id' => $om->produk_id . '',
                'status_feedback' => $om->status_feedback,
                'nama' => $om->produk->nama,
                'jumlah' => $om->jumlah,
                'harga' => $om->produk->harga,
                'gambar' => $gambar,
                'penjual_produk' => $om->produk->penjual->username,
            ]);
        }

        $showData = [
            'id' => $order->id . '',
            'jumlah' => $order->jumlah,
            'total_harga' => $order->total_harga,
            'status_checkout' => $order->status_checkout,
            'status_order' => $order->status_order,
            'alasan' => $order->alasan,
            'tanggal' => $order->created_at->format('d F Y'),
            'jam' => $order->created_at->format('H:i'),
            'harga_jasa_pengiriman' => $order->harga_jasa_pengiriman,
            'pembeli' => $order->pembeli->nama_lengkap,
            'nomor_hp_pembeli' => $order->pembeli->nomor_hp,
            'email_pembeli' => $order->pembeli->email,
            'alamat_pembeli' => $order->pembeli->alamat,
            'kota_pembeli' => $order->pembeli->kota,
            'kecamatan_pembeli' => $order->pembeli->kecamatan,
            'penjual' => $order->penjual->nama_lengkap,
            'id_penjual' => $order->penjual_id,
            'nomor_hp_penjual' => $order->penjual->nomor_hp,
            'email_penjual' => $order->penjual->email,
            'alamat_penjual' => $order->penjual->alamat,
            'kota_penjual' => $order->penjual->kota,
            'kecamatan_penjual' => $order->penjual->kecamatan,
            'order_mapping' => $tempOrderMapping,
        ];
        return response()->json($showData);
    }


    public function destroy(Order $order)
    {
        if ($order->status_order === 'Belum')
            $order->delete();
        return response()->json(['message' => 'berhasil mendelete order']);
    }

    public function update(Order $order)
    {
        $data = request()->all();
        $order->update($data);

        return response()->json(['message' => 'berhasil mengupdate order']);
    }

    public function getOrder(User $user)
    {
        $showData = array();
        $today = strtotime(now());

        $orders = Order::where('pembeli_id', '=', $user->id)->whereNotIn('status_order', ['Batal', 'Selesai'])->get();
        // $orders = Order::where('status_checkout', '=', $status)->where('pembeli_id', '=', $user->id)->get();
        foreach ($orders as $row) {
            // expired 2 hari kemudian
            if ($row->status_order == 'Belum') {

                $expiredDate =  strtotime($row->created_at->modify('+2 days'));
                if ($today >= $expiredDate) {
                    $row->update(["status_order" => 'Batal']);
                    continue;
                }
            }
            $tempOrderMapping = [];
            foreach ($row->order_mappings as $om) {
                $gambar = array();
                foreach ($om->produk->images as $image) {
                    array_push($gambar, $image->path_image);
                }
                array_push($tempOrderMapping, [
                    'id' => $om->id . '',
                    'produk_id' => $om->produk_id . '',
                    'status_feedback' => $om->status_feedback,
                    'nama' => $om->produk->nama,
                    'jumlah' => $om->jumlah,
                    'harga' => $om->produk->harga,
                    'gambar' => $gambar,
                    'penjual_produk' => $om->produk->penjual->nama_lengkap,
                ]);
            }



            array_push($showData, [
                'id' => $row->id . '',
                'total_harga' => $row->total_harga,
                'status_order' => $row->status_order,
                'alasan' => $row->alasan,
                'tanggal' => $row->created_at->format('d F Y'),
                'jam' => $row->created_at->format('H:i'),
                'harga_jasa_pengiriman' => $row->harga_jasa_pengiriman,
                'pembeli' => $row->pembeli->nama_lengkap,
                'nomor_hp_pembeli' => $row->pembeli->nomor_hp,
                'email_pembeli' => $row->pembeli->email,
                'alamat_pembeli' => $row->pembeli->alamat,
                'kota_pembeli' => $row->pembeli->kota,
                'kecamatan_pembeli' => $row->pembeli->kecamatan,
                'penjual' => $row->penjual->nama_lengkap,
                'id_penjual' => $row->penjual_id,
                'nomor_hp_penjual' => $row->penjual->nomor_hp,
                'email_penjual' => $row->penjual->email,
                'alamat_penjual' => $row->penjual->alamat,
                'kota_penjual' => $row->penjual->kota,
                'kecamatan_penjual' => $row->penjual->kecamatan,
                'order_mapping' => $tempOrderMapping,


            ]);
        }
        return response()->json($showData);
    }

    public function getOrderSelesai(User $user)
    {
        $showData = array();

        $orders = Order::where('pembeli_id', '=', $user->id)->whereIn('status_order', ['Batal', 'Selesai'])->orderBy('updated_at', 'DESC')->get();
        // $orders = Order::where('status_checkout', '=', $status)->where('pembeli_id', '=', $user->id)->get();
        foreach ($orders as $row) {
            // expired 2 hari kemudian

            $tempOrderMapping = [];
            foreach ($row->order_mappings as $om) {
                $gambar = array();
                foreach ($om->produk->images as $image) {
                    array_push($gambar, $image->path_image);
                }
                array_push($tempOrderMapping, [
                    'id' => $om->id . '',
                    'produk_id' => $om->produk_id . '',
                    'status_feedback' => $om->status_feedback,
                    'nama' => $om->produk->nama,
                    'jumlah' => $om->jumlah,
                    'harga' => $om->produk->harga,
                    'gambar' => $gambar,
                    'penjual_produk' => $om->produk->penjual->nama_lengkap,
                ]);
            }



            array_push($showData, [
                'id' => $row->id . '',
                'total_harga' => $row->total_harga,
                'status_order' => $row->status_order,
                'alasan' => $row->alasan,
                'tanggal' => $row->created_at->format('d F Y'),
                'jam' => $row->created_at->format('H:i'),
                'harga_jasa_pengiriman' => $row->harga_jasa_pengiriman,
                'pembeli' => $row->pembeli->nama_lengkap,
                'nomor_hp_pembeli' => $row->pembeli->nomor_hp,
                'email_pembeli' => $row->pembeli->email,
                'alamat_pembeli' => $row->pembeli->alamat,
                'kota_pembeli' => $row->pembeli->kota,
                'kecamatan_pembeli' => $row->pembeli->kecamatan,
                'penjual' => $row->penjual->nama_lengkap,
                'id_penjual' => $row->penjual_id,
                'nomor_hp_penjual' => $row->penjual->nomor_hp,
                'email_penjual' => $row->penjual->email,
                'alamat_penjual' => $row->penjual->alamat,
                'kota_penjual' => $row->penjual->kota,
                'kecamatan_penjual' => $row->penjual->kecamatan,
                'order_mapping' => $tempOrderMapping,


            ]);
        }
        return response()->json($showData);
    }

    public function getOrderByCheckout($status, User $user)
    {
        $showData = array();
        $today = strtotime(now());

        $orders = Order::where('status_checkout', '=', $status)->where('pembeli_id', '=', $user->id)->whereNotIn('status_order', ['Batal', 'Selesai'])->get();
        // $orders = Order::where('status_checkout', '=', $status)->where('pembeli_id', '=', $user->id)->get();
        foreach ($orders as $row) {
            // expired 2 hari kemudian
            if ($row->status_order == 'Belum') {
                if ($row->status_checkout == 'Beli') {
                    $expiredDate =  strtotime($row->created_at->modify('+2 days'));
                    if ($today >= $expiredDate) {
                        $row->update(["status_order" => 'Batal']);
                        continue;
                    }
                }
            }
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
                'alasan' => $row->alasan,
                'tanggal' => $row->created_at->format('d F Y'),
                'jam' => $row->created_at->format('H:i'),
                'harga_jasa_pengiriman' => $row->harga_jasa_pengiriman,
                'pembeli' => $row->pembeli->nama_lengkap,
                'nomor_hp_pembeli' => $row->pembeli->nomor_hp,
                'email_pembeli' => $row->pembeli->email,
                'alamat_pembeli' => $row->pembeli->alamat,
                'kota_pembeli' => $row->pembeli->kota,
                'kecamatan_pembeli' => $row->pembeli->kecamatan,
                'status_feedback' => $row->status_feedback,
                'produk' => [
                    'id' => $row->produk_id . '',
                    'penjual' => $row->produk->penjual->nama_lengkap,
                    'id_penjual' => $row->produk->penjual_id,
                    'username_penjual' => $row->produk->penjual->username,
                    'nomor_hp_penjual' => $row->produk->penjual->nomor_hp,
                    'email_penjual' => $row->produk->penjual->email,
                    'alamat_penjual' => $row->produk->penjual->alamat,
                    'kota_penjual' => $row->produk->penjual->kota,
                    'kecamatan_penjual' => $row->produk->penjual->kecamatan,
                    'nama' => $row->produk->nama,
                    'harga' => $row->produk->harga,
                    'stok' => $row->produk->stok,
                    'keterangan' => $row->produk->keterangan,
                    'total_feedback' => $row->produk->total_feedback,
                    'gambar' => $gambar,
                    'potongan' => $row->produk->promo_id ? $row->produk->promo->potongan : 0,
                    'periode_awal' => $row->produk->promo_id ? $row->produk->promo->awal_periode : '',
                    'periode_akhir' => $row->produk->promo_id ? $row->produk->promo->akhir_periode : '',
                    'promo_nama' => $row->produk->promo_id ? $row->produk->promo->nama : '',
                    'promo_id' => $row->produk->promo_id,

                ]
            ]);
        }
        return response()->json($showData);
    }

    public function getOrderPenjual(User $user)
    {
        $showData = array();
        $today = strtotime(now());

        $orders = Order::where('penjual_id', '=', $user->id)->whereNotIn('status_order', ['Batal', 'Selesai'])->get();

        foreach ($orders as $row) {
            // expired 2 hari kemudian
            if ($row->status_order == 'Belum') {

                $expiredDate =  strtotime($row->created_at->modify('+2 days'));
                if ($today >= $expiredDate) {
                    $row->update(["status_order" => 'Batal']);
                    continue;
                }
            }
            $tempOrderMapping = [];
            foreach ($row->order_mappings as $om) {
                $gambar = array();
                foreach ($om->produk->images as $image) {
                    array_push($gambar, $image->path_image);
                }
                array_push($tempOrderMapping, [
                    'id' => $om->id . '',
                    'produk_id' => $om->produk_id . '',
                    'status_feedback' => $om->status_feedback,
                    'nama' => $om->produk->nama,
                    'jumlah' => $om->jumlah,
                    'harga' => $om->produk->harga,
                    'gambar' => $gambar,
                    'penjual_produk' => $om->produk->penjual->nama_lengkap,
                ]);
            }



            array_push($showData, [
                'id' => $row->id . '',
                'total_harga' => $row->total_harga,
                'status_order' => $row->status_order,
                'alasan' => $row->alasan,
                'tanggal' => $row->created_at->format('d F Y'),
                'jam' => $row->created_at->format('H:i'),
                'harga_jasa_pengiriman' => $row->harga_jasa_pengiriman,
                'pembeli' => $row->pembeli->nama_lengkap,
                'nomor_hp_pembeli' => $row->pembeli->nomor_hp,
                'email_pembeli' => $row->pembeli->email,
                'alamat_pembeli' => $row->pembeli->alamat,
                'kota_pembeli' => $row->pembeli->kota,
                'kecamatan_pembeli' => $row->pembeli->kecamatan,
                'penjual' => $row->penjual->nama_lengkap,
                'id_penjual' => $row->penjual_id,
                'nomor_hp_penjual' => $row->penjual->nomor_hp,
                'email_penjual' => $row->penjual->email,
                'alamat_penjual' => $row->penjual->alamat,
                'kota_penjual' => $row->penjual->kota,
                'kecamatan_penjual' => $row->penjual->kecamatan,
                'order_mapping' => $tempOrderMapping,


            ]);
        }

        return response()->json($showData);
    }

    public function getOrderByCheckoutSelesai($status, User $user)
    {
        $showData = array();

        $orders = Order::where('status_checkout', '=', $status)->where('pembeli_id', '=', $user->id)->whereIn('status_order', ['Batal', 'Selesai'])->orderBy('updated_at', 'DESC')->get();
        foreach ($orders as $row) {
            $gambar = array();
            foreach ($row->produk->images as $image) {
                array_push($gambar, $image->path_image);
            }
            array_push($showData, [
                'id' => $row->id . '',
                'produk_id' => $row->produk_id,
                'jumlah' => $row->jumlah,
                'total_harga' => $row->total_harga,
                'status_checkout' => $row->status_checkout,
                'status_order' => $row->status_order,
                'alasan' => $row->alasan,
                'tanggal' => $row->created_at->format('d F Y'),
                'jam' => $row->created_at->format('H:i'),
                'harga_jasa_pengiriman' => $row->harga_jasa_pengiriman,
                'pembeli' => $row->pembeli->nama_lengkap,
                'nomor_hp_pembeli' => $row->pembeli->nomor_hp,
                'email_pembeli' => $row->pembeli->email,
                'alamat_pembeli' => $row->pembeli->alamat,
                'kota_pembeli' => $row->pembeli->kota,
                'kecamatan_pembeli' => $row->pembeli->kecamatan,
                'status_feedback' => $row->status_feedback,
                'produk' => [
                    'id' => $row->produk_id . '',
                    'penjual' => $row->produk->penjual->nama_lengkap,
                    'id_penjual' => $row->produk->penjual_id,
                    'username_penjual' => $row->produk->penjual->username,
                    'nomor_hp_penjual' => $row->produk->penjual->nomor_hp,
                    'email_penjual' => $row->produk->penjual->email,
                    'alamat_penjual' => $row->produk->penjual->alamat,
                    'kota_penjual' => $row->produk->penjual->kota,
                    'kecamatan_penjual' => $row->produk->penjual->kecamatan,
                    'nama' => $row->produk->nama,
                    'harga' => $row->produk->harga,
                    'stok' => $row->produk->stok,
                    'keterangan' => $row->produk->keterangan,
                    'total_feedback' => $row->produk->total_feedback,
                    'gambar' => $gambar,
                    'potongan' => $row->produk->promo_id ? $row->produk->promo->potongan : 0,
                    'periode_awal' => $row->produk->promo_id ? $row->produk->promo->awal_periode : '',
                    'periode_akhir' => $row->produk->promo_id ? $row->produk->promo->akhir_periode : '',
                    'promo_nama' => $row->produk->promo_id ? $row->produk->promo->nama : '',
                    'promo_id' => $row->produk->promo_id,

                ]
            ]);
        }
        return response()->json($showData);
    }

    public function getOrderPenjualSelesai(User $user)
    {
        $showData = array();

        $orders = Order::where('penjual_id', '=', $user->id)->whereIn('status_order', ['Batal', 'Selesai'])->orderBy('updated_at', 'DESC')->get();
        // $orders = Order::where('status_checkout', '=', $status)->where('pembeli_id', '=', $user->id)->get();
        foreach ($orders as $row) {
            // expired 2 hari kemudian

            $tempOrderMapping = [];
            foreach ($row->order_mappings as $om) {
                $gambar = array();
                foreach ($om->produk->images as $image) {
                    array_push($gambar, $image->path_image);
                }
                array_push($tempOrderMapping, [
                    'id' => $om->id . '',
                    'produk_id' => $om->produk_id . '',
                    'status_feedback' => $om->status_feedback,
                    'nama' => $om->produk->nama,
                    'jumlah' => $om->jumlah,
                    'harga' => $om->produk->harga,
                    'gambar' => $gambar,
                    'penjual_produk' => $om->produk->penjual->nama_lengkap,
                ]);
            }



            array_push($showData, [
                'id' => $row->id . '',
                'total_harga' => $row->total_harga,
                'status_order' => $row->status_order,
                'alasan' => $row->alasan,
                'tanggal' => $row->created_at->format('d F Y'),
                'jam' => $row->created_at->format('H:i'),
                'harga_jasa_pengiriman' => $row->harga_jasa_pengiriman,
                'pembeli' => $row->pembeli->nama_lengkap,
                'nomor_hp_pembeli' => $row->pembeli->nomor_hp,
                'email_pembeli' => $row->pembeli->email,
                'alamat_pembeli' => $row->pembeli->alamat,
                'kota_pembeli' => $row->pembeli->kota,
                'kecamatan_pembeli' => $row->pembeli->kecamatan,
                'penjual' => $row->penjual->nama_lengkap,
                'id_penjual' => $row->penjual_id,
                'nomor_hp_penjual' => $row->penjual->nomor_hp,
                'email_penjual' => $row->penjual->email,
                'alamat_penjual' => $row->penjual->alamat,
                'kota_penjual' => $row->penjual->kota,
                'kecamatan_penjual' => $row->penjual->kecamatan,
                'order_mapping' => $tempOrderMapping,


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
                'alasan' => $row->alasan,
                'tanggal' => $row->created_at->format('d F Y'),
                'jam' => $row->created_at->format('H:i'),
                'harga_jasa_pengiriman' => $row->harga_jasa_pengiriman,
                'pembeli' => $row->pembeli->nama_lengkap,
                'nomor_hp_pembeli' => $row->pembeli->nomor_hp,
                'email_pembeli' => $row->pembeli->email,
                'alamat_pembeli' => $row->pembeli->alamat,
                'kota_pembeli' => $row->pembeli->kota,
                'kecamatan_pembeli' => $row->pembeli->kecamatan,
                'status_feedback' => $row->status_feedback,
                'produk' => [
                    'id' => $row->produk_id . '',
                    'penjual' => $row->produk->penjual->nama_lengkap,
                    'nama' => $row->produk->nama,
                    'harga' => $row->produk->harga,
                    'stok' => $row->produk->stok,
                    'keterangan' => $row->produk->keterangan,
                    'total_feedback' => $row->produk->total_feedback,
                    'gambar' => $gambar,
                    'potongan' => $row->produk->promo_id ? $row->produk->promo->potongan : 0,
                    'periode_awal' => $row->produk->promo_id ? $row->produk->promo->awal_periode : '',
                    'periode_akhir' => $row->produk->promo_id ? $row->produk->promo->akhir_periode : '',
                    'promo_nama' => $row->produk->promo_id ? $row->produk->promo->nama : '',
                    'promo_id' => $row->produk->promo_id,

                ]
            ]);
        }
        return response()->json($showData);
    }

    public function getJumlahOrderPembeli(User $user)
    {

        return response()->json(['total' => count($user->orders->where('status_checkout', '=', 'keranjang')->all())]);
    }

    public function changeOrderStatus(Order $order)
    {
        $validator = Validator::make(request()->all(), [
            'status_order' => 'required',
            'alasan' => 'string',
        ]);


        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }
        $data = request()->validate(
            [
                'status_order' => 'required',
                'alasan' => 'string',
            ]
        );

        $order->update($data);
        if ($data['status_order'] == 'Selesai') {
            if ($order->pembeli->notificationTokens) {
                foreach ($order->pembeli->notificationTokens as $notif) {
                    $this->sendNotification($notif->notificationToken, 'Pesanan Selesai', 'Terima Kasih ' . $order->pembeli->nama_lengkap . ', Pesanan telah diselesaikan');
                }
            }
        } else if ($data['status_order'] == 'Diproses') {
            if ($order->pembeli->notificationTokens) {
                foreach ($order->pembeli->notificationTokens as $notif) {
                    $this->sendNotification($notif->notificationToken, 'Pesanan Dikonfirmasi',  'Pesanan Anda Sedang ' . $order->status_order);
                }
            }
        } else if ($data['status_order'] == 'Batal') {
            if ($order->pembeli->notificationTokens) {
                foreach ($order->pembeli->notificationTokens as $notif) {
                    $this->sendNotification($notif->notificationToken, 'Pesanan Dibatalkan',  'Maaf, Pesanan anda telah dibatalkan oleh penjual');
                }
            }
        } else {
            if ($order->pembeli->notificationTokens) {
                foreach ($order->pembeli->notificationTokens as $notif) {
                    $this->sendNotification($notif->notificationToken, 'Tunggu Pesanan Anda',  'Pesanan Anda Sedang ' . $order->status_order);
                }
            }
        }

        return response()->json(['message' => 'berhasil merubah status order']);
    }

    public function changeHargaPengiriman(Order $order)
    {
        $validator = Validator::make(request()->all(), [
            'harga_jasa_pengiriman' => 'required|numeric'
        ]);


        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }
        $data = request()->validate(
            [
                'harga_jasa_pengiriman' => 'required|numeric'
            ]
        );
        if ($data['harga_jasa_pengiriman'] > 10000) {
            return response()->json(['message' => 'harga melebihi batas maksimum']);
        }
        if ($data['harga_jasa_pengiriman'] < 0) {
            return response()->json(['message' => 'harga tidak mencapai minimal']);
        }
        $order->update($data);
        return response()->json(['message' => 'berhasil menambahkan harga pengiriman']);
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
