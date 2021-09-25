<?php

namespace App\Http\Controllers\API;

use App\Models\Report;

use App\Models\Produk;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NotificationToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiReportController extends Controller
{

    public function reportUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pembeli_id' => 'required',
            'penjual_id' => 'required',
            'isi_laporan' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'type' => 'failed']);
        }

        $data = $request->validate([
            'pembeli_id' => 'required',
            'penjual_id' => 'required',
            'isi_laporan' => 'required'
        ]);

        $data['tanggal'] = date('Y-m-d');
 

        $report = Report::create($data);
        return response()->json(['message' => 'berhasil mereport pengguna', 'type' => 'success']);
    }

}