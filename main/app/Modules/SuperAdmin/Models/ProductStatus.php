<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Transformers\ProductStatusTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductStatus
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductStatus newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductStatus onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductStatus query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductStatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductStatus withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductStatus whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductStatus whereUpdatedAt($value)
 */
class ProductStatus extends Model
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
      Route::post('create', [self::class, 'createProductStatus'])->name($gen('create_status'))->defaults('ex', __e('ss', 'aperture', true));
      Route::put('{statuse}/edit', [self::class, 'editProductStatus'])->name($gen('edit_status'))->defaults('ex', __e('ss', 'aperture', true));
    });
  }

  public function getProductStatuses()
  {
    return response()->json((new ProductStatusTransformer)->collectionTransformer(self::all(), 'basic'), 200);
  }

  public function createProductStatus(Request $request)
  {
    if (!$request->status) {
      return generate_422_error('Specify a product status');
    }

    try {
      $product_status = self::create([
        'status' => $request->status,
      ]);

      return response()->json((new ProductStatusTransformer)->basic($product_status), 201);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Product status not created');
      return response()->json(['err' => 'Product status not created'], 500);
    }
  }

  public function editProductStatus(Request $request, self $product_status)
  {
    if (!$request->status) {
      return generate_422_error('Specify a new product status to change this to');
    }

    if (self::where('status', $request->status)->exists()) {
      return generate_422_error('This status already exists');
    }

    try {
      $product_status->status = $request->status;
      $product_status->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Product status not updated');
      return response()->json(['err' => 'Product status not updated'], 500);
    }
  }
}
