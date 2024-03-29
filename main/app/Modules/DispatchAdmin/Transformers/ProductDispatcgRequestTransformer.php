<?php

namespace App\Modules\DispatchAdmin\Transformers;

use App\Modules\SalesRep\Models\ProductDispatchRequest;

class ProductDispatcgRequestTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(ProductDispatchRequest $productDispatchRequest): array
  {
    return [
      'id' => (int)$productDispatchRequest->id,
      'product_description' => (string)$productDispatchRequest->product_description,
      'primary_identifier' => (string)$productDispatchRequest->primary_identifier(),
      'online_rep' => (string)$productDispatchRequest->online_rep->full_name,
      'grand_total' => (string)$productDispatchRequest->proposed_selling_price,
      'customer_details' => (string) $productDispatchRequest->customer_details(),
      'time_of_request' => (string)$productDispatchRequest->created_at->diffForHumans(),
      'is_scheduled' => (bool)$productDispatchRequest->is_scheduled(),
      'is_sold' => (bool)$productDispatchRequest->is_sold(),

    ];
  }
}
