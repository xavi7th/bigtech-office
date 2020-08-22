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

  public function basic(OtherExpense $expense): array
  {
    return [
      'id' => (int)$expense->id,
      'amount' => (string)to_naira($expense->amount),
      'purpose' => (string)$expense->purpose,
      'recorder' => (string)$expense->recorder->full_name,
      'date' => (string)$expense->created_at->diffForHumans(),
    ];
  }

  public function transformWithComment(OtherExpense $expense)
  {
    return [
      'id' => (int)$expense->id,
      'batch_number' => $expense->batch_number,
      'order_date' => $expense->order_date,
      'comments' => (new UserCommentTransformer)->collectionTransformer($expense->comments, 'commentDetails'),
    ];
  }
}
