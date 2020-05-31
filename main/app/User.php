<?php

namespace App;

use App\Modules\Admin\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ActivityLog;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Modules\AppUser\Models\AppUser;

/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\User withoutTrashed()
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 */
class User extends Authenticatable //implements JWTSubject
{
  use Notifiable, SoftDeletes;

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
    return $this->morphMany(Expense::class, 'recorder')->latest();
  }


  public function activities()
  {
    return $this->morphMany(ActivityLog::class, 'user')->latest();
  }

  public function setPasswordAttribute($value)
  {
    $this->attributes['password'] = bcrypt($value);
  }

  /**
   * Check if the currently authenticated user's status
   *
   * @return bool
   */

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

  public function get_navigation_routes(): object
  {
    return $this->isAdmin() ? get_related_routes('admin.', ['GET']) : $this->isAppUser() ? get_related_routes('appuser.', ['GET']) : get_related_routes('app.', ['GET']);
  }

  public function dashboardRoute(): string
  {
    if ($this->isAppUser()) {
      return  'appuser.dashboard';
    } elseif ($this->isAdmin()) {
      return 'admin.dashboard';
    } elseif ($this->isSuperAdmin()) {
      return 'superadmin.dashboard';
    } else if (Auth::normalAdmin()) {
      return 'normaladmin.dashboard';
    } else if (Auth::accountant()) {
      return 'accountant.dashboard';
    } else if (Auth::accountOfficer()) {
      return 'accountofficer.dashboard';
    } else if (Auth::salesRep()) {
      return 'salesrep.dashboard';
    } else if (Auth::customerSupport()) {
      return 'customersupport.dashboard';
    } else {
      abort(403, 'Invalid user');
    }
  }

  public function getType(): string
  {
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
