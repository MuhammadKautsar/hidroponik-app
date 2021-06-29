<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasarMurah extends Model
{
    use HasFactory;
    protected $table = 'pasar_murahs';
    protected $fillable = [
        'name',
        'email',
        'course',
        'profile_image',
    ];
}
