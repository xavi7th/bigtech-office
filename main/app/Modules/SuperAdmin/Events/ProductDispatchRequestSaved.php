<?php

namespace App\Modules\SuperAdmin\Events;

use App\Modules\SalesRep\Models\ProductDispatchRequest;
use Illuminate\Queue\SerializesModels;

class ProductDispatchRequestSaved
{
  use SerializesModels;

  public $productDispatchRequest;

  public function __construct(ProductDispatchRequest $productDispatchRequest)
  {
    $this->productDispatchRequest = $productDispatchRequest;
  }
}
