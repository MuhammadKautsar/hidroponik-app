<?php

namespace App\Models;

use App\Models\User;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use SoftDeletes;
    use HasFactory;

    //protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'orders';
    protected $fillable = [
        'pembeli_id',
        'produk_id',
        'jumlah',
        'total_harga',
        'status_checkout',
        'status_order',
        'harga_jasa_pengiriman',
        'status_feedback',
    ];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('jumlah', 'like', '%' . $query . '%')
            ->orWhere('status_order', 'like', '%' . $query . '%');
    }

    public function pembeli()
    {
        return $this->belongsTo(User::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
