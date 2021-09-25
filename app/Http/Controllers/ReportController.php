<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        if($request->has('search')){
            $data_report=report::where('nama','LIKE','%'.$request->search.'%')->paginate(5);
        }else{
            $data_report=report::paginate(5);
        }
        return view('pages.reports', compact('data_report'));
    }

    public function destroy($id)
    {
        $report = Report::find($id);
        $report->delete();
        return redirect('/laporan')->with('sukses','Data berhasil dihapus');
    }
}
