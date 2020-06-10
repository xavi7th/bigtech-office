<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Transformers\ExpenseTransformer;

/**
 * App\Modules\SuperAdmin\Models\Expense
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $recorder
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Expense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Expense newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\Expense onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Expense query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\Expense withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\Expense withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property float $amount
 * @property string $purpose
 * @property int $recorder_id
 * @property string $recorder_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Expense whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Expense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Expense whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Expense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Expense wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Expense whereRecorderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Expense whereRecorderType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Expense whereUpdatedAt($value)
 */
class Expense extends Model
{
  use SoftDeletes;
  protected $fillable = ['amount', 'purpose'];

  public function recorder()
  {
    return $this->morphTo();
  }

  public static function routes()
  {
    Route::group(['prefix' => 'expenses'], function () {
      $gen = function ($namespace, $name = null) {
        return 'superadmin.product_' . $namespace . $name;
      };

      Route::get('', [self::class, 'getExpenses'])->name($gen('office_expenses'))->defaults('ex', __e('ss', 'clipboard', false));
      Route::post('create', [self::class, 'createExpense'])->name($gen('office_expenses', '.create_expense'))->defaults('ex', __e('ss', 'clipboard', true));
      Route::put('{size}/edit', [self::class, 'editExpense'])->name($gen('office_expenses', '.edit_expense'))->defaults('ex', __e('ss', 'clipboard', true));
    });
  }


  public function getExpenses()
  {
    return response()->json((new ExpenseTransformer)->collectionTransformer(self::with('recorder')->get(), 'basic'), 200);
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

      return response()->json((new ExpenseTransformer)->basic($expense), 201);
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
