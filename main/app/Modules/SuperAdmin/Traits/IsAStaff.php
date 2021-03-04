<?php

namespace App\Modules\SuperAdmin\Traits;

use Throwable;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\SuperAdmin\Models\OfficeBranch;
use App\Modules\SuperAdmin\Transformers\StaffTransformer;

/**
 * A trait to make a model commentable
 */
trait IsAStaff
{

  public function office_branch()
  {
    return $this->belongsTo(OfficeBranch::class);
  }

  public function recorded_reseller_transactions()
  {
    return $this->morphMany(ResellerTransaction::class, 'recorder');
  }

  static function findByEmail(string $email)
  {
    return self::whereEmail($email)->first();
  }

  public function is_verified()
  {
    return $this->verified_at !== null;
  }

  /**
   * @use self::staffRoutes() after the get route group
   *
   * @return void
   */
  static function staffRoutes()
  {
    // dd(Str::of(__CLASS__)->afterLast('\\')->plural());
    $userType = Str::of(class_basename(self::class))->snake()->plural();
    Route::name('manage_staff.')->prefix($userType->slug())->group(function () use ($userType) {
      Route::get('', [self::class, 'getAllStaff'])->name($userType)->defaults('ex', __e('ss,a', 'aperture'));
      Route::post('create', [self::class, 'createStaff'])->name($userType . '.create');
      Route::put('{staff}/edit', [self::class, 'editStaff'])->name($userType . '.edit');
      Route::put('{staff}/suspend', [self::class, 'suspendStaff'])->name($userType . '.suspend');
      Route::put('{staff}/restore', [self::class, 'restoreStaff'])->name($userType . '.reactivate');
      Route::delete('{staff}/delete', [self::class, 'deleteStaff'])->name($userType . '.delete');
    });
  }

  public function getAllStaff(Request $request)
  {
    return Inertia::render('SuperAdmin,ManageStaff/Manage' . Str::of(__CLASS__)->afterLast('\\')->plural(), [
      (string)Str::of(class_basename(self::class))->snake()->plural() => (new StaffTransformer)->collectionTransformer(self::all(), 'transformForSuperAdminViewSalesReps'),
      'officeBranches' => OfficeBranch::get(['id', 'city'])
    ]);
  }

  public function createStaff(Request $request)
  {
    $userType = Str::of(class_basename(self::class))->snake()->plural();

    $validated = $request->validate([
      'full_name' => 'required|string|max:20',
      'email' => 'required|email|max:50|unique:' . $userType . ',email',
      'phone' => 'required|max:30|unique:' . $userType . ',phone',
      'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
      'password' => '',
      'office_branch_id' => 'required|exists:office_branches,id'
    ], [
      'office_branch_id.required' => 'Select an office branch for the ' . Str::of(class_basename(self::class)),
      'office_branch_id.exists' => 'Invalid office branch selected'
    ]);

    $validated['password'] = $userType->slug();
    $validated['is_active'] = true;

    if ($request->hasFile('avatar')) {
      $validated['avatar'] = compress_image_upload('avatar', 'user-avatars/', 'user-avatars/thumbs/', 600, true, 50)['img_url'];
    }

    try {

      $staff = self::create($validated);

      ActivityLog::notifySuperAdmins($request->user()->full_name . ' created a ' . $userType->singular() . ' account for ' . $staff->full_name);

      return back()->withFlash(['success' => 'User account created']);
    } catch (Throwable $e) {
      if (app()->environment() == 'local') {
        return back()->withFlash(['error' => $e->getMessage()]);
      }
      return back()->withFlash(['error' => 'Error occurred']);
    }
  }

  public function editStaff(Request $request, self $staff)
  {

    $userType = Str::of(class_basename(self::class))->snake()->plural();

    $validated = $request->validate([
      'full_name' => 'required|string|max:20',
      'office_branch_id' => 'required|exists:office_branches,id',
      'email' => 'required|email|max:50|unique:' . $userType . ',email,' . $staff->id,
      'phone' => 'required|max:30|unique:' . $userType . ',phone,'.$staff->phone.',phone',
      'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
    ],[
      'office_branch_id.required' => 'Select an office branch for the ' . Str::of(class_basename(self::class)),
      'office_branch_id.exists' => 'Invalid office branch selected'
    ]);

    if ($request->hasFile('avatar')) {
      $validated['avatar'] = compress_image_upload('avatar', 'user-avatars/', 'user-avatars/thumbs/', 1400, true, 50)['img_url'];
    }

    try {

      $staff->update($validated);

      ActivityLog::notifySuperAdmins($request->user()->full_name . ' updated the ' . $userType->slug(' ') . ' account for ' . $staff->full_name);

      return back()->withFlash(['success' =>  'User account updated']);
    } catch (Throwable $e) {
      if (app()->environment() == 'local') {
        return back()->withFlash(['error' => $e->getMessage()]);
      }
      return back()->withFlash(['error' => 'Error occurred']);
    }
  }

  public function suspendStaff(self $staff)
  {
    ActivityLog::logUserActivity(auth()->user()->email . ' suspended the account of ' . $staff->email);

    $staff->is_active = false;
    $staff->save();

    return back()->withFlash(['success' => 'User account suspended']);
  }

  public function restoreStaff(self $staff)
  {
    $staff->is_active = true;
    $staff->save();

    ActivityLog::logUserActivity(auth()->user()->email . ' restored the account of ' . $staff->email);

    return back()->withFlash(['success' => 'User account re-activated']);
  }

  public function deleteStaff(self $staff)
  {
    ActivityLog::logUserActivity(auth()->user()->email . ' permanently deleted the account of ' . $staff->email);

    $staff->forceDelete();

    return back()->withFlash(['success' => 'User account deleted']);
  }

  protected static function booted()
  {
    static::addGlobalScope('safeRecords', function (Builder $builder) {
      $builder->where('id', '>', 1);
    });
  }
}
