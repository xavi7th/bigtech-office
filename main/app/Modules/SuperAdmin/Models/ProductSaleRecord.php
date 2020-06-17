<?php

namespace App\Modules\SuperAdmin\Models;

use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Awobaz\Compoships\Compoships;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\SwapDeal;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\SuperAdmin\Models\SalesChannel;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Models\CompanyBankAccount;
use App\Modules\SuperAdmin\Models\SalesRecordBankAccount;
use App\Modules\SuperAdmin\Transformers\ProductSaleRecordTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductSaleRecord
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\CompanyBankAccount[] $bank_account_payments
 * @property-read int|null $bank_account_payments_count
 * @property-read mixed $is_payment_complete
 * @property-read float $total_bank_payments_amount
 * @property-read \App\Modules\SalesRep\Models\SalesRep $online_rep
 * @property-read \App\Modules\SuperAdmin\Models\Product $product
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $sale_confirmer
 * @property-read \App\Modules\SuperAdmin\Models\SalesChannel $sales_channel
 * @property-read \App\Modules\SalesRep\Models\SalesRep $sales_rep
 * @property-read \App\Modules\SuperAdmin\Models\SwapDeal|null $swap_deal
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord confirmed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord today()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord unconfirmed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord yesterday()
 * @mixin \Eloquent
 * @property int $id
 * @property int $product_id
 * @property float $selling_price
 * @property int|null $sales_channel_id
 * @property int|null $online_rep_id
 * @property int|null $sales_rep_id
 * @property int|null $sale_confirmed_by
 * @property string|null $sale_confirmer_type
 * @property int $is_swap_deal
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord whereIsSwapDeal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord whereOnlineRepId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord whereSaleConfirmedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord whereSaleConfirmerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord whereSalesChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord whereSalesRepId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord whereSellingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\ProductSaleRecord whereUpdatedAt($value)
 */
class ProductSaleRecord extends Model
{
  use SoftDeletes;
  use Compoships;

  protected $fillable = [
    'selling_price', 'online_rep_id', 'sales_rep_id', 'sales_channel_id', 'is_swap_deal'
  ];

  protected $casts = ['selling_price' => 'float'];

  // protected $with = ['bank_account_payments'];

  protected $appends = ['total_bank_payments_amount', 'is_payment_complete'];

  public function __construct()
  {
    Inertia::setRootView('superadmin::app');
  }

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function swap_deal()
  {
    return $this->hasOne(SwapDeal::class, 'swapped_with', 'product_id');
  }

  public function sales_rep()
  {
    return $this->belongsTo(SalesRep::class);
  }

  public function online_rep()
  {
    return $this->belongsTo(SalesRep::class);
  }

  public function sale_confirmer()
  {
    return $this->morphTo('sale_confirmer', 'sale_confirmer_type', 'sale_confirmed_by');
  }

  public function sales_channel()
  {
    return $this->belongsTo(SalesChannel::class);
  }

  public function bank_account_payments()
  {
    return $this->belongsToMany(CompanyBankAccount::class, $table = 'sales_record_bank_accounts')->using(SalesRecordBankAccount::class)
      ->as('payment_record')->withPivot('amount')->withTimestamps();
  }

  public function total_bank_payments_amount(): float
  {
    return $this->bank_account_payments()->sum('amount');
  }

  public function getTotalBankPaymentsAmountAttribute(): float
  {
    return $this->total_bank_payments_amount();
  }

  public function getIsPaymentCompleteAttribute()
  {
    return $this->total_bank_payments_amount === $this->selling_price;
  }

  public static function routes()
  {
    Route::group(['prefix' => 'product-sales-records'], function () {
      $p = function ($name) {
        return 'superadmin.product_sales_records.' . $name;
      };
      // Route::get('', [self::class, 'getProductSaleRecords'])->name($p('view_sales_records'))->defaults('ex', __e('ss', null, true));
      Route::get('/{date}', [self::class, 'getDailyProductSaleRecords'])->name($p('daily'))->defaults('ex', __e('ss', null, true));
      Route::get('{product}/transactions', [self::class, 'getSaleRecordTransactions'])->name($p('view_sales_record_transactions'))->defaults('ex', __e('ss', null, true));
      Route::post('{product}/confirm', [self::class, 'confirmSaleRecord'])->name($p('confirm_sales_record'))->defaults('ex', __e('ss', null, true));
      Route::get('{product}/swap-deal', [self::class, 'getSaleRecordSwapDeal'])->name($p('view_sales_record_swap_deal'))->defaults('ex', __e('ss', null, true));
    });
  }

