<?php

namespace App\Models;

use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promo extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'promos';
    protected $dates = ['awal_periode', 'akhir_periode'];
    protected $fillable = ['nama', 'potongan', 'awal_periode', 'akhir_periode', 'keterangan'];

    // saat delete. akan delete childnya juga
    protected static function booted()
    {
        static::deleting(function ($promo) {
            foreach ($promo->produks as $produk) {
                $produk->update(array('promo_id' => NULL));
            }
        });
    }
    //

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('nama', 'like', '%' . $query . '%')
            ->orWhere('potongan', 'like', '%' . $query . '%')
            ->orWhere('awal_periode', 'like', '%' . $query . '%')
            ->orWhere('akhir_periode', 'like', '%' . $query . '%')
            ->orWhere('keterangan', 'like', '%' . $query . '%');
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

    public function setPromoDateAttribute($value)
    {
        $this->attributes['awal_periode'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
        $this->attributes['akhir_periode'] = Carbon::createFromFormat('d-m-Y', $value)->format('Y-m-d');
    }
}
