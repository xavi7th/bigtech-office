<?php

namespace App;

use Inertia\Inertia;
use App\Modules\Admin\Models\Admin;
use Illuminate\Support\Facades\Auth;
use App\Modules\AppUser\Models\AppUser;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\SuperAdmin\Models\OtherExpense;
use App\Modules\SuperAdmin\Models\ProductHistory;
use App\Modules\SuperAdmin\Models\ResellerHistory;
use App\Modules\SuperAdmin\Traits\MakesComments;
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

  // public function __construct(array $attributes = [])
  // {
  //   parent::__construct($attributes);
  //   if (routeHasRootNamespace('appuser.')) {
  //     Inertia::setRootView('appuser::app');
  //   } elseif (routeHasRootNamespace('superadmin.')) {
  //     Inertia::setRootView('superadmin::app');
  //   }
  // }

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
    return $this instanceof SuperAdmin;
  }

  public function isSocialMediaRep(): bool
  {
    return $this instanceof SuperAdmin;
  }

  public function isWalkInRep(): bool
  {
    return $this instanceof SuperAdmin;
  }

  public function isCallCenterRep(): bool
  {
    return $this instanceof SuperAdmin;
  }

  public function isStock(): bool
  {
    return $this instanceof SuperAdmin;
  }

  public function isAccountant(): bool
  {
    return $this instanceof SuperAdmin;
  }

  public function isQA(): bool
  {
    return $this instanceof SuperAdmin;
  }

  public function isDispatch(): bool
  {
    return $this instanceof SuperAdmin;
  }

  public function isWebAdmin(): bool
  {
    return $this instanceof SuperAdmin;
  }

  public function get_navigation_routes(): array
  {
    if ($this->isAppUser()) {
      return get_related_routes('appuser.', ['GET'], $isHeirarchical = true);
    } elseif ($this->isAdmin()) {
      return get_related_routes('admin.', ['GET'], $isHeirarchical = true);
    } elseif ($this->isSuperAdmin()) {
      return get_related_routes('superadmin.', ['GET'], $isHeirarchical = true);
    } else {
      return [];
    }
  }

  public function dashboardRoute(): string
  {
    if ($this->isAppUser()) {
      return  'appuser.dashboard';
    } elseif ($this->isAdmin()) {
      return 'admin.dashboard';
    } elseif ($this->isSuperAdmin()) {
      return 'superadmin.dashboard';
    } else {
      abort(403, 'Invalid user');
    }
  }

  public function getType(): string
  {
    return class_basename(get_class($this));
    if ($this->isAppUser()) {
      return  'Normal User';
    } elseif ($this->isAdmin()) {
      return 'Admin';
    } elseif ($this->isSuperAdmin()) {
      return 'Super Admin';
    } else if (Auth::accountant()) {
      return 'Accountant';
    } else if (Auth::accountOfficer()) {
      return 'Account Officer';
    } else if (Auth::salesRep()) {
      return 'Sales Rep';
    } else if (Auth::customerSupport()) {
      return 'Customer Support';
    } else {
      return 'Invalid user';
    }
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
