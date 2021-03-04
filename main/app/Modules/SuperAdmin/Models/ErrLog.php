<?php

namespace App\Modules\SuperAdmin\Models;

use App\User;
use Throwable;
use TypeError;
use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Transformers\ErrLogTransformer;

/**
 * App\Modules\SuperAdmin\Models\ErrLog
 *
 * @property int $id
 * @property string|null $message
 * @property string|null $channel
 * @property int $level
 * @property string $level_name
 * @property int $unix_time
 * @property string|null $datetime
 * @property string|null $context
 * @property string|null $extra
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog old()
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereLevelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereUnixTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ErrLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ErrLog extends BaseModel
{
  protected $fillable = [];

  static function notifyAuditor(?User $user, Throwable $exception, string $message = null)
  {
    if ($exception instanceof TypeError) {
      Log::error($message, ['userId' => optional($user)->id, 'userType' => get_class($user), 'exception' => $exception->getMessage()]);
    }
    Log::error($message, ['userId' => optional($user)->id, 'userType' => get_class(optional($user) ?? (object)[]), 'exception' => $exception]);
  }

  static function notifyAuditorAndFail(?User $user, Throwable $exception, string $message = null)
  {
    if (DB::transactionLevel() > 0) {
      DB::rollBack();
    }
    Log::error($message, ['userId' => optional($user)->id, 'userType' => get_class($user), 'exception' => $exception]);
  }

  static function superAdminRoutes()
  {
    Route::group([], function () {
      Route::get('error-logs', [self::class, 'getErrorLogs'])->name('logs.error_logs')->defaults('ex', __e('ss,a', 'activity', false));
      Route::delete('error-logs', [self::class, 'pruneErrLogs'])->name('logs.prune');
      Route::delete('error-logs/flush', [self::class, 'flushErrLogs'])->name('logs.flush');
    });
  }

  public function getErrorLogs(Request $request)
  {
    if ($request->isApi()) return (new ErrLogTransformer)->collectionTransformer(self::latest()->get(), 'basicTransform');
    return Inertia::render('SuperAdmin,Notifications/ErrorLogs', [
      'errLogs' => (new ErrLogTransformer)->collectionTransformer(self::latest()->get(), 'basicTransform')
    ]);
  }

  public function pruneErrLogs(Request $request)
  {
    self::old()->delete();

    return back()->withFlash(['success'=>'Error logs cleared']);
  }

  public function flushErrLogs(Request $request)
  {
    self::exceptLatest(optional(self::latest('id')->first())->id ?? 1)->delete();

    return back()->withFlash(['success' => 'Error logs cleared']);
  }

  public function scopeOld($query)
  {
    return $query->whereDate('created_at', '<', now()->subDays(2));
  }

  public function scopeExceptLatest($query, $id)
  {
    return $query->where('id', '<', $id);
  }

}
