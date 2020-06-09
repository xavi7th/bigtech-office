<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ProductBatch;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;


class ProductBatchTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(ProductBatch $product_batch)
  {
    return [
      'id' => (int)$product_batch->id,
      'batch_number' => (string)$product_batch->batch_number,
      'order_date' => (string)$product_batch->order_date->toDateString(),
    ];
  }

  public function transformWithComment(ProductBatch $product_batch)
  {
    return [
      'id' => (int)$product_batch->id,
      'batch_number' => $product_batch->batch_number,
      'order_date' => $product_batch->order_date,
      'comments' => (new UserCommentTransformer)->collectionTransformer($product_batch->comments, 'commentDetails'),
    ];
  }
}
