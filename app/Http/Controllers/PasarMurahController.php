<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasarMurah;

class PasarMurahController extends Controller
{
    public function index()
    {
        return view('pasarmurah.index');
    }

    public function create()
    {
        return view('pasarmurah.create');
    }

    public function store(Request $request)
    {
        $pasar = new PasarMurah;
        $pasar->name = $request->input('name');
        $pasar->email = $request->input('email');
        $pasar->course = $request->input('course');
        if($request->hasfile('profile_image'))
        {
            $file = $request->file('profile_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('uploads/pasar_murahs/', $filename);
            $pasar->profile_image = $filename;
        }
        $pasar->save();
        return redirect()->back()->with('status','image success');
    }
}
