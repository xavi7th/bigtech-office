<?php

namespace App\Modules\SuperAdmin\Models;

use Cache;
use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
use Illuminate\Notifications\Notifiable;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\SuperAdmin\Models\SalesChannel;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Models\ResellerHistory;
use App\Modules\SuperAdmin\Models\ResellerProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Modules\SuperAdmin\Transformers\ProductTransformer;
use App\Modules\SuperAdmin\Transformers\ResellerTransformer;
use App\Modules\SuperAdmin\Http\Validations\CreateResellerValidation;

/**
 * App\Modules\SuperAdmin\Models\Reseller
 *
 * @property int $id
 * @property string $business_name
 * @property string $ceo_name
 * @property string $address
 * @property string $phone
 * @property string $img_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ResellerHistory[] $reseller_histories
 * @property-read int|null $reseller_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\SwapDeal[] $swap_deals
 * @property-read int|null $swap_deals_count
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller newQuery()
 * @method static \Illuminate\Database\Query\Builder|Reseller onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereBusinessName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereCeoName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reseller whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Reseller withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Reseller withoutTrashed()
 * @mixin \Eloquent
 */
class Reseller extends BaseModel
{
  use SoftDeletes, Notifiable;

  protected $fillable = [
    'business_name',
    'ceo_name',
    'address',
    'phone',
    'img_url',
  ];

  protected $touches = ['products'];

  public function products()
  {
    return $this->morphedByMany(Product::class, 'product', $table = 'reseller_product')->using(ResellerProduct::class)->withTimestamps()->as('tenure_record');
  }

  public function products_in_possession()
  {
    return $this->products()->wherePivot('status', 'tenured')->withPivot('status');
  }

  public function swap_deals()
  {
    return $this->morphedByMany(SwapDeal::class, 'product', $table = 'reseller_product')->using(ResellerProduct::class)->withTimestamps()->as('tenure_record');
  }

  public function swap_deals_in_possession()
  {
    return $this->swap_deals()->wherePivot('status', 'tenured')->withPivot('status');
  }

  public function reseller_histories()
  {
    return $this->hasMany(ResellerHistory::class);
  }

  public static function stockKeeperRoutes()
  {
    Route::group(['prefix' => 'resellers'], function () {
      Route::name('stockkeeper.resellers.')->group(function () {
        Route::post('{reseller}/{product_uuid}/sold', [self::class, 'markProductAsSold'])->name('mark_as_sold')->defaults('ex', __e('sk', 'at-sign', true));
        Route::post('{reseller}/{product_uuid}/return', [self::class, 'resellerReturnProduct'])->name('return_product')->defaults('ex', __e('ss,sk', 'at-sign', true))->middleware('auth:stock_keeper');
        Route::post('{reseller}/give-product/{product_uuid}', [self::class, 'giveProductToReseller'])->name('give_product')->defaults('ex', __e('ss,sk', 'at-sign', true))->middleware('auth:stock_keeper');
      });
    });
  }

