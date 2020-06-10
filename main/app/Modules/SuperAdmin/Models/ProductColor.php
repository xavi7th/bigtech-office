<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Transformers\ProductColorTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductColor
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductColor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductColor newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductColor onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductColor query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductColor withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductColor withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductColor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductColor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductColor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductColor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductColor whereUpdatedAt($value)
 */
class ProductColor extends Model
{
  use SoftDeletes;

  protected $fillable = ['name'];

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

  public function getProductColors()
  {
    return response()->json((new ProductColorTransformer)->collectionTransformer(self::all(), 'basic'), 200);
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

      return response()->json((new ProductColorTransformer)->basic($product_color), 201);
    } catch (\Throwable $th) {
      if ($th instanceof QueryException) {
        if ($th->errorInfo[1] === 1062) {
          return generate_422_error($th->errorInfo[2]);
        }
      }
      ErrLog::notifyAdmin(auth()->user(), $th, 'Color creation failed');
      return response()->json(['err' => 'Color creation failed'], 500);
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

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Color not updated');
      return response()->json(['err' => 'Color not updated'], 500);
    }
  }
}
