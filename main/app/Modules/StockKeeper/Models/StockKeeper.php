<?php

namespace App\Modules\StockKeeper\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\SuperAdmin\Traits\IsAStaff;

class StockKeeper extends User
{
  use IsAStaff;

  protected $fillable = [];
  // const DASHBOARD_ROUTE_PREFIX = 'stock-panel';

}
