<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Transformers\ProductStatusTransformer;
use Cache;
use Str;

class ProductStatus extends BaseModel
{
  use SoftDeletes;

  protected $fillable = ['status'];

  public function products()
  {
    return $this->hasMany(Product::class);
  }

  static function justArrivedId(): int
  {
    static $id =  null;
    if (is_null($id)) {
      $id = self::where('status', 'just arrived')->first()->id;
    }

    return $id;
  }

  /**
   * Get the Id of the "Undergoing QA" status
   *
   * @return integer
   */
  static function undergoingQaId(): int
  {
    return self::where('status', 'undergoing qa')->first()->id;
  }

  static function qaFailedId(): int
  {
    return self::where('status', 'qa failed')->first()->id;
  }

  static function rtoId(): int
  {
    return self::where('status', 'rto (damaged)')->first()->id;
  }

  static function backFromRepairsId(): int
  {
    return self::where('status', 'back from repairs')->first()->id;
  }

  static function outForRepairsId(): int
  {
    return self::where('status', 'out for repairs')->first()->id;
  }

  static function inStockId(): int
  {
    return self::where('status', 'in stock')->first()->id;
  }
  static function scheduledDeliveryId(): int
  {
    return self::where('status_slug', 'out-for-delivery')->first()->id;
  }

  /**
   * Get the Id of the "WITH RESELLER" status
   *
   * @return integer
   */
  static function withResellerId(): int
  {
    return self::where('status', 'with reseller')->first()->id;
  }

  static function soldByResellerId(): int
  {
    return self::where('status', 'sold by reseller')->first()->id;
  }

  /**
   * Get the Id of the "SOLD" status
   *
   * @return integer
   */
  static function soldId(): int
  {
    return self::where('status', 'sold')->first()->id;
  }

  /**
   * Get the Id of the "SALE CONFIRMED" status
   *
   * @return integer
   */
  static function saleConfirmedId(): int
  {
    return self::where('status', 'sale confirmed')->first()->id;
  }

  public static function superAdminRoutes()
  {
    Route::group(['prefix' => 'product-statuses'], function () {
      Route::name('miscellaneous.')->group(function () {
        Route::post('create', [self::class, 'createProductStatus'])->name('create_product_status')->defaults('ex', __e('ss', 'aperture', true));
        Route::put('{productStatus}/edit', [self::class, 'editProductStatus'])->name('edit_product_status')->defaults('ex', __e('ss', 'aperture', true));
      });
    });
  }

  public static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'product-statuses'], function () {
      Route::name('multiaccess.miscellaneous.')->group(function () {
        Route::get('', [self::class, 'getProductStatuses'])->name('product_status')->defaults('ex', __e('ss,a', 'aperture', false))->middleware('auth:super_admin,auditor');
      });
    });
  }

  public function getProductStatuses(Request $request)
  {
    $productStatuses = Cache::rememberForever('productStatuses', function () {
      return (new ProductStatusTransformer)->collectionTransformer(self::all(), 'basic');
    });

    if ($request->isApi()) return response()->json($productStatuses, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/ManageProductStatus', compact('productStatuses'));
  }

  public function createProductStatus(Request $request)
  {
    if (!$request->status) return generate_422_error('Specify a product status');
    if (self::where('status', $request->status)->exists()) return generate_422_error('This status already exists');

    try {
      $productStatus = self::create([
        'status' => $request->status,
      ]);

      Cache::forget('productStatuses');

      if ($request->isApi()) return response()->json((new ProductStatusTransformer)->basic($productStatus), 201);
      return back()->withFlash(['success'=>'Product status created. <br/> Products can now be assigned this status']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Product status not created');

      if ($request->isApi()) return response()->json(['err' => 'Product status not created'], 500);
      return back()->withFlash(['error'=>['Status creation failed']]);
    }
  }

  public function editProductStatus(Request $request, self $productStatus)
  {
    if (!$request->status) {
      return generate_422_error('Specify a new product status to change this to');
    }

    if (self::where('status', $request->status)->exists()) {
      return generate_422_error('This status already exists');
    }

    try {
      $productStatus->status = $request->status;
      $productStatus->save();

      Cache::forget('productStatuses');

      if ($request->isApi())       return response()->json([], 204);
      return back()->withFlash(['success'=>'Product status updated. <br/> Products can now be assigned this status']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Product status not updated');

      if ($request->isApi()) return response()->json(['err' => 'Product status not created'], 500);
      return back()->withFlash(['error'=>['Status creation failed']]);
    }
  }

  public function scopeQa($query)
  {
    return $query->whereScope('qa');
  }


  protected static function boot()
  {
    parent::boot();

    static::saving(function (self $productStatus) {
      $productStatus->status_slug = Str::slug($productStatus->status);
    });

    static::saved(function (self $productStatus) {
      Cache::forget('qAProductStatuses');
      Cache::forget('productStatuses');
      Cache::forget('statuses');
    });
  }
}
