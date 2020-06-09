<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\SuperAdmin\Transformers\ProductCategoryTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductCategory
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ProductModel[] $product_model
 * @property-read int|null $product_model_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductCategory newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductCategory query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductCategory withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string|null $img_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductCategory whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductCategory whereUpdatedAt($value)
 */
class ProductCategory extends Model
{
  use SoftDeletes;

  protected $fillable = ['name', 'img_url'];

  public function product_model()
  {
    return $this->hasMany(ProductModel::class);
  }

  public static function apiRoutes()
  {
    Route::group(['prefix' => 'product-categories', 'namespace' => '\App\Modules\Admin\Models'], function () {
      Route::get('', 'ProductCategory@getProductCategories')->middleware('auth:admin_api');
      Route::post('create', 'ProductCategory@createProductCategory')->middleware('auth:admin_api');
    });
  }

  public function getProductCategories()
  {
    return response()->json((new ProductCategoryTransformer)->collectionTransformer(self::all(), 'basic'), 200);
  }

  public function createProductCategory(Request $request)
  {
    if (!$request->name) {
      return generate_422_error('The category name is required');
    }

    if (self::where('name', $request->name)->exists()) {
      return generate_422_error('This category already exists');
    }

    try {
      $product_category = self::create([
        'name' => $request->name,
        'img_url' => $request->img_url,
      ]);

      return response()->json((new ProductCategoryTransformer)->basic($product_category), 201);
    } catch (\Throwable $th) {
      return response()->json(['err' => 'Category creation failed'], 500);
    }
  }
}
