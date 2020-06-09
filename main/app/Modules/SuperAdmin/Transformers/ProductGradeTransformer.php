<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ProductGrade;

class ProductGradeTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(ProductGrade $result)
  {
    return [
      'id' => (int)$result->id,
      'grade' => (string)$result->grade
    ];
  }
}
