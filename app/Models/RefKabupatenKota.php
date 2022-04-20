<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RefKabupatenKota extends Model
{
  use SoftDeletes;
  use HasFactory;

  //protected $hidden = ['created_at', 'updated_at'];

  protected $table = 'ref_kabupaten_kotas';

  protected $fillable = [
    'kode',
    'nama',
  ];
}
