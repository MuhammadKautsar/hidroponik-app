<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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

    function get()
    {
        $data = User::all();

        return response()->json(
            [
                "message" => "Succsess",
                "data" => $data
            ]
        );
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

    public function create(Request $request)
    {
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return redirect('/penjual')->with('sukses','Data berhasil diinput');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/penjual')->with('sukses','Data berhasil dihapus');
    }
}
