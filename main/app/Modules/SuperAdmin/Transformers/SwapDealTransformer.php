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
      'status' => $swapDeal->product_status->status,
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
      'total_product_expenses' => (float)$swapDeal->total_product_expenses(),
      'sold_at' => (float)optional($swapDeal->product_sales_record)->selling_price,
      'swapped_with' => $swapDeal->swapped_with,
      'product_status_id' => $swapDeal->product_status_id,
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

  public function transformWithStatusHistory(SwapDeal $swapDeal)
  {
    return [
      'id' => (int)$swapDeal->id,
      'model' => (string)$swapDeal->description . ' swap deal',
      'identifier' => (string)$swapDeal->primary_identifier(),
      'status' => (string)$swapDeal->product_status->status,
      'uuid' => (string)$swapDeal->product_uuid,
      'cost_price' => $swapDeal->swap_value,
      'selling_price' => $swapDeal->selling_price,
      'product_histories' => (new ProductHistoryTransformer)->collectionTransformer($swapDeal->product_histories, 'detailedSwapDealHistory'),
    ];
  }


  public function transformWithTenureDetails(SwapDeal $swapDeal)
  {
    return [
      'id' => (int)$swapDeal->id,
      'uuid' => (string)$swapDeal->product_uuid,
      'model' => (string)$swapDeal->description,
      'identifier' => (string)$swapDeal->primary_identifier(),
      'collection_date' => (string)$swapDeal->tenure_record->created_at,
      'is_swap_transaction' => (bool)true,
      // 'status' => (string)$swapDeal->tenure_record->status,
      // 'cost_price' => $swapDeal->product_price->cost_price,
      // 'selling_price' => $swapDeal->product_price->proposed_selling_price,
    ];
  }

  public function transformWithResellerDetails(SwapDeal $swapDeal)
  {
    return [
      'id' => (int)$swapDeal->id,
      'model' => (string)$swapDeal->description,
      'identifier' => (string)$swapDeal->primary_identifier(),
      'reseller' => (string)$swapDeal->with_resellers[0]->business_name,
      'reseller_phone' => (string)$swapDeal->with_resellers[0]->phone,
      'date_collected' => (string)$swapDeal->with_resellers[0]->tenure_record->created_at,
      'uuid' => $swapDeal->product_uuid,
      'is_swap_deal' => (bool)true,
      // 'cost_price' => $swapDeal->product_price->cost_price,
      // 'selling_price' => $swapDeal->product_price->proposed_selling_price,
      // 'collection_date' => (string)$swapDeal->tenure_record->created_at,
      // 'status' => (string)$swapDeal->tenure_record->status,
    ];
  }
}
