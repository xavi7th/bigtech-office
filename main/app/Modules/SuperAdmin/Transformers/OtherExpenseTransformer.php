<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\OtherExpense;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;

class OtherExpenseTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(OtherExpense $reseller): array
  {
    return [
      'id' => (int)$reseller->id,
      'amount' => (float)$reseller->amount,
      'purpose' => (string)$reseller->purpose,
      'recorder' => (string)$reseller->recorder->full_name,
    ];
  }

  public function transformWithComment(OtherExpense $reseller)
  {
    return [
      'id' => (int)$reseller->id,
      'batch_number' => $reseller->batch_number,
      'order_date' => $reseller->order_date,
      'comments' => (new UserCommentTransformer)->collectionTransformer($reseller->comments, 'commentDetails'),
    ];
  }
}
