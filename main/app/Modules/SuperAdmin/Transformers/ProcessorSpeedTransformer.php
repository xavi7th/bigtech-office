<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ProcessorSpeed;

class ProcessorSpeedTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(ProcessorSpeed $result)
  {
    return [
      'id' => (int)$result->id,
      'speed' => (string)$result->speed
    ];
  }
}
