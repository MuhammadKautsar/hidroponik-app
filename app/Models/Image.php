<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class Image extends Model
{
    use HasFactory;
    protected $fillable=[
        'produk_id',
        'path_image',
    ];

    public function produks(){
        return $this->belongsTo(Produk::class);
    }
}
