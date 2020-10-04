<?php

namespace App\Modules\DispatchAdmin\Models;

use App\User;

class DispatchAdmin extends User
{
  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'dispatch-admin-panel';

  public function is_verified()
  {
    return $this->verified_at !== null;
  }
}
