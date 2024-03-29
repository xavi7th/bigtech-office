<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Transformers\StorageSizeTransformer;
use Cache;

class StorageSize extends BaseModel
{
  use SoftDeletes;

  protected $fillable = ['size'];
  protected $casts = ['size' => 'double'];

  public function getHumanSizeAttribute(): string
  {

    switch (true) {
      case $this->size < 1:
        return $this->size * 1000 . 'MB';
        break;
      case $this->size < 1000:
        return $this->size . 'GB';
        break;
      case $this->size >= 1000:
        return $this->size / 1000 . 'TB';
        break;

      default:
        return $this->size;
        break;
    }
    return '$value';
  }

  public static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'storage-sizes'], function () {
      $misc = function ($name) {
        return 'multiaccess.miscellaneous.' . $name;
      };

      Route::get('', [self::class, 'getStorageSizes'])->name($misc('storage_sizes'))->defaults('ex', __e('ss,a,w', 'hard-drive', false))->middleware('auth:super_admin,auditor,web_admin');
      Route::post('create', [self::class, 'createStorageSize'])->name($misc('create_storage_size'))->middleware('auth:super_admin,auditor,web_admin');
      Route::put('{storageSize}/edit', [self::class, 'editStorageSize'])->name($misc('edit_storage_size'))->middleware('auth:super_admin,auditor,web_admin');
    });
  }

  public function getStorageSizes(Request $request)
  {
    $storageSizes = Cache::rememberForever('storageSizes', function () {
      return (new StorageSizeTransformer)->collectionTransformer(self::all(), 'basic');
    });

    if ($request->isApi()) return response()->json($storageSizes, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/ManageStorageSizes', compact('storageSizes'));
  }

  public function createStorageSize(Request $request)
  {
    if (!$request->size) return generate_422_error('Specify a storage size');
    if (!is_numeric($request->size)) return generate_422_error('Storage size must be numeric');
    if (self::where('size', $request->size)->exists()) return generate_422_error('Storage size already exists');

    try {
      $storage_size = self::create([
        'size' => $request->size,
      ]);

      Cache::forget('storageSizes');

      if ($request->isApi()) return response()->json((new StorageSizeTransformer)->basic($storage_size), 201);
      return back()->withFlash(['success'=>'Storage Size created. <br/> Products of this storage size can now be created.']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Storage size not created');

      if ($request->isApi()) return response()->json(['err' => 'Storage size not created'], 500);
      return back()->withFlash(['success'=>'Storage size not created']);
    }
  }

  public function editStorageSize(Request $request, self $storageSize)
  {
    if (!$request->size) return generate_422_error('Specify a new storage size to change this to');
    if (!is_numeric($request->size)) return generate_422_error('Storage size must be numeric');
    if (self::where('size', $request->size)->exists()) return generate_422_error('Storage size already exists');

    try {
      $storageSize->size = $request->size;
      $storageSize->save();

      Cache::forget('storageSizes');


      if ($request->isApi()) return response()->json([], 204);
      return back()->withFlash(['success'=>'Storage size updated.']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Storage size not updated');

      if ($request->isApi()) return response()->json(['err' => 'Storage size not created'], 500);
      return back()->withFlash(['success'=>'Storage size not created']);
    }
  }

  protected static function boot()
  {
    parent::boot();

    static::saved(function ($product) {
      Cache::forget('storageSizes');
      Cache::forget('storage_sizes');
    });
  }
}
