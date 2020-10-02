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
use App\Modules\SuperAdmin\Transformers\SwapDealTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductHistory
 *
 * @property int $id
 * @property int $product_id
 * @property string $product_type
 * @property int $product_status_id
 * @property int $user_id
 * @property string $user_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $product
 * @property-read ProductStatus $product_status
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $user
 * @method static \Illuminate\Database\Eloquent\Builder|ProductHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductHistory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductHistory whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductHistory whereProductStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductHistory whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductHistory whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductHistory whereUserType($value)
 * @mixin \Eloquent
 */
class ProductHistory extends BaseModel
{
  protected $fillable = [
    'product_id',
    'product_type',
    'product_status_id',
    'user_id',
  ];

  public function user()
  {
    return $this->morphTo();
  }

  public function product()
  {
    return $this->morphTo();
    // return $this->belongsTo(Product::class);
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
      Route::get('', [self::class, 'getDetailedProductHistories'])->name($gen('product_histories', null))->defaults('ex', __e('ss', 'rewind', true));
      Route::get('product/{product:product_uuid}', [self::class, 'getSingleProductHistory'])->name($gen('view_product_history'))->defaults('ex', __e('ss', 'rewind', true));
      Route::get('swap-deal/{swapDeal:product_uuid}', [self::class, 'getSwapDealHistory'])->name($gen('view_swap_history'))->defaults('ex', __e('ss', 'rewind', true));
    });
  }

  public function getDetailedProductHistories(Request $request)
  {
    $productHistories = (new ProductHistoryTransformer)->collectionTransformer(self::with('product.product_model', 'product_status', 'user')->get(), 'detailed');

    if ($request->isApi()) return response()->json($productHistories, 200);
    return Inertia::render('SuperAdmin,Histories/ViewProductHistories', compact('productHistories'));
  }

  public function getSingleProductHistory(Request $request, Product $product)
  {
    $productWithHistory = (new ProductTransformer)->transformWithStatusHistory($product->load('product_histories.user', 'product_histories.product_status'));
    if ($request->isApi()) return response()->json($productWithHistory, 200);
    return Inertia::render('SuperAdmin,Histories/ViewProductHistory', compact('productWithHistory'));
  }

  public function getSwapDealHistory(Request $request, SwapDeal $swapDeal)
  {
    $productWithHistory = (new SwapDealTransformer)->transformWithStatusHistory($swapDeal->load('product_histories.user', 'product_histories.product_status'));
    if ($request->isApi()) return response()->json($productWithHistory, 200);
    return Inertia::render('SuperAdmin,Histories/ViewProductHistory', compact('productWithHistory'));
  }
}
