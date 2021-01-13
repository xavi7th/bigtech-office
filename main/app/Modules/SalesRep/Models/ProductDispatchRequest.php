<?php

namespace App\Modules\SalesRep\Models;

use DB;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\SwapDeal;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Traits\Commentable;
use Illuminate\Validation\ValidationException;
use App\Modules\SuperAdmin\Models\SalesChannel;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SalesRep\Notifications\DispatchRequestDiscarded;
use App\Modules\SalesRep\Http\Validations\SendDispatchRequestValidation;
use App\Modules\DispatchAdmin\Transformers\ProductDispatcgRequestTransformer;

/**
 * App\Modules\SalesRep\Models\ProductDispatchRequest
 *
 * @property int $id
 * @property int|null $sales_channel_id
 * @property int $online_rep_id
 * @property string $product_description
 * @property int|null $product_id
 * @property string|null $product_type
 * @property float $proposed_selling_price
 * @property string $customer_first_name
 * @property string|null $customer_last_name
 * @property string $customer_phone
 * @property string|null $customer_email
 * @property string $customer_address
 * @property string $customer_city
 * @property string|null $customer_ig_handle
 * @property string|null $scheduled_at
 * @property string|null $sold_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\UserComment[] $comments
 * @property-read int|null $comments_count
 * @property-read \App\Modules\SalesRep\Models\SalesRep $online_rep
 * @property-read Model|\Eloquent $product
 * @property-read SalesChannel|null $sales_channel
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest newQuery()
 * @method static \Illuminate\Database\Query\Builder|ProductDispatchRequest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereCustomerAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereCustomerCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereCustomerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereCustomerFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereCustomerIgHandle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereCustomerLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereCustomerPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereOnlineRepId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereProductDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereProductType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereProposedSellingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereSalesChannelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereSoldAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDispatchRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|ProductDispatchRequest withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ProductDispatchRequest withoutTrashed()
 * @mixin \Eloquent
 * @method static Builder|ProductDispatchRequest unprocessed()
 */
class ProductDispatchRequest extends Model
{

  use Commentable;
  use SoftDeletes;

  protected $fillable = ['sales_channel_id', 'online_rep_id', 'product_description', 'product_id', 'product_type', 'proposed_selling_price', 'customer_first_name', 'customer_last_name', 'customer_phone', 'customer_email', 'customer_address', 'customer_city', 'customer_ig_handle'];

  public function sales_channel()
  {
    return $this->belongsTo(SalesChannel::class);
  }

  public function online_rep()
  {
    return $this->belongsTo(SalesRep::class);
  }

  public function product()
  {
    return $this->morphTo();
  }

  public function is_scheduled(): bool
  {
    return !is_null($this->scheduled_at);
  }

  public function is_sold(): bool
  {
    return !is_null($this->sold_at);
  }

  public function primary_identifier(): ?string
  {
    return optional($this->product)->primary_identifier();
  }


  public function customer_details(): HtmlString
  {
    return new HtmlString('<b>CUSTOMER DETAILS:</b> <br> Full Name: ' . $this->customer_first_name . ' ' . $this->customer_last_name . '<br> Phone: ' .  $this->customer_phone . '<br> Address: ' .  $this->customer_address . '<br> City: ' .  $this->customer_city . '<br> IG HANDLE: ' .  $this->customer_ig_handle);
  }

  /**
   * Check if there is a request for this user in the database already
   *
   * @param string $firstName
   * @param string $lastName
   * @param string $phone
   * @param Carbon\Carbon $createdAt
   *
   * @return boolean
   */
  static function alreadyExists(string $firstName, string $lastName, string $phone, Carbon $createdAt): bool
  {
    return self::whereCustomerFirstName($firstName)->whereCustomerLastName($lastName)->whereCustomerPhone($phone)->whereDate('created_at', $createdAt)->exists();
  }


  static function salesRepRoutes()
  {
    Route::group(['prefix' => 'product-dispatch-requests'], function () {
      Route::name('salesrep.products.')->group(function () {
        Route::post('create', [self::class, 'sendProductToDispatch'])->name('send_for_dispatch')->defaults('ex', __e('ac', 'list', true));
      });
    });
  }


