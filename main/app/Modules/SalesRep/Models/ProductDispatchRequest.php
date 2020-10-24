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
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Traits\Commentable;
use Illuminate\Validation\ValidationException;
use App\Modules\SuperAdmin\Models\SalesChannel;
use App\Modules\SalesRep\Notifications\DispatchRequestDiscarded;
use App\Modules\SalesRep\Http\Validations\SendDispatchRequestValidation;
use App\Modules\DispatchAdmin\Transformers\ProductDispatcgRequestTransformer;

class ProductDispatchRequest extends Model
{

  use Commentable;
  use SoftDeletes;

  protected $fillable = ['sales_channel_id', 'online_rep_id', 'product_description', 'product_id', 'product_type', 'proposed_selling_price', 'customer_first_name', 'customer_last_name', 'customer_phone', 'customer_address', 'customer_city', 'customer_ig_handle'];

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
    return $this->scheduled_at == null;
  }

  public function is_sold(): bool
  {
    return $this->sold_at == null;
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
        Route::post('{productDispatchRequest}/delete', [self::class, 'deleteDispatchRequest'])->name('delete')->defaults('ex', __e('d', 'list', false));
      });
    });
  }

  public function sendProductToDispatch(SendDispatchRequestValidation $request)
  {
    $request->user()->product_dispatch_requests()->create($request->validated());

    if ($request->isApi()) return response()->json([], 204);
    return back()->withSuccess('A request has been sent to the dispatch unit');
  }



  public function getDispatchRequests(Request $request)
  {
    return Inertia::render('DispatchAdmin,ViewDispatchRequests', [
      'dispatch_requests' => fn () => Cache::rememberForever('dispatchRequests', fn () => (new ProductDispatcgRequestTransformer)->collectionTransformer(self::with('online_rep')->get(), 'basic')),
    ]);
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

    return back()->withSuccess('Dispatch request deleted. Kindly inform ' . $productDispatchRequest->online_rep->full_name . ' that you discarded one of their requests if they are not aware');
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
    });
  }
}
