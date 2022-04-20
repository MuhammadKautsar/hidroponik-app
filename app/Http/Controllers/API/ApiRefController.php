<?php

namespace App\Http\Controllers\API;

use App\Models\RefKecamatan;
use App\Models\RefKabupatenKota;
use App\Http\Controllers\Controller;

class ApiRefController extends Controller
{

    // getKabupaten
    public function getKabupaten()
    {
        // select refkabupatenkota where kode == mapping_kabupaten_kota
        $kabupaten = RefKabupatenKota::whereIn('kode', function ($query) {
            $query->select('kode')
                ->from('mapping_kabupaten_kotas');
        })->get();
        return response()->json(['message' => 'berhasil mendapatkan data kabupaten', 'type' => 'success', 'data' => $kabupaten]);
    }

    // getKecamatan
    public function getKecamatan($kabupaten)
    {
        // select refkecamatan where kode == mapping_kecamatan_kota
        $kecamatan = RefKecamatan::whereRaw("SUBSTR(kode,1,5) = ?", [$kabupaten])->get();
        return response()->json(['message' => 'berhasil mendapatkan data kecamatan', 'type' => 'success', 'data' => $kecamatan]);
    }
}
