<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ProductStatus;
use Str;

class ProductStatusTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(ProductStatus $product_status)
  {
    return [
      'id' => (int)$product_status->id,
      'status' => (string)Str::title($product_status->status),
    ];
  }
}
