<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderMapping extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'order_mappings';
    protected $fillable = [
        'pembeli_id',
        'produk_id',
        'order_id',
        'status_checkout',
        'status_feedback',
        'jumlah',
    ];

    public function pembeli()
    {
        return $this->belongsTo(User::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
