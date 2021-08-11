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
        $feedbacks=Feedback::latest()->paginate(1);
        // $produks=Produk::all();
        // $users=User::all();
        return view('pages.feedbacks', compact('feedbacks'));
    }

    function post(Request $request)
    {
        $feedback = new Feedback;
        $feedback->produk_id = $request->produk_id;
        $feedback->user_id = $request->user_id;
        $feedback->komentar = $request->komentar;
        $feedback->rating = $request->rating;
        
        $feedback->save();

        return response()->json(
            [
                "message" => "Succsess",
                "data" => $feedback
            ]
        );
    }
}
