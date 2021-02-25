<?php

namespace App\Modules\SalesRep\Models;

use App\User;
use Throwable;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\SuperAdmin\Traits\IsAStaff;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SalesRep\Transformers\SalesRepTransformer;
use App\Modules\SuperAdmin\Transformers\AdminUserTransformer;

/**
 * App\Modules\SalesRep\Models\SalesRep
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $password
 * @property string|null $phone
 * @property string|null $avatar
 * @property string|null $address
 * @property string $unit
 * @property string|null $gender
 * @property int $office_branch_id
 * @property int|null $is_active
 * @property string|null $verified_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\UserComment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\OtherExpense[] $expenses
 * @property-read int|null $expenses_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SalesRep\Models\ProductDispatchRequest[] $product_dispatch_requests
 * @property-read int|null $product_dispatch_requests_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ProductHistory[] $product_histories
 * @property-read int|null $product_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductSaleRecord[] $product_sales_record
 * @property-read int|null $product_sales_record_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ResellerHistory[] $reseller_histories
 * @property-read int|null $reseller_histories_count
 * @method static Builder|SalesRep callCenter()
 * @method static Builder|SalesRep newModelQuery()
 * @method static Builder|SalesRep newQuery()
 * @method static Builder|SalesRep query()
 * @method static Builder|SalesRep socialMedia()
 * @method static Builder|SalesRep walkIn()
 * @method static Builder|SalesRep whereAddress($value)
 * @method static Builder|SalesRep whereAvatar($value)
 * @method static Builder|SalesRep whereCreatedAt($value)
 * @method static Builder|SalesRep whereDeletedAt($value)
 * @method static Builder|SalesRep whereEmail($value)
 * @method static Builder|SalesRep whereFullName($value)
 * @method static Builder|SalesRep whereGender($value)
 * @method static Builder|SalesRep whereId($value)
 * @method static Builder|SalesRep whereIsActive($value)
 * @method static Builder|SalesRep whereOfficeBranchId($value)
 * @method static Builder|SalesRep wherePassword($value)
 * @method static Builder|SalesRep wherePhone($value)
 * @method static Builder|SalesRep whereRememberToken($value)
 * @method static Builder|SalesRep whereUnit($value)
 * @method static Builder|SalesRep whereUpdatedAt($value)
 * @method static Builder|SalesRep whereVerifiedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductSaleRecord[] $onlineSalesRecords
 * @property-read int|null $online_sales_records_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductSaleRecord[] $walkInSalesRecords
 * @property-read int|null $walk_in_sales_records_count
 * @property-read string $receipt_thumb_url
 * @property-read string $avatar_thumb_url
 */
class SalesRep extends User
{

  use IsAStaff;

  protected $fillable = [
    'role_id', 'full_name', 'email', 'password', 'phone', 'avatar', 'gender', 'address',
  ];
  protected $dates = ['dob'];
  const DASHBOARD_ROUTE_PREFIX = 'sales-reps';

  public function is_verified(): bool
  {
    return $this->verified_at !== null;
  }

  static function defaultSystemAccountId(): int
  {
    return 1;
  }

  public function walkInSalesRecords()
  {
    return $this->morphMany(ProductSaleRecord::class, 'sales_rep');
  }

  public function onlineSalesRecords()
  {
    return $this->hasMany(ProductSaleRecord::class, 'online_rep_id');
  }

  public function product_dispatch_requests()
  {
    return $this->hasMany(ProductDispatchRequest::class, 'online_rep_id');
  }

  static function findByEmail(string $email)
  {
    return self::whereEmail($email)->first();
  }

  public function getAvatarThumbUrlAttribute(): string
  {
    return Str::of($this->avatar)->replace(Str::of($this->avatar)->dirname(), Str::of($this->avatar)->dirname() . '/thumbs');
  }

  static function superAdminRoutes()
  {
    // Route::name('superadmin.manage_staff.')->prefix('sales-reps')->group(function () {
    self::staffRoutes();
    // });
  }

