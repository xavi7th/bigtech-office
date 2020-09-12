<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\QueryException;
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
    if ($request->isApi()) return response()->json($resellers, 200);
    return Inertia::render('SuperAdmin,Resellers/ManageResellers', compact('resellers'));
  }

  public function getProductsWithReseller(Request $request, self $reseller)
  {
    $resellerProducts = (new ResellerTransformer)->transformWithTenuredProducts($reseller->load('products_in_possession'));
    if ($request->isApi())  return response()->json($resellerProducts, 200);
    return Inertia::render('SuperAdmin,Resellers/ViewProductsWithReseller', compact('resellerProducts'));
  }

  public function getResellersWithProducts(Request $request)
  {
    // return self::has('products_in_possession')->with('products_in_possession')->get();
    $records = (new ResellerTransformer)->collectionTransformer(self::has('products_in_possession')->with('products_in_possession')->get(), 'transformWithTenuredProducts');

    if ($request->isApi())
      return response()->json($records, 200);
    return Inertia::render('SuperAdmin,Resellers/ViewResellersWithProducts', compact('records'));
  }

  public function createReseller(CreateResellerValidation $request)
  {
    try {

      if ($request->hasFile('img')) {
        $reseller = self::create(collect($request->validated())->merge(['img_url' => compress_image_upload('img', 'product_models_images/', null, 200)['img_url']])->all());
      } else {
        $reseller = self::create($request->validated());
      }

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
        'handled_by' => $request->user()->id,
        'handler_type' => get_class($request->user()),
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
        'handled_by' => $request->id(),
        'handler_type' => get_class($request->user()),
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
    $product->product_status_id = ProductStatus::soldId();
    $product->save();

    /**
     * Create a sales record for the product
     */
    $product->product_sales_record()->create([
      'selling_price' => $request->selling_price,
      'sales_rep_id' => 1,
      'sales_channel_id' => SalesChannel::reseller_id(),
    ]);

    ActivityLog::notifySuperAdmins($request->user()->email . ' marked product with UUID no: ' . $product->product_uuid . ' as sold.');
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

    return response()->json((new ProductTransformer)->basic($product), 201);
  }
}
