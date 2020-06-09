<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\QATest;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Transformers\ProductTransformer;
use App\Modules\SuperAdmin\Transformers\ProductQATestResultTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductQATestResult
 *
 * @property-read \App\Modules\SuperAdmin\Models\Product $product
 * @property-read \App\Modules\SuperAdmin\Models\QATest $qa_test
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductQATestResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductQATestResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductQATestResult query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $product_id
 * @property int $qa_test_id
 * @property int $is_qa_certified
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductQATestResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductQATestResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductQATestResult whereIsQaCertified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductQATestResult whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductQATestResult whereQaTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductQATestResult whereUpdatedAt($value)
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

  public static function routes()
  {
    Route::group(['prefix' => 'product-qa-test-results'], function () {
      $p = function ($name) {
        return 'superadmin.products.' . $name;
      };
      Route::get('', [self::class, 'getProductQATestResults'])->name($p('qa_test_results'))->defaults('ex', __e('file-text', false));
    });
  }

  public function getProductQATestResults()
  {
    $results = (new ProductTransformer)->collectionTransformer(Product::has('qa_tests')->with(['qa_tests', 'product_model'])->get(), 'transformWithTestResults');
    // $results = (new ProductQATestResultTransformer)->collectionTransformer(self::with(['product.product_model', 'qa_test'])->get(), 'detailed');
    return response()->json($results, 200);
  }
}
