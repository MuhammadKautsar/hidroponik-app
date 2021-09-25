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
        $feedbacks=Feedback::latest()->paginate(5);
        $data_product=Produk::all();
        // $users=User::all();
        return view('pages.feedbacks', compact('feedbacks', 'data_product'));
    }

    public function indexAdmin()
    {
        $feedbacks=Feedback::latest()->paginate(5);
        // $produks=Produk::all();
        // $users=User::all();
        return view('admin.umpanbalik', compact('feedbacks'));
    }

    public function destroy($id)
    {
        $feedback = Feedback::find($id);
        $feedback->delete();
        return redirect('/ulasan')->with('sukses','Data berhasil dihapus');
    }

    public function destroyAdmin($id)
    {
        $feedback = Feedback::find($id);
        $feedback->delete();
        return redirect('/umpanbalik')->with('sukses','Data berhasil dihapus');
    }
}
