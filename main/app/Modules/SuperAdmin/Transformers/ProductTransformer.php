<?php

namespace App\Modules\SuperAdmin\Transformers;

use App\Modules\SuperAdmin\Models\Product;
use App\Modules\AppUser\Transformers\AppUserTransformer;
use App\Modules\SuperAdmin\Transformers\QATestTransformer;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;
use App\Modules\SuperAdmin\Transformers\ProductHistoryTransformer;

class ProductTransformer
{
  public function collectionTransformer($collection, $transformerMethod)
  {
    return
      $collection->map(function ($v) use ($transformerMethod) {
        return $this->$transformerMethod($v);
      });
  }

  public function basic(Product $product)
  {
    return [
      'uuid' => (string)$product->product_uuid,
      'model' => (string)$product->product_model->name,
      'identifier' => (string)$product->primary_identifier(),
      'cost_price' => $product->cost_price,
      'selling_price' => $product->proposed_selling_price,
    ];
  }

  public function detailed(Product $product)
  {
    return [
      'id' => (int)$product->id,
      'location' => (string)$product->location->city,
      'color' => (string)$product->product_color->name,
      'grade' => (string)$product->product_grade->grade,
      'model' => (string)$product->product_model->name,
      'storage_size' => (string)$product->storage_size->size,
      'identifier' => (string)$product->primary_identifier(),
      'supplier' => (string)$product->product_supplier->name,
      'batch' => (string)$product->product_batch->batch_number,
      'processor_speed' => (string)optional($product->processor_speed)->speed,
      'ram_size' => (string)optional($product->ram_size)->size,
      'storage_type' => (string)optional($product->storage_type)->type,
      'status' => (string)$product->product_status->status,
      'uuid' => (string)$product->product_uuid,
      'buyer' => (new AppUserTransformer)->transformBasic($product->app_user),
      'cost_price' => $product->cost_price,
      'selling_price' => $product->proposed_selling_price,
    ];
  }

  public function transformWithTestResults(Product $product)
  {
    return [
      'uuid' => (string)$product->product_uuid,
      'product_model' => (string)$product->product_model->name,
      'identifier' => (string)$product->primary_identifier(),
      'qa_tests' => (new QATestTransformer)->collectionTransformer($product->qa_tests, 'transformWithTestResult'),
      'valid_tests' => (new QATestTransformer)->collectionTransformer($product->product_model->qa_tests, 'basic'),
      'cost_price' => $product->product_price->cost_price,
      'selling_price' => $product->product_price->proposed_selling_price,
    ];
  }

  public function transformWithComment(Product $product)
  {
    return [
      'id' => (int)$product->id,
      'identifier' => $product->primary_identifier(),
      'model' => $product->product_model->name,
      'comments' => (new UserCommentTransformer)->collectionTransformer($product->comments, 'commentDetails'),
      'cost_price' => $product->product_price->cost_price,
      'selling_price' => $product->product_price->proposed_selling_price,
    ];
  }

  public function transformWithTenureDetails(Product $product)
  {
    return [
      'id' => (int)$product->id,
      'color' => (string)$product->product_color->name,
      'model' => (string)$product->product_model->name,
      'identifier' => (string)$product->primary_identifier(),
      'collection_date' => (string)$product->tenure_record->created_at,
      'status' => (string)$product->tenure_record->status,
      'cost_price' => $product->product_price->cost_price,
      'selling_price' => $product->product_price->proposed_selling_price,
    ];
  }


  public function transformWithResellerDetails(Product $product)
  {
    return [
      'id' => (int)$product->id,
      'color' => (string)$product->product_color->name,
      'model' => (string)$product->product_model->name,
      'identifier' => (string)$product->primary_identifier(),
      'reseller' => (string)$product->with_resellers[0]->business_name,
      'reseller_phone' => (string)$product->with_resellers[0]->phone,
      'date_collected' => (string)$product->with_resellers[0]->tenure_record->created_at,
      'cost_price' => $product->product_price->cost_price,
      'selling_price' => $product->product_price->proposed_selling_price,
      // 'collection_date' => (string)$product->tenure_record->created_at,
      // 'status' => (string)$product->tenure_record->status,
    ];
  }

  public function transformWithStatusHistory(Product $product)
  {
    return [
      'id' => (int)$product->id,
      'color' => (string)$product->product_color->name,
      'model' => (string)$product->product_model->name,
      'identifier' => (string)$product->primary_identifier(),
      'status' => (string)$product->product_status->status,
      'uuid' => (string)$product->product_uuid,
      'cost_price' => $product->product_price->cost_price,
      'selling_price' => $product->product_price->proposed_selling_price,
      'product_histories' => (new ProductHistoryTransformer)->collectionTransformer($product->product_histories, 'detailed'),
    ];
  }
}
