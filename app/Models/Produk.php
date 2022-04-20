<?php

namespace App\Models;

use App\Models\User;
use App\Models\Promo;
use App\Models\Feedback;
use App\Models\OrderMapping;
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
        'satuan',
        'jumlah_per_satuan',
    ];

    protected $table = 'produks';

    // saat delete. akan delete childnya juga
    protected static function booted()
    {
        // static::deleting(function ($produk) {
        //     $produk->orders()->delete();
        //     $produk->order_mappings()->delete();
        //     $produk->feedbacks()->delete();
        // });
    }

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('nama', 'like', $term)
                ->orWhere('harga', 'like', $term)
                ->orWhere('stok', 'like', $term)
                ->orWhere('satuan', 'like', $term);
        });
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class)->withTrashed();
    }

    public function order_mappings()
    {
        return $this->hasMany(OrderMapping::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_mappings', 'produk_id', 'order_id');
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function penjual()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class)->withTrashed();
    }
}
