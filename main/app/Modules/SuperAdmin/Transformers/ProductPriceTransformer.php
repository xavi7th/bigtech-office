<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ProductPrice;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;

class ProductPriceTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(ProductPrice $product_price): array
  {
    return [
      'id' => (int)$product_price->id,
      'color' => (string)$product_price->product_color->name,
      'grade' => (string)$product_price->product_grade->grade,
      'model' => (string)$product_price->product_model->name,
      'supplier' => (string)$product_price->product_supplier->name,
      'storage_size' => (string)$product_price->storage_size->human_size,
      'batch_number' => (string)$product_price->product_batch->batch_number,
      'order_date' => (string)$product_price->product_batch->order_date,
      'cost_price' => $product_price->cost_price,
      'proposed_selling_price' => $product_price->proposed_selling_price,
    ];
  }

  public function transformWithComment(ProductPrice $product_price)
  {
    return [
      'id' => (int)$product_price->id,
      'batch_number' => $product_price->batch_number,
      'order_date' => $product_price->order_date,
      'comments' => (new UserCommentTransformer)->collectionTransformer($product_price->comments, 'commentDetails'),
    ];
  }
}
