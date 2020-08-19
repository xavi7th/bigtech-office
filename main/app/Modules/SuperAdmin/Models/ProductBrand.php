<?php

namespace App\Modules\SuperAdmin\Models;

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

/**
 * App\Modules\SuperAdmin\Models\ProductBrand
 *
 * @property int $id
 * @property string $name
 * @property string|null $logo_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\UserComment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductModel[] $product_models
 * @property-read int|null $product_models_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBrand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBrand newQuery()
 * @method static \Illuminate\Database\Query\Builder|ProductBrand onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBrand query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBrand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBrand whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBrand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBrand whereLogoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBrand whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductBrand whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ProductBrand withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProductBrand withoutTrashed()
 * @mixin \Eloquent
 */
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

  public static function routes()
  {
    Route::group(['prefix' => 'product-brands'], function () {
      $gen = function ($namespace, $name = null) {
        return 'superadmin.product_' . $namespace . $name;
      };
      Route::get('', [self::class, 'getProductBrands'])->name($gen('brands'))->defaults('ex', __e('ss', 'feather', false));
      Route::post('create', [self::class, 'createProductBrand'])->name($gen('brands', '.create_product_brand'))->defaults('ex', __e('ss', 'feather', true));
      Route::put('{productBrand}/edit', [self::class, 'editProductBrand'])->name($gen('brands', '.edit_product_brand'))->defaults('ex', __e('ss', 'feather', true));
      Route::delete('{productBrand}/delete', [self::class, 'deleteProductBrand'])->name($gen('brands', '.delete_product_brand'))->defaults('ex', __e('ss', 'feather', true));
    });
  }

  public function getProductBrands(Request $request)
  {
    $productBrands = (new ProductBrandTransformer)->collectionTransformer(self::withCount('products')->get(), 'basic');
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

      return back()->withSuccess('Product brand created. <br/> Products can now be created under this brand');
    } catch (\Throwable $th) {
      if ($request->isApi())
        return response()->json(['err' => 'Brand creation failed'], 500);
      return back()->withError('Brand creation failed');
    }
  }


  public function editProductBrand(Request $request, self $productBrand)
  {

    if (!$request->name) {
      return generate_422_error('Specify a new brand to change this to');
    }

    if (self::where('name', $request->name)->exists()) {
      return generate_422_error('This brand already exists');
    }

    try {
      $productBrand->name = $request->name;
      if ($request->hasFile('img')) {
        $productBrand->logo_url = compress_image_upload('img', 'product-brands/logos', null, 200, true)['img_url'];
      }
      $productBrand->save();

      if ($request->isApi())
        return response()->json([], 204);

      return back()->withSuccess('Product brand updated. <br/> All products under this brand will reflect this new name');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Brand not updated');
      if ($request->isApi())

        return response()->json(['err' => 'Brand not updated'], 500);

      return back()->withError('Brand update failed');
    }
  }

  public function deleteProductBrand(Request $request, self $productBrand)
  {
    if ($productBrand->products()->exists() || $productBrand->product_models()->exists()) {
      return generate_422_error('This brand has products and / or models under it and so cannot be deleted');
    }

    $productBrand->delete();

    if ($request->isApi())
      return response()->json([], 204);
    return back()->withSuccess('Deleted');
  }
}
