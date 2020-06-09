<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ResellerHistory;


class ResellerHistoryTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(ResellerHistory $reseller_history): array
  {
    return [
      'reseller' => (string)$reseller_history->reseller->business_name,
      'product' => (string)$reseller_history->product->primary_identifier(),
      'product_uuid' => (string)$reseller_history->product->product_uuid,
      'handler' => (string)$reseller_history->handler->full_name,
      'product_status' => (string)$reseller_history->product_status,
    ];
  }
}
