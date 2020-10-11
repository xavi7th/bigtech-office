<?php

namespace App\Modules\Admin\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;

class Admin extends User
{
  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'admin-panel';
  // protected $table = 'adm';

  public function is_verified()
  {
    return $this->verified_at !== null;
  }


  static function findByEmail(string $email)
  {
    return self::whereEmail($email)->first();
  }

  // protected static function booted()
  // {
  //   static::addGlobalScope('safeRecords', function (Builder $builder) {
  //     $builder->where('full_name', '<>', 'SysDef Admin');
  //   });
  // }
}
