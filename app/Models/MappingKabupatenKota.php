<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MappingKabupatenKota extends Model
{
  use HasFactory;

  //protected $hidden = ['created_at', 'updated_at'];

  protected $table = 'mapping_kabupaten_kotas';

  protected $fillable = [
    'kode',
  ];
}
