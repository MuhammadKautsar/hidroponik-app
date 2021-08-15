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
                            ->orWhere('level','LIKE','%'.$request->search.'%')->paginate(4);
        }else{
            $data_user=User::paginate(4);
        }
        return view('pages.users', compact('data_user'));
    }

    public function create(Request $request)
    {
        $user = new User;
        $user->nama_lengkap = $request->input('nama_lengkap');
        $user->username = $request->input('username');
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

    /**
     * To update Status of User
     *
     * @param  Integer $user_id
     * @param  Integer $status_code
     * @return Success Response.
     */
    public function updateStatus($user_id, $status_code)
    {
        try {
            $update_user = User::whereId($user_id)->update([
                'status' => $status_code
            ]);

            if($update_user){
                return redirect()->route('users')->with('success', 'User Status Update Successfully.');
            }

            return redirect()->route('users')->with('error', 'Fail to Update User Status.');

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
