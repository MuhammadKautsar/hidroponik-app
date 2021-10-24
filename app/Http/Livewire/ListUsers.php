<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
            'level' => $this->level
        ];

        $validateData = Validator::make($data, [
            'nama_lengkap' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'level' => 'required',
        ])->validate();

        $validateData['password'] = bcrypt($validateData['password']);

        User::create($validateData);

        $this->dispatchBrowserEvent('hide-form');
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
    }
}
