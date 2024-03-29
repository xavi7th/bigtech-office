<?php

namespace App\Modules\SuperAdmin\Models;

use Cache;
use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Traits\Commentable;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\SuperAdmin\Transformers\ProductBrandTransformer;

class ProductBrand extends BaseModel
{
  use SoftDeletes, Commentable;

  protected $fillable = ['name', 'logo_url'];

  public function product_models()
  {
    return $this->hasMany(ProductModel::class);
  }

  public function products()
  {
    return $this->hasMany(Product::class);
  }

  public static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'product-brands'], function () {
      $gen = function ($namespace, $name = null) {
        return 'multiaccess.product_' . $namespace . $name;
      };
      Route::get('', [self::class, 'getProductBrands'])->name($gen('brands.manage_product_brands'))->defaults('ex', __e('ss,a,w', 'feather', false))->middleware('auth:super_admin,auditor,web_admin');
      Route::post('create', [self::class, 'createProductBrand'])->name($gen('brands', '.create_product_brand'))->defaults('ex', __e('ss,a,w', 'feather', true))->middleware('auth:super_admin,auditor,web_admin');
      Route::put('{productBrand}/edit', [self::class, 'editProductBrand'])->name($gen('brands', '.edit_product_brand'))->defaults('ex', __e('ss,a,w', 'feather', true))->middleware('auth:super_admin,auditor,web_admin');
      Route::delete('{productBrand}/delete', [self::class, 'deleteProductBrand'])->name($gen('brands', '.delete_product_brand'))->defaults('ex', __e('ss,a,w', 'feather', true))->middleware('auth:super_admin,auditor,web_admin');
    });
  }

  public function getProductBrands(Request $request)
  {
    $productBrands = Cache::rememberForever('brandsWithProductCount', fn () => (new ProductBrandTransformer)->collectionTransformer(self::withCount('products')->get(), 'basic'));
    if ($request->isApi())
      return response()->json($productBrands, 200);

    return Inertia::render('SuperAdmin,Miscellaneous/ManageProductBrands', compact('productBrands'));
  }

  public function createProductBrand(Request $request)
  {
    if (!$request->name) {
      return generate_422_error('The brand name is required');
    }

    if (self::where('name', $request->name)->exists()) {
      return generate_422_error('The brand ' . $request->name . ' already exists');
    }

    if ($request->hasFile('img')) {
      $logo_url = compress_image_upload('img', 'product-brands/logos', null, 200, true)['img_url'];
    }

    try {
      $product_brand = self::create([
        'name' => $request->name,
        'logo_url' => $logo_url ?? null,
      ]);

      if ($request->isApi())
        return response()->json((new ProductBrandTransformer)->basic($product_brand), 201);

      return back()->withFlash(['success'=>'Product brand created. <br/> Products can now be created under this brand']);
    } catch (\Throwable $th) {
      if ($request->isApi())
        return response()->json(['err' => 'Brand creation failed'], 500);
      return back()->withFlash(['error'=>['Brand creation failed']]);
    }
  }


  public function editProductBrand(Request $request, self $productBrand)
  {

    if (!$request->name) {
      return generate_422_error('Specify a new brand to change this to');
    }

    try {
      $productBrand->name = $request->name;
      if ($request->hasFile('img')) {
        $productBrand->logo_url = compress_image_upload('img', 'product-brands/logos', null, 200, true)['img_url'];
      }
      $productBrand->save();

      if ($request->isApi())
        return response()->json([], 204);

      return back()->withFlash(['success'=>'Product brand updated. <br/> All products under this brand will reflect this new name']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Brand not updated');
      if ($request->isApi())

        return response()->json(['err' => 'Brand not updated'], 500);

      return back()->withFlash(['error'=>['Brand update failed']]);
    }
  }

  public function deleteProductBrand(Request $request, self $productBrand)
  {
    if ($productBrand->products()->exists()) {
      return generate_422_error('This brand has products under it and so cannot be deleted');
    }

    $productBrand->delete();

    if ($request->isApi()) return response()->json([], 204);
    return back()->withFlash(['success'=>'Deleted']);
  }


  protected static function boot()
  {
    parent::boot();

    static::saved(function (self $productBrand) {
      Cache::forget('brands');
      Cache::forget('brandsWithProductCount');
    });

    static::deleting(function (self $productBrand) {
      Cache::forget('brands');
      Cache::forget('brandsWithProductCount');

      /**
       * Delete associated models
       */
      $productBrand->product_models()->delete();
    });
  }
}
