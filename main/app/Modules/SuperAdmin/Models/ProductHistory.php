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
use Cache;

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

  public static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'product-histories'], function () {
      $gen = function ($namespace, $name = null) {
        return 'multiaccess.miscellaneous.' . $namespace . $name;
      };
      Route::get('', [self::class, 'getDetailedProductHistories'])->name($gen('product_histories', null))->defaults('ex', __e('ss,a,ac', 'rewind', true))->middleware('auth:super_admin,admin,accountant');
      Route::get('product/{product:product_uuid}', [self::class, 'getSingleProductHistory'])->name($gen('view_product_history'))->defaults('ex', __e('ss,a,ac', 'rewind', true))->middleware('auth:super_admin,admin,accountant');
      Route::get('swap-deal/{swapDeal:product_uuid}', [self::class, 'getSwapDealHistory'])->name($gen('view_swap_history'))->defaults('ex', __e('ss,a,ac', 'rewind', true))->middleware('auth:super_admin,admin,accountant');
    });
  }

  public function getDetailedProductHistories(Request $request)
  {
    $productHistories = Cache::rememberForever('productHistories', fn () => (new ProductHistoryTransformer)->collectionTransformer(self::with('product.product_model', 'product_status', 'user')->get(), 'detailed'));

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


  protected static function boot()
  {
    parent::boot();

    static::saved(function ($product) {
      Cache::forget('productHostories');
    });
  }
}
