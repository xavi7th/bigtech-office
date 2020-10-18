<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Transformers\ProductExpenseTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductExpense
 *
 * @property int $id
 * @property int $product_id
 * @property string $product_type
 * @property float $amount
 * @property string $reason
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductExpense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductExpense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductExpense query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductExpense whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductExpense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductExpense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductExpense whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductExpense whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductExpense whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductExpense whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductExpense extends BaseModel
{
  protected $fillable = [
    'amount',
    'reason',
  ];

  public function product()
  {
    return $this->morphTo();
  }

  public static function qualityControlRoutes()
  {
    Route::name('qualitycontrol.products.')->group(function () {
      Route::post('product/{product:product_uuid}/create', [self::class, 'createProductExpense'])->name('create_product_expense')->defaults('ex', __e('ss', null, true));
      Route::post('swap-deal/{swapDeal:product_uuid}/create', [self::class, 'createSwapExpense'])->name('create_swap_expense')->defaults('ex', __e('ss', null, true));
    });
  }
  public static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'product-expenses'], function () {
      $p = function ($name) {
        return 'multiaccess.products.' . $name;
      };
      // Route::get('', [self::class, 'getAllProductExpenses'])->name($p('create_expense'))->defaults('ex', __e('ss', 'credit-card', true));
      Route::get('{date}', [self::class, 'getDailyProductExpenses'])->name($p('daily_expenses'))->defaults('ex', __e('ss,ac', 'credit-card', true))->middleware('auth:super_admin,accountant');
      Route::get('product/{product:product_uuid}', [self::class, 'getProductExpenses'])->name($p('expenses'))->defaults('ex', __e('ss,q,ac', null, true))->middleware('auth:super_admin,quality_control,accountant');
      Route::get('swap-deal/{swapDeal:product_uuid}', [self::class, 'getSwapDealExpenses'])->name($p('swap_expenses'))->defaults('ex', __e('ss,q,ac', null, true))->middleware('auth:super_admin,quality_control,accountant');
    });
  }

  public function getAllProductExpenses()
  {
    return response()->json((new ProductExpenseTransformer)->collectionTransformer(self::all(), 'basic'), 200);
  }

  public function getDailyProductExpenses(Request $request, $date)
  {
    $expenses = (new ProductExpenseTransformer)->collectionTransformer(self::whereDate('created_at', Carbon::parse($date))->with(
      'product',
      'product.storage_size',
      'product.product_model',
      'product.product_price',
      'product.product_status',
      'product.product_color',
      'product.product_expenses_amount'
    )->get(), 'transformWithProduct');

    if ($request->isApi()) return response()->json($expenses, 200);
    return Inertia::render('SuperAdmin,Products/DailyProductExpenses', compact('date', 'expenses'));
  }


  public function getProductExpenses(Request $request, Product $product)
  {
    $productWithExpenses = (new ProductExpenseTransformer)->collectionTransformer($product->product_expenses, 'basic');
    $product = ['uuid' => $product->product_uuid, 'identifier' => $product->primary_identifier()];

    if ($request->isApi()) return response()->json($productWithExpenses, 200);
    return Inertia::render('SuperAdmin,Products/Expenses', compact('productWithExpenses', 'product'));
  }


  public function getSwapDealExpenses(Request $request, SwapDeal $swapDeal)
  {
    $productWithExpenses = (new ProductExpenseTransformer)->collectionTransformer($swapDeal->product_expenses, 'basic');
    $product = ['uuid' => $swapDeal->product_uuid, 'identifier' => $swapDeal->primary_identifier()];
    $isSwapDeal = true;

    if ($request->isApi()) return response()->json($productWithExpenses, 200);
    return Inertia::render('SuperAdmin,Products/Expenses', compact('productWithExpenses', 'product', 'isSwapDeal'));
  }

  public function createProductExpense(Request $request, Product $product)
  {
    if (!$request->amount || !$request->reason) {
      return generate_422_error('Amount and reason for expense required');
    }

    if (!is_numeric($request->amount)) {
      return generate_422_error('Amount must be numeric');
    }

    try {
      $product_expense = $product->product_expenses()->create($request->only(['amount', 'reason']));

      if ($request->isApi()) return response()->json((new ProductExpenseTransformer)->basic($product_expense), 201);
      return back()->withSuccess('Expense created');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'ProductExpense not created');
      return response()->json(['err' => 'ProductExpense not created'], 500);
    }
  }

  public function createSwapExpense(Request $request, SwapDeal $swapDeal)
  {
    if (!$request->amount || !$request->reason) {
      return generate_422_error('Amount and reason for expense required');
    }

    if (!is_numeric($request->amount)) {
      return generate_422_error('Amount must be numeric');
    }

    try {
      $swapDeal_expense = $swapDeal->product_expenses()->create($request->only(['amount', 'reason']));

      if ($request->isApi()) return response()->json((new ProductExpenseTransformer)->basic($swapDeal_expense), 201);
      return back()->withSuccess('Expense created');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'ProductExpense not created');
      return response()->json(['err' => 'ProductExpense not created'], 500);
    }
  }


  protected static function boot()
  {
    parent::boot();

    static::creating(function (self $productExpense) {
      request()->user()->activities()->create([
        'activity' => 'Recorded an expense for ' . $productExpense->product->primary_identifier() . ' of ' . to_naira($productExpense->amount),
      ]);
    });
  }
}
