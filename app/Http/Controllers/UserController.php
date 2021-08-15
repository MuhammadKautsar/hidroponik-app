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

    public function pengguna(Request $request)
    {
        if($request->has('search')){
            $data_user=User::where('nama_lengkap','LIKE','%'.$request->search.'%')
                            ->orWhere('level','LIKE','%'.$request->search.'%')->paginate(3);
        }else{
            $data_user=User::paginate(3);
        }
        return view('pages.users', compact('data_user'));
    }

    public function create(Request $request)
    {
        $user = new User;
        $user->nama_lengkap = $request->input('nama_lengkap');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->level = $request->input('level');
        $user->save();
        return redirect('/pengguna')->with('sukses','Data berhasil diinput');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/pengguna')->with('sukses','Data berhasil dihapus');
    }
}
