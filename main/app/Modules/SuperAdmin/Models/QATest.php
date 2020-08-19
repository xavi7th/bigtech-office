<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\ProductQATestResult;
use App\Modules\SuperAdmin\Transformers\QATestTransformer;
use Cache;

/**
 * App\Modules\SuperAdmin\Models\QATest
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|QATest[] $product_models
 * @property-read int|null $product_models_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductQATestResult[] $product_qa_test_results
 * @property-read int|null $product_qa_test_results_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|QATest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QATest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|QATest query()
 * @method static \Illuminate\Database\Eloquent\Builder|QATest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QATest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QATest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|QATest whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

  public static function routes()
  {
    Route::group(['prefix' => 'qa-tests'], function () {
      $gen = function ($name) {
        return 'superadmin.miscellaneous.'  . $name;
      };
      Route::get('', [self::class, 'getQATests'])->name($gen('qa-tests'))->defaults('ex', __e('ss', 'award', false));
      Route::post('create', [self::class, 'createQATest'])->name($gen('create_qa_test'))->defaults('ex', __e('ss', 'award', true));
      Route::put('{qaTest}/edit', [self::class, 'editQATest'])->name($gen('edit_qa_test'))->defaults('ex', __e('ss', 'award', true));
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
      return back()->withSuccess('QA Test created. <br/> Product models can now be assigned this test');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'QA Test not created');

      if ($request->isApi()) return response()->json(['err' => 'QA Test not created'], 500);
      return back()->withError('Test creation failed');
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
      return back()->withSuccess('QA Test updated. <br/> Product models can now be assigned this test');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'QA test name not updated');

      if ($request->isApi()) return response()->json(['err' => 'QA test name not updated'], 500);
      return back()->withError('Test update failed');
    }
  }
}
