<?php

namespace App\Http\Controllers\API;

use App\Models\Promo;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ApiPromoController extends Controller
{

    public function index()
    {
        $promos = array();
        $data = Promo::all();
        $today = strtotime(now());
        foreach ($data as $row) {
            $start =  strtotime($row->awal_periode);
            $end =  strtotime($row->akhir_periode);
            if (($today >= $start) && ($today <= $end))
                array_push($promos, [
                    'id' => $row->id,
                    'nama' => $row->nama,
                    'potongan' => $row->potongan,
                    'periode_awal' => $row->awal_periode,
                    'periode_akhir' => $row->akhir_periode,
                ]);
        }
        return response()->json($promos);
    }
}
