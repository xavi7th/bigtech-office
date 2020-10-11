<?php

namespace App\Modules\WebAdmin\Models;

use App\User;

class WebAdmin extends User
{
  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'web-admin-panel';

  public function is_verified()
  {
    return $this->verified_at !== null;
  }

  static function findByEmail(string $email)
  {
    return self::whereEmail($email)->first();
  }
}
