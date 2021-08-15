<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Feedback;
use App\Models\Produk;
use App\Models\Report;
use App\Models\Order;

class User extends Authenticatable
{
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
        'level',
        'profile_image',
    ];

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

    public function feedbacks(){
        return $this->hasMany(Feedback::class);
    }

    public function orders(){
        return $this->hasMany(Order::class, 'pembeli_id');
    }

    public function produks(){
        return $this->hasMany(Produk::class, 'penjual_id');
    }

    public function repots(){
        return $this->hasMany(Report::class);
    }

    public function notificationTokens()
    {
        return $this->hasMany(NotificationToken::class, 'user_id');
    }

    public function getProfileImage(){
        if(!$this->profile_image){
            return asset('images/default.png');
        }

        return asset('images/'.$this->profile_image);
    }
}
