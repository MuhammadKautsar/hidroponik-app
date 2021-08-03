<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    function post(Request $request)
    {
        $report = new report;
        $report->laporan = $request->laporan;
        $report->pelapor = $request->pelapor;
        $report->penjual = $request->penjual;
        
        $report->save();

        return response()->json(
            [
                "message" => "Succsess",
                "data" => $report
            ]
        );
    }

    function get()
    {
        $data = report::all();

        return response()->json(
            [
                "message" => "Succsess",
                "data" => $data
            ]
        );
    }

    function getById($id)
    {
        $data = report::where('id', $id)->get();

        return response()->json(
            [
                "message" => "Succsess",
                "data" => $data
            ]
        );
    }

    function put($id, Request $request)
    {
        $report = report::where('id', $id)->first();
        if($report){
            $report->laporan = $request->laporan ? $request->laporan : $report->laporan;
            $report->pelapor = $request->pelapor ? $request->pelapor : $report->pelapor;
            $report->penjual = $request->penjual ? $request->penjual :$report->penjual;

            $report->save();
            return response()->json(
                [
                    "message" => "PUT Method Succsess ",
                    "data" => $report
                ]
            );
        }
        return response()->json(
            [
                "message" => "report with id " . $id . " not found"
            ], 400
        );
    }

    function delete($id)
    {
        $report = report::where('id', $id)->first();
        if($report) {
            $report->delete();
            return response()->json(
                [
                    "message" => "DELETE report id " . $id . " Success"
                ]
            );
        }
        return response()->json(
            [
                "message" => "report with id " . $id . " not found"
            ], 400
        );
    }

    public function index()
    {
        $data_report=report::all();
        return view('pages.reports', compact('data_report'));
    }

    public function destroy($id)
    {
        $report = Report::find($id);
        $report->delete();
        return redirect('/laporan')->with('sukses','Data berhasil dihapus');
    }
}