  static function dispatchAdminRoutes()
  {
    Route::group(['prefix' => 'product-dispatch-requests'], function () {
      Route::name('dispatchadmin.dispatch_requests.')->group(function () {
        Route::get('', [self::class, 'getDispatchRequests'])->name('view_dispatch_requests')->defaults('ex', __e('d', 'list', false));
        Route::post('{productDispatchRequest}/schedule-delivery', [self::class, 'scheduleProductForDeliveryRequest'])->name('schedule_delivery')->defaults('ex', __e('d', null, true));
        Route::post('{productDispatchRequest}/delete', [self::class, 'deleteDispatchRequest'])->name('delete')->defaults('ex', __e('d', 'list', false));
      });
    });
  }

  public function sendProductToDispatch(SendDispatchRequestValidation $request)
  {
    $request->user()->product_dispatch_requests()->create($request->validated());

    if ($request->isApi()) return response()->json([], 204);
    return back()->withFlash(['success'=>'A request has been sent to the dispatch unit']);
  }

  public function getDispatchRequests(Request $request)
  {
    return Inertia::render('DispatchAdmin,ViewDispatchRequests', [
      'dispatch_requests' => fn () => Cache::rememberForever('dispatchRequests', fn () => (new ProductDispatcgRequestTransformer)->collectionTransformer(self::unprocessed()->with('online_rep')->latest()->get(), 'basic')),
    ]);
  }

  public function scheduleProductForDeliveryRequest(Request $request, self $productDispatchRequest)
  {
    if (!$request->identification_type) throw ValidationException::withMessages(['err' => "An IMEI or Serial Number or Model Number is required"])->status(Response::HTTP_UNPROCESSABLE_ENTITY);

    $product = Product::where($request->identification_type, $request->input($request->identification_type))->first() ?? SwapDeal::where($request->identification_type, $request->input($request->identification_type))->firstOr(function () {
      throw ValidationException::withMessages(['err' => "Invalid product selected"])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
    });

    DB::beginTransaction();

    if (!$product->in_stock()) {
      throw ValidationException::withMessages(['err' => "This product is currently not listed in the stock list"])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
    } else {
      $product->product_status_id = ProductStatus::scheduledDeliveryId();
      $product->save();
    }

    $productDispatchRequest->product_id = $product->id;
    $productDispatchRequest->product_type = get_class($product);
    $productDispatchRequest->scheduled_at = now();
    $productDispatchRequest->save();

    DB::commit();

    if ($request->isApi()) return response()->json([], 204);
    return back()->withFlash(['success'=>'Product removed from stock list and scheduled for delivery']);
  }

  public function deleteDispatchRequest(Request $request, self $productDispatchRequest)
  {

    if (!$request->reason) throw ValidationException::withMessages(['error' => "A reason for the deleting the request is required"])->status(Response::HTTP_UNPROCESSABLE_ENTITY);

    DB::beginTransaction();

    /**
     * ! Record the reason for deleting this request
     */
    $request->user()->comments()->create([
      'subject_id' => $productDispatchRequest->id,
      'subject_type' => get_class($productDispatchRequest),
      'comment' => 'Dispatch request deleted because ' . $request->reason
    ]);

    $productDispatchRequest->online_rep->notify(new DispatchRequestDiscarded($productDispatchRequest, $request->reason));

    $productDispatchRequest->delete();

    DB::commit();

    return back()->withFlash(['success'=>'Dispatch request deleted. Kindly inform ' . $productDispatchRequest->online_rep->full_name . ' that you discarded one of their requests if they are not aware']);
  }

  public function scopeUnprocessed(Builder $query)
  {
    return $query->whereNull('sold_at');
  }

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($dispatchRequest) {
      $dispatchRequest->online_rep_id = request()->user()->id;
    });

    static::saved(function ($dispatchRequest) {
      Cache::forget('dispatchRequests');
    });

    static::deleted(function ($dispatchRequest) {
      Cache::forget('dispatchRequests');
      Cache::forget('products');
      Cache::forget('webAdminProducts');
      Cache::forget('dispatchAdminProducts');
      Cache::forget('stockKeeperProducts');
      Cache::forget('salesRepProducts');
      Cache::forget('qualityControlProducts');
      Cache::forget('brandsWithProductCount');
    });
  }
}
