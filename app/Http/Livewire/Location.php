<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\RefKabupatenKota;
use App\Models\MappingKabupatenKota;
use Illuminate\Support\Facades\Validator;

class Location extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $sortBy = 'created_at';

    public $sortDirection = 'desc';
    public $perPage = 10;
    public $search = '';

    public $kode;
    public $selectedKota = null;

    public function mount()
    {
        $this->kotas = RefKabupatenKota::whereRaw("SUBSTR(kode,1,2) = ?", ['11'])->get();
        $this->kecamatans = collect();
    }

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

    public function saveLoc()
    {
        $data = [
            'kode' => $this->selectedKota,
        ];

        // $validateData = Validator::make($data, [
        //     'kode' => 'required',
        // ])->validate();

        $location = MappingKabupatenKota::all();
        $aktif = 0;

        foreach($location as $loc){
            if($this->selectedKota == $loc->kode){
                $aktif++;
            }
        }

        if($aktif==0 && $this->selectedKota != ""){
            MappingKabupatenKota::create($data);
            session()->flash('message', 'Data lokasi aktif berhasil ditambahkan');
        }elseif($aktif>0){
            session()->flash('error', 'Data lokasi aktif sudah ada');
        }
        elseif($this->selectedKota == ""){
            session()->flash('error', 'Data lokasi belum dipilih');
        }

        // MappingKabupatenKota::create($validateData);

        // MappingKabupatenKota::create([
        //     'kode' => $this->selectedKota]);

        $this->selectedKota = null;
    }

    public function remove($locationId)
    {
        $location = MappingKabupatenKota::find($locationId);

        $location->delete();

        session()->flash('message', 'Data lokasi aktif berhasil dihapus');
    }

    public function render()
    {
        return view('livewire.location', ['data_lokasi' => MappingKabupatenKota::all()])
            // ->orderBy($this->sortBy, $this->sortDirection)
            // ->paginate($this->perPage),])
            ->extends('layouts.app')
            ->section('content');
    }
}
