<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenjualController extends Controller
{
    public function welcome()
    {
        return view('penjual.welcome');
    }

    public function login()
    {
        return view('penjual.login');
    }

    public function register()
    {
        return view('penjual.register');
    }
}
