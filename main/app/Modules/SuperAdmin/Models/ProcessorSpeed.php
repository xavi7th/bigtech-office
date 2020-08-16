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

class ProcessorSpeed extends BaseModel
{
  use SoftDeletes;

  protected $fillable = ['speed'];

  public static function routes()
  {
    Route::group(['prefix' => 'processor-speeds', 'namespace' => '\App\Modules\Admin\Models'], function () {
      $misc = function ($name) {
        return 'superadmin.miscellaneous.' . $name;
      };
      Route::get('', [self::class, 'getProcessorSpeeds'])->name($misc('processor_speeds'))->defaults('ex', __e('ss', 'cpu', false));
      Route::post('create', [self::class, 'createProcessorSpeed'])->name($misc('create_processor_speed'))->defaults('ex', __e('ss', 'cpu', true));
      Route::put('{processorSpeed}/edit', [self::class, 'editProcessorSpeed'])->name($misc('edit_processor_speed'))->defaults('ex', __e('ss', 'cpu', true));
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
}
