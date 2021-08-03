<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\Models\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    {
        return view('users.index');
    }

    public function penjual()
    {
        $data_penjual=User::all();
        return view('pages.sellers', compact('data_penjual'));
    }

    public function pembeli()
    {
        $data_pembeli=User::all();
        return view('pages.buyers', compact('data_pembeli'));
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/penjual')->with('sukses','Data berhasil dihapus');
    }
}
