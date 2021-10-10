<?php

namespace App\Models;

use App\Models\User;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'feedbacks';

    protected $fillable = [
        'produk_id',
        'user_id',
        'komentar',
        'rating',
    ];

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('komentar', 'like', '%'.$query.'%')
                ->orWhere('rating', 'like', '%'.$query.'%');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
