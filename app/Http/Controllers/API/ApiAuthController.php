<?php

namespace App\Http\Controllers\API;

use App\Models\User;

use App\Models\Produk;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NotificationToken;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{

    public function register(Request $request)
    {
        // TODO: tambah username kemudian hari
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:users',
            'nomor_hp' => 'required|max:13',
            'password' => 'required',
            'username' => 'required|unique:users'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors(), 'type' => 'failed', 'user' => '', 'token' => '']);
        }

        $data = $request->validate([
            'nama_lengkap' => 'required',
            'email' => 'required|email|unique:users',
            'nomor_hp' => 'required|max:13',
            'password' => 'required',
            'username' => 'required|unique:users'
        ]);

        $data['level'] = 'pembeli';
        $data['status'] = 1;
        $data['alamat'] = '';
        $data['password'] = Hash::make($data['password']);


        $user = User::create($data);
        $token = Str::random(50);
        return response()->json(['message' => $data['nama_lengkap'] . ' berhasil membuat akun', 'user' => $user, 'type' => 'success', 'token' => $token]);
    }

    public function storeAlamat(User $user)
    {
        $validator = Validator::make(request()->all(), [
            'alamat' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }

        $data = request()->validate([
            'alamat' => 'required|string',

        ]);

        $user->update($data);

        return response()->json(['message' => 'Berhasil melengkapi akun']);
    }

    public function updateProfil(User $user)
    {
        $data = request()->all();
        $user->update($data);

        if (request()->hasFile('gambar')) {
            $file = request()->file('gambar');
            // $file = $request->file('gambar');
            $imgName = time() . '_' . $file->getClientOriginalName();
            $file->move($this->path_file('/images'), $imgName);
            $user->update(['profile_image' => asset('images/' . $imgName)]);
        }


        return response()->json(['message' => 'Berhasil mengupdate profil']);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'notificationToken' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }

        $data = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'notificationToken' => 'required'
        ]);

        $user = User::where('email', $data['email'])->where('status', 1)->first();
        if (!$user) {
            return response()->json(['message' => ['email' => 'email tidak valid']]);
        }
        if (!Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => ['password' =>
            'password tidak valid']]);
        }

        $isChecked = NotificationToken::where('notificationToken',  $data['notificationToken'])->first();
        if (!$isChecked)
            NotificationToken::create(
                [
                    'notificationToken' => $data['notificationToken'],
                    'user_id' => $user->id
                ]
            );
        $this->sendNotification($data['notificationToken'], 'Login', 'Selamat ' . $user['name'] . ' berhasil login');
        // // TODO: belum ada atribut notificationTokens. tolong ditambahkan tabel kedepannya

        $token = Str::random(50);
        return response()->json(['message' => 'berhasil login', 'user' => $user, 'token' => $token]);
        // return response()->json(['message' => 'berhasil login', 'user' => $user]);
    }

    public function logout(User $user)
    {
        $validator = Validator::make(request()->all(), [
            'notificationToken' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()]);
        }

        $data = request()->validate([
            'notificationToken' => 'required',
        ]);

        NotificationToken::where('notificationToken', '=', $data['notificationToken'])->where('user_id', '=', $user->id)->delete();


        return response()->json(['message' => 'Berhasil logout']);
    }

    // notifikasi untuk si user hp
    private function sendNotification($to, $title, $body)
    {
        $post = [
            'to' => $to,
            'title' => $title,
            'body'   => $body,
        ];
        // persiapkan curl
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "https://exp.host/--/api/v2/push/send");

        // return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt(
            $ch,
            CURLOPT_POSTFIELDS,
            $post
        );
        // $output contains the output string
        $output = curl_exec($ch);

        // tutup curl
        curl_close($ch);

        // menampilkan hasil curl
        return  $output;
    }
    private function path_file($value)
    {
        return public_path($value);
    }
}
