<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ProductColor;

class ProductColorTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return $collection->map(function ($v) use ($transformerMethod) {
      return $this->$transformerMethod($v);
    });
  }

  public function basic(ProductColor $productColor)
  {
    return [
      'id' => (int)$productColor->id,
      'name' => (string)$productColor->name,
      'products_count' => (int)$productColor->products_count
    ];
  }
}
