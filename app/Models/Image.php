<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class Image extends Model
{
    use HasFactory;
    protected $fillable=[
        'image',
        'produk_id',
    ];

    public function produks(){
        return $this->belongsTo(Produk::class);
    }
}
