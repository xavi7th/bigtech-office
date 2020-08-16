<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ProductCategory;

class ProductCategoryTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return $collection->map(function ($v) use ($transformerMethod) {
      return $this->$transformerMethod($v);
    });
  }

  public function basic(ProductCategory $productCategory)
  {
    return [
      'id' => (int)$productCategory->id,
      'name' => (string)$productCategory->name,
      'img_url' => (string)$productCategory->img_url,
      'products_count' => (int)$productCategory->products_count,
    ];
  }
}
