<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Transformers\StorageTypeTransformer;
use Cache;

class StorageType extends BaseModel
{
  use SoftDeletes;

  protected $fillable = ['type'];

  public static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'storage-types'], function () {

      $misc = function ($name) {
        return 'multiaccess.miscellaneous.' . $name;
      };
      Route::get('', [self::class, 'getStorageTypes'])->name($misc('storage_types'))->defaults('ex', __e('ss,a,w', 'hard-drive', false))->middleware('auth:super_admin,auditor,web_admin');
      Route::post('create', [self::class, 'createStorageType'])->name($misc('create_storage_type'))->middleware('auth:super_admin,auditor,web_admin');
      Route::put('{storageType}/edit', [self::class, 'editStorageType'])->name($misc('edit_storage_type'))->middleware('auth:super_admin,auditor,web_admin');
    });
  }

  public function getStorageTypes(Request $request)
  {
    $storageTypes = Cache::rememberForever('storageTypes', function () {
      return (new StorageTypeTransformer)->collectionTransformer(self::all(), 'basic');
    });

    if ($request->isApi()) return response()->json($storageTypes, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/ManageStorageTypes', compact('storageTypes'));
  }

  public function createStorageType(Request $request)
  {
    if (!$request->type)  return generate_422_error('Specify a storage type');
    if (self::where('type', $request->type)->exists()) return generate_422_error('Storage type already exists');

    try {
      $storageType = self::create([
        'type' => $request->type,
      ]);

      Cache::forget('storageTypes');

      if ($request->isApi())       return response()->json((new StorageTypeTransformer)->basic($storageType), 201);
      return back()->withFlash(['success'=>'Storage type created. <br/> Products can now be created under this storage type']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Storage type not created');

      if ($request->isApi()) return response()->json(['err' => 'Storage type not created'], 500);
      return back()->withFlash(['error'=>['Type creation failed']]);
    }
  }

  public function editStorageType(Request $request, self $storageType)
  {
    if (!$request->type) return generate_422_error('Specify a new storage type to change this to');
    if (self::where('type', $request->type)->exists()) return generate_422_error('This type already exists');

    try {
      $storageType->type = $request->type;
      $storageType->save();

      Cache::forget('storageTypes');

      if ($request->isApi()) return response()->json([], 204);
      return back()->withFlash(['success'=>'Storage type created. <br/> Products can now be created under this type']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Storage type not updated');

      if ($request->isApi()) return response()->json(['err' => 'Storage type not created'], 500);
      return back()->withFlash(['error'=>['Type creation failed']]);
    }
  }

  protected static function boot()
  {
    parent::boot();

    static::saved(function ($product) {
      Cache::forget('storageTypes');
      Cache::forget('storage_types');
    });
  }
}
