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

/**
 * App\Modules\SuperAdmin\Models\StorageSize
 *
 * @property int $id
 * @property string $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|StorageSize newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StorageSize newQuery()
 * @method static \Illuminate\Database\Query\Builder|StorageSize onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|StorageSize query()
 * @method static \Illuminate\Database\Eloquent\Builder|StorageSize whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageSize whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageSize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageSize whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageSize whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|StorageSize withTrashed()
 * @method static \Illuminate\Database\Query\Builder|StorageSize withoutTrashed()
 * @mixin \Eloquent
 */
class StorageSize extends BaseModel
{
  use SoftDeletes;

  protected $fillable = ['size'];
  protected $casts = ['size' => 'double'];

  public function getSizeAttribute($value): string
  {

    switch (true) {
      case $value <= 1:
        return $value * 1000 . 'MB';
        break;
      case $value < 1000:
        return $value . 'GB';
        break;
      case $value >= 1000:
        return $value / 1000 . 'TB';
        break;

      default:
        return $value;
        break;
    }
    return '$value';
  }

  public static function routes()
  {
    Route::group(['prefix' => 'storage-sizes', 'namespace' => '\App\Modules\Admin\Models'], function () {
      $misc = function ($name) {
        return 'superadmin.miscellaneous.' . $name;
      };

      Route::get('', [self::class, 'getStorageSizes'])->name($misc('storage_sizes'))->defaults('ex', __e('ss', 'hard-drive', false));
      Route::post('create', [self::class, 'createStorageSize'])->name($misc('create_storage_size'))->defaults('ex', __e('ss', 'hard-drive', true));
      Route::put('{storageSize}/edit', [self::class, 'editStorageSize'])->name($misc('edit_storage_size'))->defaults('ex', __e('ss', 'hard-drive', true));
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
      return back()->withSuccess('Storage Size created. <br/> Products of this storage size can now be created.');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Storage size not created');

      if ($request->isApi()) return response()->json(['err' => 'Storage size not created'], 500);
      return back()->withSuccess('Storage size not created');
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
      return back()->withSuccess('Storage size updated.');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Storage size not updated');

      if ($request->isApi()) return response()->json(['err' => 'Storage size not created'], 500);
      return back()->withSuccess('Storage size not created');
    }
  }
}
