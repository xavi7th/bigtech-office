<?php

namespace App\Modules\SuperAdmin\Models;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Transformers\ProductSupplierTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductSupplier
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSupplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSupplier newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductSupplier onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSupplier query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductSupplier withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductSupplier withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSupplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSupplier whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSupplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSupplier whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSupplier whereUpdatedAt($value)
 */
class ProductSupplier extends Model
{
  use SoftDeletes;

  protected $fillable = ['name'];

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    if (routeHasRootNamespace('appuser.')) {
      Inertia::setRootView('appuser::app');
    } elseif (routeHasRootNamespace('superadmin.')) {
      Inertia::setRootView('superadmin::app');
    }
  }

  public static function routes()
  {
    Route::group(['prefix' => 'product-suppliers'], function () {
      $gen = function ($namespace, $name = null) {
        return 'superadmin.product_' . $namespace . $name;
      };
      Route::get('', [self::class, 'getProductSuppliers'])->name($gen('suppliers', null))->defaults('ex', __e('ss', 'user-plus', false));
      Route::post('create', [self::class, 'createProductSupplier'])->name($gen('suppliers', 'create_supplier'))->defaults('ex', __e('ss', 'user-plus', true));
      Route::put('{supplier}/edit', [self::class, 'editProductSupplier'])->name($gen('suppliers', 'edit_supplier'))->defaults('ex', __e('ss', 'user-plus', true));
    });
  }

  public function getProductSuppliers(Request $request)
  {
    $productSuppliers = (new ProductSupplierTransformer)->collectionTransformer(self::all(), 'basic');
    if ($request->isApi())
      return response()->json($productSuppliers, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/ManageProductSuppliers', compact('productSuppliers'));
  }

  public function createProductSupplier(Request $request)
  {
    if (!$request->name) {
      return generate_422_error('Specify a product supplier');
    }

    try {
      $product_supplier = self::create([
        'name' => $request->name,
      ]);

      return response()->json((new ProductSupplierTransformer)->basic($product_supplier), 201);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Product supplier not created');
      return response()->json(['err' => 'Product supplier not created'], 500);
    }
  }

  public function editProductSupplier(Request $request, self $product_supplier)
  {
    if (!$request->name) {
      return generate_422_error('Specify a new product supplier to change this to');
    }

    if (self::where('name', $request->name)->exists()) {
      return generate_422_error('This supplier already exists');
    }

    try {
      $product_supplier->name = $request->name;
      $product_supplier->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Product supplier not updated');
      return response()->json(['err' => 'Product supplier not updated'], 500);
    }
  }
}
