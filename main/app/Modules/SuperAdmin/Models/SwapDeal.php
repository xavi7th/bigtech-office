<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\Reseller;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\SuperAdmin\Traits\Commentable;
use App\Modules\SuperAdmin\Models\SalesChannel;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Models\ProductHistory;
use App\Modules\SuperAdmin\Models\ResellerProduct;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SalesRep\Transformers\SalesRepTransformer;
use App\Modules\SuperAdmin\Transformers\ResellerTransformer;
use App\Modules\SuperAdmin\Transformers\SwapDealTransformer;
use App\Modules\SuperAdmin\Transformers\SalesChannelTransformer;
use App\Modules\SuperAdmin\Transformers\ProductStatusTransformer;
use App\Modules\SuperAdmin\Http\Validations\CreateSwapDealValidation;
use App\Modules\SuperAdmin\Http\Validations\MarkProductAsSoldValidation;
use App\Modules\SuperAdmin\Http\Validations\CreateProductCommentValidation;

/**
 * App\Modules\SuperAdmin\Models\SwapDeal
 *
 * @property int $id
 * @property int|null $app_user_id
 * @property string $description
 * @property string $owner_details
 * @property string|null $id_url
 * @property string|null $receipt_url
 * @property string|null $imei
 * @property string|null $serial_no
 * @property string|null $model_no
 * @property float $swap_value
 * @property float|null $selling_price
 * @property string|null $sold_at
 * @property Product $swapped_with
 * @property int $product_status_id
 * @property string $product_uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read AppUser|null $app_user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\UserComment[] $comments
 * @property-read int|null $comments_count
 * @property-read string $id_thumb_url
 * @property-read string $receipt_thumb_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ProductExpense[] $product_expenses
 * @property-read int|null $product_expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductHistory[] $product_histories
 * @property-read int|null $product_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductSaleRecord[] $product_sales_record
 * @property-read int|null $product_sales_record_count
 * @property-read ProductStatus $product_status
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ResellerHistory[] $reseller_histories
 * @property-read int|null $reseller_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Reseller[] $with_resellers
 * @property-read int|null $with_resellers_count
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal backFromRepairs()
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal inStock()
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal outForRepairs()
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal query()
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal saleConfirmed()
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal sold()
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal soldByReseller()
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal untested()
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal whereAppUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal whereIdUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal whereImei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal whereModelNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal whereOwnerDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal whereProductStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal whereProductUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal whereReceiptUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal whereSellingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal whereSerialNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal whereSoldAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal whereSwapValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal whereSwappedWith($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal withReseller()
 * @mixin \Eloquent
 */
class SwapDeal extends BaseModel
{
  use Commentable;

  protected $fillable = [
    'description', 'owner_details', 'id_url', 'receipt_url', 'imei', 'serial_no', 'model_no',
    'swap_value', 'swapped_with', 'product_status_id', 'app_user_id'
  ];

  protected $apennds = ['id_thumb_url', 'receipt_thumb_url'];

  public function primary_identifier(): string
  {
    switch (true) {
      case $this->imei:
        return 'IMEI: ' . $this->imei;
        break;
      case $this->serial_no:
        return 'Serial No: ' . $this->serial_no;
        break;
      case $this->model_no:
        return 'Model No: ' . $this->model_no;
        break;
      default:
        return '';
    }
  }

  public function product_histories()
  {
    return $this->morphMany(ProductHistory::class, 'product')->latest();
  }

  public function reseller_histories()
  {
    return $this->morphMany(ResellerHistory::class, 'product')->latest();
  }

  public function product_sales_record()
  {
    return $this->morphMany(ProductSaleRecord::class, 'product');
  }

  public function product_expenses()
  {
    return $this->morphMany(ProductExpense::class, 'product')->latest();
  }

  public function with_resellers()
  {
    return $this->morphToMany(Reseller::class, 'product',  $table = 'reseller_product')->using(ResellerProduct::class)->wherePivot('status', 'tenured')->withPivot('status')->withTimestamps()->as('tenure_record');
    // return $this->belongsToMany(Reseller::class, $table = 'reseller_product')->using(ResellerProduct::class)->wherePivot('status', 'tenured')->withPivot('status')->withTimestamps()->as('tenure_record');
  }

  public function swapped_with()
  {
    return $this->belongsTo(Product::class);
  }

  public function product_status()
  {
    return $this->belongsTo(ProductStatus::class);
  }

