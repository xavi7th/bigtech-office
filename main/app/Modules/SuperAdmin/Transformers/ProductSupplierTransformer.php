<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ProductSupplier;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;

class ProductSupplierTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(ProductSupplier $product_supplier)
  {
    return [
      'id' => (int)$product_supplier->id,
      'name' => (string)$product_supplier->name,
    ];
  }

  public function transformWithComment(ProductSupplier $product_supplier)
  {
    return [
      'id' => (int)$product_supplier->id,
      'batch_number' => $product_supplier->batch_number,
      'order_date' => $product_supplier->order_date,
      'comments' => (new UserCommentTransformer)->collectionTransformer($product_supplier->comments, 'commentDetails'),
    ];
  }
}
