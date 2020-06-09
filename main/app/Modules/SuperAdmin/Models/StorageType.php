<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Transformers\StorageTypeTransformer;

/**
 * App\Modules\SuperAdmin\Models\StorageType
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StorageType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StorageType newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\StorageType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StorageType query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\StorageType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\StorageType withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StorageType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StorageType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StorageType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StorageType whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StorageType whereUpdatedAt($value)
 */
class StorageType extends Model
{
  use SoftDeletes;

  protected $fillable = ['type'];

  public static function apiRoutes()
  {
    Route::group(['prefix' => 'storage-types', 'namespace' => '\App\Modules\Admin\Models'], function () {
      Route::get('', 'StorageType@getStorageTypes')->middleware('auth:admin_api');
      Route::post('create', 'StorageType@createStorageType')->middleware('auth:admin_api');
      Route::put('{storage_type}/edit', 'StorageType@editStorageType')->middleware('auth:admin_api');
    });
  }

  public function getStorageTypes()
  {
    return response()->json((new StorageTypeTransformer)->collectionTransformer(self::all(), 'basic'), 200);
  }

  public function createStorageType(Request $request)
  {
    if (!$request->type) {
      return generate_422_error('Specify a storage type');
    }

    try {
      $storage_type = self::create([
        'type' => $request->type,
      ]);

      return response()->json((new StorageTypeTransformer)->basic($storage_type), 201);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Storage type not created');
      return response()->json(['err' => 'Storage type not created'], 500);
    }
  }

  public function editStorageType(Request $request, self $storage_type)
  {
    if (!$request->type) {
      return generate_422_error('Specify a new storage type to change this to');
    }

    if (self::where('type', $request->type)->exists()) {
      return generate_422_error('This type already exists');
    }

    try {
      $storage_type->type = $request->type;
      $storage_type->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Storage type not updated');
      return response()->json(['err' => 'Storage type not updated'], 500);
    }
  }
}
