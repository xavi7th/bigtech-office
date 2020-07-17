<?php

namespace App\Modules\SuperAdmin\Models;

use Inertia\Inertia;
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

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    if (routeHasRootNamespace('appuser.')) {
      Inertia::setRootView('appuser::app');
    } elseif (routeHasRootNamespace('superadmin.')) {
      Inertia::setRootView('superadmin::app');
    }
  }

  public function product_model()
  {
    return $this->hasMany(ProductModel::class);
  }

  public static function routes()
  {
    Route::group(['prefix' => 'product-categories'], function () {
      $gen = function ($name = null) {
        return 'superadmin.miscellaneous.' . $name;
      };
      Route::get('', [self::class, 'getProductCategories'])->name($gen('product_categories'))->defaults('ex', __e('ss', 'edit-3', false));
      Route::post('create', [self::class, 'createProductCategory'])->name($gen('create_product_category'))->defaults('ex', __e('ss', 'edit-3', true));
      Route::put('{category}/edit', [self::class, 'editProductCategory'])->name($gen('edit_product_category'))->defaults('ex', __e('ss', 'edit-3', true));
    });
  }

  public function getProductCategories(Request $request)
  {
    $categories = (new ProductCategoryTransformer)->collectionTransformer(self::all(), 'basic');
    if ($request->isApi()) {
      return response()->json($categories, 200);
    }

    return Inertia::render('Miscellaneous/ManageProductCategories', compact('categories'));
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
