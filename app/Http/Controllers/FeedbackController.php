<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Produk;
use App\Models\User;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedbacks=Feedback::latest()->get();
        // $produks=Produk::all();
        // $users=User::all();
        return view('pages.feedbacks', compact('feedbacks'));
    }
}
