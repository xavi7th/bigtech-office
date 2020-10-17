<?php

namespace App\Modules\DispatchAdmin\Models;

use App\User;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;

class DispatchAdmin extends User
{
  protected $fillable = [];
  const DASHBOARD_ROUTE_PREFIX = 'dispatch-admins';

  public function is_verified()
  {
    return $this->verified_at !== null;
  }

  public function product_sales_record()
  {
    return $this->morphMany(ProductSaleRecord::class, 'sales_rep');
  }


  static function findByEmail(string $email)
  {
    return self::whereEmail($email)->first();
  }
}
