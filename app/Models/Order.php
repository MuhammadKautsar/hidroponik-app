<?php

namespace App\Models;

use App\Models\User;
use App\Models\OrderMapping;
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
        'penjual_id',
        'total_harga',
        'status_order',
        'harga_jasa_pengiriman',
    ];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('total_harga', 'like', '%' . $query . '%')
            ->orWhere('status_order', 'like', '%' . $query . '%');
    }

    public function pembeli()
    {
        return $this->belongsTo(User::class, 'pembeli_id');
    }

    public function penjual()
    {
        return $this->belongsTo(User::class, 'penjual_id');
    }

    public function order_mappings()
    {
        return $this->hasMany(OrderMapping::class);
    }
}
