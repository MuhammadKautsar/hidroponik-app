<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Promo;
use Illuminate\Http\Request;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ListPromos extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $ids;
    public $gambar;
    public $nama;
    public $potongan;
    public $awal_periode;
    public $akhir_periode;
    public $keterangan;

    public $sortBy = 'created_at';

    public $sortDirection = 'desc';
    public $byLevel = null;
    public $perPage = 5;
    public $search = '';

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
        $this->clear();
        $this->dispatchBrowserEvent('show-form');
    }

    public function createPromo()
    {
        $this->validate([
            'gambar' => 'image|max:1024',
            'nama' => 'required',
            'potongan' => 'required|numeric',
            'awal_periode' => 'required|date',
            'akhir_periode' => 'required|date',
        ]);

        $path = $this->gambar->store('promo','public');

        $data = new Promo;
        $data->gambar = asset('storage/' . $path);
        $data->nama = $this->nama;
        $data->potongan = $this->potongan;
        $data->awal_periode = $this->awal_periode;
        $data->akhir_periode = $this->akhir_periode;
        $data->keterangan = $this->keterangan;
        $data->save();

        $this->dispatchBrowserEvent('hide-form');
        session()->flash('sukses','Data berhasil diinput');
        $this->clear();
        return redirect()->back();
    }

    // public function deletePromo()
    // {
    //     unlink(public_path('storage/'.$this->gambar));
    //     Promo::where('id', $this->ids)->delete();
    //     session()->flash('sukses','Data berhasil dihapus');
    //     $this->emit('deletepromo');
    // }

    public function sortBy($field)
    {
        if ($this->sortDirection == 'asc') {
            $this->sortDirection = 'desc';
        } else {
            $this->sortDirection = 'asc';
        }

        return $this->sortBy = $field;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = Promo::all();
        $today = strtotime(now());
        foreach ($data as $row) {
            $end =  strtotime($row->akhir_periode. " +1 days");
            if ($today > $end)
                $row->delete();
        }

        return view('livewire.list-promos', ['promo' => Promo::search($this->search)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage),])
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

    private function path_file($value)
    {
        return public_path($value);
    }
}
