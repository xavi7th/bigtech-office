<?php

namespace App;

use Inertia\Inertia;
use App\Modules\Admin\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Modules\AppUser\Models\AppUser;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\WebAdmin\Models\WebAdmin;
use App\Modules\Accountant\Models\Accountant;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\StockKeeper\Models\StockKeeper;
use App\Modules\SuperAdmin\Models\OtherExpense;
use App\Modules\SuperAdmin\Traits\MakesComments;
use App\Modules\SuperAdmin\Models\ProductHistory;
use App\Modules\SuperAdmin\Models\ResellerHistory;
use App\Modules\DispatchAdmin\Models\DispatchAdmin;
use App\Modules\QualityControl\Models\QualityControl;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\UserComment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|OtherExpense[] $expenses
 * @property-read int|null $expenses_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductHistory[] $product_histories
 * @property-read int|null $product_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ResellerHistory[] $reseller_histories
 * @property-read int|null $reseller_histories_count
 * @property-write mixed $password
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable implements JWTSubject
{
  use Notifiable, SoftDeletes, MakesComments;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'name', 'email', 'password',
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = [
    'password', 'remember_token',
  ];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function expenses()
  {
    return $this->morphMany(OtherExpense::class, 'recorder')->latest();
  }

  public function activities()
  {
    return $this->morphMany(ActivityLog::class, 'user')->latest();
  }

  public function product_histories()
  {
    return $this->morphMany(ProductHistory::class, 'user')->latest();
  }

  public function reseller_histories()
  {
    return $this->morphMany(ResellerHistory::class, 'user', 'handler_type', 'handled_by')->latest();
  }

  public function setPasswordAttribute($value)
  {
    $this->attributes['password'] = bcrypt($value);
  }

  public function isAppUser(): bool
  {
    return $this instanceof AppUser;
  }

  public function isAdmin(): bool
  {
    return $this instanceof Admin;
  }

  public function isSuperAdmin(): bool
  {
    return $this instanceof SuperAdmin;
  }

  public function isSalesRep(): bool
  {
    return $this instanceof SalesRep;
  }

  public function isSocialMediaRep(): bool
  {
    return $this instanceof SalesRep && $this->unit == 'social-media';
  }

  public function isWalkInRep(): bool
  {
    return $this instanceof SalesRep && $this->unit == 'walk-in';
  }

  public function isCallCenterRep(): bool
  {
    return $this instanceof SalesRep && $this->unit == 'call-center';
  }

  public function isStockKeeper(): bool
  {
    return $this instanceof StockKeeper;
  }

  public function isAccountant(): bool
  {
    return $this instanceof Accountant;
  }

  public function isQualityControl(): bool
  {
    return $this instanceof QualityControl;
  }

  public function isDispatchAdmin(): bool
  {
    return $this instanceof DispatchAdmin;
  }

  public function isWebAdmin(): bool
  {
    return $this instanceof WebAdmin;
  }

  public function get_navigation_routes(): array
  {
    return get_related_routes(strtolower($this->getType()), ['GET'], $isHeirarchical = true);
  }

  public function dashboardRoute(): string
  {
    return strtolower($this->getType()) . '.dashboard';
  }

  public function getType(): string
  {
    return class_basename(get_class($this));
  }

  public function toFlare(): array
  {
    // Only `id` will be sent to Flare.
    return [
      'id' => $this->id
    ];
  }

  /**
   * Get the identifier that will be stored in the subject claim of the JWT.
   *
   * @return mixed
   */
  public function getJWTIdentifier()
  {
    return $this->getKey();
  }

  /**
   * Return a key value array, containing any custom claims to be added to the JWT.
   *
   * @return array
   */
  public function getJWTCustomClaims()
  {
    return [];
  }
}
