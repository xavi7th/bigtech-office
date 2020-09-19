<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Traits\Commentable;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Transformers\SwapDealTransformer;
use App\Modules\SuperAdmin\Http\Validations\CreateSwapDealValidation;
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
 * @property-read ProductStatus $product_status
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SwapDeal query()
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

  public static function routes()
  {
    Route::group(['prefix' => 'swap-deals', 'namespace' => '\App\Modules\Admin\Models'], function () {
      $p = function ($name) {
        return 'superadmin.products.' . $name;
      };
      Route::get('', [self::class, 'getSwapDeals'])->name($p('swap_deals'))->defaults('ex', __e('ss', 'refresh-cw', false));
      Route::get('details/{swapDeal:product_uuid}', [self::class, 'getSwapDealDetails'])->name($p('swap_deal_details'))->defaults('ex', __e('ss', 'refresh-cw', true));
      Route::get('create', [self::class, 'showCreateSwapDealForm'])->name($p('create_swap_deal'))->defaults('ex', __e('ss', 'refresh-cw', false));
      Route::post('create', [self::class, 'createSwapDeal'])->name($p('swap_deal.create'))->defaults('ex', __e('ss', 'refresh-cw', true));
      Route::put('{swapDeal:product_uuid}/edit', [self::class, 'editSwapDeal'])->name($p('edit_swap_deal'))->defaults('ex', __e('ss', 'refresh-cw', true));
      Route::post('{swapDeal:product_uuid}/comment', [self::class, 'commentOnSwapDeal'])->name($p('comment_on_swap_deal'))->defaults('ex', __e('ss', null, true));
    });
  }

  public function getSwapDeals(Request $request)
  {
    /**
     *! Sales rep will see the ones that are not sold
     *! Accountant will see the ones that are sold
     *! Qa will see the ones that are untested
     */
    $swapDeals = (new SwapDealTransformer)->collectionTransformer(self::untested()->orWhere->inStock()->with('swapped_with', 'product_status', 'app_user')->get(), 'basic');

    if ($request->isApi()) return response()->json($swapDeals, 200);
    return Inertia::render('SuperAdmin,Products/SwapDeals', compact('swapDeals'));
  }

  public function getSwapDealDetails(Request $request, SwapDeal $swapDeal)
  {
    $swapDeal = (new SwapDealTransformer)->detailed($swapDeal->load('swapped_with', 'product_status', 'app_user', 'comments'));

    return Inertia::render('SuperAdmin,Products/SwapDealDetails', compact('swapDeal'));
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

    static::updated(function ($swapDeal) {
      // dd('fire an event to report this change');
      $changes = $swapDeal->getChanges();
      Arr::forget($changes, 'updated_at');
      request()->user()->comments()->create([
        'subject_id' => $swapDeal->id,
        'subject_type' => get_class($swapDeal),
        'comment' => 'Changed ' . http_build_query($changes) . ' because ' . request()->comment
    ]);
    });
  }
}
