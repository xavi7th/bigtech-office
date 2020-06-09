<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SuperAdmin\Transformers\SalesChannelTransformer;

/**
 * App\Modules\SuperAdmin\Models\SalesChannel
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ProductSaleRecord[] $sales_records
 * @property-read int|null $sales_records_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SalesChannel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SalesChannel newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\SalesChannel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SalesChannel query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\SalesChannel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\SalesChannel withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $channel_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SalesChannel whereChannelName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SalesChannel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SalesChannel whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SalesChannel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SalesChannel whereUpdatedAt($value)
 */
class SalesChannel extends Model
{
  use SoftDeletes;

  protected $fillable = ['channel_name'];

  public function sales_records()
  {
    return $this->hasMany(ProductSaleRecord::class);
  }

  static function reseller_id(): int
  {
    return self::where('channel_name', 'Reseller')->first()->id;
  }

  public static function apiRoutes()
  {
    Route::group(['prefix' => 'sales-channels', 'namespace' => '\App\Modules\Admin\Models'], function () {
      Route::get('', 'SalesChannel@getSalesChannels')->middleware('auth:admin_api');
      Route::post('create', 'SalesChannel@createSalesChannel')->middleware('auth:admin_api');
      Route::put('{sales_channel}/edit', 'SalesChannel@editSalesChannel')->middleware('auth:admin_api');
    });
  }

  public function getSalesChannels()
  {
    return response()->json((new SalesChannelTransformer)->collectionTransformer(self::all(), 'basic'), 200);
  }

  public function createSalesChannel(Request $request)
  {
    if (!$request->channel_name) {
      return generate_422_error('Channel name required');
    }

    if (self::where('channel_name', $request->channel_name)->exists()) {
      return generate_422_error('Channel already exists');
    }

    try {
      $channel_name = self::create([
        'channel_name' => $request->channel_name,
      ]);

      return response()->json((new SalesChannelTransformer)->basic($channel_name), 201);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Sales Channel not created');
      return response()->json(['err' => 'Sales Channel not created'], 500);
    }
  }


  public function editSalesChannel(Request $request, self $sales_channel)
  {
    if (!$request->channel_name) {
      return generate_422_error('New channel name required');
    }

    if (self::where('channel_name', $request->channel_name)->exists()) {
      return generate_422_error('Sales Channel already exists');
    }

    try {
      $sales_channel->channel_name = $request->channel_name;
      $sales_channel->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Channel name not updated');
      return response()->json(['err' => 'Channel name not updated'], 500);
    }
  }
}
