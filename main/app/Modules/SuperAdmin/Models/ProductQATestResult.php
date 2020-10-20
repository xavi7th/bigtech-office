<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\QATest;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Transformers\ProductTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductQATestResult
 *
 * @property int $id
 * @property int $product_id
 * @property int $qa_test_id
 * @property int $is_qa_certified
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Product $product
 * @property-read QATest $qa_test
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQATestResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQATestResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQATestResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQATestResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQATestResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQATestResult whereIsQaCertified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQATestResult whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQATestResult whereQaTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQATestResult whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductQATestResult extends Model
{
  protected $fillable = [];
  protected $table = 'product_qa_test_results';


  public function product()
  {
    return $this->belongsTo(Product::class);
  }


  public function qa_test()
  {
    return $this->belongsTo(QATest::class);
  }

  public static function superAdminRoutes()
  {
    Route::group(['prefix' => 'product-qa-test-results'], function () {
      $p = function ($name) {
        return 'superadmin.products.' . $name;
      };
      // Route::get('', [self::class, 'getProductQATestResults'])->name($p('all_qa_test_results'))->defaults('ex', __e('ss', 'file-text', false));
    });
  }

  public function getProductQATestResults()
  {
    $results = (new ProductTransformer)->collectionTransformer(Product::has('qa_tests')->with(['qa_tests', 'product_model'])->get(), 'transformWithTestResults');
    // $results = (new ProductQATestResultTransformer)->collectionTransformer(self::with(['product.product_model', 'qa_test'])->get(), 'detailed');
    return response()->json($results, 200);
  }
}
