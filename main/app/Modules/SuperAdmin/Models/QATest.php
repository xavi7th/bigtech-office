<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\ProductQATestResult;
use App\Modules\SuperAdmin\Transformers\QATestTransformer;

/**
 * App\Modules\SuperAdmin\Models\QATest
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\QATest[] $product_models
 * @property-read int|null $product_models_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ProductQATestResult[] $product_qa_test_results
 * @property-read int|null $product_qa_test_results_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\QATest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\QATest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\QATest query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\QATest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\QATest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\QATest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\QATest whereUpdatedAt($value)
 */
class QATest extends Model
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
      $gen = function ($namespace, $name = null) {
        return 'superadmin.product_' . $namespace . $name;
      };
      Route::get('', [self::class, 'getQATests'])->name($gen('qa-tests'))->defaults('ex', __e('award', false));
      Route::post('create', [self::class, 'createQATest'])->name($gen('qa-tests', '.create_qa_test'))->defaults('ex', __e('award', true));
      Route::put('{size}/edit', [self::class, 'editQATest'])->name($gen('qa-tests', '.edit_qa_test'))->defaults('ex', __e('award', true));
    });
  }

  public function getQATests()
  {
    return response()->json((new QATestTransformer)->collectionTransformer(self::all(), 'basic'), 200);
  }

  public function createQATest(Request $request)
  {
    if (!$request->name) {
      return generate_422_error('QA test name required');
    }

    if (self::where('name', $request->name)->exists()) {
      return generate_422_error('Test already exists');
    }

    try {
      $qa_test = self::create([
        'name' => $request->name,
      ]);

      return response()->json((new QATestTransformer)->basic($qa_test), 201);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'QA Test not created');
      return response()->json(['err' => 'QA Test not created'], 500);
    }
  }


  public function editQATest(Request $request, self $qa_test)
  {
    if (!$request->name) {
      return generate_422_error('New QA test name required');
    }

    if (self::where('name', $request->name)->exists()) {
      return generate_422_error('Test already exists');
    }

    try {
      $qa_test->name = $request->name;
      $qa_test->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'QA test name not updated');
      return response()->json(['err' => 'QA test name not updated'], 500);
    }
  }
}
