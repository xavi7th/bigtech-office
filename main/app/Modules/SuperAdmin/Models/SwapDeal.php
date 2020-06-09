<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Transformers\SwapDealTransformer;
use App\Modules\SuperAdmin\Http\Validations\CreateSwapDealValidation;

/**
 * App\Modules\SuperAdmin\Models\SwapDeal
 *
 * @property-read \App\Modules\AppUser\Models\AppUser $app_user
 * @property-read \App\Modules\SuperAdmin\Models\ProductStatus $product_status
 * @property-read \App\Modules\SuperAdmin\Models\Product $swapped_with
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal query()
 * @mixin \Eloquent
 * @property int $id
 * @property int|null $app_user_id
 * @property string $description
 * @property string $owner_details
 * @property string|null $id_url
 * @property string|null $reciept_url
 * @property string|null $imei
 * @property string|null $serial_no
 * @property string|null $model_no
 * @property float $swap_value
 * @property float|null $selling_price
 * @property string|null $sold_at
 * @property int $product_status_id
 * @property string $product_uuid
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal whereAppUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal whereIdUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal whereImei($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal whereModelNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal whereOwnerDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal whereProductStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal whereProductUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal whereRecieptUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal whereSellingPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal whereSerialNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal whereSoldAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal whereSwapValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal whereSwappedWith($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\SwapDeal whereUpdatedAt($value)
 */
class SwapDeal extends Model
{
  protected $fillable = [
    'description', 'owner_details', 'id_url', 'reciept_url', 'imei', 'serial_no', 'model_no',
    'swap_value', 'swapped_with', 'product_status_id', 'app_user_id'
  ];


  public function primary_identifier(): string
  {
    switch (true) {
      case $this->imei:
        return 'imei: ' . $this->imei;
        break;
      case $this->serial_no:
        return 'serial no: ' . $this->serial_no;
        break;
      case $this->model_no:
        return 'model no: ' . $this->model_no;
        break;
      default:
        return '';
    }
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

  static function store_documents(Request $request)
  {
    Storage::makeDirectory('public/swap_deals_documents/' . now()->toDateString());
    $id_url = Storage::url($request->file('id_url')->store('public/swap_deals_documents/' . now()->toDateString()));
    $reciept_url = Storage::url($request->file('reciept_url')->store('public/swap_deals_documents/' . now()->toDateString()));

    return [
      $id_url,
      $reciept_url,
    ];
  }

  static function create_swap_record(object $request, string $id_url, string $reciept_url)
  {
    try {
      $swap_deal = self::create([
        'description' => $request->description,
        'owner_details' => $request->owner_details,
        'id_url' => $id_url,
        'reciept_url' => $reciept_url,
        'imei' => $request->imei ?? null,
        'serial_no' => $request->serial_no ?? null,
        'model_no' => $request->model_no ?? null,
        'swap_value' => $request->swap_value,
        'swapped_with' => $request->swapped_with ?? null,
        'app_user_id' => $request->app_user_id ?? null,
        'product_status_id' => ProductStatus::undergoing_qa_id(),
      ]);

      return response()->json((new SwapDealTransformer)->detailed($swap_deal), 201);
    } catch (\Throwable $th) {
      ErrLog::notifyAdminAndFail(auth()->user(), $th, 'Swap Deal not created');
      abort(500, 'Swap Deal not created', ['Content-Type' => 'application/json']);
      return response()->json(['err' => 'Swap Deal not created'], 500);
    }
  }

  public static function apiRoutes()
  {
    Route::group(['prefix' => 'swap-deals', 'namespace' => '\App\Modules\Admin\Models'], function () {
      Route::get('', 'SwapDeal@getSwapDeals')->middleware('auth:admin_api');
      Route::post('create', 'SwapDeal@createSwapDeal')->middleware('auth:admin_api');
      Route::put('{swap_deal}/edit', 'SwapDeal@editSwapDeal')->middleware('auth:admin_api');
    });
  }

  public function getSwapDeals()
  {
    return response()->json((new SwapDealTransformer)->collectionTransformer(self::with('swapped_with', 'product_status', 'app_user')->get(), 'detailed'), 200);
  }

  public function createSwapDeal(CreateSwapDealValidation $request)
  {
    // return $request->validated();

    list($id_url, $reciept_url) = $this->store_documents($request);

    return $this->create_swap_record($request, $id_url, $reciept_url);
  }


  public function editSwapDeal(CreateSwapDealValidation $request, self $swap_deal)
  {


    try {
      foreach ($request->validated() as $key => $value) {
        $swap_deal->$key = $value;
      }

      $swap_deal->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth()->user(), $th, 'Channel name not updated');
      return response()->json(['err' => 'Channel name not updated'], 500);
    }
  }

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($product) {
      $product->product_uuid = (string)Str::uuid();
    });

    static::updating(function ($product) {
      /**
       * add an entry for the product trail that it's status changed
       */
      auth()->user()->product_histories()->create([
        'product_id' => $product->id,
        'product_status_id' => $product->product_status_id,
      ]);
    });
  }
}
