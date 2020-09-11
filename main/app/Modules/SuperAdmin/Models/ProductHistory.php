<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Transformers\ProductTransformer;
use App\Modules\SuperAdmin\Transformers\ProductHistoryTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductHistory
 *
 * @property int $id
 * @property int $product_id
 * @property int $product_status_id
 * @property int $user_id
 * @property string $user_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Modules\SuperAdmin\Models\Product $product
 * @property-read \App\Modules\SuperAdmin\Models\ProductStatus $product_status
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory whereProductStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductHistory whereUserType($value)
 * @mixin \Eloquent
 */
class ProductHistory extends BaseModel
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

  public static function routes()
  {
    Route::group(['prefix' => 'product-histories', 'namespace' => '\App\Modules\Admin\Models'], function () {
      $gen = function ($namespace, $name = null) {
        return 'superadmin.miscellaneous.' . $namespace . $name;
      };
      Route::get('', [self::class, 'getDetailedProductHistories'])->name($gen('product_histories', null))->defaults('ex', __e('ss', 'rewind', false));
      Route::get('{product:id}', [self::class, 'getSingleProductHistory'])->name($gen('view_product_history'))->defaults('ex', __e('ss', 'rewind', true));
    });
  }

  public function getDetailedProductHistories(Request $request)
  {
    $productHistories = (new ProductHistoryTransformer)->collectionTransformer(self::with('product.product_model', 'product_status', 'user')->get(), 'detailed');

    if ($request->isApi())
      return response()->json($productHistories, 200);
    return Inertia::render('SuperAdmin,Histories/ViewProductHistories', compact('productHistories'));
  }

  public function getSingleProductHistory(Request $request, Product $product)
  {
    $productWithHistory = (new ProductTransformer)->transformWithStatusHistory($product->load('product_histories.user', 'product_histories.product_status'));
    if ($request->isApi()) return response()->json($productWithHistory, 200);
    return Inertia::render('SuperAdmin,Histories/ViewProductHistory', compact('productWithHistory'));
  }
}
