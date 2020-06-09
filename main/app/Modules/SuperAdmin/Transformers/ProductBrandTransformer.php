<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ProductBrand;

class ProductBrandTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return [
      'product_brands' => $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      })
    ];
  }

  public function basic(ProductBrand $product_brand)
  {
    return [
      'id' => (int)$product_brand->id,
      'name' => (string)$product_brand->name,
      'logo_url' => (string)$product_brand->logo_url,
    ];
  }
}
