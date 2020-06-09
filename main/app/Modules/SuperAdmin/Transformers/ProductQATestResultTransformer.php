<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ProductQATestResult;

class ProductQATestResultTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic($result)
  {
    return [
      'result' => (string)$result->is_qa_certified ? 'passsed' : 'failed',
    ];
  }

  public function result_only($result)
  {
    return (bool)$result->is_qa_certified;
  }

  public function detailed(ProductQATestResult $result)
  {
    return [
      'id' => (int)$result->id,
      'product_model' => (string)$result->product->product_model->name,
      'product_uuid' => (string)$result->product->product_uuid,
      'qa_test' => (string)$result->qa_test->name,
      'result' => (string)$result->is_qa_certified ? 'passsed' : 'failed',
      'is_qa_certified' => (bool)$result->is_qa_certified,
    ];
  }
}
