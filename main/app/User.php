<?php

namespace App;

use Inertia\Inertia;
use App\Modules\Auditor\Models\Auditor;
use App\Modules\AppUser\Models\AppUser;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\WebAdmin\Models\WebAdmin;
use App\Modules\Accountant\Models\Accountant;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\SuperAdmin\Models\OtherExpense;
use App\Modules\SuperAdmin\Traits\MakesComments;
use App\Modules\SuperAdmin\Models\ProductHistory;
use App\Modules\SuperAdmin\Models\ResellerHistory;
use App\Modules\QualityControl\Models\QualityControl;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
    'is_active' =>'bool'
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

  public function isAuditor(): bool
  {
    return $this instanceof Auditor;
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

  public function isOnlineSalesRep(): bool
  {
    return $this->isSocialMediaRep() || $this->isCallCenterRep();
  }

  public function isAccountant(): bool
  {
    return $this instanceof Accountant;
  }

  public function isQualityControl(): bool
  {
    return $this instanceof QualityControl;
  }

  public function isWebAdmin(): bool
  {
    return $this instanceof WebAdmin;
  }

  public function getUserType()
  {
    if ($this->isAccountant()) {
      return ['isAccountant' => true, 'office_branch' => $this->office_branch->city, 'user_type' => strtolower($this->getType())];
    } elseif ($this->isAuditor()) {
      return ['isAuditor' => true, 'office_branch' => $this->office_branch->city, 'user_type' => strtolower($this->getType())];
    } elseif ($this->isSuperAdmin()) {
      return ['isSuperAdmin' => true, 'user_type' => strtolower($this->getType())];
    } elseif ($this->isSocialMediaRep()) {
      return [ 'isSocialMediaRep' => true, 'office_branch' => $this->office_branch->city, 'user_type' => strtolower($this->getType()), 'isOnlineSalesRep' => true ];
    } elseif ($this->isWalkInRep()) {
      return ['isWalkInRep' => true, 'office_branch' => $this->office_branch->city, 'user_type' => strtolower($this->getType())];
    } elseif ($this->isCallCenterRep()) {
      return ['isCallCenterRep' => true, 'office_branch' => $this->office_branch->city, 'user_type' => strtolower($this->getType()), 'isOnlineSalesRep' => true ];
    } elseif ($this->isQualityControl()) {
      return ['isQualityControl' => true, 'office_branch' => $this->office_branch->city, 'user_type' => strtolower($this->getType())];
    } elseif ($this->isWebAdmin()) {
      return ['isWebAdmin' => true, 'office_branch' => $this->office_branch->city, 'user_type' => strtolower($this->getType())];
    }
  }

  public function get_navigation_routes(): array
  {
    return get_related_routes(strtolower($this->getType()), ['GET'], $isHeirarchical = true);
  }

  public function getDashboardRoute(): string
  {
    // return 'multiaccess.products.view_products';
    return strtolower($this->getType()) . '.dashboard';
  }

  /**
   * Find a user from the different user types using an email
   *
   * @param string $email
   *
   * @return \App\User
   */
  static function findUserByEmail(string $email): self
  {
    return SalesRep::findByEmail($email) ?? QualityControl::findByEmail($email) ?? WebAdmin::findByEmail($email) ?? Accountant::findByEmail($email) ?? Auditor::findByEmail($email);
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
