<?php

namespace App\Modules\QualityControl\Models;

use App\User;

class QualityControl extends User
{
  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'quality-control-panel';

  public function is_verified()
  {
    return $this->verified_at !== null;
  }

  static function findByEmail(string $email)
  {
    return self::whereEmail($email)->first();
  }
}