  public static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'resellers'], function () {
      Route::name('multiaccess.resellers.')->group(function () {
        Route::get('', [self::class, 'getResellers'])->name('resellers')->defaults('ex', __e('ss,a,ac', 'at-sign', false))->middleware('auth:admin,super_admin,accountant');
        Route::get('products', [self::class, 'getResellersWithProducts'])->name('resellers_with_products')->defaults('ex', __e('ss,sk,a,ac', 'at-sign', false))->middleware('auth:stock_keeper,admin,super_admin,accountant');
        Route::get('{reseller}/products', [self::class, 'getProductsWithReseller'])->name('products')->defaults('ex', __e('ss,sk,a,ac', 'at-sign', true))->middleware('auth:stock_keeper,super_admin,admin,accountant');
      });
    });
  }

  public static function superAdminRoutes()
  {
    Route::group(['prefix' => 'resellers'], function () {
      $others = function ($name) {
        return 'superadmin.' . $name;
      };
      Route::post('create', [self::class, 'createReseller'])->name($others('resellers.create_reseller'))->defaults('ex', __e('ss', 'at-sign', true));
      Route::put('{reseller}/edit', [self::class, 'editReseller'])->name($others('resellers.edit_reseller'))->defaults('ex', __e('ss', 'at-sign', true));
    });
  }

  public function getResellers(Request $request)
  {
    $resellers = Cache::rememberForever('resellers', fn () => (new ResellerTransformer)->collectionTransformer(self::all(), 'basic'));

    if ($request->isApi()) return response()->json($resellers, 200);
    return Inertia::render('SuperAdmin,Resellers/ManageResellers', compact('resellers'));
  }

  public function getResellersWithProducts(Request $request)
  {
    $resellersWithProducts = (new ResellerTransformer)->collectionTransformer(self::has('products_in_possession')->orHas('swap_deals_in_possession')->with('products_in_possession', 'swap_deals_in_possession')->get(), 'transformWithTenuredProducts');

    if ($request->isApi()) return response()->json($resellersWithProducts, 200);
    return Inertia::render('SuperAdmin,Resellers/ViewResellersWithProducts', compact('resellersWithProducts'));
  }

  public function getProductsWithReseller(Request $request, self $reseller)
  {
    $resellerWithProducts = fn () => (new ResellerTransformer)->fullDetailsWithTenuredProducts($reseller->load('products_in_possession', 'swap_deals_in_possession'));

    if ($request->isApi())  return response()->json($resellerWithProducts, 200);
    return Inertia::render('SuperAdmin,Resellers/ViewProductsWithReseller', compact('resellerWithProducts'));
  }

  public function createReseller(CreateResellerValidation $request)
  {
    try {

      if ($request->hasFile('img')) {
        $reseller = self::create(collect($request->validated())->merge(['img_url' => compress_image_upload('img', 'product_models_images/', null, 200)['img_url']])->all());
      } else {
        $reseller = self::create($request->validated());
      }

      Cache::forget('resellers');

      if ($request->isApi()) return response()->json((new ResellerTransformer)->basic($reseller), 201);
      return back()->withSuccess('Success');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Reseller not created');
      if ($request->isApi()) return response()->json(['err' => 'Reseller not created'], 500);
      return back()->withError('Error');
    }
  }

  public function editReseller(CreateResellerValidation $request, self $reseller)
  {
    try {

      foreach ($request->validated() as $key => $value) {
        $reseller->$key = $value;
      }

      if ($request->hasFile('brand_img')) {
        $reseller->img_url = compress_image_upload('brand_img', 'product_models_images/', null, 200)['img_url'];
      }

      $reseller->save();

      if ($request->isApi()) return response()->json([], 204);
      return back()->withSuccess('Success');
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Reseller not updated');
      if ($request->isApi()) return response()->json(['err' => 'Reseller not updated'], 500);
      return back()->withError('Error');
    }
  }

  public function giveProductToReseller(Request $request, self $reseller,  $product_uuid)
  {
    try {
      $product =  Product::where('product_uuid', $product_uuid)->firstOr(fn () => SwapDeal::where('product_uuid', $product_uuid)->firstOrFail());
    } catch (ModelNotFoundException $th) {
      return generate_422_error('Invalid product selected');
    }

    DB::beginTransaction();

    /**
     * Check if this product is marked as with reseller already
     */

    if ($product->with_reseller()) {
      DB::rollBack();
      ActivityLog::notifySuperAdmins(
        $request->user()->email . ' tried to give a product: ' . $product->primary_identifier() . ' with a reseller to another reseller without signing out from previous reseller'
      );
      return generate_422_error('This product is already with a reseller');
    }

    if (!$product->in_stock()) {
      DB::rollBack();

      ActivityLog::notifySuperAdmins(
        $request->user()->email . ' tried to give a product: ' . $product->primary_identifier() . ' that is not listed as being in stock to a reseller'
      );
      return generate_422_error('This product is currently not in the stock list and cannot be given to a reseller');
    }

    try {

      /**
       * create a reseller history for picking up this device
       * ? Default status is tenured
       */

      $reseller->reseller_histories()->create([
        'product_id' => $product->id,
        'product_type' => get_class($product),
        'handled_by' => $request->user()->id,
        'handler_type' => get_class($request->user()),
      ]);

      /**
       * Create an entry in the product reseller table
       * ! syncwithoutdetach()
       */
      if ($product instanceof Product) {
        $reseller->products()->save($product);
      } elseif ($product instanceof SwapDeal) {
        $reseller->swap_deals()->save($product);
      }
    } catch (QueryException $th) {
      ErrLog::notifyAdminAndFail($request->user(), $th, 'Error giving product to reseller');
      if ($th->errorInfo[1] == 1062) {
        return generate_422_error($th->errorInfo[2]);
      }
      return generate_422_error($th->getMessage());
    }

    /**
     * Change the product's status to reflect that it's with reseller
     */
    $product->product_status_id = ProductStatus::withResellerId();
    $product->save();

    /**
     * Setup notifications for admin in reseller_history static boot method
     */

    /**
     * Send CEO of the reseller company an SMS or email that he just picked up a device
     */
    try {
      $reseller->notify(new ProductUpdate($product));
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Reseller notification failed');
    }

    DB::commit();

    if ($request->isApi()) return response()->json((new ProductTransformer)->basic($product), 201);
    return back()->withSuccess('Done. Product has been removed from stock list');
  }

  public function resellerReturnProduct(Request $request, self $reseller, $product_uuid)
  {

    try {
      $product = Product::whereProductUuid($product_uuid)->firstOr(fn () => SwapDeal::whereProductUuid($product_uuid)->firstOrFail());
    } catch (ModelNotFoundException $th) {
      return back()->withError('The product you are trying to return to shelf does not exist');
    }

    /**
     * Check if this product is marked as with reseller
     */
    if (!$product->with_reseller()) {
      ActivityLog::notifySuperAdmins(
        $request->user()->email . ' tried to return a product with ' . $product->primary_identifier() . ' from a reseller that wasn\'t signed out to any reseller'
      );
      return generate_422_error('This product is not supposed to be with a reseller');
    }

    DB::beginTransaction();
    /**
     * create a reseller history for returning this device
     */
    try {

      $reseller->reseller_histories()->create([
        'product_id' => $product->id,
        'product_type' => get_class($product),
        'handled_by' => $request->user()->id,
        'handler_type' => get_class($request->user()),
        'product_status' => 'returned'
      ]);
      /**
       * Update the entry in the product reseller table to reflect returned
       */
      if ($product instanceof Product) {
        $reseller->products()->where('product_id', $product->id)->update([
          'status' => 'returned'
        ]);
      } elseif ($product instanceof SwapDeal) {
        $reseller->swap_deals()->where('product_id', $product->id)->update([
          'status' => 'returned'
        ]);
      }
    } catch (QueryException $th) {
      if ($th->errorInfo[1] == 1062) {
        return generate_422_error($th->errorInfo[2]);
      }
      return generate_422_error($th->getMessage());
    }

    /**
     * Change the product's status to reflect that it has been returned to stock
     */
    $product->product_status_id = ProductStatus::inStockId();
    $product->save();

    /**
     * Send CEO of the reseller company an SMS or email that he just picked up a device
     */
    try {
      $reseller->notify(new ProductUpdate($product));
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Reseller notification failed');
    }

    DB::commit();

    if ($request->isApi()) return response()->json((new ProductTransformer)->basic($product), 201);
    return back()->withSuccess('The product has been marked as returned and is back in the stock list');
  }

  public function markProductAsSold(Request $request, self $reseller, $product_uuid)
  {
    try {
      $product = Product::whereProductUuid($product_uuid)->firstOr(fn () => SwapDeal::whereProductUuid($product_uuid)->firstOrFail());
    } catch (ModelNotFoundException $th) {
      return generate_422_error('The product you are trying to mark as sold does not exist');
    }


    if (!$request->selling_price) {
      return generate_422_error('Specify selling price');
    }
    if (!is_numeric($request->selling_price)) {
      return generate_422_error('The selling price must be a number');
    }

    if ($product->is_sold()) {
      ActivityLog::notifySuperAdmins(
        $request->user()->email . ' tried to mark a product with ' . $product->primary_identifier() . ' as sold when it has been previously marked as sold'
      );
      return generate_422_error('This product is sold already');
    }

    if (!$product->with_reseller()) {
      ActivityLog::notifySuperAdmins(
        $request->user()->email . ' tried to mark a product with ' . $product->primary_identifier() . ' from a reseller that wasn\'t signed out to any reseller as returned'
      );
      return generate_422_error('This product is not supposed to be with a reseller');
    }

    DB::beginTransaction();
    /**
     * create a reseller history for selling this device
     */
    try {

      $reseller->reseller_histories()->create([
        'product_id' => $product->id,
        'product_type' => get_class($product),
        'handled_by' => $request->user()->id,
        'handler_type' => get_class($request->user()),
        'product_status' => 'sold'
      ]);

      /**
       * Update the entry in the product reseller table to reflect returned
       */
      if ($product instanceof Product) {
        $reseller->products()->where('product_id', $product->id)->update([
          'status' => 'sold'
        ]);
      } elseif ($product instanceof SwapDeal) {
        $reseller->swap_deals()->where('product_id', $product->id)->update([
          'status' => 'sold'
        ]);
      }
    } catch (QueryException $th) {
      ErrLog::notifyAdminAndFail($request->user(), $th, 'Error trying to mark product from a reseller as sold.');
      if ($th->errorInfo[1] == 1062) {
        return generate_422_error($th->errorInfo[2]);
      }
      return generate_422_error($th->getMessage());
    }

    /**
     * Change the product's status to reflect that it has been sold
     */
    $product->product_status_id = ProductStatus::soldId();
    $product->save();

    /**
     * Create a sales record for the product
     */
    $product->product_sales_record()->create([
      'selling_price' => $request->selling_price,
      'sales_rep_id' => SalesRep::defaultSystemAccountId(),
      'online_rep_id' => SalesRep::defaultSystemAccountId(),
      'sales_channel_id' => SalesChannel::resellerId(),
    ]);

    ActivityLog::notifySuperAdmins($request->user()->email . ' marked product with UUID: ' . $product->product_uuid . ' as sold.');
    ActivityLog::notifyAccountants($request->user()->email . ' marked product with UUID: ' . $product->product_uuid . ' as sold.');

    /**
     * Send CEO of the reseller company an SMS or email that he just picked up a device
     */
    try {
      $reseller->notify(new ProductUpdate($product));
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Reseller notification failed');
    }

    DB::commit();

    if ($request->isApi()) return response()->json((new ProductTransformer)->basic($product), 201);
    return back()->withSuccess('Product marked as sold to reseller');
  }
}
