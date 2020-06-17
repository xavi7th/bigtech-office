<?php

namespace App\Modules\Admin\Models;

use App\User;

class Admin extends User
{
  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'admin-panel';

  public function is_verified()
  {
    return $this->verified_at !== null;
  }
}
