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

class ProductGrade extends BaseModel
{
  use SoftDeletes;

  protected $fillable = ['grade'];

  public static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'product-grades'], function () {
      $gen = function ($name) {
        return 'multiaccess.miscellaneous.' . $name;
      };
      Route::get('', [self::class, 'getProductGrades'])->name($gen('product_grades'))->defaults('ex', __e('ss,a', 'check-square', false))->middleware('auth:super_admin,auditor');
      Route::post('create', [self::class, 'createProductGrade'])->name($gen('create_product_grade'))->defaults('ex', __e('ss,a', 'check-square', true))->middleware('auth:super_admin,auditor');
      Route::put('{productGrade}/edit', [self::class, 'editProductGrade'])->name($gen('edit_product_grade'))->defaults('ex', __e('ss,a', 'check-square', true))->middleware('auth:super_admin,auditor');
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
      return back()->withFlash(['success'=>'Product grade created. <br/> Products can now be created under this grade']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Product grade not created');

      if ($request->isApi()) return response()->json(['err' => 'Product grade not created'], 500);
      return back()->withFlash(['error'=>['Grade creation failed']]);
    }
  }

  public function editProductGrade(Request $request, ProductGrade $productGrade)
  {
    if (!$request->grade) return generate_422_error('Specify a new product grade to change this to');
    if (self::where('grade', $request->grade)->exists()) return generate_422_error('This grade already exists');

    try {
      $productGrade->grade = $request->grade;
      $productGrade->save();

      Cache::forget('productGrades');

      if ($request->isApi()) return response()->json([], 204);
      return back()->withFlash(['success'=>'Product grade updated. <br/> Products can now be created under this brand']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Product grade not updated');

      if ($request->isApi()) return response()->json(['err' => 'Product grade not updated'], 500);
      return back()->withFlash(['error'=>['product grade update failed']]);
    }
  }
}
