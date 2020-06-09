<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\StorageType;

class StorageTypeTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(StorageType $storage_type)
  {
    return [
      'id' => (int)$storage_type->id,
      'type' => (string)$storage_type->type
    ];
  }
}
