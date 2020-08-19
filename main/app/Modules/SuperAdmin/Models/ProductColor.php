<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Transformers\ProductColorTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductColor
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor newQuery()
 * @method static \Illuminate\Database\Query\Builder|ProductColor onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductColor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ProductColor withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProductColor withoutTrashed()
 * @mixin \Eloquent
 */
class ProductColor extends BaseModel
{
  use SoftDeletes;

  protected $fillable = ['name'];

  public function products()
  {
    return $this->hasMany(Product::class);
  }

  /**
   * The admin routes
   * @return Response
   */
  public static function routes()
  {
    Route::group(['prefix' => 'product-colors'], function () {
      Route::get('', [self::class, 'getProductColors'])->name('superadmin.miscellaneous.colors')->defaults('ex', __e('ss', 'pen-tool', false));
      Route::post('create', [self::class, 'createProductColor'])->name('superadmin.miscellaneous.create_product_color')->defaults('ex', __e('ss', 'pen-tool', true));
      Route::put('{color}/edit', [self::class, 'editProductColor'])->name('superadmin.miscellaneous.edit_product_color')->defaults('ex', __e('ss', 'pen-tool', true));
    });
  }

  public function getProductColors(Request $request)
  {
    $productColors = (new ProductColorTransformer)->collectionTransformer(self::withCount('products')->get(), 'basic');
    if ($request->isApi())
      return response()->json($productColors, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/ManageColors', compact('productColors'));
  }

  public function createProductColor(Request $request)
  {
    if (!$request->name) {
      return generate_422_error('The color name is required');
    }

    if (self::where('name', $request->name)->exists()) {
      return generate_422_error('The color ' . $request->name . ' already exists');
    }

    try {
      $product_color = self::create([
        'name' => $request->name
      ]);

      if ($request->isApi())
        return response()->json((new ProductColorTransformer)->basic($product_color), 201);
      return back()->withSuccess('Product color created. <br/> Products can now be created under this color');
    } catch (\Throwable $th) {
      if ($th instanceof QueryException) {
        if ($th->errorInfo[1] === 1062) {
          return generate_422_error($th->errorInfo[2]);
        }
      }
      ErrLog::notifyAdmin(auth()->user(), $th, 'Color creation failed');
      if ($request->isApi())
        return response()->json(['err' => 'Color creation failed'], 500);
      return back()->withError('Color creation failed');
    }
  }

  public function editProductColor(Request $request, self $color)
  {
    if (!$request->name) {
      return generate_422_error('Specify a new color to change this to');
    }

    if (self::where('name', $request->name)->exists()) {
      return generate_422_error('This color already exists');
    }

    try {
      $color->name = $request->name;
      $color->save();

      if ($request->isApi())
        return response()->json([], 204);
      return back()->withSuccess('Product color updated. <br/> Products can now be created under this color');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Color not updated');

      if ($request->isApi())
        return response()->json(['err' => 'Color not updated'], 500);
      return back()->withError('Color update failed');
    }
  }
}
