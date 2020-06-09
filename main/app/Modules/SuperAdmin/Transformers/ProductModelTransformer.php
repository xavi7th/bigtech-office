<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\QATest;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\SuperAdmin\Models\ProductModelImage;
use App\Modules\SuperAdmin\Transformers\QATestTransformer;
use App\Modules\SuperAdmin\Transformers\ProductModelImageTransformer;

class ProductModelTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(ProductModel $product_model)
  {
    return [
      'id' => (int)$product_model->id,
      'name' => (string)$product_model->name,
      'img_url' => (string)$product_model->img_url,
    ];
  }

  public function transformWithCategoryAndBrand(ProductModel $product_model)
  {
    return [
      'id' => (int)$product_model->id,
      'name' => (string)$product_model->name,
      'img_url' => (string)$product_model->img_url,
      'product_category' => $product_model->product_category->name,
      'product_brand' => $product_model->product_brand->name,
    ];
  }

  public function transformQATest(QATest $qa_test)
  {
    return (new QATestTransformer)->basic($qa_test);
  }

  public function transformImage(ProductModelImage $image)
  {
    return (new ProductModelImageTransformer)->basic($image);
  }
}
