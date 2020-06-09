<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ProductColor;

class ProductColorTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return [
      'product_colors' => $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      })
    ];
  }

  public function basic(ProductColor $product_color)
  {
    return [
      'id' => (int)$product_color->id,
      'name' => (string)$product_color->name,
    ];
  }
}
