<?php

namespace App\Modules\AppUser\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Modules\PublicPages\Models\OTP;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\Voucher;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\PublicPages\Notifications\SendOTP;
use App\Modules\AppUser\Notifications\ProfileEdited;
use App\Modules\AppUser\Transformers\AppUserTransformer;
use App\Modules\PublicPages\Notifications\AccountCreated;
use App\Modules\SuperAdmin\Transformers\AdminUserTransformer;
use App\Modules\AppUser\Http\Validations\AppUserUpdateProfileValidation;
use App\Modules\PublicPages\Notifications\SendPasswordResetNotification;

/**
 * App\Modules\AppUser\Models\AppUser
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string|null $email_verified_at
 * @property string $first_name
 * @property string|null $last_name
 * @property string $phone
 * @property string|null $otp_verified_at
 * @property string $address
 * @property string $city
 * @property string|null $ig_handle
 * @property string|null $avatar
 * @property bool $is_active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Voucher|null $active_voucher
 * @property-read \Illuminate\Database\Eloquent\Collection|ActivityLog[] $activities
 * @property-read int|null $activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\UserComment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\OtherExpense[] $expenses
 * @property-read int|null $expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Voucher[] $expired_vouchers
 * @property-read int|null $expired_vouchers_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read OTP|null $otp
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ProductHistory[] $product_histories
 * @property-read int|null $product_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ResellerHistory[] $reseller_histories
 * @property-read int|null $reseller_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Voucher[] $vouchers
 * @property-read int|null $vouchers_count
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereIgHandle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereOtpVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppUser whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AppUser extends User
{
  protected $fillable = [
    'first_name',
    'last_name',
    'ig_handle',
    'email',
    'password',
    'phone',
    'address',
    'city',
    'avatar'
  ];
  protected $hidden = [
    'password', 'remember_token', 'deleted_at', 'created_at', 'updated_at'
  ];

  protected $casts = [
    'is_active' => 'boolean',
  ];

  const DASHBOARD_ROUTE_PREFIX = 'user';


  public function is_otp_verified()
  {
    return $this->otp_verified_at !== null;
  }

  public function otp()
  {
    return $this->hasOne(OTP::class);
  }

  /**
   * Create a new OTP for the user
   *
   * Deletes all previous OTP codes, creates a new unique one and then returns it
   * @return int
   **/
  public function createOTP()
  {
    $otp = unique_random('otps', 'code', null, 4);
    $this->otp()->create([
      'code' => $otp
    ]);

    return $otp;
  }

  public function sendPasswordResetNotification($token)
  {
    $token = $this->generatePasswordResetToken();
    $this->notify(new SendPasswordResetNotification($token));
  }

  private function generatePasswordResetToken()
  {
    $token = unique_random('password_resets', 'token', null, 6);
    DB::table('password_resets')->updateOrInsert(
      ['email' => $this->email],
      ['token' => $token, 'created_at' => now()]

    );
    return $token;
  }

  public function products()
  {
    return $this->hasMany(Product::class);
  }

  public function vouchers()
  {
    return $this->hasMany(Voucher::class);
  }

  public function active_voucher()
  {
    return $this->hasOne(Voucher::class)->whereDate('created_at', '>', now()->subDays(config('app.voucher_validity_days'))->toDateString());
  }

  public function expired_vouchers()
  {
    return $this->hasMany(Voucher::class)->whereDate('created_at', '<', Carbon::today()->subDays(config('app.voucher_validity_days'))->toDateString());
  }


  static function routes()
  {
    Route::group([], function () {
      Route::get('app-users', [self::class, 'getAllAppUsers'])->middleware('auth:admin,normal_admin,account_officer');

      Route::put('app-user/{app_user}/suspend', [self::class, 'suspendAppUser'])->middleware('auth:account_officer');

      Route::put('app-user/{id}/restore', [self::class, 'unsuspendAppUser'])->middleware('auth:account_officer');

      Route::delete('app-user/{app_user}/delete', [self::class, 'deleteAppUserAccount'])->middleware('auth:admin');
    });
  }

  static function appUserRoutes()
  {
    Route::group(['prefix' => 'auth', 'middleware' => ['auth:app_api_user', 'app_users']], function () {

      Route::group(['middleware' => ['unverified_app_users']], function () {
        Route::get('/user/request-otp', [self::class, 'requestOTP']);
        Route::put('/user/verify-otp', [self::class, 'verifyOTP']);
      });

      Route::group(['middleware' => ['verified_app_users']], function () {
        Route::get('app-users/profile-details', [self::class, 'getAppUserProfileDetails']);
        Route::get('/user', [self::class, 'user']);
        Route::put('/user', [self::class, 'updateUserProfile']);
      });
    });
  }

  public function requestOTP(Request $request)
  {
    /** Delete Previous OTP **/
    $request->user()->otp()->delete();

    /** Create new OTP */
    $otp = $request->user()->createOTP();

    /** Send the OTP notification */
    $request->user()->notify(new SendOTP($otp));

    ActivityLog::logUserActivity($request->user()->email . ' successfully requested a new OTP.');

    return response()->json(['message' => 'OTP sent'], 201);
  }

  public function verifyOTP(Request $request)
  {
    if ($request->user()->otp->code !== intval($request->otp)) {
      return response()->json(['message' => 'Invalid OTP code'], 422);
    }
    DB::beginTransaction();
    /** Verify the user **/
    $request->user()->otp_verified_at = now();
    $request->user()->save();

    /** Delete the otp code */
    $request->user()->otp()->delete();

    /** Send welcome message */
    ActivityLog::logUserActivity($request->user()->email . ' OTP successfully verified.');

    $request->user()->notify(new AccountCreated);

    DB::commit();

    return response()->json(['message' => 'Account verified'], 205);
  }

  public function user(Request $request)
  {
    return response()->json((new AppUserTransformer)->transformBasic($request->user()));
  }

  public function updateUserProfile(AppUserUpdateProfileValidation $request)
  {
    auth('app_user')->user()->update($request->except(['email', 'phone']));

    auth()->user()->notify(new ProfileEdited);

    return response()->json(['updated' => true], 204);
  }

  public function getAppUserProfileDetails()
  {
    return self::$editableProperties;
  }

  public function getAllAppUsers()
  {
    return (new AdminUserTransformer)->collectionTransformer(self::withTrashed()->get(), 'transformForAdminViewAppUsers');
  }

  public function createAppUser()
  {
    try {
      DB::beginTransaction();
      $admin = self::create(Arr::collapse([
        request()->all(),
        [
          'password' => bcrypt('itsefintech@admin'),
        ]
      ]));

      ActivityLog::logUserActivity('New Card User account created. Details: ' . $admin->email);

      DB::commit();
      return response()->json(['rsp' => $admin], 201);
    } catch (\Throwable $e) {
      if (app()->environment() == 'local') {
        return response()->json(['error' => $e->getMessage()], 500);
      }
      return response()->json(['rsp' => 'error occurred'], 500);
    }
  }

  public function suspendAppUser(self $app_user)
  {
    $app_user->delete();

    ActivityLog::logUserActivity('Card User account suspended. Card user details: ' . $app_user->email);

    return response()->json(['rsp' => true], 204);
  }

  public function unsuspendAppUser($id)
  {
    $app_user = self::withTrashed()->find($id);
    $app_user->restore();

    ActivityLog::logUserActivity('Card User account restored. Card user details: ' . $app_user->email);

    return response()->json(['rsp' => true], 204);
  }

  public function deleteAppUserAccount(self $app_user)
  {
    $app_user->forceDelete();

    ActivityLog::logUserActivity('Card User account deleted permanently. Card user details: ' . $app_user->email);

    return response()->json(['rsp' => true], 204);
  }
}
