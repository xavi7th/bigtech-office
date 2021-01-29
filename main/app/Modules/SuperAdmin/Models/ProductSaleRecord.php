<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
use Illuminate\Validation\ValidationException;
use App\Modules\SuperAdmin\Models\SalesChannel;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Models\CompanyBankAccount;
use App\Modules\SuperAdmin\Models\SalesRecordBankAccount;
use App\Modules\AppUser\Notifications\ProductReceiptNotification;
use App\Modules\SuperAdmin\Transformers\ProductSaleRecordTransformer;
use App\Modules\SuperAdmin\Transformers\CompanyBankAccountTransformer;

/**
 * App\Modules\SuperAdmin\Models\ProductSaleRecord
 *
 * @property int $id
 * @property int $product_id
 * @property string $product_type
 * @property float $selling_price
 * @property int|null $sales_channel_id
 * @property int|null $online_rep_id
 * @property int|null $sales_rep_id
 * @property string|null $sales_rep_type
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
 * @property-read SalesRep|null $online_rep
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $product
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $sale_confirmer
 * @property-read SalesChannel|null $sales_channel
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $sales_rep
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
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord whereSalesRepType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord whereSellingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ProductSaleRecord withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProductSaleRecord withoutTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord yesterday()
 * @mixin \Eloquent
 * @property float $online_rep_bonus
 * @property float $walk_in_rep_bonus
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord whereOnlineRepBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord whereWalkInRepBonus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSaleRecord thisMonth()
 */
class ProductSaleRecord extends BaseModel
{
  use SoftDeletes;
  use Compoships;

  protected $fillable = [
    'selling_price', 'online_rep_id', 'sales_rep_id', 'sales_rep_type', 'sales_channel_id', 'is_swap_transaction'
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
    return $this->hasOne(SwapDeal::class, 'swapped_with_id', 'product_id')->where('swapped_with_type', $this->product_type);
  }

