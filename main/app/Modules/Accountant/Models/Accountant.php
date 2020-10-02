<?php

namespace App\Modules\Accountant\Models;

use App\User;

class Accountant extends User
{
  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'accountant-panel';

  public function is_verified()
  {
    return $this->verified_at !== null;
  }
}
