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

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function($query) use ($term) {
            $query->where('total_harga', 'like', $term)
                ->orWhere('created_at', 'like', $term)
                ->orWhere('status_order', 'like', $term);
        });
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