  public function app_user()
  {
    return $this->belongsTo(AppUser::class);
  }

  public function total_product_expenses(): float
  {
    return $this->product_expenses()->sum('amount');
  }

  public function is_sold(): bool
  {
    /**
     * Check if the product has been sold already or confirmed
     */
    return $this->product_status_id === ProductStatus::soldId() || $this->product_status_id === ProductStatus::saleConfirmedId();
  }

  public function in_stock(): bool
  {
    /**
     * Check if the product has been sold already or confirmed
     */
    return $this->product_status_id === ProductStatus::inStockId();
  }

  public function with_reseller(): bool
  {
    return $this->product_status_id === ProductStatus::withResellerId();
  }

  public function getIdThumbUrlAttribute(): string
  {
    return Str::of($this->id_url)->replace(Str::of($this->id_url)->dirname(), Str::of($this->id_url)->dirname() . '/thumbs');
  }

  public function getReceiptThumbUrlAttribute(): string
  {
    return Str::of($this->receipt_url)->replace(Str::of($this->receipt_url)->dirname(), Str::of($this->receipt_url)->dirname() . '/thumbs');
  }

  static function store_documents()
  {
    return [
      compress_image_upload('id_card', 'swap-deal-documents/' . now()->toDateString() . '/', 'swap-deal-documents/' . now()->toDateString() . '/thumbs/', 800, true, 50)['img_url'],
      compress_image_upload('receipt', 'swap-deal-documents/' . now()->toDateString() . '/', 'swap-deal-documents/' . now()->toDateString() . '/thumbs/', 800, true, 50)['img_url'],
    ];
  }

  static function create_swap_record(object $request, string $id_url, string $receipt_url)
  {
    try {
      self::create([
        'description' => $request->description,
        'owner_details' => $request->owner_details,
        'id_url' => $id_url,
        'receipt_url' => $receipt_url,
        'imei' => $request->imei ?? null,
        'serial_no' => $request->serial_no ?? null,
        'model_no' => $request->model_no ?? null,
        'swap_value' => $request->swap_value,
        'swapped_with' => $request->swapped_with ?? null,
        'app_user_id' => $request->app_user_id ?? null,
        'product_status_id' => ProductStatus::undergoingQaId(),
      ]);

      return true;
    } catch (\Throwable $th) {
      ErrLog::notifyAdminAndFail(auth()->user(), $th, 'Swap Deal not created');

      return false;
    }
  }

  static function stockKeeperRoutes()
  {
    Route::group(['prefix' => 'swap-deals'], function () {
      Route::name('stockkeeper.products.')->group(function () {
        Route::get('create', [self::class, 'showCreateSwapDealForm'])->name('create_swap_deal')->defaults('ex', __e('sk', 'refresh-cw', false));
        Route::post('create', [self::class, 'createSwapDeal'])->name('swap_deal.create')->defaults('ex', __e('sk', 'refresh-cw', true));
      });
    });
  }

  static function qualityControlRoutes()
  {
    Route::group(['prefix' => 'swap-deals'], function () {
      Route::name('qualitycontrol.products.')->group(function () {
        Route::put('{swapDeal:product_uuid}/status', [self::class, 'updateSwapDealStatus'])->name('update_swap_status')->defaults('ex', __e('q', null, true));
      });
    });
  }

