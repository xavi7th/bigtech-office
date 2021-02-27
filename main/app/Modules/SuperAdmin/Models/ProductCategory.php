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

  public static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'product-categories'], function () {
      $gen = function ($name = null) {
        return 'multiaccess.miscellaneous.' . $name;
      };
      Route::get('', [self::class, 'getProductCategories'])->name($gen('product_categories'))->defaults('ex', __e('ss,a', 'edit-3', false))->middleware('auth:auditor,super_admin');;
      Route::post('create', [self::class, 'createProductCategory'])->name($gen('create_product_category'))->defaults('ex', __e('ss,a', 'edit-3', true))->middleware('auth:auditor,super_admin');;
      Route::put('{productCategory}/edit', [self::class, 'editProductCategory'])->name($gen('edit_product_category'))->defaults('ex', __e('ss,a', 'edit-3', true))->middleware('auth:auditor,super_admin');;
    });
  }

  public function getProductCategories(Request $request)
  {
    $productCategories = Cache::rememberForever('productCategories', fn () => (new ProductCategoryTransformer)->collectionTransformer(self::withCount('products')->get(), 'basic'));

    if ($request->isApi()) return response()->json($productCategories, 200);
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
        'img_url' => compress_image_upload('img', 'product_models_images/', null, 400)['img_url'],
      ]);

      if ($request->isApi())
        return response()->json((new ProductCategoryTransformer)->basic($product_category), 201);
      return back()->withFlash(['success'=>'Product category created. <br/> Products can now be created under this category']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Product category not created');
      if ($request->isApi())
        return response()->json(['err' => 'Category creation failed'], 500);
      return back()->withFlash(['error'=>['Category creation failed']]);
    }
  }

  public function editProductCategory(Request $request, self $productCategory)
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
      return back()->withFlash(['success'=>'Updated']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Category not updated');
      if ($request->isApi())
        return response()->json(['err' => 'Category not updated'], 500);
      return back()->withFlash(['error'=>['Category update failed']]);
    }
  }


  protected static function boot()
  {
    parent::boot();

    static::saved(function () {
      Cache::forget('productCategories');
      Cache::forget('categories');
    });
  }
}
