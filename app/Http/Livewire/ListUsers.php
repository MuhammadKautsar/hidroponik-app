<?php

namespace App\Http\Livewire;

use App\Models\RefKabupatenKota;
use App\Models\RefKecamatan;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ListUsers extends Component
{
    use WithPagination;
    use WithFileUploads;
    protected $paginationTheme = 'bootstrap';

    public $nama_lengkap;
    public $username;
    public $email;
    public $password;
    public $level;
    public $nomor_hp;
    public $alamat;
    public $kotas;
    public $kota_kab;
    public $kecamatans;
    public $foto_ktp;

    public $selectedKota = null;
    public $selectedKecamatan = null;

    public $sortBy = 'created_at';

    public $sortDirection = 'desc';
    public $byLevel = null;
    public $perPage = 10;
    public $search = '';

    protected $queryString = ['search' => ['except' => '']];

    public function sortBy($field)
    {
        if ($this->sortDirection == 'asc') {
            $this->sortDirection = 'desc';
        } else {
            $this->sortDirection = 'asc';
        }

        return $this->sortBy = $field;
    }

    public function mount()
    {
        $this->kotas = RefKabupatenKota::whereIn('kode', function ($query) {
            $query->select('kode')
                ->from('mapping_kabupaten_kotas');
        })->get();
        $this->kecamatans = collect();
    }

    public function updatedSelectedKota($kota)
    {
        $this->kecamatans = RefKecamatan::whereRaw("SUBSTR(kode,1,5) = ?", [$kota])->get();
    }

    public function addNew()
    {
        $this->dispatchBrowserEvent('show-form');
    }

    public function createUser()
    {
        $kabs = RefKabupatenKota::whereIn('kode', function ($query) {
            $query->select('kode')
                ->from('mapping_kabupaten_kotas');
        })->get();

        foreach($kabs as $kab){
            if($this->selectedKota == $kab->kode){
                $this->kota_kab = $kab->nama;
            }
        }

        if($this->level == 'penjual'){
            $filename = $this->foto_ktp->store('foto_ktp', 'public');
            $data = [
                'nama_lengkap' => $this->nama_lengkap,
                'username' => $this->username,
                'email' => $this->email,
                'password' => $this->password,
                'level' => $this->level,
                'nomor_hp' => $this->nomor_hp,
                'alamat' => $this->alamat,
                'kota' => $this->kota_kab,
                'kecamatan' => $this->selectedKecamatan,
                'foto_ktp' => $filename,
            ];

            $validateData = Validator::make($data, [
                'nama_lengkap' => 'required',
                'username' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:5',
                'level' => 'required',
                'nomor_hp' => 'required|numeric|digits_between:11,13',
                'alamat' => 'required',
                'kota' => 'required',
                'kecamatan' => 'required',
                'foto_ktp' => 'required',
            ])->validate();
        }

        else{
            $data = [
                'nama_lengkap' => $this->nama_lengkap,
                'username' => $this->username,
                'email' => $this->email,
                'password' => $this->password,
                'level' => $this->level,
                'nomor_hp' => $this->nomor_hp,
                'alamat' => $this->alamat,
                'kota' => $this->kota_kab,
                'kecamatan' => $this->selectedKecamatan,
            ];
            $validateData = Validator::make($data, [
                'nama_lengkap' => 'required',
                'username' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:5',
                'level' => 'required',
                'nomor_hp' => 'required|numeric|digits_between:11,13',
                'alamat' => 'required',
                'kota' => 'required',
                'kecamatan' => 'required',
            ])->validate();
        }

        $validateData['password'] = bcrypt($validateData['password']);

        $user = User::create($validateData);

        event(new Registered($user));

        $this->dispatchBrowserEvent('hide-form');
        $this->resetValidation();
        $this->clear();
        return redirect()->back();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.list-users', [
            'data_user' => User::when($this->byLevel, function($query){
                $query->where('level', $this->byLevel);
            })
            ->search(trim($this->search))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage),])
            ->extends('layouts.app')
            ->section('content');
    }

    private function clear()
    {
        $this->nama_lengkap = null;
        $this->username = null;
        $this->email = null;
        $this->password = null;
        $this->level = null;
        $this->nomor_hp = null;
        $this->alamat = null;
        $this->foto_ktp = null;
        $this->selectedKota = null;
        $this->selectedKecamatan = null;
    }
}
