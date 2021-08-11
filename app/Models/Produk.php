<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Feedback;
use App\Models\User;
use App\Models\Promo;
use App\Models\Order;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'penjual_id',
        'promo_id',
        'nama',
        'harga',
        'stok',
        'total_feedback',
        'keterangan',
    ];

    protected $table='produks';

    public function feedbacks(){
        return $this->hasMany(Feedback::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }

    public function penjual(){
        return $this->belongsTo(User::class);
    }

    public function promo(){
        return $this->belongsTo(Promo::class);
    }
}
