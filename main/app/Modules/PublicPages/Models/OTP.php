<?php

namespace App\Modules\PublicPages\Models;

use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
  protected $fillable = ['code'];
  protected $table = 'otps';
  protected $casts = [
    'code' => 'int'
  ];
}
