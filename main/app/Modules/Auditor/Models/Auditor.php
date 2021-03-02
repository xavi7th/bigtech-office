<?php

namespace App\Modules\Auditor\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\SuperAdmin\Traits\IsAStaff;

class Auditor extends User
{

  use IsAStaff;

  protected $fillable = ['full_name', 'email', 'password', 'phone', 'avatar', 'gender', 'address', 'office_branch_id', 'is_active'];
  const DASHBOARD_ROUTE_PREFIX = 'auditor-panel';

  static function superAdminRoutes()
  {
    self::staffRoutes();
  }
}
