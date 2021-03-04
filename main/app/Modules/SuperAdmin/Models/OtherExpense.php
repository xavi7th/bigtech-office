<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Transformers\OtherExpenseTransformer;

class OtherExpense extends BaseModel
{
  use SoftDeletes;
  protected $fillable = ['amount', 'purpose'];
  protected $table = 'expenses';

  public function recorder()
  {
    return $this->morphTo();
  }

  public static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'other-expenses'], function () {
      Route::name('multiaccess.miscellaneous.')->group(function () {
        Route::get('', [self::class, 'getAllExpenses'])->name('all_expenses')->defaults('ex', __e('ss,a,ac', 'clipboard', false))->middleware('auth:super_admin,auditor,accountant');
        Route::get('daily', [self::class, 'getDailyExpenses'])->name('daily_expense')->defaults('ex', __e('ss,a,ac,s', 'clipboard', false))->middleware('auth:super_admin,auditor,accountant,sales_rep');
        Route::post('daily', [self::class, 'createExpense'])->name('create_daily_expense')->middleware('auth:sales_rep,accountant');
        Route::get('{date}', [self::class, 'getExpensesByDate'])->name('daily_expenses')->defaults('ex', __e('ss,a,ac', 'clipboard', true))->middleware('auth:super_admin,auditor,accountant');
        // Route::put('{expense}/edit', [self::class, 'editExpense'])->name('edit_expense')->defaults('ex', __e('ss', 'clipboard', true))->middleware('auth:super_admin,accountant');
      });
    });
  }

  public function getDailyExpenses(Request $request)
  {
    if ($request->user()->isSalesRep()) {
      $dailyExpenses = Cache::rememberForever($request->user()->full_name . 'DailyExpenses', fn () => (new OtherExpenseTransformer)->collectionTransformer($request->user()->other_expenses->load('recorder'), 'basic'));
    } else {
      $dailyExpenses = Cache::rememberForever('dailyExpenses', fn () => (new OtherExpenseTransformer)->collectionTransformer(self::today()->with('recorder')->get(), 'basic'));
    }

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
    $expenses = Cache::remember($date . 'dateExpenses', (60 * 60 * 10), fn () => (new OtherExpenseTransformer)->collectionTransformer(self::with('recorder')->whereDate('created_at', Carbon::parse($date))->get(), 'basic'));

    if ($request->isApi()) return response()->json($expenses, 200);
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

      if ($request->isApi()) return response()->json((new OtherExpenseTransformer)->basic($expense), 201);
      return back()->withFlash(['success'=>'Expense Record created. ']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Expense record not created');
      if ($request->isApi()) return response()->json(['err' => 'Expense record not created'], 500);
      return back()->withFlash(['error'=>['Could not create expense record. Try again']]);
    }
  }

  public function scopeToday($query)
  {
    return $query->whereDay('created_at', today());
  }

  public function scopeThisMonth($query)
  {
    return $query->whereMonth('created_at', today());
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

  protected static function boot()
  {
    parent::boot();

    static::saved(function () {
      request()->user() && Cache::forget(request()->user()->full_name . 'DailyExpenses');
      Cache::forget('dailyExpenses');
      Cache::forget('allExpenses');
    });
  }
}
