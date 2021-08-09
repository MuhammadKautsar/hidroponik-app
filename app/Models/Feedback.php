<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;
use App\Models\User;

class Feedback extends Model
{
    use HasFactory;

    protected $table='feedbacks';

    public function produk(){
        return $this->belongsTo(Produk::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
