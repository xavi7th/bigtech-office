<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\QATest;
use App\Modules\SuperAdmin\Transformers\ProductQATestResultTransformer;

class QATestTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(QATest $qa_test)
  {
    return [
      'id' => (int)$qa_test->id,
      'name' => (string)$qa_test->name,
    ];
  }

  public function transformWithTestResult(QATest $qa_test)
  {
    return [
      'name' => (string)$qa_test->name,
      'is_qa_certified' => (new ProductQATestResultTransformer)->result_only($qa_test->test_result),
    ];
  }
}
