<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Transformers\ProductGradeTransformer;
use Cache;

/**
 * App\Modules\SuperAdmin\Models\ProductGrade
 *
 * @property int $id
 * @property string $grade
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGrade newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGrade newQuery()
 * @method static \Illuminate\Database\Query\Builder|ProductGrade onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGrade query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGrade whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGrade whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGrade whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGrade whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductGrade whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ProductGrade withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProductGrade withoutTrashed()
 * @mixin \Eloquent
 */
class ProductGrade extends BaseModel
{
  use SoftDeletes;

  protected $fillable = ['grade'];

  public static function routes()
  {
    Route::group(['prefix' => 'product-grades', 'namespace' => '\App\Modules\Admin\Models'], function () {
      $gen = function ($name) {
        return 'superadmin.miscellaneous.' . $name;
      };
      Route::get('', [self::class, 'getProductGrades'])->name($gen('product_grades'))->defaults('ex', __e('ss', 'check-square', false));
      Route::post('create', [self::class, 'createProductGrade'])->name($gen('create_product_grade'))->defaults('ex', __e('ss', 'check-square', true));
      Route::put('{productGrade}/edit', [self::class, 'editProductGrade'])->name($gen('edit_product_grade'))->defaults('ex', __e('ss', 'check-square', true));
    });
  }

  public function getProductGrades(Request $request)
  {
    $productGrades = Cache::rememberForever('productGrades', function () {
      return (new ProductGradeTransformer)->collectionTransformer(self::all(), 'basic');
    });

    if ($request->isApi()) return response()->json($productGrades, 201);

    return Inertia::render('SuperAdmin,Miscellaneous/ManageProductGrades', compact('productGrades'));
  }

  public function createProductGrade(Request $request)
  {
    if (!$request->grade) return generate_422_error('Specify a product grade');
    if (self::where('grade', $request->grade)->exists()) return generate_422_error('This grade exists already');

    try {
      $product_grade = self::create([
        'grade' => $request->grade,
      ]);

      Cache::forget('productGrades');

      if ($request->isApi()) return response()->json((new ProductGradeTransformer)->basic($product_grade), 201);
      return back()->withSuccess('Product grade created. <br/> Products can now be created under this grade');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Product grade not created');

      if ($request->isApi()) return response()->json(['err' => 'Product grade not created'], 500);
      return back()->withError('Grade creation failed');
    }
  }

  public function editProductGrade(Request $request, ProductGrade $product_grade)
  {
    if (!$request->grade)       return generate_422_error('Specify a new product grade to change this to');
    if (self::where('grade', $request->grade)->exists()) return generate_422_error('This grade already exists');

    try {
      $product_grade->grade = $request->grade;
      $product_grade->save();

      Cache::forget('productGrades');

      if ($request->isApi()) return response()->json([], 204);
      return back()->withSuccess('Product grade updated. <br/> Products can now be created under this brand');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Product grade not updated');

      if ($request->isApi()) return response()->json(['err' => 'Product grade not updated'], 500);
      return back()->withError('product grade update failed');
    }
  }
}
