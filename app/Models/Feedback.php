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

    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        $query->where(function ($query) use ($term) {
            $query->where('komentar', 'like', $term)
                ->orWhere('rating', 'like', $term);
        });
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
