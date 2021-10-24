<?php

namespace App\Models;

use App\Models\Produk;
use App\Models\Report;
use App\Models\Feedback;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_lengkap',
        'username',
        'email',
        'nomor_hp',
        'alamat',
        'password',
        'status',
        'level',
        'profile_image',
    ];

    // saat delete. akan delete childnya juga
    protected static function booted()
    {
        static::deleting(function ($user) {
            $user->produks()->delete();
            $user->reportpenjuals()->delete();
            $user->reportpembelis()->delete();
            $user->orders()->delete();
            $user->notificationTokens()->delete();
        });
    }

    public static function search($query)
    {
        return empty($query) ? static::query()
            : static::where('nama_lengkap', 'like', '%'.$query.'%')
                ->orWhere('email', 'like', '%'.$query.'%')
                ->orWhere('level', 'like', '%'.$query.'%');
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function produks()
    {
        return $this->hasMany(Produk::class, 'penjual_id');
    }

    public function repots()
    {
        return $this->hasMany(Report::class);
    }
    public function reportpenjuals()
    {
        return $this->hasMany(Report::class, 'penjual_id');
    }
    public function reportpembelis()
    {
        return $this->hasMany(Report::class, 'pembeli_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'pembeli_id');
    }

    public function notificationTokens()
    {
        return $this->hasMany(NotificationToken::class, 'user_id');
    }

    public function getProfileImage()
    {
        if (!$this->profile_image) {
            return asset('images/default.png');
        }

        return  $this->profile_image;
    }
}
