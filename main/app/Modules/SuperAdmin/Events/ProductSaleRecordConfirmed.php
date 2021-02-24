<?php

namespace App\Modules\SuperAdmin\Events;

use Illuminate\Queue\SerializesModels;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;

class ProductSaleRecordConfirmed
{
  use SerializesModels;

  public $productSaleRecord;

  /**
   * Create a new event instance.
   *
   * @return void
   */
  public function __construct(ProductSaleRecord $productSaleRecord)
  {
    $this->$productSaleRecord = $productSaleRecord;
  }
}