  /** Overide trait method */
  public function getAllStaff(Request $request)
  {
    $salesReps =
      // Cache::rememberForever('allSalesReps', fn() =>
      (new SalesRepTransformer)->collectionTransformer(
        self::withCount([
          'onlineSalesRecords',
          'walkInSalesRecords',
          'onlineSalesRecords AS total_online_sales_amount' => fn ($query) => $query->select(DB::raw('SUM(selling_price)')),
          'walkInSalesRecords AS total_walk_in_sales_amount' => fn ($query) => $query->select(DB::raw('SUM(selling_price)')),
          'onlineSalesRecords AS total_online_sales_bonus_amount' => fn ($query) => $query->select(DB::raw('SUM(online_rep_bonus)')),
          'walkInSalesRecords AS total_walk_in_sales_bonus_amount' => fn ($query) => $query->select(DB::raw('SUM(walk_in_rep_bonus)')),

          'onlineSalesRecords AS monthly_online_sales_amount' => fn ($query) => $query->thisMonth()->select(DB::raw('SUM(selling_price)')),
          'walkInSalesRecords AS monthly_walk_in_sales_amount' => fn ($query) => $query->thisMonth()->select(DB::raw('SUM(selling_price)')),
          'onlineSalesRecords AS monthly_online_sales_bonus_amount' => fn ($query) => $query->thisMonth()->select(DB::raw('SUM(online_rep_bonus)')),
          'walkInSalesRecords AS monthly_walk_in_sales_bonus_amount' => fn ($query) => $query->thisMonth()->select(DB::raw('SUM(walk_in_rep_bonus)')),
          'onlineSalesRecords AS monthly_online_sales_count' => fn ($query) => $query->thisMonth(),
          'walkInSalesRecords AS monthly_walk_in_sales_count' => fn ($query) => $query->thisMonth(),

          'onlineSalesRecords AS last_month_online_sales_amount' => fn ($query) => $query->lastMonth()->select(DB::raw('SUM(selling_price)')),
          'walkInSalesRecords AS last_month_walk_in_sales_amount' => fn ($query) => $query->lastMonth()->select(DB::raw('SUM(selling_price)')),
          'onlineSalesRecords AS last_month_online_sales_bonus_amount' => fn ($query) => $query->lastMonth()->select(DB::raw('SUM(online_rep_bonus)')),
          'walkInSalesRecords AS last_month_walk_in_sales_bonus_amount' => fn ($query) => $query->lastMonth()->select(DB::raw('SUM(walk_in_rep_bonus)')),
          'onlineSalesRecords AS last_month_online_sales_count' => fn ($query) => $query->lastMonth(),
          'walkInSalesRecords AS last_month_walk_in_sales_count' => fn ($query) => $query->lastMonth(),

          'onlineSalesRecords AS today_online_sales_count' => fn ($query) => $query->today(),
          'walkInSalesRecords AS today_walk_in_sales_count' => fn ($query) => $query->today(),
          'onlineSalesRecords AS today_online_sales_amount' => fn ($query) => $query->today()->select(DB::raw('SUM(selling_price)')),
          'walkInSalesRecords AS today_walk_in_sales_amount' => fn ($query) => $query->today()->select(DB::raw('SUM(selling_price)')),
          'onlineSalesRecords AS today_online_sales_bonus_amount' => fn ($query) => $query->today()->select(DB::raw('SUM(online_rep_bonus)')),
          'walkInSalesRecords AS today_walk_in_sales_bonus_amount' => fn ($query) => $query->today()->select(DB::raw('SUM(walk_in_rep_bonus)')),
        ])->withTrashed()->get(),
        'transformForSuperAdminViewSalesReps'
      );
    // });

    if ($request->isApi())  return response()->json($salesReps, 200);
    return Inertia::render('SuperAdmin,ManageStaff/ManageSalesReps', compact('salesReps'));
  }


  public function scopeSocialMedia($query)
  {
    return $query->where('unit', 'social-media');
  }

  public function scopeWalkIn($query)
  {
    return $query->where('unit', 'walk-in');
  }

  public function scopeCallCenter($query)
  {
    return $query->where('unit', 'call-center');
  }

  protected static function booted()
  {
    static::addGlobalScope('safeRecords', function (Builder $builder) {
      $builder->where('id', '>', 1);
    });


    static::saved(function (self $salesRep) {
      Cache::forget('allSalesReps');
    });
  }
}
