<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RefKecamatan extends Model
{
  use SoftDeletes;
  use HasFactory;

  //protected $hidden = ['created_at', 'updated_at'];

  protected $table = 'ref_kecamatans';

  protected $fillable = [
    'kode',
    'nama',
  ];
}
