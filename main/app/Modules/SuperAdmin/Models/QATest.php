<?php

namespace App\Modules\SuperAdmin\Models;

use Cache;
use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\ProductQATestResult;
use App\Modules\SuperAdmin\Transformers\QATestTransformer;

class QATest extends BaseModel
{
  protected $fillable = ['name'];
  protected $table = 'qa_tests';
  /**
   * All of the relationships to be touched.
   *
   * @var array
   */
  protected $touches = ['products'];

  public function product_models()
  {
    return $this->belongsToMany(self::class, 'qa_test_qa_test', 'qa_test_id', 'qa_test_id');
  }

  public function product_qa_test_results()
  {
    return $this->hasMany(ProductQATestResult::class, 'qa_test_qa_test', 'qa_test_id', 'qa_test_id');
  }

  public function products()
  {
    return $this->belongsToMany(Product::class, 'product_qa_test_results', 'product_id', 'qa_test_id')
      ->as('test_result')->withPivot('is_qa_certified')->withTimestamps();
  }

  public static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'qa-tests'], function () {
      Route::name('multiaccess.miscellaneous.')->group(function () {
        Route::get('', [self::class, 'getQATests'])->name('qa_tests')->defaults('ex', __e('ss,a', 'award', false))->middleware('auth:super_admin,auditor');
        Route::post('create', [self::class, 'createQATest'])->name('create_qa_test')->defaults('ex', __e('ss,a', 'award', true))->middleware('auth:super_admin,auditor');
        Route::put('{qaTest}/edit', [self::class, 'editQATest'])->name('edit_qa_test')->defaults('ex', __e('ss,a', 'award', true))->middleware('auth:super_admin,auditor');
      });
    });
  }

  public function getQATests(Request $request)
  {
    $qaTests = Cache::rememberForever('qaTests', function () {
      return (new QATestTransformer)->collectionTransformer(self::all(), 'basic');
    });

    if ($request->isApi()) return response()->json($qaTests, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/ManageQATests', compact('qaTests'));
  }

  public function createQATest(Request $request)
  {
    if (!$request->name) return generate_422_error('QA test name required');
    if (self::where('name', $request->name)->exists()) return generate_422_error('This test already exists');

    try {
      $qaTest = self::create([
        'name' => $request->name,
      ]);

      Cache::forget('qaTests');

      if ($request->isApi()) return response()->json((new QATestTransformer)->basic($qaTest), 201);
      return back()->withFlash(['success'=>'QA Test created. <br/> Product models can now be assigned this test']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'QA Test not created');

      if ($request->isApi()) return response()->json(['err' => 'QA Test not created'], 500);
      return back()->withFlash(['error'=>['Test creation failed']]);
    }
  }

  public function editQATest(Request $request, self $qaTest)
  {
    if (!$request->name) return generate_422_error('New QA test name required');
    if (self::where('name', $request->name)->exists()) return generate_422_error('Test already exists');

    try {
      $qaTest->name = $request->name;
      $qaTest->save();

      Cache::forget('qaTests');

      if ($request->isApi()) return response()->json([], 204);
      return back()->withFlash(['success'=>'QA Test updated. <br/> Product models can now be assigned this test']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'QA test name not updated');

      if ($request->isApi()) return response()->json(['err' => 'QA test name not updated'], 500);
      return back()->withFlash(['error'=>['Test update failed']]);
    }
  }
}
