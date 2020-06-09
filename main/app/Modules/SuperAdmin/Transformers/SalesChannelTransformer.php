<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\SalesChannel;

class SalesChannelTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(SalesChannel $sales_channel)
  {
    return [
      'id' => (int)$sales_channel->id,
      'channel_name' => (string)$sales_channel->channel_name,
    ];
  }
}
