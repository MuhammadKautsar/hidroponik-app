<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Produk;

class Order extends Model
{
    use HasFactory;

    //protected $hidden = ['created_at', 'updated_at'];

    protected $table='orders';
    protected $fillable=[
        'pembeli_id',
        'produk_id',
        'jumlah',
        'total_harga',
        'status_checkout',
        'status_order',
        'tanggal',
    ];

    public function pembeli(){
        return $this->belongsTo(User::class);
    }

    public function produk(){
        return $this->belongsTo(Produk::class);
    }
}
