<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Feedback;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'penjual_id',
        'promo_id',
        'nama',
        'harga',
        'stok',
        'total_feedback',
        'keterangan',
        'harga_promo',
    ];

    protected $table = 'produks';

    // saat delete. akan delete childnya juga
    protected static function booted()
    {
        static::deleting(function ($produk) {
            $produk->orders()->delete();
            $produk->feedbacks()->delete();
        });
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function penjual()
    {
        return $this->belongsTo(User::class);
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }
}
