<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ProductHistory;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;

class ProductHistoryTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(ProductHistory $product_history)
  {
    return [
      'id' => (int)$product_history->id,
      'product' => (string)$product_history->product->product_model->name . ' with ' . $product_history->product->primary_identifier(),
      'product_status' => (string)'changed to ' . $product_history->product_status->status,
    ];
  }

  public function detailed(ProductHistory $product_history)
  {
    return [
      'id' => (int)$product_history->id,
      'product' => (string)$product_history->product->product_model->name . ' with ' . $product_history->product->primary_identifier(),
      'product_status' => (string)'changed to ' . $product_history->product_status->status .
        ' by ' . $product_history->user->email .
        ' on ' . $product_history->created_at
    ];
  }

  public function transformWithComment(ProductHistory $product_history)
  {
    return [
      'id' => (int)$product_history->id,
      'batch_number' => $product_history->batch_number,
      'order_date' => $product_history->order_date,
      'comments' => (new UserCommentTransformer)->collectionTransformer($product_history->comments, 'commentDetails'),
    ];
  }
}
