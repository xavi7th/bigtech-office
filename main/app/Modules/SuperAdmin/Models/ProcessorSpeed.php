<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Transformers\ProcessorSpeedTransformer;
use Cache;

/**
 * App\Modules\SuperAdmin\Models\ProcessorSpeed
 *
 * @property int $id
 * @property string $speed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProcessorSpeed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProcessorSpeed newQuery()
 * @method static \Illuminate\Database\Query\Builder|ProcessorSpeed onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProcessorSpeed query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProcessorSpeed whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProcessorSpeed whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProcessorSpeed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProcessorSpeed whereSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProcessorSpeed whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ProcessorSpeed withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProcessorSpeed withoutTrashed()
 * @mixin \Eloquent
 */
class ProcessorSpeed extends BaseModel
{
  use SoftDeletes;

  protected $fillable = ['speed'];

  public static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'processor-speeds', 'namespace' => '\App\Modules\Admin\Models'], function () {
      $misc = function ($name) {
        return 'multiaccess.miscellaneous.' . $name;
      };
      Route::get('', [self::class, 'getProcessorSpeeds'])->name($misc('processor_speeds'))->defaults('ex', __e('ss,a', 'cpu', false))->middleware('auth:super_admin,admin');
      Route::post('create', [self::class, 'createProcessorSpeed'])->name($misc('create_processor_speed'))->defaults('ex', __e('ss,a', 'cpu', true))->middleware('auth:super_admin,admin');
      Route::put('{processorSpeed}/edit', [self::class, 'editProcessorSpeed'])->name($misc('edit_processor_speed'))->defaults('ex', __e('ss,a', 'cpu', true))->middleware('auth:super_admin,admin');
    });
  }

  public function getProcessorSpeeds(Request $request)
  {
    $processorSpeeds = Cache::rememberForever('processorSpeeds', function () {
      return (new ProcessorSpeedTransformer)->collectionTransformer(self::all(), 'basic');
    });

    if ($request->isApi())
      return response()->json($processorSpeeds, 200);

    return Inertia::render('SuperAdmin,Miscellaneous/ManageProcessorSpeed', compact('processorSpeeds'));
  }

  public function createProcessorSpeed(Request $request)
  {
    if (!$request->speed) return generate_422_error('Specify a processor speed');

    try {
      $processor_speed = self::create([
        'speed' => $request->speed,
      ]);

      Cache::forget('processorSpeeds');

      if ($request->isApi()) return response()->json((new ProcessorSpeedTransformer)->basic($processor_speed), 201);
      return back()->withSuccess('Processor speed created. <br/> Products can now be created under this processor speed');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Processor Speed not created');

      if ($request->isApi()) return response()->json(['err' => 'Processor Speed not created'], 500);
      return back()->withError('Processor speed creation failed');
    }
  }


  public function editprocessorSpeed(Request $request, self $processorSpeed)
  {

    if (!$request->speed) return generate_422_error('The processor speed is required');
    if (self::where('speed', $request->speed)->exists()) return generate_422_error('The processor speed already exists');

    try {

      $processorSpeed->speed = $request->speed;
      $processorSpeed->save();

      Cache::forget('processorSpeeds');

      if ($request->isApi()) {
        return response()->json([], 204);
      }
      return back()->withSuccess('Updated');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Processor Speed not updated');
      if ($request->isApi()) return response()->json(['err' => 'Processor Speed not updated'], 500);
      return back()->withError('Processor Speed update failed');
    }
  }

  protected static function boot()
  {
    parent::boot();

    static::saved(function ($product) {
      Cache::forget('processorSpeeds');
      Cache::forget('processor_speeds');
    });
  }
}
