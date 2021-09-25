<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Livewire\WithPagination;

class ListUsers extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $state = [];

    // public $level;

    public function pengguna(Request $request)
    {
        if($request->has('search')){
            $data_user=User::where('nama_lengkap','LIKE','%'.$request->search.'%')
                            ->orWhere('level','LIKE','%'.$request->search.'%')->paginate(4);
        }else{
            $data_user=User::paginate(4);
        }
        return view('livewire.list-users', compact('data_user'));
    }

    public function addNew()
    {
        $this->dispatchBrowserEvent('show-form');
    }

    public function createUser()
    {
        $validateData = Validator::make($this->state, [
            'nama_lengkap' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            // 'level' => 'required',
        ])->validate();

        $validateData['password'] = bcrypt($validateData['password']);

        User::create($validateData);

        $this->dispatchBrowserEvent('hide-form');

        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.list-users', ['data_user' => User::paginate(4)])
        ->extends('layouts.app')
        ->section('content');
    }
}
