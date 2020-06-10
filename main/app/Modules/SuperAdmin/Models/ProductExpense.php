<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Transformers\ProductExpenseTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductExpense
 *
 * @property-read \App\Modules\SuperAdmin\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductExpense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductExpense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductExpense query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $product_id
 * @property float $amount
 * @property string $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductExpense whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductExpense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductExpense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductExpense whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductExpense whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductExpense whereUpdatedAt($value)
 */
class ProductExpense extends Model
{
  protected $fillable = [
    'amount',
    'reason',
  ];

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public static function routes()
  {
    Route::group(['prefix' => 'product-expenses'], function () {
      $p = function ($name) {
        return 'superadmin.products.' . $name;
      };
      Route::get('', [self::class, 'getProductExpenses'])->name($p('expenses'))->defaults('ex', __e('ss', 'credit-card', false));
    });
  }

  public function getProductExpenses()
  {
    return response()->json((new ProductExpenseTransformer)->collectionTransformer(self::all(), 'basic'), 200);
  }
}
