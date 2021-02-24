<?php

namespace App\Modules\SuperAdmin\Events;

use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use Illuminate\Queue\SerializesModels;

class ProductSaleRecordUpdated
{
  use SerializesModels;

  public $productSaleRecord;

  public function __construct(ProductSaleRecord $productSaleRecord)
  {
    $this->productSaleRecord = $productSaleRecord;
  }
}
