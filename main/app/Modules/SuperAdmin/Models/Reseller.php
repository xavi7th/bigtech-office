<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Modules\SuperAdmin\Transformers\ProductTransformer;
use App\Modules\SuperAdmin\Transformers\ResellerTransformer;
use App\Modules\SuperAdmin\Http\Validations\CreateResellerValidation;

class Reseller extends BaseModel
{
  use SoftDeletes, Notifiable;

  protected $fillable = [
    'business_name',
    'ceo_name',
    'address',
    'phone',
    'email',
    'img_url',
  ];

  protected $touches = ['products'];

  public function reseller_transactions()
  {
    return $this->hasMany(ResellerTransaction::class);
  }

  public function products()
  {
    return $this->morphedByMany(Product::class, 'product', $table = 'reseller_product')->using(ResellerProduct::class)->withTimestamps()->as('tenure_record');
  }

  public function products_in_possession()
  {
    return $this->products()->wherePivot('status', 'tenured')->withPivot('status');
  }

  public function purchased_products()
  {
    return $this->products()->wherePivot('status', 'sold')->withPivot('status');
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

  /**
   * Mark a product as being with this reseller
   *
   * @param string $productUuid
   *
   * @return void
   * @throws ModelNotFoundException
   */
  public function giveProduct(string $productUuid): object
  {
    /** @var Product */
    $product =  Product::where('product_uuid', $productUuid)->firstOr(fn () => SwapDeal::where('product_uuid', $productUuid)->firstOrFail());

    DB::beginTransaction();

    /**
     * Check if this product is marked as with reseller already
     */
    if ($product->with_reseller()) {
      DB::rollBack();
      ActivityLog::notifySuperAdmins(
        optional(request()->user())->email ?? 'Console App' . ' tried to give a product: ' . $product->primary_identifier() . ' with a reseller to another reseller without signing out from previous reseller'
      );
      abort(422, 'productWithReseller');
    }

    if (!$product->in_stock()) {
      DB::rollBack();
      ActivityLog::notifySuperAdmins(
        optional(request()->user())->email ?? 'Console App' . ' tried to give a product: ' . $product->primary_identifier() . ' that is not listed as being in stock to a reseller'
      );
      abort(422, 'productNotInStock');
    }

    /**
     * Create an entry in the product reseller table
     * ! syncwithoutdetach()
     */
    if ($product instanceof Product) {
      // $this->products()->detach($product);
      $this->products()->syncWithoutDetaching([$product->id => ['status' => 'tenured']]);
    } elseif ($product instanceof SwapDeal) {
      $this->swap_deals()->save($product);
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
      $this->notify(new ProductUpdate($product));
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor(request()->user(), $th, 'Reseller notification failed');
    }

    DB::commit();

    return $product;
  }

  /**
   * Mark a product as being returned from reseller to stock
   *
   * @param string $productUuid
   *
   * @return void
   */
  public function returnProduct(string $productUuid): object
  {

    $product = Product::whereProductUuid($productUuid)->firstOr(fn () => SwapDeal::whereProductUuid($productUuid)->firstOrFail());

    /**
     * Check if this product is marked as with reseller
     */
    if (!$product->with_reseller()) {
      ActivityLog::notifySuperAdmins(
        optional(request()->user())->email ?? 'Console App' . ' tried to return a product with ' . $product->primary_identifier() . ' from a reseller that wasn\'t signed out to any reseller'
      );
      abort(422, 'productNotWithReseller');
    }

    DB::beginTransaction();

    /**
     * Update the entry in the product reseller table to reflect returned
     */
    if ($product instanceof Product) {
      $this->products()->syncWithoutDetaching([$product->id => ['status' => 'returned']]);
    } elseif ($product instanceof SwapDeal) {
      $this->swap_deals()->sync([$product->id => ['status' => 'returned']]);
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
      $this->notify(new ProductUpdate($product));
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor(request()->user(), $th, 'Reseller notification failed');
    }

    DB::commit();

    return $product;
  }

  public static function accountantRoutes()
  {
    Route::group(['prefix' => 'resellers'], function () {
      Route::name('accountant.resellers.')->group(function () {
        Route::post('{reseller}/{product_uuid}/sold', [self::class, 'markProductAsSold'])->name('mark_as_sold');
        Route::post('{reseller}/{product_uuid}/return', [self::class, 'resellerReturnProduct'])->name('return_product');
        Route::post('{reseller}/give-product/{product_uuid}', [self::class, 'giveProductToReseller'])->name('give_product');
      });
    });
  }

  public static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'resellers'], function () {
      Route::name('multiaccess.resellers.')->group(function () {
        Route::get('', [self::class, 'getResellers'])->name('resellers')->defaults('ex', __e('ss,a,ac', 'at-sign', false))->middleware('auth:auditor,super_admin,accountant');
        Route::get('products', [self::class, 'getResellersWithProducts'])->name('resellers_with_products')->defaults('ex', __e('ss,a,ac', 'at-sign', false))->middleware('auth:auditor,super_admin,accountant');
        Route::get('{reseller}/products', [self::class, 'getProductsWithReseller'])->name('products')->defaults('ex', __e('ss,a,ac', 'at-sign', true))->middleware('auth:super_admin,auditor,accountant');

        Route::get('{reseller:business_name}/financial-records', [self::class, 'getResellerFinancialRecord'])->name('finances')->middleware('auth:auditor,super_admin');
      });
    });
  }

  public static function superAdminRoutes()
  {
    Route::name('resellers.')->prefix('resellers')->group(function () {
      Route::put('{reseller}/edit', [self::class, 'editReseller'])->name('edit_reseller');
      Route::post('create', [self::class, 'createReseller'])->name('create_reseller');

      Route::post('{reseller:business_name}/financial-records/create', [self::class, 'createResellerTransaction'])->name('finances.create');
    });
  }

  public function getResellerFinancialRecord(Request $request, self $reseller)
  {
    // dd($reseller->reseller_transactions);

    return Inertia::render('SuperAdmin,Resellers/ManageResellerTransactions', [
      'resellerWithTransactions' => $reseller->load('reseller_transactions.recorder:id,full_name')
    ]);
  }

  public function createResellerTransaction(Request $request, self $reseller)
  {

    $validated = $request->validate([
      'amount' => 'required|numeric|gt:0',
      'purpose' => 'required|string',
      'trans_type' => 'required|in:credit,debit',
    ], [
      'trans_type.required' => 'Enter the transaction type',
      'trans_type.in' => 'Invalid transaction type selected',
    ]);

    $reseller->reseller_transactions()->create($validated);

    return back()->withFlash(['success' => 'Transaction successfully created']);
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
        $reseller = self::create(collect($request->validated())->merge(['img_url' => compress_image_upload('img', 'resellers/', null, 200)['img_url']])->all());
      } else {
        $reseller = self::create($request->validated());
      }

      if ($request->isApi()) return response()->json((new ResellerTransformer)->basic($reseller), 201);
      return back()->withFlash(['success'=>'Success']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Reseller not created');
      if ($request->isApi()) return response()->json(['err' => 'Reseller not created'], 500);
      return back()->withFlash(['error'=>['Error']]);
    }
  }

  public function editReseller(CreateResellerValidation $request, self $reseller)
  {
    try {

      foreach ($request->validated() as $key => $value) {
        $reseller->$key = $value;
      }

      if ($request->hasFile('img')) {
        $reseller->img_url = compress_image_upload('img', 'resellers/', null, 200)['img_url'];
      }

      $reseller->save();

      if ($request->isApi()) return response()->json([], 204);
      return back()->withFlash(['success'=>'Success']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Reseller not updated');
      if ($request->isApi()) return response()->json(['err' => 'Reseller not updated'], 500);
      return back()->withFlash(['error'=>['Error']]);
    }
  }

  public function giveProductToReseller(Request $request, self $reseller,  $product_uuid)
  {

    try {
      $reseller->giveProduct($product_uuid);
    } catch (ModelNotFoundException $th) {
      return generate_422_error('Invalid product selected');
    } catch (HttpException $th) {
      if ($th->getMessage() == 'productWithReseller') {
        return generate_422_error('This product is already with a reseller');
      } elseif ($th->getMessage() == 'productNotInStock') {
        return generate_422_error('This product is currently not in the stock list and cannot be given to a reseller');
      } else {
        return generate_422_error('Error giving product to reseller');
      }
    } catch (QueryException $th) {
      ErrLog::notifyAuditorAndFail($request->user(), $th, 'Error giving product to reseller');
      if ($th->errorInfo[1] == 1062) return generate_422_error($th->errorInfo[2]);
      return generate_422_error($th->getMessage());
    }

    return back()->withFlash(['success'=>'Done. Product has been removed from stock list']);
  }

  public function resellerReturnProduct(Request $request, self $reseller, $product_uuid)
  {

    /**
     * Use the transaction here because if
     */

    try {
      $reseller->returnProduct($product_uuid);
    } catch (ModelNotFoundException $th) {
      return back()->withFlash(['error' => ['The product you are trying to return to shelf does not exist in our records']]);
    } catch (HttpException $th) {
      if ($th->getMessage() == 'productNotWithReseller') {
        return generate_422_error('This product is not supposed to be with a reseller');
      } elseif ($th->getMessage() == 'productNotInStock') {
        return generate_422_error('This product is currently not in the stock list and cannot be given to a reseller');
      } else {
        return generate_422_error('Error giving product to reseller');
      }
    } catch (QueryException $th) {
      ErrLog::notifyAuditorAndFail($request->user(), $th, 'Error giving product to reseller');
      if ($th->errorInfo[1] == 1062) return generate_422_error($th->errorInfo[2]);
      return generate_422_error($th->getMessage());
    }


    return back()->withFlash(['success'=>'The product has been marked as returned and is back in the stock list']);
  }

  public function markProductAsSold(Request $request, self $reseller, $product_uuid)
  {
    try {
      /**
       * @var Product|SwapDeal $product
       */
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
       * Update the entry in the product reseller table to reflect sold
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
      ErrLog::notifyAuditorAndFail($request->user(), $th, 'Error trying to mark product from a reseller as sold.');
      if ($th->errorInfo[1] == 1062) {
        return generate_422_error($th->errorInfo[2]);
      }
      return generate_422_error($th->getMessage());
    }

    /**
     * Change the product's status to reflect that it has been sold
     */
    $product->product_status_id = ProductStatus::soldByResellerId();
    $product->save();

    /**
     * Create a sales record for the product
     */
    try {
      $product->product_sales_record()->create([
        'selling_price' => $request->selling_price,
        'sales_rep_id' => $request->user()->id,
        'online_rep_id' => null,
        'sales_channel_id' => SalesChannel::resellerId(),
      ]);
    } catch (\Throwable $th) {
      return generate_422_error('Error occured: ' . $th->getMessage());
    }

    ActivityLog::notifySuperAdmins($request->user()->email . ' marked product with UUID: ' . $product->product_uuid . ' as sold.');
    ActivityLog::notifyAccountants($request->user()->email . ' marked product with UUID: ' . $product->product_uuid . ' as sold.');

    /**
     * Send CEO of the reseller company an SMS or email that he just picked up a device
     */
    try {
      $reseller->notify(new ProductUpdate($product));
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Reseller notification failed');
    }

    DB::commit();

    if ($request->isApi()) return response()->json((new ProductTransformer)->basic($product), 201);
    return back()->withFlash(['success'=>'Product marked as sold to reseller']);
  }

  protected static function boot()
  {
    parent::boot();

    static::saved(function ($reseller) {
      Cache::forget('resellers');
    });
  }
}
