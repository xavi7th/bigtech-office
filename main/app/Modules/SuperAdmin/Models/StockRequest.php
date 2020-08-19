<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\SuperAdmin\Transformers\AdminStockRequestTransformer;

/**
 * App\Modules\SuperAdmin\Models\StockRequest
 *
 * @property-read \App\Modules\SalesRep\Models\SalesRep $sales_rep
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StockRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StockRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\StockRequest query()
 * @mixin \Eloquent
 */
class StockRequest extends Model
{

  protected $fillable = [
    'sales_rep_id',
    'number_of_cards'
  ];

  public function sales_rep()
  {
    return $this->belongsTo(SalesRep::class);
  }


  static function adminRoutes()
  {
    Route::group(['namespace' => '\App\Modules\NormalAdmin\Models'], function () {

      Route::get('stock-requests', 'StockRequest@adminViewStockRequests')->middleware('auth:admin,normal_admin');

      Route::put('stock-request/{stock_request}/processed', 'StockRequest@markStockRequestAsProcessed')->middleware('auth:normal_admin');

      Route::delete('stock-request/{stock_request}/delete', 'StockRequest@deleteStockRequest')->middleware('auth:admin');
    });
  }

  static function salesRepRoutes()
  {
    Route::group(['namespace' => '\App\Modules\NormalAdmin\Models', 'prefix' => 'api'], function () {
      Route::post('stock-request/create', 'StockRequest@createStockRequest')->middleware('auth:sales_rep');
    });
  }

  /**
   * ! Sales Rep Route Methods
   */
  public function createStockRequest()
  {
    if (!request('num')) {
      return generate_422_error(['err' => ['Specify number of cards']]);
    }
    /** Make a stock request for the logged in sales rep */
    self::updateOrCreate(
      [
        'sales_rep_id' => auth()->id(),
        'is_processed' => false
      ],
      [
        'sales_rep_id' => auth()->id(),
        'number_of_cards' => request('num')
      ]
    );

    /** record activity */
    ActivityLog::logUserActivity('Sales rep ' . auth()->user()->first_name . ' requested for ' . request('num') . ' cards');

    return response()->json([], 204);
  }

  /**
   * ! Admin Route Methods
   */
  public function adminViewStockRequests()
  {
    if (auth('admin')->check()) {
      return (new AdminStockRequestTransformer)->collectionTransformer(self::withTrashed()->get(), 'transformForAdminViewStockRequests');
    } else if (auth('normal_admin')->check()) {
      return (new AdminStockRequestTransformer)->collectionTransformer(self::all(), 'transformForAdminViewStockRequests');
    }
  }

  public function markStockRequestAsProcessed(self $stock_request)
  {
    $stock_request->is_processed = true;
    $stock_request->save();

    ActivityLog::logUserActivity(auth()->user()->email . ' marked ' . $stock_request->sales_rep->email . '\'s stock request as processed');

    return response()->json([], 204);
  }

  public function deleteStockRequest(self $stock_request)
  {
    return;
    $stock_request->delete();

    ActivityLog::logUserActivity(auth()->user()->email . ' deleted ' . $stock_request->sales_rep->email . '\'s stock request.');

    return response()->json(['rsp' => true], 204);
  }
}
