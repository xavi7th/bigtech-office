<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ProductBatch;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;
use App\Modules\SuperAdmin\Transformers\ProductPriceTransformer;


class ProductBatchTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(ProductBatch $productBatch)
  {
    return [
      'id' => (int)$productBatch->id,
      'batch_number' => (string)$productBatch->batch_number,
      'order_date' => (string)$productBatch->order_date->toDateString(),
    ];
  }

  public function transformWithComment(ProductBatch $productBatch)
  {
    return [
      'id' => (int)$productBatch->id,
      'batch_number' => $productBatch->batch_number,
      'order_date' => $productBatch->order_date,
      'comments' => (new UserCommentTransformer)->collectionTransformer($productBatch->comments, 'commentDetails'),
    ];
  }

  public function transformWithPriceDetails(ProductBatch $productBatch)
  {
    return [
      'id' => (int)$productBatch->id,
      'batch_number' => $productBatch->batch_number,
      'order_date' => $productBatch->order_date,
      'prices' => (new ProductPriceTransformer)->collectionTransformer($productBatch->productPrices, 'basic'),
    ];
  }

  public function transformWithProductSummaries(ProductBatch $productBatch)
  {
    return [
      'id' => (int)$productBatch->id,
      'batch_number' => $productBatch->batch_number,
      'order_date' => $productBatch->order_date,
      'num_of_products' => $productBatch->products()->count()
    ];
  }
}
