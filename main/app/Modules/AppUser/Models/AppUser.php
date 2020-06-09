<?php

namespace App\Modules\AppUser\Models;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\PublicPages\Models\OTP;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\Voucher;
use App\Modules\PublicPages\Notifications\SendOTP;
use App\Modules\AppUser\Notifications\ProfileEdited;
use App\Modules\AppUser\Transformers\AppUserTransformer;
use App\Modules\PublicPages\Notifications\AccountCreated;
use App\Modules\SuperAdmin\Transformers\AdminUserTransformer;
use App\Modules\AppUser\Http\Validations\AppUserUpdateProfileValidation;
use App\Modules\PublicPages\Notifications\SendPasswordResetNotification;

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


  static function adminRoutes()
  {
    Route::group(['namespace' => '\App\Modules\AppUser\Models'], function () {
      Route::get('card-users', 'AppUser@getAllAppUsers')->middleware('auth:admin,normal_admin,account_officer');

      Route::post('card-user/create', 'AppUser@createAppUser')->middleware('auth:admin');

      Route::get('card-user/{app_user}/bvn', 'AppUser@getFullBvnNumber')->middleware('auth:admin');

      Route::put('card-user/{app_user}/credit-limit', 'AppUser@setUserCreditLimit')->middleware('auth:account_officer');

      Route::put('card-user/{app_user}/merchant-limit', 'AppUser@setUserMerchantLimit')->middleware('auth:account_officer');

      Route::get('card-user/{app_user}/permissions', 'AppUser@getPermittedRoutes')->middleware('auth:admin');

      Route::put('card-user/{app_user}/permissions', 'AppUser@setAppUserPermittedRoutes')->middleware('auth:admin');

      Route::put('card-user/{app_user}/suspend', 'AppUser@suspendAppUser')->middleware('auth:account_officer');

      Route::put('card-user/{id}/restore', 'AppUser@unsuspendAppUser')->middleware('auth:account_officer');

      Route::delete('card-user/{app_user}/delete', 'AppUser@deleteAppUserAccount')->middleware('auth:admin');
    });
  }

  static function appUserRoutes()
  {
    Route::group(['namespace' =>  '\App\Modules\AppUser\Models'], function () {
      Route::get('card-users/profile-details', 'AppUser@getAppUserProfileDetails');
      Route::get('card-users/categories', 'AppUser@getAppUserCategories');
    });

    Route::group(['prefix' => 'auth', 'middleware' => ['auth:app_api_user', 'app_users'], 'namespace' =>  '\App\Modules\AppUser\Models'], function () {

      Route::group(['middleware' => ['unverified_app_users']], function () {
        Route::get('/user/request-otp', 'AppUser@requestOTP');
        Route::put('/user/verify-otp', 'AppUser@verifyOTP');
      });

      // Route::group(['middleware' => ['verified_app_users']], function () {
      Route::get('/user', 'AppUser@user');
      Route::put('/user', 'AppUser@updateUserProfile');
      // });
    });
  }


  /**
   * ! Card User Route methods
   */


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

    /**
     * ! Disabled per app owner's request
     */
    // $request->user()->notify(new AccountCreated);

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



  public function getAppUserCategories()
  {
    return AppUserCategory::get(['category_name', 'id']);
  }

  public function getAppUserProfileDetails()
  {
    return self::$editableProperties;
  }


  /**
   * ! Admin route methods
   */

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

      ActivityLog::logAdminActivity('New Card User account created. Details: ' . $admin->email);

      DB::commit();
      return response()->json(['rsp' => $admin], 201);
    } catch (\Throwable $e) {
      if (app()->environment() == 'local') {
        return response()->json(['error' => $e->getMessage()], 500);
      }
      return response()->json(['rsp' => 'error occurred'], 500);
    }
  }

  public function suspendAppUser(AppUser $app_user)
  {
    $app_user->delete();

    ActivityLog::logAdminActivity('Card User account suspended. Card user details: ' . $app_user->email);

    return response()->json(['rsp' => true], 204);
  }

  public function unsuspendAppUser($id)
  {
    $app_user = self::withTrashed()->find($id);
    $app_user->restore();

    ActivityLog::logAdminActivity('Card User account restored. Card user details: ' . $app_user->email);

    return response()->json(['rsp' => true], 204);
  }

  public function deleteAppUserAccount(AppUser $app_user)
  {
    $app_user->forceDelete();

    ActivityLog::logAdminActivity('Card User account deleted permanently. Card user details: ' . $app_user->email);

    return response()->json(['rsp' => true], 204);
  }
}
