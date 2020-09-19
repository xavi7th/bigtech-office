<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\SwapDeal;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;

class SwapDealTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(SwapDeal $swapDeal): array
  {
    return [
      'description' => (string)$swapDeal->description,
      'identifier' => (string)$swapDeal->primary_identifier(),
      'selling_price' => (float)$swapDeal->selling_price,
      'uuid' => $swapDeal->product_uuid,
    ];
  }

  public function detailed(SwapDeal $swapDeal): array
  {
    return [
      'description' => (string)$swapDeal->description,
      'seller_details' => (string)$swapDeal->owner_details,
      'identifier' => (string)$swapDeal->primary_identifier(),
      'id_url' => (string)$swapDeal->id_url,
      'id_thumb_url' => (string)$swapDeal->id_thumb_url,
      'receipt_url' => (string)$swapDeal->receipt_url,
      'receipt_thumb_url' => (string)$swapDeal->receipt_thumb_url,
      'swap_value' => (float)$swapDeal->swap_value,
      'selling_price' => (float)$swapDeal->selling_price,
      'sold_at' => (float)$swapDeal->sold_at,
      'swapped_with' => $swapDeal->swapped_with,
      'status' => $swapDeal->product_status->status,
      'uuid' => $swapDeal->product_uuid,
      'comments' => (new UserCommentTransformer)->collectionTransformer($swapDeal->comments, 'commentDetails'),
      'buyer' => optional($swapDeal->app_user)->email ?? 'N/A',
    ];
  }

  public function transformWithComment(SwapDeal $swapDeal): array
  {
    return [
      'id' => (int)$swapDeal->id,
      'batch_number' => $swapDeal->batch_number,
      'order_date' => $swapDeal->order_date,
      'comments' => (new UserCommentTransformer)->collectionTransformer($swapDeal->comments, 'commentDetails'),
    ];
  }
}
