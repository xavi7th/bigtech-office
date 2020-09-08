<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Transformers\OtherExpenseTransformer;
use Cache;

/**
 * App\Modules\SuperAdmin\Models\OtherExpense
 *
 * @property int $id
 * @property float $amount
 * @property string $purpose
 * @property int $recorder_id
 * @property string $recorder_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $recorder
 * @method static Builder|OtherExpense newModelQuery()
 * @method static Builder|OtherExpense newQuery()
 * @method static \Illuminate\Database\Query\Builder|OtherExpense onlyTrashed()
 * @method static Builder|OtherExpense query()
 * @method static Builder|OtherExpense today()
 * @method static Builder|OtherExpense whereAmount($value)
 * @method static Builder|OtherExpense whereCreatedAt($value)
 * @method static Builder|OtherExpense whereDeletedAt($value)
 * @method static Builder|OtherExpense whereId($value)
 * @method static Builder|OtherExpense wherePurpose($value)
 * @method static Builder|OtherExpense whereRecorderId($value)
 * @method static Builder|OtherExpense whereRecorderType($value)
 * @method static Builder|OtherExpense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|OtherExpense withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OtherExpense withoutTrashed()
 * @mixin \Eloquent
 */
class OtherExpense extends BaseModel
{
  use SoftDeletes;
  protected $fillable = ['amount', 'purpose'];
  protected $table = 'expenses';

  public function recorder()
  {
    return $this->morphTo();
  }

  public static function routes()
  {
    Route::group(['prefix' => 'other-expenses'], function () {
      $gen = function ($name) {
        return 'superadmin.miscellaneous.' . $name;
      };

      Route::get('', [self::class, 'getDailyExpenses'])->name($gen('daily_expense'))->defaults('ex', __e('ss', 'clipboard', false));
      Route::get('all', [self::class, 'getAllExpenses'])->name($gen('all_expenses'))->defaults('ex', __e('ss', 'clipboard', false));
      Route::get('{date}', [self::class, 'getExpensesByDate'])->name($gen('daily_expenses'))->defaults('ex', __e('ss', 'clipboard', true));
      Route::post('create', [self::class, 'createExpense'])->name($gen('create_daily_expense'))->defaults('ex', __e('ss', 'clipboard', true));
      // Route::put('{size}/edit', [self::class, 'editExpense'])->name($gen('edit_expense'))->defaults('ex', __e('ss', 'clipboard', true));
    });
  }

  public function getDailyExpenses(Request $request)
  {
    $dailyExpenses = Cache::rememberForever('dailyExpenses', function () {
      return (new OtherExpenseTransformer)->collectionTransformer(self::today()->with('recorder')->get(), 'basic');
    });

    if ($request->isApi()) return response()->json($dailyExpenses, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/CreateExpense', compact('dailyExpenses'));
  }

  public function getAllExpenses(Request $request)
  {
    $dailyExpenses = Cache::rememberForever('allExpenses', function () {
      return (new OtherExpenseTransformer)->collectionTransformer(self::with('recorder')->get(), 'basic');
    });

    if ($request->isApi()) return response()->json($dailyExpenses, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/ViewAllExpenses', compact('dailyExpenses'));
  }

  public function getExpensesByDate(Request $request, $date)
  {
    $expenses = Cache::rememberForever('dateExpenses', function () {
      return (new OtherExpenseTransformer)->collectionTransformer(self::with('recorder')->whereDate('created_at', Carbon::parse($date))->get(), 'basic');
    });
    if ($request->isApi()) {
      return response()->json($expenses, 200);
    }

    return Inertia::render('SuperAdmin,Miscellaneous/DailyOtherExpenses', compact('date', 'expenses'));
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
      $expense = $request->user()->expenses()->create([
        'amount' => $request->amount,
        'purpose' => $request->purpose,
      ]);

      Cache::forget('dailyExpenses');
      Cache::forget('allExpenses');

      if ($request->isApi()) return response()->json((new OtherExpenseTransformer)->basic($expense), 201);
      return back()->withSuccess('Expense Record created. ');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Expense record not created');
      if ($request->isApi()) return response()->json(['err' => 'Expense record not created'], 500);
      return back()->withError('Could not create expense record. Try again');
    }
  }

  public function scopeToday($query)
  {
    return $query->whereDay('created_at', today());
  }

  /**
   * The "booted" method of the model.
   *
   * @return void
   */
  protected static function booted()
  {
    static::addGlobalScope('latest', function (Builder $builder) {
      $builder->latest();
    });
  }
}
