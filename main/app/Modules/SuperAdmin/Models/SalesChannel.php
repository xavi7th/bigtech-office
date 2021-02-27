<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SuperAdmin\Transformers\SalesChannelTransformer;
use Cache;

class SalesChannel extends BaseModel
{
  use SoftDeletes;

  protected $fillable = ['channel_name'];

  public function sales_records()
  {
    return $this->hasMany(ProductSaleRecord::class);
  }

  static function resellerId(): int
  {
    return self::where('channel_name', 'Reseller')->first()->id;
  }

  public static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'sales-channels'], function () {
      Route::name('multiaccess.miscellaneous.')->group(function () {
        Route::get('', [self::class, 'getSalesChannels'])->name('sales_channels')->defaults('ex', __e('ss,a,w', 'airplay', false))->middleware('auth:super_admin,auditor,web_admin');
        Route::post('create', [self::class, 'createSalesChannel'])->name('create_sales_channel')->middleware('auth:super_admin,auditor,web_admin');
        Route::put('{salesChannel}/edit', [self::class, 'editSalesChannel'])->name('edit_sales_channel')->middleware('auth:super_admin,auditor,web_admin');
      });
    });
  }

  public function getSalesChannels(Request $request)
  {
    $salesChannels = Cache::rememberForever('salesChannels', function () {
      return (new SalesChannelTransformer)->collectionTransformer(self::all(), 'basic');
    });

    if ($request->isApi())  return response()->json($salesChannels, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/ManageSalesChannels', compact('salesChannels'));
  }

  public function createSalesChannel(Request $request)
  {
    if (!$request->channel_name) return generate_422_error('The name of the sales channel is required');
    if (self::where('channel_name', $request->channel_name)->exists()) return generate_422_error('Sales channel already exists');


    try {
      $channel_name = self::create([
        'channel_name' => $request->channel_name,
      ]);

      Cache::forget('salesChannels');

      if ($request->isApi()) return response()->json((new SalesChannelTransformer)->basic($channel_name), 201);
      return back()->withFlash(['success'=>'Sales Channel created']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Sales Channel not created');

      if ($request->isApi()) return response()->json(['err' => 'Sales Channel not created'], 500);
      return back()->withFlash(['error'=>['Sales channel creation failed']]);
    }
  }


  public function editSalesChannel(Request $request, self $salesChannel)
  {
    if (!$request->channel_name) return generate_422_error('New channel name required');
    if (self::where('channel_name', $request->channel_name)->exists())       return generate_422_error('Sales Channel already exists');


    try {
      $salesChannel->channel_name = $request->channel_name;
      $salesChannel->save();

      Cache::forget('salesChannels');

      if ($request->isApi())       return response()->json([], 204);
      return back()->withFlash(['success'=>'Sales channel updated']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Channel name not updated');

      if ($request->isApi()) return response()->json(['err' => 'Sales Channel not created'], 500);
      return back()->withFlash(['error'=>['Sales channel creation failed']]);
    }
  }
}
