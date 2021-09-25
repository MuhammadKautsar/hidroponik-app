<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Report extends Model
{
    use HasFactory;

    //protected $hidden = ['created_at', 'updated_at'];

    protected $table = 'reports';

    protected $fillable = [
        'pembeli_id',
        'penjual_id',
        'isi_laporan',
        'tanggal',
    ];

    public function pembeli()
    {
        return $this->belongsTo(User::class, 'pembeli_id');
    }

    public function penjual()
    {
        return $this->belongsTo(User::class, 'penjual_id');
    }
}
