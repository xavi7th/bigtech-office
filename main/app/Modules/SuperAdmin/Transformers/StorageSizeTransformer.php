<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\StorageSize;

class StorageSizeTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(StorageSize $storage_size)
  {
    return [
      'id' => (int)$storage_size->id,
      'size' => $storage_size->size,
      'human_size' => $storage_size->human_size
    ];
  }
}
