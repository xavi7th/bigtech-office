<?php

namespace App\Modules\DispatchAdmin\Models;

use App\User;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SuperAdmin\Traits\IsAStaff;

class DispatchAdmin extends User
{
  protected $fillable = [];
  // const DASHBOARD_ROUTE_PREFIX = 'dispatch-admins';

  // public function product_sales_record()
  // {
  //   return $this->morphMany(ProductSaleRecord::class, 'sales_rep');
  // }
}
