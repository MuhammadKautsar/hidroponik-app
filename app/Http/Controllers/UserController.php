<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
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
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'level' => 'required',
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
        else
        {
            $user = new User;
            $user->nama_lengkap = $request->input('nama_lengkap');
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->level = $request->input('level');
            $user->save();
            return response()->json([
                'status'=>200,
                'message'=>'Data berhasil diinput',
            ]);
        }

        return redirect('/pengguna')->with('sukses','Data berhasil diinput');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/admin/pengguna')->with('sukses','Data berhasil dihapus');
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