  static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'swap-deals'], function () {
      Route::name('multiaccess.products.')->group(function () {
        Route::get('', [self::class, 'getSwapDeals'])->name('swap_deals')->defaults('ex', __e('sk,s,q,a', 'refresh-cw', false))->middleware('auth:stock_keeper,sales_rep,quality_control,admin');
        Route::get('details/{swapDeal:product_uuid}', [self::class, 'getSwapDealDetails'])->name('swap_deal_details')->defaults('ex', __e('ss,sk,s,q,a', 'refresh-cw', true))->middleware('auth:stock_keeper,sales_rep,quality_control,admin');
        Route::post('{swapDeal:product_uuid}/comment', [self::class, 'commentOnSwapDeal'])->name('comment_on_swap_deal')->defaults('ex', __e('ss,sk,s,q,a', null, true))->middleware('auth:stock_keeper,sales_rep,quality_control,admin');
        Route::post('{swapDeal:product_uuid}/sold', [self::class, 'markSwapDealAsSold'])->name('mark_swap_as_sold')->defaults('ex', __e('ss,s', null, true))->middleware('auth:stock_keeper,sales_rep');
      });
    });
  }

  public static function routes()
  {
    Route::group(['prefix' => 'swap-deals', 'namespace' => '\App\Modules\Admin\Models'], function () {
      $p = function ($name) {
        return 'superadmin.products.' . $name;
      };
      Route::put('{swapDeal:product_uuid}/edit', [self::class, 'editSwapDeal'])->name($p('edit_swap_deal'))->defaults('ex', __e('ss', 'refresh-cw', true));
      Route::put('{swapDeal:product_uuid}/confirm-sale', [self::class, 'confirmSwapDealSale'])->name($p('confirm_swap_sale'))->defaults('ex', __e('ss', null, true));
    });
  }

  public function getSwapDeals(Request $request)
  {
    if ($request->user()->isSalesRep()) {
      $swapDeals = Cache::rememberForever('salesRepsSwapDeals', fn () => (new SwapDealTransformer)->collectionTransformer(self::inStock()->with('swapped_with', 'product_status', 'app_user')->get(), 'basic'));
    } elseif ($request->user()->isQualityControl()) {
      $swapDeals = Cache::rememberForever('qualityControlsSwapDeals', fn () => (new SwapDealTransformer)->collectionTransformer(self::untested()->with('swapped_with', 'product_status', 'app_user')->get(), 'basic'));
    } else {
      $swapDeals = collect([]);
    }
    $onlineReps = fn () => Cache::rememberForever('onlineReps', fn () => (new SalesRepTransformer)->collectionTransformer(SalesRep::socialMedia()->get(), 'transformBasic'));
    $salesChannel = fn () => Cache::rememberForever('salesChannel', fn () => (new SalesChannelTransformer)->collectionTransformer(SalesChannel::all(), 'basic'));
    $resellers = fn () => Cache::rememberForever('resellers', fn () => (new ResellerTransformer)->collectionTransformer(Reseller::all(), 'basic'));

    if ($request->isApi()) return response()->json($swapDeals, 200);
    return Inertia::render('SuperAdmin,Products/SwapDeals', compact('swapDeals', 'onlineReps', 'salesChannel', 'resellers'));
  }

  public function getSwapDealDetails(Request $request, self $swapDeal)
  {
    $swapDeal = (new SwapDealTransformer)->detailed($swapDeal->load('swapped_with', 'product_status', 'app_user', 'comments', 'product_expenses'));
    $product_statuses = Cache::rememberForever('productStatuses', fn () => (new ProductStatusTransformer)->collectionTransformer(ProductStatus::notSaleStatus()->get(), 'basic'));

    return Inertia::render('SuperAdmin,Products/SwapDealDetails', compact('swapDeal', 'product_statuses'));
  }

  public function showCreateSwapDealForm()
  {
    return Inertia::render('SuperAdmin,Products/CreateDirectSwapDeal');
  }

  public function createSwapDeal(CreateSwapDealValidation $request)
  {
    // dd($request->validated());
    list($id_url, $receipt_url) = $this->store_documents($request);

    if ($this->create_swap_record($request, $id_url, $receipt_url)) {
      if ($request->isApi()) return response()->json([], 201);
      return back()->withSuccess('Swap deal created');
    } else {
      if ($request->isApi()) return response()->json(['err' => 'Swap Deal not created'], 500);
      return back()->withError('Swap Deal not created');
    }
  }

  public function editSwapDeal(CreateSwapDealValidation $request, self $swapDeal)
  {
    try {
      $swapDeal->selling_price = $request->selling_price;
      $swapDeal->description = $request->description;

      $swapDeal->save();

      if ($request->isApi()) return response()->json([], 204);
      return back()->withSuccess('Details updated');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth()->user(), $th, 'Swap details not updated');
      if ($request->isApi()) return response()->json(['err' => 'Swap details not updated'], 500);
      return back()->withError('Details not updated');
    }
  }

  public function commentOnSwapDeal(CreateProductCommentValidation $request, self $swapDeal)
  {
    $comment =  $request->user()->comments()->create([
      'subject_id' => $swapDeal->id,
      'subject_type' => get_class($swapDeal),
      'comment' => $request->comment
    ]);

    if ($request->isApi()) return response()->json($comment, 201);
    return back()->withSuccess('Comment created. ');
  }

  public function markSwapDealAsSold(MarkProductAsSoldValidation $request, self $swapDeal)
  {

    // dd($product);

    DB::beginTransaction();

    /**
     * Update product status to sold
     */
    $swapDeal->product_status_id = ProductStatus::soldId();
    $swapDeal->sold_at = now();

    /**
     * Create a sales record for the product
     */
    try {
      $swapDeal->product_sales_record()->create([
        'selling_price' => $request->selling_price,
        'online_rep_id' => $request->online_rep_id,
        'sales_rep_id' => auth()->id(),
        'sales_channel_id' => $request->sales_channel_id,
        'is_swap_transaction' => filter_var($request->is_swap_transaction, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
      ]);
    } catch (\Throwable $th) {
      ErrLog::notifyAdminAndFail(auth()->user(), $th, 'Could not create product sales record ' . $request->email);
      if ($request->isApi()) return response()->json(['err' => 'Could not create product sales record ' . $request->email], 500);
      return back()->withError('Could not create product sales record. Try again');
    }

    /**
     * Create or update the buyer's user profile using the email
     */
    try {
      $app_user = AppUser::updateOrCreate(
        [
          'email' => $request->email,
          'phone' => $request->phone,
        ],
        [
          'first_name' => $request->first_name,
          'last_name' => $request->last_name,
          'address' => $request->address,
          'city' => $request->city,
          'ig_handle' => $request->ig_handle,
          'password' => 'default'
        ]
      );
    } catch (\Throwable $th) {
      ErrLog::notifyAdminAndFail(auth()->user(), $th, 'Could not create account profile for ' . $request->email);
      if ($request->isApi()) return response()->json(['err' => 'Could not create account profile for ' . $request->email], 500);
      return back()->withError('Could not create account profile for buyer. Try again');
    }

    /**
     * Allocate the item to the user
     */
    $swapDeal->app_user_id = $app_user->id;
    $swapDeal->save();


    /**
     * ! If swap deal, process the swap device
     */
    if (filter_var($request->is_swap_transaction, FILTER_VALIDATE_BOOLEAN)) {
      // return $request->validated();
      list($id_url, $receipt_url) = SwapDeal::store_documents($request);
      if (!SwapDeal::create_swap_record((object)collect($request->validated())->merge(['app_user_id' => $app_user->id])->all(), $id_url, $receipt_url)) {
        if ($request->isApi()) return response()->json(['err' => 'Transaction not completed. The swap details could not be created'], 500);
        return back()->withError('Transaction not completed. The swap details could not be created');
      }
    }

    /**
     * Notify Admin that a product was sold
     */
    ActivityLog::notifySuperAdmins($request->user()->email . ' marked swap deal with UUID no: ' . $swapDeal->product_uuid . ' as sold.');

    /**
     * Notify Accountant that a product was marked as sold
     */
    ActivityLog::notifyAccountants($request->user()->email . ' marked swap deal with UUID: ' . $swapDeal->product_uuid . ' as sold.');

    DB::commit();

    if ($request->isApi()) return response()->json([], 204);
    return back()->withSuccess('Product has been marked as sold. It will no longer be available in stock');
  }

  /**
   * !This belongs to accountants only
   * @param self $product The product to mark as sold
   */
  public function confirmSwapDealSale(Request $request, self $swapDeal)
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

    // $product_sales_record = $swapDeal->product_sales_record;

    // if (is_null($product_sales_record)) {
    //   return generate_422_error('This product has not being sold');
    // }

    $status_id = ProductStatus::saleConfirmedId();

    if ($swapDeal->product_status_id === $status_id) {
      return generate_422_error('This product has being confirmed sold already');
    }
    DB::beginTransaction();

    /**
     * Update the product's status to confirmed sold
     */
    $swapDeal->product_status_id = $status_id;
    $swapDeal->save();

    /**
     * Mark the product's sales record as confirmed
     */
    // $product_sales_record->sale_confirmed_by = $request->user()->id;
    // $product_sales_record->sale_confirmer_type = get_class($request->user());
    // $product_sales_record->save();

    /**
     * Record the bank account payments breakdown for this transaction
     */
    // $product_sales_record->bank_account_payments()->sync($paymentRecords);


    /**
     * // generate the receipt and save it in the DB.
     * ? This is so that even if the user should change his details in the future,
     * ? this receipt will still carry this his current records
     */
    try {
      $receipt = $swapDeal->generate_receipt();
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Receipt generation failed');
      // if ($request->isApi()) return response()->json(['err' => 'Receipt generation failed'], 500);
      // return back()->withError('Receipt generation failed');
    }

    /**
     * Send the user an email containing his receipt
     */

    try {
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Failed to send receipt to user', $swapDeal->app_user->email);
      // if ($request->isApi()) return response()->json(['err' => 'Failed to send receipt to user ' . $product->app_user->emai], 500);
      // return back()->withError('Failed to send receipt to user  ' . $product->app_user->emai);
    }


    /**
     * Notify Admin that a product was sold
     */
    ActivityLog::notifySuperAdmins($request->user()->email . ' marked product with ' . $swapDeal->primary_identifier() . ' as confirmed sold.');

    /**
     * Notify Accountant that a product was marked as sold
     */
    ActivityLog::notifyAccountants($request->user()->email . ' marked product with ' . $swapDeal->primary_identifier() . ' as confirmed sold.');

    DB::commit();

    if ($request->isApi()) return response()->json([], 204);
    return back()->withSuccess('Product has been marked as sold. It will no longer be available in stock');
  }

  public function updateSwapDealStatus(Request $request, self $swapDeal)
  {

    if ($swapDeal->product_status_id == $request->product_status_id) {
      return generate_422_error('Nothing changed');
    }

    DB::beginTransaction();

    try {
      $product_status = ProductStatus::findOrFail($request->product_status_id);
    } catch (\Throwable $th) {
      return generate_422_error('Invalid product status selected');
    }

    //notify admin that someone updated a product status
    ActivityLog::notifySuperAdmins($request->user()->email . ' changed product with ' . $swapDeal->primary_identifier() . ' to status:  "' . $product_status->status . '"');

    /**
     * Update the status
     */
    if ($product_status->id === ProductStatus::soldId()) {
      return generate_422_error('Mark this product as sold instead');
    } elseif ($product_status->id === ProductStatus::saleConfirmedId()) {
      return generate_422_error('Confirm this product as sold instead');
    } elseif ($product_status->id === ProductStatus::soldByResellerId()) {
      return generate_422_error('Confirm this product as sold instead');
    } else {
      $swapDeal->product_status_id = $request->product_status_id;
      $swapDeal->save();
    }

    DB::commit();

    if ($request->isApi()) return response()->json([], 204);
    return back()->withSuccess('Status updated');
  }

  public function scopeUntested($query)
  {
    return $query->where('product_status_id', ProductStatus::undergoingQaId());
  }

  public function scopeSold($query)
  {
    return $query->where('product_status_id', ProductStatus::soldId());
  }

  public function scopeSaleConfirmed($query)
  {
    return $query->where('product_status_id', ProductStatus::saleConfirmedId());
  }

  public function scopeInStock($query)
  {
    return $query->where('product_status_id', ProductStatus::inStockId());
  }

  public function scopeOutForRepairs($query)
  {
    return $query->where('product_status_id', ProductStatus::outForRepairsId());
  }

  public function scopeBackFromRepairs($query)
  {
    return $query->where('product_status_id', ProductStatus::backFromRepairsId());
  }

  public function scopeWithReseller($query)
  {
    return $query->where('product_status_id', ProductStatus::withResellerId());
  }

  public function scopeSoldByReseller($query)
  {
    return $query->where('product_status_id', ProductStatus::soldByResellerId());
  }

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($swapDeal) {
      $swapDeal->product_uuid = (string)Str::uuid();
    });

    static::saved(function ($swapDeal) {
      Cache::forget('products');
      Cache::forget('qualityControlsSwapDeals');
      Cache::forget('salesRepsSwapDeals');

      if ($swapDeal->isDirty('product_status_id')) {
        request()->user()->product_histories()->create([
          'product_id' => $swapDeal->id,
          'product_type' => get_class($swapDeal),
          'product_status_id' => $swapDeal->product_status_id,
        ]);
      }
    });

    static::updated(function ($swapDeal) {
      // dd('fire an event to report this change');

      if (!$swapDeal->isDirty('product_status_id')) {
        $changes = $swapDeal->getChanges();
        Arr::forget($changes, 'updated_at');
        request()->user()->comments()->create([
          'subject_id' => $swapDeal->id,
          'subject_type' => get_class($swapDeal),
          'comment' => 'Changed ' . http_build_query($changes) . ' because ' . request()->comment
        ]);
      }
    });
  }
}
