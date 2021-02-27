<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ReturnedLocalProduct;
use App\Modules\SuperAdmin\Transformers\ProductSupplierTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductSupplier
 *
 * @property int $id
 * @property string $name
 * @property int $is_local
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|ReturnedLocalProduct[] $returnedLocalProducts
 * @property-read int|null $returned_local_products_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier foreign()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier local()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier newQuery()
 * @method static \Illuminate\Database\Query\Builder|ProductSupplier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier whereIsLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSupplier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ProductSupplier withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProductSupplier withoutTrashed()
 * @mixin \Eloquent
 */
class ProductSupplier extends BaseModel
{
  use SoftDeletes;

  protected $fillable = ['name', 'is_local'];

  public function returnedLocalProducts()
  {
    return $this->hasMany(ReturnedLocalProduct::class);
  }

  public static function superAdminRoutes()
  {
    Route::group(['prefix' => 'product-suppliers'], function () {
      $gen = function ($namespace, $name = null) {
        return 'superadmin.product_' . $namespace . $name;
      };
      Route::get('', [self::class, 'getProductSuppliers'])->name($gen('suppliers.manage_suppliers'))->defaults('ex', __e('ss', 'user-plus', false));
      Route::post('create', [self::class, 'createProductSupplier'])->name($gen('suppliers', '.create'))->defaults('ex', __e('ss', 'user-plus', true));
      Route::put('{productSupplier}/edit', [self::class, 'editProductSupplier'])->name($gen('suppliers', '.edit'))->defaults('ex', __e('ss', 'user-plus', true));
    });
  }

  public function getProductSuppliers(Request $request)
  {
    $productSuppliers = Cache::rememberForever('suppliers', fn () => (new ProductSupplierTransformer)->collectionTransformer(self::all(), 'basic'));
    if ($request->isApi()) return response()->json($productSuppliers, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/ManageProductSuppliers', compact('productSuppliers'));
  }

  public function createProductSupplier(Request $request)
  {
    if (!$request->name) return generate_422_error('Specify a product supplier');

    try {
      $product_supplier = self::create([
        'name' => $request->name,
        'is_local' => $request->is_local,
      ]);

      if ($request->isApi()) return response()->json((new ProductSupplierTransformer)->basic($product_supplier), 201);
      return back()->withFlash(['success'=>'Success']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Product supplier not created');
      if ($request->isApi()) return response()->json(['err' => 'Product supplier not created'], 500);
      return back()->withFlash(['error'=>['Product supplier not created']]);
    }
  }

  public function editProductSupplier(Request $request, self $productSupplier)
  {
    if (!$request->name) {
      return generate_422_error('Specify a new product supplier to change this to');
    }

    if (self::where('name', $request->name)->where('name', '<>', $productSupplier->name)->exists()) {
      return generate_422_error('This supplier already exists');
    }

    try {
      $productSupplier->name = $request->name;
      $productSupplier->is_local = $request->is_local ?? false;
      $productSupplier->save();

      if ($request->isApi()) return response()->json([], 204);
      return back()->withFlash(['success'=>'Success']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Product supplier not updated');
      if ($request->isApi()) return response()->json(['err' => 'Product supplier not updated'], 500);
      return back()->withFlash(['error'=>['Product supplier not updated']]);
    }
  }

  public function scopeLocal($query)
  {
    return $query->where('is_local', true);
  }

  public function scopeForeign($query)
  {
    return $query->where('is_local', false);
  }

  protected static function boot()
  {
    parent::boot();

    static::saved(function ($product) {
      Cache::forget('suppliers');
      Cache::forget('localSuppliers');
      Cache::forget('foreignSuppliers');
    });
  }
}
