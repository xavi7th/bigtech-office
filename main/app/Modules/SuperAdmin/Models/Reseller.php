<?php

namespace App\Modules\SuperAdmin\Models;

use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\SuperAdmin\Models\SalesChannel;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Models\ResellerHistory;
use App\Modules\SuperAdmin\Models\ResellerProduct;
use App\Modules\SuperAdmin\Transformers\ProductTransformer;
use App\Modules\SuperAdmin\Transformers\ResellerTransformer;
use App\Modules\SuperAdmin\Http\Validations\CreateResellerValidation;
use App\Modules\SuperAdmin\Http\Validations\GiveResellerProcuctValidation;
use Illuminate\Http\Request;

/**
 * App\Modules\SuperAdmin\Models\Reseller
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ResellerHistory[] $reseller_histories
 * @property-read int|null $reseller_histories_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Reseller newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Reseller newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\Reseller onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Reseller query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\Reseller withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\Reseller withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $business_name
 * @property string $ceo_name
 * @property string $address
 * @property string $phone
 * @property string $img_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Reseller whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Reseller whereBusinessName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Reseller whereCeoName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Reseller whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Reseller whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Reseller whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Reseller whereImgUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Reseller wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\Reseller whereUpdatedAt($value)
 */
class Reseller extends Model
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

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    if (routeHasRootNamespace('appuser.')) {
      Inertia::setRootView('appuser::app');
    } elseif (routeHasRootNamespace('superadmin.')) {
      Inertia::setRootView('superadmin::app');
    }
  }

  public function products()
  {
    return $this->belongsToMany(Product::class, $table = 'reseller_product')->using(ResellerProduct::class)->withTimestamps()->as('tenure_record');
  }
  public function products_in_possession()
  {
    return $this->products()->wherePivot('status', 'tenured')->withPivot('status');
  }

  public function reseller_histories()
  {
    return $this->hasMany(ResellerHistory::class);
  }

  public static function routes()
  {
    Route::group(['prefix' => 'resellers'], function () {
      $others = function ($name) {
        return 'superadmin.' . $name;
      };
      Route::get('', [self::class, 'getResellers'])->name($others('resellers'))->defaults('ex', __e('ss', 'at-sign', false));
      Route::get('products', [self::class, 'getResellersWithProducts'])->name($others('resellers.resellers_with_products', null))->defaults('ex', __e('ss', 'at-sign', false));
      Route::get('{reseller}/products', [self::class, 'getProductsWithReseller'])->name($others('resellers.products', null))->defaults('ex', __e('ss', 'at-sign', true));
      Route::post('create', [self::class, 'createReseller'])->name($others('resellers.create_reseller'))->defaults('ex', __e('ss', 'at-sign', true));
      Route::put('{reseller}/edit', [self::class, 'editReseller'])->name($others('resellers.edit_reseller'))->defaults('ex', __e('ss', 'at-sign', true));
      Route::post('{reseller}/give-product', [self::class, 'giveProductToReseller'])->name($others('resellers.give_product'))->defaults('ex', __e('ss', 'at-sign', true));
      Route::post('{reseller}/return-product', [self::class, 'resellerReturnProduct'])->name($others('resellers.return_product'))->defaults('ex', __e('ss', 'at-sign', true));
      Route::post('{reseller}/pay-for-product', [self::class, 'payForProduct'])->name($others('resellers.pay_for_product'))->defaults('ex', __e('ss', 'at-sign', true));
    });
  }

  public function getResellers(Request $request)
  {
    $resellers = (new ResellerTransformer)->collectionTransformer(self::all(), 'basic');
    if ($request->isApi())
      return response()->json($resellers, 200);
    return Inertia::render('Resellers/ManageResellers', compact('resellers'));
  }

  public function getProductsWithReseller(Request $request, self $reseller)
  {
    $resellerProducts = (new ResellerTransformer)->transformWithTenuredProducts($reseller->load('products_in_possession'));
    if ($request->isApi())
      return response()->json($resellerProducts, 200);
    return Inertia::render('Resellers/ViewProductsWithReseller', compact('resellerProducts'));
  }

  public function getResellersWithProducts(Request $request)
  {
    // return self::has('products_in_possession')->with('products_in_possession')->get();
    $records = (new ResellerTransformer)->collectionTransformer(self::has('products_in_possession')->with('products_in_possession')->get(), 'transformWithTenuredProducts');

    if ($request->isApi())
      return response()->json($records, 200);
    return Inertia::render('Resellers/ViewResellersWithProducts', compact('records'));
  }

  public function createReseller(CreateResellerValidation $request)
  {
    try {
      $reseller = self::create($request->validated());

      return response()->json((new ResellerTransformer)->basic($reseller), 201);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Reseller not created');
      return response()->json(['err' => 'Reseller not created'], 500);
    }
  }

  public function editReseller(CreateResellerValidation $request, self $reseller)
  {

    try {
      foreach ($request->validated() as $key => $value) {
        $reseller->$key = $value;
      }

      $reseller->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Reseller not updated');
      return response()->json(['err' => 'Reseller not updated'], 500);
    }
  }

  public function giveProductToReseller(GiveResellerProcuctValidation $request, self $reseller)
  {
    DB::beginTransaction();

    $product = Product::where($request->code_type, $request->product_code)->firstOrFail();

    /**
     * create a reseller history for picking up this device
     * ? Default status is tenured
     */

    /**
     * Check if this product is marked as with reseller already
     */
    if ($product->with_reseller()) {
      ActivityLog::notifySuperAdmins(
        $request->user()->email . ' tried to give a product: ' . $product->primary_identifier() . ' with a reseller to another reseller without signing out from previous reseller'
      );
      return generate_422_error('This product is already with a reseller');
    }

    try {

      $reseller->reseller_histories()->create([
        'product_id' => $product->id,
        'handled_by' => $request->user()->id,
        'handler_type' => get_class($request->user()),
      ]);
      /**
       * Create an entry in the product reseller table
       * ! syncwithoutdetach()
       */
      $reseller->products()->save($product);
    } catch (QueryException $th) {
      if ($th->errorInfo[1] == 1062) {
        return generate_422_error($th->errorInfo[2]);
      }
      return generate_422_error($th->getMessage());
    }

    /**
     * Change the product's status to reflect that it's with reseller
     */
    $product->product_status_id = ProductStatus::with_reseller();
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

    return response()->json((new ProductTransformer)->basic($product), 201);
  }

  public function resellerReturnProduct(GiveResellerProcuctValidation $request, self $reseller)
  {

    $product = Product::where($request->code_type, $request->product_code)->firstOrFail();

    /**
     * Check if this product is marked as with reseller
     */
    if (!$product->with_reseller()) {
      ActivityLog::notifySuperAdmins(
        auth(auth()->getDefaultDriver())->user()->email . ' tried to return a product with ' . $product->primary_identifier() . ' from a reseller that wasn\'t signed out to any reseller'
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
        'handled_by' => auth(auth()->getDefaultDriver())->id(),
        'handler_type' => get_class(auth(auth()->getDefaultDriver())->user()),
        'product_status' => 'returned'
      ]);
      /**
       * Update the entry in the product reseller table to reflect returned
       */
      $reseller->products()->where('product_id', $product->id)->update([
        'status' => 'returned'
      ]);
    } catch (QueryException $th) {
      if ($th->errorInfo[1] == 1062) {
        return generate_422_error($th->errorInfo[2]);
      }
      return generate_422_error($th->getMessage());
    }

    /**
     * Change the product's status to reflect that it has been returned to stock
     */
    $product->product_status_id = ProductStatus::in_stock();
    $product->save();

    /**
     * Send CEO of the reseller company an SMS or email that he just picked up a device
     */
    try {
      $reseller->notify(new ProductUpdate($product));
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Reseller notification failed');
    }

    DB::commit();

    return response()->json((new ProductTransformer)->basic($product), 201);
  }

  public function payForProduct(GiveResellerProcuctValidation $request, self $reseller)
  {
    if (!$request->selling_price) {
      return generate_422_error('Specify selling price');
    }

    $product = Product::where($request->code_type, $request->product_code)->firstOrFail();

    if ($product->is_sold()) {
      ActivityLog::notifySuperAdmins(
        auth(auth()->getDefaultDriver())->user()->email . ' tried to mark a product with ' . $product->primary_identifier() . ' as sold when it has been previously marked as sold'
      );
      return generate_422_error('This product is sold already');
    }

    if (!$product->with_reseller()) {
      ActivityLog::notifySuperAdmins(
        auth(auth()->getDefaultDriver())->user()->email . ' tried to mark a product with ' . $product->primary_identifier() . ' from a reseller that wasn\'t signed out to any reseller as returned'
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
        'handled_by' => auth(auth()->getDefaultDriver())->id(),
        'handler_type' => get_class(auth(auth()->getDefaultDriver())->user()),
        'product_status' => 'sold'
      ]);

      /**
       * Update the entry in the product reseller table to reflect returned
       */
      $reseller->products()->where('product_id', $product->id)->update([
        'status' => 'sold'
      ]);
    } catch (QueryException $th) {
      if ($th->errorInfo[1] == 1062) {
        return generate_422_error($th->errorInfo[2]);
      }
      return generate_422_error($th->getMessage());
    }

    /**
     * Change the product's status to reflect that it has been sold
     */
    $product->product_status_id = ProductStatus::sold_id();
    $product->save();

    /**
     * Create a sales record for the product
     */
    $product->product_sales_record()->create([
      'selling_price' => $request->selling_price,
      'sales_rep_id' => 1,
      'sales_channel_id' => SalesChannel::reseller_id(),
    ]);

    ActivityLog::notifySuperAdmins(auth(auth()->getDefaultDriver())->user()->email . ' marked product with UUID no: ' . $product->product_uuid . ' as sold.');
    ActivityLog::notifyAccountants(auth(auth()->getDefaultDriver())->user()->email . ' marked product with UUID: ' . $product->product_uuid . ' as sold.');

    /**
     * Send CEO of the reseller company an SMS or email that he just picked up a device
     */
    try {
      $reseller->notify(new ProductUpdate($product));
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Reseller notification failed');
    }

    DB::commit();

    return response()->json((new ProductTransformer)->basic($product), 201);
  }
}
