<?php

namespace App\Http\Controllers\API;

use App\Models\OrderMapping;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiOrderMappingController extends Controller
{
	public function index()
	{
		$showData = array();
		$data = OrderMapping::orderBy('updated_at', 'DESC')->get();

		foreach ($data as $row) {
			$gambar = array();
			foreach ($row->produk->images as $image) {
				array_push($gambar, $image->path_image);
			}
			array_push($showData, [
				'id' => $row->id . '',
				'jumlah' => $row->jumlah,
				'status_checkout' => $row->status_checkout,
				'tanggal' => $row->created_at->format('d-m-Y'),
				'jam' => $row->created_at->format('H:i'),
				'pembeli' => $row->pembeli->nama_lengkap,
				'nomor_hp_pembeli' => $row->pembeli->nomor_hp,
				'email_pembeli' => $row->pembeli->email,
				'alamat_pembeli' => $row->pembeli->alamat,
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

		return response()->json($showData); //result.data
	}



	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'produk_id' => 'required',
			'pembeli_id' => 'required',
			'jumlah' => 'required|numeric',
		]);


		if ($validator->fails()) {
			return response()->json(['message' => $validator->errors()]);
		}


		$data = $request->validate(
			[
				'produk_id' => 'required',
				'pembeli_id' => 'required',
				'jumlah' => 'required|numeric',
			]
		);
		$data['status_checkout'] = 'Keranjang';
		$data['status_feedback'] = 0;
		$om = OrderMapping::where('pembeli_id', $data['pembeli_id'])->where('produk_id', $data['produk_id'])->where('status_checkout', 'Keranjang');
		if ($om->exists()) {
			$jumlah = $om->first()->jumlah;
			$om->update([
				'jumlah' => $jumlah + $data['jumlah'],
			]);
			return response()->json(['message' => 'berhasil menambahkan Order']);
		}
		$order = OrderMapping::create($data);

		return response()->json(['message' => 'berhasil menambahkan Order']);
	}




	public function show(OrderMapping $orderMap)
	{
		$gambar = array();
		foreach ($orderMap->produk->images as $image) {
			array_push($gambar, $image->path_image);
		}
		$showData = [
			'id' => $orderMap->id . '',
			'jumlah' => $orderMap->jumlah,
			'status_checkout' => $orderMap->status_checkout,
			'tanggal' => $orderMap->created_at->format('d-m-Y'),
			'jam' => $orderMap->created_at->format('H:i'),
			'pembeli' => $orderMap->pembeli->nama_lengkap,
			'nomor_hp_pembeli' => $orderMap->pembeli->nomor_hp,
			'email_pembeli' => $orderMap->pembeli->email,
			'alamat_pembeli' => $orderMap->pembeli->alamat,
			'status_feedback' => $orderMap->status_feedback,
			'produk' => [
				'id' => $orderMap->produk_id . '',
				'penjual' => $orderMap->produk->penjual->nama_lengkap,
				'nama' => $orderMap->produk->nama,
				'harga' => $orderMap->produk->harga,
				'stok' => $orderMap->produk->stok,
				'keterangan' => $orderMap->produk->keterangan,
				'total_feedback' => $orderMap->produk->total_feedback,
				'gambar' => $gambar,
				'potongan' => $orderMap->produk->promo_id ? $orderMap->produk->promo->potongan : 0,
				'periode_awal' => $orderMap->produk->promo_id ? $orderMap->produk->promo->awal_periode : '',
				'periode_akhir' => $orderMap->produk->promo_id ? $orderMap->produk->promo->akhir_periode : '',
				'promo_nama' => $orderMap->produk->promo_id ? $orderMap->produk->promo->nama : '',
				'promo_id' => $orderMap->produk->promo_id,

			]
		];
		return response()->json($showData);
	}


	public function destroy(OrderMapping $orderMap)
	{
		// if ($order->status_checkout === 'Keranjang')
		$orderMap->delete();
		return response()->json(['message' => 'berhasil mendelete dari keranjang']);
	}

	public function update(OrderMapping $orderMap)
	{
		$data = request()->all();
		$orderMap->update($data);

		return response()->json(['message' => 'berhasil mengupdate order']);
	}

	public function getOrderByCheckout($status, User $user)
	{
		$showData = array();
		$today = strtotime(now());

		$orders = OrderMapping::where('status_checkout', '=', $status)->where('pembeli_id', '=', $user->id)->get();
		// ->whereNotIn('status_order', ['Batal', 'Selesai'])
		// $orders = Order::where('status_checkout', '=', $status)->where('pembeli_id', '=', $user->id)->get();
		foreach ($orders as $row) {
			// expired 2 hari kemudian
			$gambar = array();
			foreach ($row->produk->images as $image) {
				array_push($gambar, $image->path_image);
			}
			array_push($showData, [
				'id' => $row->id . '',
				'jumlah' => $row->jumlah,
				'status_checkout' => $row->status_checkout,
				'tanggal' => $row->created_at->format('d-m-Y'),
				'jam' => $row->created_at->format('H:i'),
				'pembeli' => $row->pembeli->nama_lengkap,
				'nomor_hp_pembeli' => $row->pembeli->nomor_hp,
				'email_pembeli' => $row->pembeli->email,
				'alamat_pembeli' => $row->pembeli->alamat,
				'status_feedback' => $row->status_feedback,
				'produk' => [
					'id' => $row->produk_id . '',
					'penjual' => $row->produk->penjual->nama_lengkap,
					'id_penjual' => $row->produk->penjual_id,
					'username_penjual' => $row->produk->penjual->username,
					'nomor_hp_penjual' => $row->produk->penjual->nomor_hp,
					'email_penjual' => $row->produk->penjual->email,
					'alamat_penjual' => $row->produk->penjual->alamat,
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

	public function addQuantity(OrderMapping $order)
	{
		if ($order->jumlah + 1 <= $order->produk->stok) {
			$order->update(['jumlah' => $order->jumlah + 1]);
		} else
			return response()->json(['message' => 'stok terbatas']);

		return response()->json(['message' => 'jumlah ditambah 1']);
	}

	public function minusQuantity(OrderMapping $order)
	{


		if ($order->jumlah - 1 <= $order->produk->stok && $order->jumlah - 1 >= 1) {

			$order->update(['jumlah' => $order->jumlah - 1]);
		} else
			return response()->json(['message' => 'gagal']);

		return response()->json(['message' => 'jumlah dikurang 1']);
	}


	// public function changeCheckoutStatus(OrderMapping $order)
	// {
	// 	$validator = Validator::make(request()->all(), [
	// 		'status_checkout' => 'required'
	// 	]);


	// 	if ($validator->fails()) {
	// 		return response()->json(['message' => $validator->errors()]);
	// 	}
	// 	$data = request()->validate(
	// 		[
	// 			'status_checkout' => 'required'
	// 		]
	// 	);

	// 	$order->update($data);
	// 	if ($data['status_checkout'] == 'Beli') {
	// 		// hitung harga checkout
	// 		$hargaTotalProduk = $order->jumlah * $order->produk->harga;
	// 		if ($order->produk->promo_id) {
	// 			$promo = $hargaTotalProduk * ((float) $order->produk->promo->potongan) / 100;
	// 			$hargaTotalProduk = $hargaTotalProduk - $promo;
	// 		}
	// 		$order->update(['total_harga' => $hargaTotalProduk]);
	// 		$order->produk->update(['stok' => ($order->produk->stok - $order->jumlah)]);

	// 		if ($order->produk->penjual->notificationTokens) {
	// 			foreach ($order->produk->penjual->notificationTokens as $notif) {
	// 				$this->sendNotification($notif->notificationToken, 'Pesanan Datang', 'Hai ' . $order->produk->penjual->nama_lengkap . ', Pesanan baru diterima');
	// 			}
	// 		}
	// 	}

	// 	return response()->json(['message' => 'berhasil merubah status checkout']);
	// }
}
