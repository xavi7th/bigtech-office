<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\Reseller;
use App\Modules\SuperAdmin\Transformers\ProductTransformer;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;

class ResellerTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(Reseller $reseller): array
  {
    return [
      'id' => (int)$reseller->id,
      'business_name' => (string)$reseller->business_name,
      'ceo_name' => (string)$reseller->ceo_name,
      'address' => (string)$reseller->address,
      'phone' => (string)$reseller->phone,
      'email' => (string)$reseller->email,
      'img_url' => (string)$reseller->img_url,
    ];
  }

  public function transformWithComment(Reseller $reseller)
  {
    return [
      'id' => (int)$reseller->id,
      'batch_number' => $reseller->batch_number,
      'order_date' => $reseller->order_date,
      'comments' => (new UserCommentTransformer)->collectionTransformer($reseller->comments, 'commentDetails'),
    ];
  }

  public function transformWithTenuredProducts(Reseller $reseller)
  {
    return [
      'id' => (int)$reseller->id,
      'business_name' => $reseller->business_name,
      'phone' => $reseller->phone,
      'products_in_possession' => collect((new ProductTransformer)->collectionTransformer($reseller->products_in_possession->load('product_color', 'product_model', 'storage_size'), 'transformWithTenureDetails'))->merge((new SwapDealTransformer)->collectionTransformer($reseller->swap_deals_in_possession, 'transformWithTenureDetails')),
    ];
  }

  public function transformWithTenuredSwapDeals(Reseller $reseller)
  {
    return [
      'id' => (int)$reseller->id,
      'business_name' => $reseller->business_name,
      'phone' => $reseller->phone,
      'products_in_possession' => (new SwapDealTransformer)->collectionTransformer($reseller->swap_deals_in_possession, 'transformWithTenureDetails'),
    ];
  }

  public function fullDetailsWithTenuredProducts(Reseller $reseller)
  {
    return [
      'id' => (int)$reseller->id,
      'business_name' => $reseller->business_name,
      'ceo_name' => $reseller->ceo_name,
      'phone' => $reseller->phone,
      'address' => $reseller->address,
      'img_url' => $reseller->img_url,
      'registered_on' => $reseller->created_at->diffForHumans(),
      'products_in_possession' => collect((new ProductTransformer)->collectionTransformer($reseller->products_in_possession->load('product_color', 'product_model', 'storage_size'), 'transformWithTenureDetails'))->merge((new SwapDealTransformer)->collectionTransformer($reseller->swap_deals_in_possession, 'transformWithTenureDetails')),
    ];
  }
}
