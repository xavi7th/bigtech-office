<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ProductCategory;

class ProductCategoryTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return [
      'product_categories' => $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      })
    ];
  }

  public function basic(ProductCategory $product_category)
  {
    return [
      'id' => (int)$product_category->id,
      'name' => (string)$product_category->name,
      'img_url' => (string)$product_category->img_url,
    ];
  }
}
