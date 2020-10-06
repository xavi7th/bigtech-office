<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Awobaz\Compoships\Compoships;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
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
use App\Modules\SuperAdmin\Transformers\CompanyBankAccountTransformer;


/**
 * App\Modules\SuperAdmin\Models\ProductSaleRecord
 *
 * @property int $id
 * @property int $product_id
 * @property string $product_type
 * @property float $selling_price
 * @property int $sales_channel_id
 * @property int $online_rep_id
 * @property int $sales_rep_id
 * @property int|null $sale_confirmed_by
 * @property string|null $sale_confirmer_type
 * @property int $is_swap_transaction
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|CompanyBankAccount[] $bank_account_payments
 * @property-read int|null $bank_account_payments_count
 * @property-read mixed $is_payment_complete
 * @property-read float $total_bank_payments_amount
 * @property-read SalesRep $online_rep
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $product
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $sale_confirmer
 * @property-read SalesChannel $sales_channel
 * @property-read SalesRep $sales_rep
 * @property-read SwapDeal|null $swap_deal
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord confirmed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord newQuery()
 * @method static \Illuminate\Database\Query\Builder|ProductSaleRecord onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord products()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord swapDeals()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord today()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord unconfirmed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord whereIsSwapTransaction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord whereOnlineRepId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord whereSaleConfirmedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord whereSaleConfirmerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord whereSalesChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord whereSalesRepId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord whereSellingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ProductSaleRecord withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProductSaleRecord withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord yesterday()
 * @mixin \Eloquent
 */
class ProductSaleRecord extends BaseModel
{
  use SoftDeletes;
  use Compoships;

  protected $fillable = [
    'selling_price', 'online_rep_id', 'sales_rep_id', 'sales_channel_id', 'is_swap_transaction'
  ];

  protected $casts = ['selling_price' => 'float'];

  // protected $with = ['bank_account_payments'];

  protected $appends = ['total_bank_payments_amount', 'is_payment_complete'];

  public function product()
  {
    return $this->morphTo();
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
      Route::post('{productSaleRecord}/confirm', [self::class, 'confirmSaleRecord'])->name($p('confirm_sale'))->defaults('ex', __e('ss', null, true));
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
    $salesRecords =  self::products()->with(
      'product',
      'product.product_supplier',
      'product.product_price',
      'product.product_model:id,name',
      'sales_rep:id,full_name,email',
      'online_rep:id,full_name,email',
      'sale_confirmer:id,full_name,email',
      'sales_channel:id,channel_name',
      'bank_account_payments'
    )->whereDate('created_at', Carbon::parse($date))->get();

    $swapSalesRecords =  self::swapDeals()->with(
      'product'
    )->whereDate('created_at', Carbon::parse($date))->get();

    $salesRecords = (new ProductSaleRecordTransformer)->collectionTransformer($salesRecords, 'basic')->merge((new ProductSaleRecordTransformer)->collectionTransformer($swapSalesRecords, 'basicSwapTransaction'));

    $companyAccounts = Cache::rememberForever('companyAccounts', fn () => (new CompanyBankAccountTransformer)->collectionTransformer(CompanyBankAccount::all(), 'basic'));

    if ($request->isApi()) return response()->json($salesRecords, 200);
    return Inertia::render('SuperAdmin,Products/SalesRecords', [
      'salesRecords' => $salesRecords,
      'date' => $date,
      'companyAccounts' => $companyAccounts
    ]);
  }

  /**
   * !This belongs to accountants only
   * @param Product $product The product to mark as sold
   */
  public function confirmSaleRecord(Request $request, self $productSaleRecord)
  {

    $paymentRecords = $request->payment_records;

    /**
     * !Remove any empty fields from input
     */
    foreach ($paymentRecords as $key => $value) {
      if (!is_numeric($key)) {
        unset($paymentRecords[$key]);
      }
    }

    $product = $productSaleRecord->product;

    $status_id = ProductStatus::saleConfirmedId();

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

    $productSaleRecord->sale_confirmed_by = auth()->id();
    $productSaleRecord->sale_confirmer_type = get_class($request->user());
    $productSaleRecord->save();

    /**
     * Record the bank account payments breakdown for this transaction
     */

    $productSaleRecord->bank_account_payments()->sync($paymentRecords);

    /**
     * // generate the receipt and save it in the DB.
     * ? This is so that even if the user should change his details in the future,
     * ? this receipt will still carry this his current records
     */
    try {
      $receipt = $product->generate_receipt();
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth()->user(), $th, 'Receipt generation failed');
       // if ($request->isApi()) return response()->json(['err' => 'Receipt generation failed'], 500);
      // return back()->withError('Receipt generation failed');
    }

    /**
     * Send the user an email containing his receipt
     */

    try {
      $product->app_user->notify(new SendProductReceipt($receipt));
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth()->user(), $th, 'Failed to send receipt to user', $product->app_user->email);
        // if ($request->isApi()) return response()->json(['err' => 'Failed to send receipt to user ' . $product->app_user->emai], 500);
      // return back()->withError('Failed to send receipt to user  ' . $product->app_user->emai);
    }


    /**
     * Notify Admin that a product was sold
     */
    ActivityLog::notifySuperAdmins(auth()->user()->email . ' confirmed the sale of product with ' . $product->primary_identifier() . '.');

    /**
     * Notify Accountant that a product was marked as sold
     */
    ActivityLog::notifyAccountants(auth()->user()->email . ' confirmed the sale of product with ' . $product->primary_identifier() . '.');

    DB::commit();

    if ($request->isApi()) return response()->json([], 204);
    return back()->withSuccess('Product has been marked as sold. It will no longer be available in stock');
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

  public function scopeProducts($query)
  {
    return $query->where('product_type', Product::class);
  }

  public function scopeSwapDeals($query)
  {
    return $query->where('product_type', SwapDeal::class);
  }
}
