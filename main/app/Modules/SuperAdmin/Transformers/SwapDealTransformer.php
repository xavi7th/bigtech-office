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

  public function basic(SwapDeal $swap_deal): array
  {
    return [
      'description' => (string)$swap_deal->description,
      'primary_identifier' => (string)$swap_deal->primary_identifier(),
    ];
  }

  public function detailed(SwapDeal $swap_deal): array
  {
    return [
      'description' => (string)$swap_deal->description,
      'seller_details' => (string)$swap_deal->owner_details,
      'primary_identifier' => (string)$swap_deal->primary_identifier(),
      'swap_value' => (float)$swap_deal->swap_value,
      'selling_price' => (float)$swap_deal->selling_price,
      'sold_at' => (string)$swap_deal->sold_at,
      'swapped_with' => $swap_deal->swapped_with,
      'status' => $swap_deal->product_status->status,
      'uuid' => $swap_deal->product_uuid,
      'buyer' => optional($swap_deal->app_user)->email,
    ];
  }

  public function transformWithComment(SwapDeal $swap_deal)
  {
    return [
      'id' => (int)$swap_deal->id,
      'batch_number' => $swap_deal->batch_number,
      'order_date' => $swap_deal->order_date,
      'comments' => (new UserCommentTransformer)->collectionTransformer($swap_deal->comments, 'commentDetails'),
    ];
  }
}
