<?php

namespace App\Modules\SuperAdmin\Models;

use Inertia\Inertia;
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

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    if (routeHasRootNamespace('appuser.')) {
      Inertia::setRootView('appuser::app');
    } elseif (routeHasRootNamespace('superadmin.')) {
      Inertia::setRootView('superadmin::app');
    }
  }

  public static function routes()
  {
    Route::group(['prefix' => 'processor-speeds', 'namespace' => '\App\Modules\Admin\Models'], function () {
      $misc = function ($name) {
        return 'superadmin.miscellaneous.' . $name;
      };
      Route::get('', [self::class, 'getProcessorSpeeds'])->name($misc('processor_speeds'))->defaults('ex', __e('ss', 'cpu', false));
      Route::post('create', [self::class, 'createProcessorSpeed'])->name($misc('create_processor_speed'))->defaults('ex', __e('ss', 'cpu', true));
    });
  }

  public function getProcessorSpeeds(Request $request)
  {
    $processorSpeeds = (new ProcessorSpeedTransformer)->collectionTransformer(self::all(), 'basic');
    if ($request->isApi())
      return response()->json($processorSpeeds, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/ManageProcessorSpeed', compact('processorSpeeds'));
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
