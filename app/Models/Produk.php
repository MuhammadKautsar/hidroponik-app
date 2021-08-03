<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Feedback;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'gambar',
        'nama',
        'harga',
        'stok',
    ];

    protected $table='produks';

    public function feedbacks(){
        return $this->hasMany(Feedback::class);
    }

    public function images(){
        return $this->hasMany(Image::class);
    }
}
