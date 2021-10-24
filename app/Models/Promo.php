<?php

namespace App\Models;

use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promo extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'promos';
    protected $fillable = ['nama', 'potongan', 'awal_periode', 'akhir_periode', 'keterangan'];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('nama', 'like', '%'.$query.'%')
                ->orWhere('potongan', 'like', '%'.$query.'%');
    }

    public function produks()
    {
        return $this->hasMany(Produk::class);
    }

    public function getPromoImage()
    {
        if (!$this->gambar) {
            return asset('uploads/promos/no-image.png');
        }

        return  $this->gambar;
    }
}
