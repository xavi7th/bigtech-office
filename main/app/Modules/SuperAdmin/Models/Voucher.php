<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ActivityLog;

/**
 * App\Modules\SuperAdmin\Models\Voucher
 *
 * @property-read \App\Modules\AppUser\Models\AppUser $app_user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Voucher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Voucher newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\Voucher onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Voucher query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\Voucher withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\Voucher withoutTrashed()
 * @mixin \Eloquent
 */
class Voucher extends Model
{
  use SoftDeletes;

  protected $fillable = ['code', 'amount'];

  static function exists(string $data): bool
  {
    return self::where('code', $data)->exists();
  }

  public function app_user()
  {
    return $this->belongsTo(AppUser::class);
  }

  /**
   * ! Card User routes
   */
  public function getAppUserVouchers()
  {
    return auth()->user()->vouchers;
  }

  public function getAppUserVoucherTransactions(self $voucher)
  {
    return $voucher;
  }

  public function getAppUserActiveVoucher()
  {
    $active_voucher = auth()->user()->active_voucher;
    if ($active_voucher) {
      return $active_voucher;
    } else {
      return response()->json(['message' => 'No active voucher at the moment'], 404);
    }
  }

  /**
   * ! Admin routes
   */
  public function getAllVouchers()
  {
    return self::all();
  }

  public function createVoucher(Request $request)
  {

    if ($request->auto_generate) {
      $voucher_code = unique_random('vouchers', 'code', null, 10);
      $voucher = self::create(Arr::add($request->except('code'), 'code', $voucher_code));
    } else {
      $voucher = self::create($request->all());
    }

    ActivityLog::logAdminActivity(auth()->user()->email . ' created a voucher for ' . to_naira($voucher->amount));

    return response()->json(['voucher' => $voucher], 201);
  }
}
