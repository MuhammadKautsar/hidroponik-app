<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Produk;
use App\Models\Image;
use App\Models\Promo;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class ListProducts extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $gambar = [];
    public $img = [];

    public $ids;
    public $nama;
    public $penjual_id;
    public $promo_id;
    public $harga;
    public $stok;
    public $harga_promo;
    public $keterangan;
    public $total_feedback;

    public $perPage = 10;
    public $sortField;
    public $sortAsc = true;
    public $search = '';

    public function addNew()
    {
        $this->clear();
        $this->dispatchBrowserEvent('show-form');
    }

    public function createProduk()
    {
        $this->validate([
            'gambar.*' => 'required|max:5000',
            'nama' => 'required',
            'harga' => 'required|numeric|digits_between:4,6',
            'stok' => 'required|numeric',
        ]);

        // $path = $this->gambar->store('produk','public');

        $data = new Produk;
        // $data->gambar = asset('storage/' . $path);
        $data->penjual_id = Auth::user()->id;
        $data->nama = $this->nama;
        $data->promo_id = $this->promo_id;
        $data->harga = $this->harga;
        $data->stok = $this->stok;
        $data->keterangan = $this->keterangan;
        $data->total_feedback = 0;

        if ($this->promo_id!=""){
            $data->harga_promo = $this->harga-$this->harga*$data->promo->potongan/100;
        } elseif ($this->promo_id="") {
            $data->harga_promo = "";
        }

        $data->save();

        foreach ($this->gambar as $gmbr) {
            $path = $gmbr->store('produk','public');

            $produk = new Image;
            $produk->path_image = asset('storage/' . $path);
            $produk->produk_id = $data->id;
            $produk->save();
        }

        $this->dispatchBrowserEvent('hide-form');
        session()->flash('sukses','Data berhasil diinput');
        $this->clear();
        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.list-products', ['data_product' => Produk::search($this->search)
        ->get(),], ['promo' => Promo::all()])
        ->extends('layouts.app')
        ->section('content');
    }

    private function clear()
    {
        $this->gambar = null;
        $this->nama = null;
        $this->harga = null;
        $this->promo_id = null;
        $this->stok = null;
        $this->keterangan = null;
    }

    public function removeImg($id)
    {
        array_splice($this->img, $id);
    }
}
