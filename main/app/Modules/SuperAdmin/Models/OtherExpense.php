<?php

namespace App\Modules\SuperAdmin\Models;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Transformers\OtherExpenseTransformer;

class OtherExpense extends Model
{
  use SoftDeletes;
  protected $fillable = ['amount', 'purpose'];
  protected $table = 'expenses';

  public function __construct()
  {
    Inertia::setRootView('superadmin::app');
  }

  public function recorder()
  {
    return $this->morphTo();
  }

  public static function routes()
  {
    Route::group(['prefix' => 'expenses'], function () {
      $gen = function ($name) {
        return 'superadmin.miscellaneous.' . $name;
      };

      Route::get('', [self::class, 'getExpenses'])->name($gen('other_expenses'))->defaults('ex', __e('ss', 'clipboard', true));
      Route::get('', [self::class, 'showCreateExpenseForm'])->name($gen('create_expense'))->defaults('ex', __e('ss', 'clipboard', false));
      Route::post('create', [self::class, 'createExpense'])->name($gen('save_expense'))->defaults('ex', __e('ss', 'clipboard', true));
      Route::put('{size}/edit', [self::class, 'editExpense'])->name($gen('edit_expense'))->defaults('ex', __e('ss', 'clipboard', true));
    });
  }


  public function getExpenses()
  {
    return response()->json((new OtherExpenseTransformer)->collectionTransformer(self::with('recorder')->get(), 'basic'), 200);
  }

  public function showCreateExpenseForm()
  {
    return Inertia::render('Miscellaneous/CreateExpense');
  }

  public function createExpense(Request $request)
  {
    if (!$request->amount || !$request->purpose) {
      return generate_422_error('Specify amount and purpose of the expense');
    }

    if (!is_numeric($request->amount)) {
      return generate_422_error('Expense amount must be a number');
    }

    try {
      $expense = auth()->user()->expenses()->create([
        'amount' => $request->amount,
        'purpose' => $request->purpose,
      ]);

      return response()->json((new OtherExpenseTransformer)->basic($expense), 201);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth()->user(), $th, 'Expense record not created');
      return response()->json(['err' => 'Expense record not created'], 500);
    }
  }


  public function editExpense(Request $request, self $expense)
  {
    try {
      foreach ($request->validated() as $key => $value) {
        $expense->$key = $value;
      }

      $expense->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth()->user(), $th, 'Expense record NOT updated');
      return response()->json(['err' => 'Expense record NOT updated'], 500);
    }
  }
}
