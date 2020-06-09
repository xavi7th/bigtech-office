<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Transformers\ProductTransformer;
use App\Modules\SuperAdmin\Transformers\ProductHistoryTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductHistory
 *
 * @property-read \App\Modules\SuperAdmin\Models\Product $product
 * @property-read \App\Modules\SuperAdmin\Models\ProductStatus $product_status
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $product_id
 * @property int $product_status_id
 * @property int $user_id
 * @property string $user_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory whereProductStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory whereUserType($value)
 */
class ProductHistory extends Model
{
  protected $fillable = [
    'product_id',
    'product_status_id',
    'user_id',
  ];

  public function user()
  {
    return $this->morphTo();
  }

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function product_status()
  {
    return $this->belongsTo(ProductStatus::class);
  }

  public static function apiRoutes()
  {
    Route::group(['prefix' => 'product-histories', 'namespace' => '\App\Modules\Admin\Models'], function () {
      Route::get('', 'ProductHistory@getProductHistories')->middleware('auth:admin_api');
      Route::get('detailed', 'ProductHistory@getDetailedProductHistories')->middleware('auth:admin_api');
      Route::get('{product}', 'ProductHistory@getSingleProductHistory')->middleware('auth:admin_api');
    });
  }

  public function getProductHistories()
  {
    return response()->json((new ProductHistoryTransformer)->collectionTransformer(self::all(), 'basic'), 200);
  }

  public function getDetailedProductHistories()
  {
    return response()->json((new ProductHistoryTransformer)->collectionTransformer(self::all(), 'detailed'), 200);
  }

  public function getSingleProductHistory(Product $product)
  {
    return response()->json((new ProductTransformer)->transformWithStatusHistory($product->load('product_histories.user', 'product_histories.product_status')), 200);
  }
}
