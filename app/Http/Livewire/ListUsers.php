<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use App\Models\User;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Livewire\WithPagination;

class ListUsers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $nama_lengkap;
    public $username;
    public $email;
    public $password;
    public $level;
    public $nomor_hp;
    public $alamat;

    public $perPage = 5;
    public $sortField;
    public $sortAsc = true;
    public $search = '';

    protected $queryString = ['search' => ['except' => '']];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function addNew()
    {
        $this->dispatchBrowserEvent('show-form');
    }

    public function createUser()
    {
        $data = [
            'nama_lengkap' => $this->nama_lengkap,
            'username' => $this->username,
            'email' => $this->email,
            'password' => $this->password,
            'level' => $this->level,
            'nomor_hp' => $this->nomor_hp,
            'alamat' => $this->alamat,
        ];

        $validateData = Validator::make($data, [
            'nama_lengkap' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'level' => 'required',
            'nomor_hp' => 'required|numeric|digits_between:11,13',
            'alamat' => 'required',
        ])->validate();

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
        return view('livewire.list-users', ['data_user' => User::search($this->search)
        ->orderBy('created_at', 'desc')->paginate($this->perPage),], ['data_order' => Order::all()])
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
    }
}
