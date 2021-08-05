<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class Promo extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'promos';
    protected $fillable = ['nama','potongan','periode','keterangan'];

    public function produks(){
        return $this->hasMany(Produk::class);
    }
}
