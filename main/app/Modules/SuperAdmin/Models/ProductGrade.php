<?php

namespace App\Modules\SuperAdmin\Models;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Transformers\ProductGradeTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductGrade
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductGrade newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductGrade newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductGrade onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductGrade query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductGrade withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductGrade withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $grade
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductGrade whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductGrade whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductGrade whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductGrade whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductGrade whereUpdatedAt($value)
 */
class ProductGrade extends Model
{
  use SoftDeletes;

  protected $fillable = ['grade'];

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
    Route::group(['prefix' => 'product-grades', 'namespace' => '\App\Modules\Admin\Models'], function () {
      $gen = function ($name) {
        return 'superadmin.miscellaneous.product_grades' . $name;
      };
      Route::get('', [self::class, 'getProductGrades'])->name($gen(''))->defaults('ex', __e('ss', 'check-square', false));
      Route::post('create', [self::class, 'createProductGrade'])->name($gen('.create'))->defaults('ex', __e('ss', 'check-square', true));
      Route::put('{grade}/edit', [self::class, 'editProductGrade'])->name($gen('.edit'))->defaults('ex', __e('ss', 'check-square', true));
    });
  }

  public function getProductGrades(Request $request)
  {
    $productGrades = (new ProductGradeTransformer)->collectionTransformer(self::all(), 'basic');
    if ($request->isApi())
      return response()->json($productGrades, 201);
    return Inertia::render('SuperAdmin,Miscellaneous/ManageProductGrades', compact('productGrades'));
  }

  public function createProductGrade(Request $request)
  {
    if (!$request->grade) {
      return generate_422_error('Specify a product grade');
    }

    if (self::where('grade', $request->grade)->exists()) {
      return generate_422_error('This grade exists already');
    }

    try {
      $product_grade = self::create([
        'grade' => $request->grade,
      ]);

      return response()->json((new ProductGradeTransformer)->basic($product_grade), 201);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Product grade not created');
      return response()->json(['err' => 'Product grade not created'], 500);
    }
  }

  public function editProductGrade(Request $request, ProductGrade $product_grade)
  {
    if (!$request->grade) {
      return generate_422_error('Specify a new product grade to change this to');
    }
    if (self::where('grade', $request->grade)->exists()) {
      return generate_422_error('This grade already exists');
    }

    try {
      $product_grade->grade = $request->grade;
      $product_grade->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Product grade not updated');
      return response()->json(['err' => 'Product grade not updated'], 500);
    }
  }
}
