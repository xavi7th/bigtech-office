<?php

namespace App\Modules\SuperAdmin\Models;

use Cache;
use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\SuperAdmin\Transformers\ProductCategoryTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductCategory
 *
 * @property int $id
 * @property string $name
 * @property string|null $img_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductModel[] $product_model
 * @property-read int|null $product_model_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory newQuery()
 * @method static \Illuminate\Database\Query\Builder|ProductCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ProductCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProductCategory withoutTrashed()
 * @mixin \Eloquent
 */
class ProductCategory extends BaseModel
{
  use SoftDeletes;

  protected $fillable = ['name', 'img_url'];

  public function product_model()
  {
    return $this->hasMany(ProductModel::class);
  }

  public function products()
  {
    return $this->hasMany(Product::class);
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
    $productCategories = Cache::rememberForever('productCategories', function () {
      return (new ProductCategoryTransformer)->collectionTransformer(self::withCount('products')->get(), 'basic');
    });

    if ($request->isApi()) {
      return response()->json($productCategories, 200);
    }
    return Inertia::render('SuperAdmin,Miscellaneous/ManageProductCategories', compact('productCategories'));
  }

  public function createProductCategory(Request $request)
  {
    if (!$request->name) return generate_422_error('The category name is required');
    if (!$request->hasFile('img')) return generate_422_error('A sample image is required for this category');
    if (self::where('name', $request->name)->exists()) return generate_422_error('This category already exists');

    try {
      $product_category = self::create([
        'name' => $request->name,
        'img_url' => compress_image_upload('img', 'product_models_images/', null, true, 400)['img_url'],
      ]);

      if ($request->isApi())
        return response()->json((new ProductCategoryTransformer)->basic($product_category), 201);
      return back()->withSuccess('Product category created. <br/> Products can now be created under this category');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Product category not created');
      if ($request->isApi())
        return response()->json(['err' => 'Category creation failed'], 500);
      return back()->withError('Category creation failed');
    }
  }

  public function editProductModel(Request $request, self $productCategory)
  {

    if (!$request->name) {
      return generate_422_error('The category name is required');
    }

    try {

      $productCategory->name = $request->name;
      if ($request->hasFile('img')) {
        $productCategory->img_url = compress_image_upload('img', 'product_models_images/', null, 400)['img_url'];
      }
      $productCategory->save();

      if ($request->isApi()) {
        return response()->json([], 204);
      }
      return back()->withSuccess('Updated');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Category not updated');
      if ($request->isApi())
        return response()->json(['err' => 'Category not updated'], 500);
      return back()->withError('Category update failed');
    }
  }


  protected static function boot()
  {
    parent::boot();

    static::saved(function () {
      Cache::forget('productCategories');
    });
  }
}
