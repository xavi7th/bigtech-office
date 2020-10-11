<?php

namespace App\Modules\StockKeeper\Models;

use App\User;

class StockKeeper extends User
{
  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'stock-panel';

  public function is_verified()
  {
    return $this->verified_at !== null;
  }
}