  public function sales_rep()
  {
    return $this->morphTo();
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

  public static function superAdminRoutes()
  {
    Route::group(['prefix' => 'product-sales-records/sales-reps'], function () {
      Route::name('superadmin.product_sales_records.')->group(function () {
        Route::get('{salesRep}', [self::class, 'getSalesRepSaleRecordsToday'])->name('sales_rep.today')->defaults('ex', __e('ss,ac', null, true));
        Route::get('{salesRep}/{date}', [self::class, 'getSalesRepSaleRecordsToday'])->name('sales_rep.history')->defaults('ex', __e('ss,ac', null, true));
      });
    });
  }

  public static function accountantRoutes()
  {
    Route::group(['prefix' => 'product-sales-records'], function () {
      Route::name('accountant.product_sales_records.')->group(function () {
        Route::post('{productSaleRecord}/confirm', [self::class, 'confirmSaleRecord'])->name('confirm_sale')->defaults('ex', __e('ac', null, true));
        Route::put('{productSaleRecord}/swap-product', [self::class, 'swapSaleRecordProduct'])->name('swap_product')->defaults('ex', __e('ac', null, true));
      });
    });
  }

  public static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'product-sales-records'], function () {
      Route::name('multiaccess.product_sales_records.')->group(function () {
        // Route::get('', [self::class, 'getProductSaleRecords'])->name($p('view_sales_records'))->defaults('ex', __e('ss', null, true))->middleware('auth:super_admin');
        Route::get('/{date}', [self::class, 'getDailyProductSaleRecords'])->name('daily')->defaults('ex', __e('ss,ac', null, true))->middleware('auth:super_admin,accountant');
        Route::get('{product}/transactions', [self::class, 'getSaleRecordTransactions'])->name('view_sales_record_transactions')->defaults('ex', __e('ss,ac', null, true))->middleware('auth:super_admin,accountant');
        Route::get('{product}/swap-deal', [self::class, 'getSaleRecordSwapDeal'])->name('view_sales_record_swap_deal')->defaults('ex', __e('ss,ac', null, true))->middleware('auth:super_admin,accountant');
      });
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
    $salesRecords =  self::products()->with([
      'product',
      'product.product_supplier',
      'product.product_price',
      'product.product_model:id,name',
      'sales_rep' => fn ($query) => $query->withoutGlobalScope('safeRecords')->select(['id', 'full_name', 'email']),
      'online_rep:id,full_name,email',
      'sale_confirmer:id,full_name,email',
      'sales_channel:id,channel_name',
      'bank_account_payments'
    ])->whereDate('created_at', Carbon::parse($date))->get();

    $swapSalesRecords =  self::swapDeals()->with([
      'product',
      'sales_rep' => fn ($query) => $query->withoutGlobalScope('safeRecords')->select(['id', 'full_name', 'email'])
    ])->whereDate('created_at', Carbon::parse($date))->get();


    /**
     * ! Fix: Call to a member function getKey() on array error when the first collection is empty.
     * @after Update?
     */
    if ($salesRecords->isEmpty()) {
      $salesRecords = (new ProductSaleRecordTransformer)->collectionTransformer($swapSalesRecords, 'basicSwapTransaction')->merge((new ProductSaleRecordTransformer)->collectionTransformer($salesRecords, 'basic'));
    } else {
      $salesRecords = (new ProductSaleRecordTransformer)->collectionTransformer($salesRecords, 'basic')->merge((new ProductSaleRecordTransformer)->collectionTransformer($swapSalesRecords, 'basicSwapTransaction'));
    }

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
   */
  public function confirmSaleRecord(Request $request, self $productSaleRecord)
  {
    $paymentRecords = $request->payment_records;
    $amountPaid = collect($paymentRecords)->sum('amount');
    $bankAccounts = [];
    $amounts = [];

    /**
     * !Remove any empty fields from input
     */
    foreach ($paymentRecords as $key => $value) {
      if (!is_numeric($key)) {
        unset($paymentRecords[$key]);
      }
      $bankAccounts[$key] = CompanyBankAccount::find($value['company_bank_id']);
      $amounts[$key] = ['amount' => $value['amount']];
    }

    /**
     * @var Product $product
     */
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

    /**
     * Assign bonuses to the relevant parties
     */

    if ($productSaleRecord->selling_price > +config('app.upper_bonus_treshold')) {
      $bonus = config('app.upper_bonus_amount');
    } else {
      $bonus = config('app.lower_bonus_amount');
    }

    if (!$productSaleRecord->online_rep && $productSaleRecord->sales_rep instanceof SalesRep) {
      /**
       * If this sale was handled by walk in rep alone, they get all the bonus
       */
      $productSaleRecord->walk_in_rep_bonus = $bonus;
    } elseif ($productSaleRecord->sales_rep instanceof SalesRep) {
      /**
       * If this sale was started by an online rep and marked sold by a walk in rep, then share the bonus
       */
      $productSaleRecord->walk_in_rep_bonus =  $walkInRepBonus = $bonus * (config('app.walk_in_bonus_percentage') / 100);
      $productSaleRecord->online_rep_bonus = $bonus - $walkInRepBonus;
    } else {
      $productSaleRecord->online_rep_bonus = $bonus;
    }

    $productSaleRecord->save();

    /**
     * Record the bank account payments breakdown for this transaction
     */
    $productSaleRecord->bank_account_payments()->saveMany($bankAccounts, $amounts);

    /**
     * // generate the receipt and save it in the DB.
     * ? This is so that even if the user should change his details in the future,
     * ? this receipt will still carry this his current records
     */
    try {
      $receipt = $product->generateReceipt($amountPaid);
    } catch (\Throwable $th) {
      ErrLog::notifyAdminAndFail(auth()->user(), $th, 'Receipt generation failed');
      // if ($request->isApi()) return response()->json(['err' => 'Receipt generation failed'], 500);
      return back()->withFlash(['error' => ['Receipt generation failed because ' . $th->getMessage()]]);
    }

    /**
     * Send the reseller or user an email containing his receipt
     * ! Reseller first because the app_user relationship does not ever return null because of withDefault
     */
    try {
      $receiptOwner = $product->reseller() ?? $product->app_user;
      $receiptOwner->notify(new ProductReceiptNotification($receipt));
    } catch (\Throwable $th) {
      ErrLog::notifyAdminAndFail(auth()->user(), $th, 'Failed to send receipt to user', $product->app_user->email);
      // if ($request->isApi()) return response()->json(['err' => 'Failed to send receipt to user ' . $product->app_user->emai], 500);
      return back()->withFlash(['error' => ['Failed to send receipt to user because ' . $th->getMessage()]]);
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
    return back()->withFlash(['success' => 'Product has been marked as paid and the customer has been sent their receipt']);
  }

  public function swapSaleRecordProduct(Request $request, self $productSaleRecord)
  {
    try {
      /**
     * @var Product
     */
      $newProduct = Product::inStock()->where($request->replacement_product_identifier_type, $request->replacement_product_identifier)->firstOr(fn() => SwapDeal::inStock()->where($request->replacement_product_identifier_type, $request->replacement_product_identifier)->firstOrFail());
    } catch (\Throwable $th) {
      throw ValidationException::withMessages(['err' => "The specified replacement product not found in the current stock list."])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @var Product
     */
    $oldProductToReplace = $productSaleRecord->product;

    /**
     * @var ProductReceipt
     */
    $oldProductReceipt = $oldProductToReplace->productReceipt;

    // change the old product´s status to undergoing qa
    $oldProductToReplace->product_status_id = ProductStatus::undergoingQaId();
    $newProduct->product_status_id = ProductStatus::saleConfirmedId();

    // enter a relevant history
    ActivityLog::notifySuperAdmins($request->user()->full_name . ' replaced sold product with ' . $oldProductToReplace->primary_identifier() . ' with a new product with ' . $newProduct->primary_identifier());

    // replace the appuser in old product with that in new product and nullify that of old
    $newProduct->app_user()->associate($oldProductToReplace->app_user);
    $oldProductToReplace->app_user()->dissociate();

    // nullify the sold at of old and replace the sold at of new with current date
    $oldProductToReplace->sold_at = null;
    $newProduct->sold_at = now();

    // update the product id of the sale record of the old product to the new one´s product id
    $productSaleRecord->product_id = $newProduct->id;
    $productSaleRecord->product_type = get_class($newProduct);
    $productSaleRecord->selling_price = $request->replacement_product_amount ?? $productSaleRecord->selling_price;

    // update the product_id of the old product´s receipt to the product_id of the new one

    if (!$oldProductReceipt) {
      try {
        $receipt = $newProduct->generateReceipt($productSaleRecord->selling_price);
      } catch (\Throwable $th) {
        ErrLog::notifyAdminAndFail(auth()->user(), $th, 'New receipt generation failed');
        return back()->withFlash(['error' => ['New Receipt generation failed']]);
      }
    }
    else{
      $oldProductReceipt->product_id = $newProduct->id;
    }

    /**
     * Send the user an email containing his new receipt
     */
    try {
      $newProduct->app_user->notify(new ProductReceiptNotification($newProduct->productReceipt));
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Failed to resend receipt to user', $newProduct->app_user->email);
    }

    $oldProductToReplace->save();
    $newProduct->save();
    $productSaleRecord->save();
    optional($oldProductReceipt)->save();


    DB::commit();

    return back()->withFlash(['success' => 'Product has been swapped and the user has been sent their new receipt']);
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

  public function scopeThisMonth($query)
  {
    return $query->whereMonth('product_sale_records.created_at', now()->month);
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

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($productSaleRecord) {
      $productSaleRecord->sales_rep_type = get_class(request()->user());
    });
  }
}
