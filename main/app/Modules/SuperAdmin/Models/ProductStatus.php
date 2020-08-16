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

class ProductStatus extends BaseModel
{
  use SoftDeletes;

  protected $fillable = ['status'];

  public function products()
  {
    return $this->hasMany(Product::class);
  }

  /**
   * Get the Id of the "SOLD" status
   *
   * @return integer
   */
  static function sold_id(): int
  {
    return self::where('status', 'sold')->first()->id;
  }
  /**
   * Get the Id of the "SALE CONFIRMED" status
   *
   * @return integer
   */
  static function sale_confirmed_id(): int
  {
    return self::where('status', 'sale confirmed')->first()->id;
  }

  /**
   * Get the Id of the "Undergoing QA" status
   *
   * @return integer
   */
  static function undergoing_qa_id(): int
  {
    return self::where('status', 'Undergoing QA')->first()->id;
  }

  /**
   * Get the Id of the "QA TESTED" status
   *
   * @return integer
   */
  static function in_stock(): int
  {
    return self::where('status', 'In stock')->first()->id;
  }

  /**
   * Get the Id of the "QA TESTED" status
   *
   * @return integer
   */
  static function with_reseller(): int
  {
    return self::where('status', 'With reseller')->first()->id;
  }

  public static function routes()
  {
    Route::group(['prefix' => 'product-statuses'], function () {
      $gen = function ($name) {
        return 'superadmin.miscellaneous.' . $name;
      };
      Route::get('', [self::class, 'getProductStatuses'])->name($gen('product_status', null))->defaults('ex', __e('ss', 'aperture', false));
      Route::post('create', [self::class, 'createProductStatus'])->name($gen('create_product_status'))->defaults('ex', __e('ss', 'aperture', true));
      Route::put('{productStatus}/edit', [self::class, 'editProductStatus'])->name($gen('edit_product_status'))->defaults('ex', __e('ss', 'aperture', true));
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
      return back()->withSuccess('Product status created. <br/> Products can now be assigned this status');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Product status not created');

      if ($request->isApi()) return response()->json(['err' => 'Product status not created'], 500);
      return back()->withError('Status creation failed');
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
      return back()->withSuccess('Product status updated. <br/> Products can now be assigned this status');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Product status not updated');

      if ($request->isApi()) return response()->json(['err' => 'Product status not created'], 500);
      return back()->withError('Status creation failed');
    }
  }
}
