<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ProductExpense;
use App\Modules\SuperAdmin\Transformers\ProductTransformer;

class ProductExpenseTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(ProductExpense $product_expense)
  {
    return [
      'id' => (int)$product_expense->id,
      'amount' => (string)to_naira($product_expense->amount),
      'reason' => (string)$product_expense->reason,
      'date' => (string)$product_expense->created_at,
    ];
  }

  public function transformWithProduct(ProductExpense $product_expense)
  {
    return [
      'id' => (int)$product_expense->id,
      'product' => (new ProductTransformer)->productsListing($product_expense->product),
      'amount' => (string)$product_expense->amount,
      'reason' => (string)$product_expense->reason,
      'date' => (string)$product_expense->created_at,
    ];
  }
}
