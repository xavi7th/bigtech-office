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

class ErrLog extends BaseModel
{
  protected $fillable = [];

  static function notifyAdmin(?User $user, Throwable $exception, string $message = null)
  {
    if ($exception instanceof TypeError) {
      Log::error($message, ['userId' => optional($user)->id, 'userType' => get_class($user), 'exception' => $exception->getMessage()]);
    }
    Log::error($message, ['userId' => optional($user)->id, 'userType' => get_class($user), 'exception' => $exception]);
  }

  static function notifyAdminAndFail(?User $user, Throwable $exception, string $message = null)
  {
    if (DB::transactionLevel() > 0) {
      DB::rollBack();
    }
    Log::error($message, ['userId' => optional($user)->id, 'userType' => get_class($user), 'exception' => $exception]);
  }

  static function routes()
  {
    Route::group([], function () {

      Route::get('error-logs', [self::class, 'getErrorLogs'])->name('superadmin.logs.error_logs')->defaults('ex', __e('ss', 'activity', false));
    });
  }

  public function getErrorLogs(Request $request)
  {
    if ($request->isApi())
      return (new ErrLogTransformer)->collectionTransformer(self::latest()->get(), 'basicTransform');
    return Inertia::render('SuperAdmin,Notifications/ErrorLogs');
  }
}
