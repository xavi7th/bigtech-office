<?php

namespace App\Modules\SuperAdmin\Models;

use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Transformers\ProductExpenseTransformer;

class ProductExpense extends Model
{
  protected $fillable = [
    'amount',
    'reason',
  ];

  public function __construct()
  {
    Inertia::setRootView('superadmin::app');
  }

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
      // Route::get('', [self::class, 'getAllProductExpenses'])->name($p('create_expense'))->defaults('ex', __e('ss', 'credit-card', true));
      Route::get('{date}', [self::class, 'getDailyProductExpenses'])->name($p('daily_expenses'))->defaults('ex', __e('ss', 'credit-card', true));
      Route::get('{product}', [self::class, 'getProductExpenses'])->name($p('expenses'))->defaults('ex', __e('ss', null, true));
      Route::post('{product}/create', [self::class, 'createProductExpense'])->name($p('create_product_expense'))->defaults('ex', __e('ss', null, true));
    });
  }

  public function getAllProductExpenses()
  {
    return response()->json((new ProductExpenseTransformer)->collectionTransformer(self::all(), 'basic'), 200);
  }

  public function getDailyProductExpenses(Request $request, $date)
  {
    $expenses = (new ProductExpenseTransformer)->collectionTransformer(self::whereDate('created_at', Carbon::parse($date))->get(), 'basic');

    if ($request->isApi()) {
      return response()->json($expenses, 200);
    }

    return Inertia::render('SuperAdmin,Products/DailyProductExpenses', compact('date', 'expenses'));
  }


  public function getProductExpenses(Request $request, Product $product)
  {
    if ($request->isApi()) {
      return response()->json((new ProductExpenseTransformer)->collectionTransformer($product->product_expenses, 'basic'), 200);
    } else {
      return Inertia::render('SuperAdmin,Products/Expenses', [
        'expenses' => (new ProductExpenseTransformer)->collectionTransformer($product->product_expenses, 'basic')
      ]);
    }
  }

  public function createProductExpense(Request $request, self $product)
  {
    if (!$request->amount || !$request->reason) {
      return generate_422_error('Amount and expense reason required');
    }

    if (!is_numeric($request->amount)) {
      return generate_422_error('Amount must be numeric');
    }

    try {
      $product_expense = $product->product_expenses()->create($request->only(['amount', 'reason']));

      return response()->json((new ProductExpenseTransformer)->basic($product_expense), 201);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'ProductExpense not created');
      return response()->json(['err' => 'ProductExpense not created'], 500);
    }
  }
}
