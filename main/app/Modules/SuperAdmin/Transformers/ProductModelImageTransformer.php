<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\ProductModelImage;

class ProductModelImageTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(ProductModelImage $image)
  {
    return [
      'id' => (int)$image->id,
      'img_url' => (string)$image->img_url,
      'thumb_url' => (string)$image->thumb_url,
    ];
  }
}
