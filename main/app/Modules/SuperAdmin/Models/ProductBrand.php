<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\SuperAdmin\Transformers\ProductBrandTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductBrand
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ProductModel[] $product_model
 * @property-read int|null $product_model_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductBrand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductBrand newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductBrand onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductBrand query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductBrand withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductBrand withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string|null $logo_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductBrand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductBrand whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductBrand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductBrand whereLogoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductBrand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductBrand whereUpdatedAt($value)
 */
class ProductBrand extends Model
{
  use SoftDeletes;

  protected $fillable = ['name', 'logo_url'];

  public function product_model()
  {
    return $this->hasMany(ProductModel::class);
  }

  public static function apiRoutes()
  {
    Route::group(['prefix' => 'product-brands', 'namespace' => '\App\Modules\Admin\Models'], function () {
      Route::get('', 'ProductBrand@getProductBrands')->middleware('auth:admin_api');
      Route::post('create', 'ProductBrand@createProductBrand')->middleware('auth:admin_api');
      Route::put('{brand}/edit', 'ProductBrand@editProductBrand')->middleware('auth:admin_api');
    });
  }

  public function getProductBrands()
  {
    return response()->json((new ProductBrandTransformer)->collectionTransformer(self::all(), 'basic'), 200);
  }

  public function createProductBrand(Request $request)
  {
    if (!$request->name) {
      return generate_422_error('The brand name is required');
    }

    if (self::where('name', $request->name)->exists()) {
      return generate_422_error('The brand ' . $request->name . ' already exists');
    }

    try {
      $product_brand = self::create([
        'name' => $request->name,
        'logo_url' => $request->logo_url,
      ]);

      return response()->json((new ProductBrandTransformer)->basic($product_brand), 201);
    } catch (\Throwable $th) {
      return response()->json(['err' => 'Brand creation failed'], 500);
    }
  }


  public function editProductBrand(Request $request, self $brand)
  {
    if (!$request->name) {
      return generate_422_error('Specify a new brand to change this to');
    }

    if (self::where('name', $request->name)->exists()) {
      return generate_422_error('This brand already exists');
    }

    try {
      $brand->name = $request->name;
      $brand->logo_url = $request->logo_url;
      $brand->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Brand not updated');
      return response()->json(['err' => 'Brand not updated'], 500);
    }
  }
}
