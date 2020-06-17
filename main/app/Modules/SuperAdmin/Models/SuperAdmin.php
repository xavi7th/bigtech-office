<?php

namespace App\Modules\SuperAdmin\Models;

use App\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\Admin;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\SuperAdmin\Transformers\AdminUserTransformer;

class SuperAdmin extends User
{
  protected $fillable = [];
  protected $table = 'trusted_romzy';
  const DASHBOARD_ROUTE_PREFIX = 'super-panel';

  public function is_verified()
  {
    return true;
  }


  static function adminRoutes()
  {
    Route::group(['namespace' => '\App\Modules\Admin\Models'], function () {
      Route::get('admins', 'Admin@getAllAdmins')->middleware('auth:admin,normal_admin');

      Route::post('admin/create', 'Admin@createAdminAccount')->middleware('auth:admin');

      Route::get('admin/{admin}/permissions', 'Admin@getAdminPermittedRoutes')->middleware('auth:admin');

      Route::put('admin/{admin}/permissions', 'Admin@editAdminPermittedRoutes')->middleware('auth:admin');

      Route::put('admin/{admin}/suspend', 'Admin@suspendAdminAccount')->middleware('auth:admin');

      Route::put('admin/{id}/restore', 'Admin@restoreAdminAccount')->middleware('auth:admin');

      Route::delete('admin/{admin}/delete', 'Admin@deleteAdminAccount')->middleware('auth:admin');
    });
  }

  public function getAllAdmins()
  {
    return (new AdminUserTransformer)->collectionTransformer(Admin::withTrashed()->get(), 'transformForAdminViewAdmins');
  }

  public function createAdminAccount()
  {
    try {
      DB::beginTransaction();
      $admin = Admin::create(Arr::collapse([
        request()->all(),
        [
          'password' => bcrypt('itsefintech@admin'),
        ]
      ]));

      ActivityLog::notifyAdmins(auth()->user()->email . ' created a new admin account for ' . $admin->email);

      DB::commit();
      return response()->json(['rsp' => $admin], 201);
    } catch (\Throwable $e) {
      if (app()->environment() == 'local') {
        return response()->json(['error' => $e->getMessage()], 500);
      }
      return response()->json(['rsp' => 'error occurred'], 500);
    }
  }

  public function suspendAdminAccount(Admin $admin)
  {
    if ($admin->id === auth()->id()) {
      return response()->json(['rsp' => false], 403);
    }
    $admin->delete();
    ActivityLog::notifyAdmins(auth()->user()->email . ' suspended the account of ' . $admin->email);
    return response()->json(['rsp' => true], 204);
  }

  public function restoreAdminAccount($id)
  {
    $admin = Admin::withTrashed()->find($id);
    $admin->restore();

    ActivityLog::notifyAdmins(auth()->user()->email . ' restored the account of ' . $admin->email);

    return response()->json(['rsp' => true], 204);
  }

  public function deleteAdminAccount(Admin $admin)
  {
    if ($admin->id === auth()->id()) {
      return response()->json(['rsp' => false], 403);
    }
    /** log the activity before deleting */
    ActivityLog::notifyAdmins(auth()->user()->email . ' permanently deleted the account of ' . $admin->email);

    $admin->forceDelete();

    return response()->json(['rsp' => true], 204);
  }
}
