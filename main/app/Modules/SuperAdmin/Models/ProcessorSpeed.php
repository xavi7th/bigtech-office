<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Transformers\ProcessorSpeedTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProcessorSpeed
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProcessorSpeed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProcessorSpeed newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProcessorSpeed onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProcessorSpeed query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProcessorSpeed withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProcessorSpeed withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $speed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProcessorSpeed whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProcessorSpeed whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProcessorSpeed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProcessorSpeed whereSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProcessorSpeed whereUpdatedAt($value)
 */
class ProcessorSpeed extends Model
{
  use SoftDeletes;

  protected $fillable = ['speed'];

  public static function apiRoutes()
  {
    Route::group(['prefix' => 'processor-speeds', 'namespace' => '\App\Modules\Admin\Models'], function () {
      Route::get('', 'ProcessorSpeed@getProcessorSpeeds')->middleware('auth:admin_api');
      Route::post('create', 'ProcessorSpeed@createProcessorSpeed')->middleware('auth:admin_api');
    });
  }

  public function getProcessorSpeeds()
  {
    return response()->json((new ProcessorSpeedTransformer)->collectionTransformer(self::all(), 'basic'), 200);
  }

  public function createProcessorSpeed(Request $request)
  {
    if (!$request->speed) {
      return generate_422_error('Specify a processor speed');
    }

    try {
      $processor_speed = self::create([
        'speed' => $request->speed,
      ]);

      return response()->json((new ProcessorSpeedTransformer)->basic($processor_speed), 201);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Processor Speed not created');
      return response()->json(['err' => 'Processor Speed not created'], 500);
    }
  }
}
