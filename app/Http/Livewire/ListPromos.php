<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ListPromos extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $gambar;
    public $nama;
    public $potongan;
    public $awal_periode;
    public $akhir_periode;
    public $keterangan;

    public function pengguna(Request $request)
    {
        if($request->has('search')){
            $promo=Promo::where('gambar','LIKE','%'.$request->search.'%')
                            ->orWhere('keterangan','LIKE','%'.$request->search.'%')->paginate(4);
        }else{
            $promo=Promo::paginate(4);
        }
        return view('livewire.list-users', compact('promo'));
    }

    public function addNew()
    {
        $this->dispatchBrowserEvent('show-form');

        $this->gambar;
    }

    public function createPromo()
    {
        $data = [
            // 'gambar' => $this->gambar,
            'nama' => $this->nama,
            'potongan' => $this->potongan,
            'awal_periode' => $this->awal_periode,
            'akhir_periode' => $this->akhir_periode,
            'keterangan' => $this->keterangan
        ];

        $validateData = Validator::make($data, [
            'gambar' => 'image|max:1024',
            'nama' => 'required',
            'potongan' => 'required|numeric',
            'awal_periode' => 'required|date',
            'akhir_periode' => 'required|date',
            // 'keterangan' => 'required',
        ])->validate();

        $validateData['keterangan'] = $this->keterangan;

        // $this->gambar->store('gambar');

        Promo::create($validateData);

        $this->dispatchBrowserEvent('hide-form');
        $this->clear();
        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.list-promos', ['promo' => Promo::paginate(4)])
        ->extends('layouts.app')
        ->section('content');
    }

    private function clear()
    {
        $this->gambar = null;
        $this->nama = null;
        $this->potongan = null;
        $this->awal_periode = null;
        $this->akhir_periode = null;
        $this->keterangan = null;
    }
}
