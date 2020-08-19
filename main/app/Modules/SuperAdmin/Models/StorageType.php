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

/**
 * App\Modules\SuperAdmin\Models\StorageType
 *
 * @property int $id
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|StorageType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StorageType newQuery()
 * @method static \Illuminate\Database\Query\Builder|StorageType onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|StorageType query()
 * @method static \Illuminate\Database\Eloquent\Builder|StorageType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageType whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageType whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|StorageType withTrashed()
 * @method static \Illuminate\Database\Query\Builder|StorageType withoutTrashed()
 * @mixin \Eloquent
 */
class StorageType extends BaseModel
{
  use SoftDeletes;

  protected $fillable = ['type'];

  public static function routes()
  {
    Route::group(['prefix' => 'storage-types'], function () {

      $misc = function ($name) {
        return 'superadmin.miscellaneous.' . $name;
      };
      Route::get('', [self::class, 'getStorageTypes'])->name($misc('storage_types'))->defaults('ex', __e('ss', 'hard-drive', false));
      Route::post('create', [self::class, 'createStorageType'])->name($misc('create_storage_type'))->defaults('ex', __e('ss', 'hard-drive', true));
      Route::put('{storageType}/edit', [self::class, 'editStorageType'])->name($misc('edit_storage_type'))->defaults('ex', __e('ss', 'hard-drive', true));
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
      return back()->withSuccess('Storage type created. <br/> Products can now be created under this storage type');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Storage type not created');

      if ($request->isApi()) return response()->json(['err' => 'Storage type not created'], 500);
      return back()->withError('Type creation failed');
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
      return back()->withSuccess('Storage type created. <br/> Products can now be created under this type');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Storage type not updated');

      if ($request->isApi()) return response()->json(['err' => 'Storage type not created'], 500);
      return back()->withError('Type creation failed');
    }
  }
}
