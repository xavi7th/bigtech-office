<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ProductDescriptionSummary;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;


class ProductDescriptionSummaryTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(ProductDescriptionSummary $product_description)
  {
    return [
      'id' => (int)$product_description->id,
      'model' => (string)$product_description->product_model->name,
      'description_summary' => (string)$product_description->description_summary,
    ];
  }

  public function transformWithComment(ProductDescriptionSummary $product_description)
  {
    return [
      'id' => (int)$product_description->id,
      'batch_number' => $product_description->batch_number,
      'order_date' => $product_description->order_date,
      'comments' => (new UserCommentTransformer)->collectionTransformer($product_description->comments, 'commentDetails'),
    ];
  }
}
