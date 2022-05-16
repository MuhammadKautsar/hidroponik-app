<?php

namespace App\Http\Controllers;

use App\Models\RefKecamatan;
use Illuminate\Http\Request;
use App\Models\RefKabupatenKota;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('profile.edit');
    }

    public function getkecamatan(Request $request)
    {
        $kode_kota = $request->kode_kota;

        $kecamatans = RefKecamatan::whereRaw("SUBSTR(kode,1,5) = ?", [$kode_kota])->get();

        foreach ($kecamatans as $kecamatan){
            echo "<option value='$kecamatan->nama'>$kecamatan->nama</option>";
        }
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        auth()->user()->update($request->all());
        if($request->hasFile('profile_image')){
            $files=$request->file('profile_image');
            $imageName=time().'_'.$files->getClientOriginalName();
            $request['profile_image']=$imageName;
            $files->move($this->path_file('/images'),$imageName);
            auth()->user()->profile_image = asset('images/' . $imageName);
            auth()->user()->save();
        }

        $kabs = RefKabupatenKota::whereIn('kode', function ($query) {
            $query->select('kode')
                ->from('mapping_kabupaten_kotas');
        })->get();

        foreach($kabs as $kab){
            if(auth()->user()->kota == $kab->kode){
                auth()->user()->kota = $kab->nama;
                auth()->user()->save();
            }
        }

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }

    private function path_file($value)
    {
        // TODO: saat upload ke server mtsn. comment line dibawah ini dan uncomment yang bagian ada public_htmlnya
        return public_path($value);
        // return public_path('../../public_html/hidroponik' . $value);
    }
}
