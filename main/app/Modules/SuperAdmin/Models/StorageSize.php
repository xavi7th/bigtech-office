<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Transformers\StorageSizeTransformer;

/**
 * App\Modules\SuperAdmin\Models\StorageSize
 *
 * @property-read string $size
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StorageSize newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StorageSize newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\StorageSize onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StorageSize query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\StorageSize withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\StorageSize withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StorageSize whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StorageSize whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StorageSize whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StorageSize whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StorageSize whereUpdatedAt($value)
 */
class StorageSize extends Model
{
  use SoftDeletes;

  protected $fillable = ['size'];
  protected $casts = ['size' => 'double'];

  public function getSizeAttribute($value): string
  {
    switch ($value) {
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
    return $value;
  }

  public static function routes()
  {
    Route::group(['prefix' => 'storage-sizes', 'namespace' => '\App\Modules\Admin\Models'], function () {
      $misc = function ($name) {
        return 'superadmin.miscellaneous.' . $name;
      };

      Route::get('', [self::class, 'getStorageSizes'])->name($misc('storage_sizes'))->defaults('ex', __e('ss', 'hard-drive', false));
      Route::post('create', [self::class, 'createStorageSize'])->name($misc('create_storage_size'))->defaults('ex', __e('ss', 'hard-drive', true));
      Route::put('{size}/edit', [self::class, 'editStorageSize'])->name($misc('edit_storage_size'))->defaults('ex', __e('ss', 'hard-drive', true));
    });
  }

  public function getStorageSizes()
  {
    return response()->json((new StorageSizeTransformer)->collectionTransformer(self::all(), 'basic'), 200);
  }

  public function createStorageSize(Request $request)
  {
    if (!$request->size) {
      return generate_422_error('Specify a storage size');
    }

    if (!is_numeric($request->size)) {
      return generate_422_error('Storage size must be numeric');
    }

    try {
      $storage_size = self::create([
        'size' => $request->size,
      ]);

      return response()->json((new StorageSizeTransformer)->basic($storage_size), 201);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Storage size not created');
      return response()->json(['err' => 'Storage size not created'], 500);
    }
  }

  public function editStorageSize(Request $request, self $storage_size)
  {
    if (!$request->size) {
      return generate_422_error('Specify a new storage size to change this to');
    }

    if (!is_numeric($request->size)) {
      return generate_422_error('Storage size must be numeric');
    }

    if (self::where('size', $request->size)->exists()) {
      return generate_422_error('This size already exists');
    }

    try {
      $storage_size->size = $request->size;
      $storage_size->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Storage size not updated');
      return response()->json(['err' => 'Storage size not updated'], 500);
    }
  }
}
