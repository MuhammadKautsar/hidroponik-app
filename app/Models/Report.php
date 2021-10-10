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

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('isi_laporan', 'like', '%'.$query.'%')
                ->orWhere('tanggal', 'like', '%'.$query.'%');
    }

    public function pembeli()
    {
        return $this->belongsTo(User::class, 'pembeli_id');
    }

    public function penjual()
    {
        return $this->belongsTo(User::class, 'penjual_id');
    }
}
