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

/**
 * App\Modules\SuperAdmin\Models\SalesChannel
 *
 * @property int $id
 * @property string $channel_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductSaleRecord[] $sales_records
 * @property-read int|null $sales_records_count
 * @method static \Illuminate\Database\Eloquent\Builder|SalesChannel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesChannel newQuery()
 * @method static \Illuminate\Database\Query\Builder|SalesChannel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesChannel query()
 * @method static \Illuminate\Database\Eloquent\Builder|SalesChannel whereChannelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesChannel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesChannel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesChannel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SalesChannel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|SalesChannel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|SalesChannel withoutTrashed()
 * @mixin \Eloquent
 */
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

  public static function routes()
  {
    Route::group(['prefix' => 'sales-channels', 'namespace' => '\App\Modules\Admin\Models'], function () {
      $misc = function ($name) {
        return 'superadmin.miscellaneous.' . $name;
      };
      Route::get('', [self::class, 'getSalesChannels'])->name($misc('sales_channels'))->defaults('ex', __e('ss', 'airplay', false));
      Route::post('create', [self::class, 'createSalesChannel'])->name($misc('create_sales_channel'))->defaults('ex', __e('ss', 'airplay', true));
      Route::put('{salesChannel}/edit', [self::class, 'editSalesChannel'])->name($misc('edit_sales_channel'))->defaults('ex', __e('ss', 'airplay', true));
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
      return back()->withSuccess('Sales Channel created');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Sales Channel not created');

      if ($request->isApi()) return response()->json(['err' => 'Sales Channel not created'], 500);
      return back()->withError('Sales channel creation failed');
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
      return back()->withSuccess('Sales channel updated');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Channel name not updated');

      if ($request->isApi()) return response()->json(['err' => 'Sales Channel not created'], 500);
      return back()->withError('Sales channel creation failed');
    }
  }
}
