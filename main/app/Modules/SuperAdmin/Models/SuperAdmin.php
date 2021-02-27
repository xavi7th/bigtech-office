<?php

namespace App\Modules\SuperAdmin\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;

class SuperAdmin extends User
{
  protected $fillable = [];
  protected $table = 'he_control';
  const DASHBOARD_ROUTE_PREFIX = 'super-panel';

  public function is_verified()
  {
    return true;
  }

  protected static function booted()
  {
    static::addGlobalScope('safeRecords', function (Builder $builder) {
      $builder->where('id', '>', 1);
    });
  }
}
