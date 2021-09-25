<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use SoftDeletes;
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
