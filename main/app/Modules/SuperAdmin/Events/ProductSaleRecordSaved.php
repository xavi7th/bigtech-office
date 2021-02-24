<?php

namespace App\Modules\SuperAdmin\Events;

use Illuminate\Queue\SerializesModels;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;

class ProductSaleRecordSaved
{
  use SerializesModels;

  public $productSaleRecord;

  public function __construct(ProductSaleRecord $productSaleRecord)
  {
    $this->$productSaleRecord = $productSaleRecord;
  }
}