  public function getProductSaleRecords()
  {
    // return Product::find(69);
    $sales_records =  self::with(
      'product',
      'product.product_price',
      'product.product_model:id,name',
      'sales_rep:id,full_name,email',
      'online_rep:id,full_name,email',
      'sale_confirmer:id,full_name,email',
      'sales_channel:id,channel_name',
      'bank_account_payments'
    )->get();
    return response()->json((new ProductSaleRecordTransformer)->collectionTransformer($sales_records, 'basic'), 200);
  }

  public function getDailyProductSaleRecords(Request $request, $date)
  {
    $salesRecords =  self::with(
      'product',
      'product.product_price',
      'product.product_model:id,name',
      'sales_rep:id,full_name,email',
      'online_rep:id,full_name,email',
      'sale_confirmer:id,full_name,email',
      'sales_channel:id,channel_name',
      'bank_account_payments'
    )->whereDate('created_at', Carbon::parse($date))->get();
    if ($request->isApi()) {
      return response()->json((new ProductSaleRecordTransformer)->collectionTransformer($salesRecords, 'basic'), 200);
    } else {
      return Inertia::render('Products/SalesRecords', [
        'salesRecords' => (new ProductSaleRecordTransformer)->collectionTransformer($salesRecords, 'basic'),
        'date' => $date
      ]);
    }
  }

  public function confirmSaleRecord(Request $request, self $sales_record)
  {

    $product = $sales_record->product;
    $status_id = ProductStatus::sale_confirmed_id();

    if ($product->product_status_id === $status_id) {
      return generate_422_error('This product has being confirmed sold already');
    }
    DB::beginTransaction();

    /**
     * Update the product's status to confirmed sold
     */
    $product->product_status_id = $status_id;
    $product->save();

    /**
     * Mark the product's sales record as confirmed
     */

    $sales_record->sale_confirmed_by = auth()->id();
    $sales_record->sale_confirmer_type = get_class(auth()->user());
    $sales_record->save();

    /**
     * Record the bank account payments breakdown for this transaction
     */

    $sales_record->bank_account_payments()->sync($request->payment_records);

    /**
     * // generate the receipt and save it in the DB.
     * ? This is so that even if the user should change his details in the future,
     * ? this receipt will still carry this his current records
     */
    try {
      $receipt = $product->generate_receipt();
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth()->user(), $th, 'Receipt generation failed');
    }

    /**
     * Send the user an email containing his receipt
     */

    try {
      $product->app_user->notify(new SendProductReceipt($receipt));
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth()->user(), $th, 'Failed to send receipt to user', $product->app_user->email);
    }


    /**
     * Notify Admin that a product was sold
     */
    ActivityLog::notifyAdmins(auth()->user()->email . ' confirmed the sale of product with ' . $product->primary_identifier() . '.');

    /**
     * Notify Accountant that a product was marked as sold
     */
    ActivityLog::notifyAccountants(auth()->user()->email . ' confirmed the sale of product with ' . $product->primary_identifier() . '.');

    DB::commit();
    return response()->json([], 204);
  }

  public function getSaleRecordTransactions(self $sales_record)
  {
    $record_transactions = $sales_record->load('bank_account_payments', 'product.product_model:id,name');
    return response()->json((new ProductSaleRecordTransformer)->transformWithBankPayments($record_transactions), 200);
  }

  public function getSaleRecordSwapDeal(self $sales_record)
  {
    return (new ProductSaleRecordTransformer)->transformWithSwapDeal($sales_record->load('swap_deal'));
  }


  /**
   * Scope a query to only today's records.
   *
   * @param  \Illuminate\Database\Eloquent\Builder  $query
   * @return \Illuminate\Database\Eloquent\Builder
   */
  public function scopeToday($query)
  {
    return $query->whereDate('product_sale_records.created_at', today());
  }

  public function scopeYesterday($query)
  {
    return $query->whereDate('product_sale_records.created_at', Carbon::yesterday());
  }

  public function scopeConfirmed($query)
  {
    return $query->where('sale_confirmed_by', '<>', null);
  }

  public function scopeUnconfirmed($query)
  {
    return $query->where('sale_confirmed_by', null);
  }
}
