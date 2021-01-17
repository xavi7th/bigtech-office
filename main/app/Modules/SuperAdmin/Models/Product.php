<?php

namespace App\Modules\SuperAdmin\Models;

use Cache;
use App\BaseModel;
use App\Modules\AppUser\Http\Controllers\AppUserController;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Awobaz\Compoships\Compoships;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\QueryException;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\QATest;
use App\Modules\SuperAdmin\Models\Reseller;
use App\Modules\SuperAdmin\Models\SwapDeal;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\AppUser\Models\ProductReceipt;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\SuperAdmin\Models\StorageSize;
use App\Modules\SuperAdmin\Models\StorageType;
use App\Modules\SuperAdmin\Traits\Commentable;
use Illuminate\Validation\ValidationException;
use App\Modules\SuperAdmin\Models\OfficeBranch;
use App\Modules\SuperAdmin\Models\OtherExpense;
use App\Modules\SuperAdmin\Models\ProductBatch;
use App\Modules\SuperAdmin\Models\ProductBrand;
use App\Modules\SuperAdmin\Models\ProductColor;
use App\Modules\SuperAdmin\Models\ProductGrade;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\SuperAdmin\Models\ProductPrice;
use App\Modules\SuperAdmin\Models\SalesChannel;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Models\ProcessorSpeed;
use App\Modules\SuperAdmin\Models\ProductExpense;
use App\Modules\SuperAdmin\Models\ProductHistory;
use App\Modules\SuperAdmin\Models\ProductCategory;
use App\Modules\SuperAdmin\Models\ProductSupplier;
use App\Modules\SuperAdmin\Models\ResellerHistory;
use App\Modules\SuperAdmin\Models\ResellerProduct;
use App\Modules\SuperAdmin\Models\LocalProductPrice;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SalesRep\Models\ProductDispatchRequest;
use App\Modules\SalesRep\Transformers\SalesRepTransformer;
use App\Modules\SuperAdmin\Transformers\QATestTransformer;
use App\Modules\SuperAdmin\Transformers\ProductTransformer;
use App\Modules\SuperAdmin\Transformers\ResellerTransformer;
use App\Modules\SuperAdmin\Transformers\SwapDealTransformer;
use App\Modules\SuperAdmin\Transformers\StorageSizeTransformer;
use App\Modules\SuperAdmin\Transformers\StorageTypeTransformer;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;
use App\Modules\SuperAdmin\Transformers\ProductBatchTransformer;
use App\Modules\SuperAdmin\Transformers\ProductBrandTransformer;
use App\Modules\SuperAdmin\Transformers\ProductColorTransformer;
use App\Modules\SuperAdmin\Transformers\ProductGradeTransformer;
use App\Modules\SuperAdmin\Transformers\ProductModelTransformer;
use App\Modules\SuperAdmin\Transformers\SalesChannelTransformer;
use App\Modules\SuperAdmin\Transformers\ProductStatusTransformer;
use App\Modules\SuperAdmin\Transformers\ProcessorSpeedTransformer;
use App\Modules\SuperAdmin\Transformers\ProductCategoryTransformer;
use App\Modules\SuperAdmin\Transformers\ProductSupplierTransformer;
use App\Modules\SuperAdmin\Http\Validations\CreateProductValidation;
use App\Modules\SuperAdmin\Http\Validations\MarkProductAsSoldValidation;
use App\Modules\SuperAdmin\Http\Validations\CreateProductCommentValidation;
use App\Modules\SuperAdmin\Http\Validations\CreateLocalSupplierProductValidation;

class Product extends BaseModel
{
  use SoftDeletes, Compoships, Commentable;

  protected $fillable = [
    'product_category_id', 'product_model_id', 'product_brand_id', 'product_batch_id', 'product_color_id', 'product_grade_id',
    'product_supplier_id', 'storage_size_id', 'imei', 'serial_no', 'model_no', 'product_uuid', 'processor_speed_id', 'ram_size_id',
    'storage_type_id', 'stocked_by', 'stocker_type', 'office_branch_id', 'product_status_id', 'is_local'
  ];

  protected $casts = [
    'product_status_id' => 'int',
    'is_local' => 'bool',
  ];

  public function app_user()
  {
    return $this->belongsTo(AppUser::class)->withDefault([
      'first_name' => 'Not Sold',
    ]);
  }

  public function test_result_comments()
  {
    return $this->comments()->where('comment', 'like', 'Test Result%');
  }

  public function qa_tests()
  {
    return $this->belongsToMany(QATest::class, 'product_qa_test_results', 'product_id', 'qa_test_id')
      ->as('test_result')->withPivot('is_qa_certified')->withTimestamps();
  }

  public function passed_qa_tests()
  {
    return $this->qa_tests()->wherePivot('is_qa_certified', true);
  }

  public function failed_qa_tests()
  {
    return $this->qa_tests()->wherePivot('is_qa_certified', false);
  }

  public function location()
  {
    return $this->belongsTo(OfficeBranch::class, 'office_branch_id');
  }

  public function product_category()
  {
    return $this->belongsTo(ProductCategory::class);
  }

  public function product_model()
  {
    return $this->belongsTo(ProductModel::class);
  }

  public function product_brand()
  {
    return $this->belongsTo(ProductBrand::class);
  }

  public function product_status()
  {
    return $this->belongsTo(ProductStatus::class);
  }

  public function product_batch()
  {
    return $this->belongsTo(ProductBatch::class);
  }

  public function product_color()
  {
    return $this->belongsTo(ProductColor::class);
  }

  public function product_grade()
  {
    return $this->belongsTo(ProductGrade::class);
  }

  public function product_supplier()
  {
    return $this->belongsTo(ProductSupplier::class);
  }

  public function productReceipt()
  {
    return $this->morphOne(ProductReceipt::class, 'product')->latest();
  }

  public function swapped_deal_device()
  {
    return $this->morphOne(SwapDeal::class, 'swapped_with');
  }

  public function product_sales_record()
  {
    return $this->morphMany(ProductSaleRecord::class, 'product');
  }

  public function dispatch_request()
  {
    return $this->morphOne(ProductDispatchRequest::class, 'product')->latest();
  }

  public function product_histories()
  {
    return $this->morphMany(ProductHistory::class, 'product')->latest();
  }

  public function reseller_histories()
  {
    return $this->morphMany(ResellerHistory::class, 'product')->latest();
  }

  public function with_resellers()
  {
    return $this->morphToMany(Reseller::class, 'product',  $table = 'reseller_product')->using(ResellerProduct::class)->wherePivot('status', 'tenured')->withPivot('status')->withTimestamps()->as('tenure_record');
    // return $this->belongsToMany(Reseller::class, $table = 'reseller_product')->using(ResellerProduct::class)->wherePivot('status', 'tenured')->withPivot('status')->withTimestamps()->as('tenure_record');
  }

  public function product_expenses()
  {
    return $this->morphMany(ProductExpense::class, 'product');
  }

  public function product_expenses_amount()
  {
    return $this->product_expenses()->selectRaw('product_id, SUM(amount) as expense_amount')->groupBy('product_id');
  }

  public function product_expenses_sum(): float
  {
    return isset($this->product_expenses_amount[0]) ? $this->product_expenses_amount[0]->expense_amount : 0;
  }

  public function total_product_expenses(): float
  {
    return $this->product_expenses()->sum('amount');
  }

  public function product_price()
  {
    return $this->belongsTo(
      ProductPrice::class,
      ['product_brand_id', 'product_batch_id', 'product_model_id', 'product_color_id', 'storage_size_id', 'product_grade_id', 'product_supplier_id'],
      ['product_brand_id', 'product_batch_id', 'product_model_id', 'product_color_id', 'storage_size_id', 'product_grade_id', 'product_supplier_id']
    )->withDefault([
      'cost_price' => 0,
      'proposed_selling_price' => 0
    ]);
  }

  public function localProductPrice()
  {
    return $this->hasOne(LocalProductPrice::class);
  }

  public function storage_size()
  {
    return $this->belongsTo(StorageSize::class);
  }

  public function processor_speed()
  {
    return $this->belongsTo(ProcessorSpeed::class);
  }

  public function ram_size()
  {
    return $this->belongsTo(StorageSize::class);
  }

  public function storage_type()
  {
    return $this->belongsTo(StorageType::class);
  }

  public function office_branch()
  {
    return $this->belongsTo(OfficeBranch::class);
  }

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

  public function shortDescription(): string
  {
    return $this->product_color->color . ' ' . $this->product_model->name . ' ' . $this->storage_size->human_size . ' ' . $this->primary_identifier();
  }

  public function just_arrived(): bool
  {
    return $this->product_status_id === ProductStatus::justArrivedId();
  }

  public function is_sold(): bool
  {
    /**
     * Check if the product has been sold already or confirmed
     */
    return $this->product_status_id === ProductStatus::soldId()
      || $this->product_status_id === ProductStatus::saleConfirmedId()
      || $this->product_status_id === ProductStatus::soldByResellerId();
  }

  public function out_for_delivery(): bool
  {
    return $this->product_status_id === ProductStatus::scheduledDeliveryId();
  }

  public function in_stock(): bool
  {
    /**
     * Check if the product has been sold already or confirmed
     */
    return $this->product_status_id === ProductStatus::inStockId();
  }

  public function is_from_local_supplier(): bool
  {
    return $this->product_batch_id === ProductBatch::local_supplied_id();
  }

  public function generateReceipt(float $amount): ProductReceipt
  {
    /** If there is no app_user attached to the product, it is most likely a reseller sale **/
    if ($this->is_sold() && $this->app_user->first_name == 'Not Sold') {
      return new ProductReceipt;
    }
    return $this->productReceipt()->create([
      'user_email' => $this->app_user->email,
      'user_phone' => $this->app_user->phone,
      'user_address' => $this->app_user->address,
      'user_city' => $this->app_user->city,
      'amount_paid' => $amount
    ]);
  }

  public function with_reseller(): bool
  {
    return $this->product_status_id === ProductStatus::withResellerId();
  }

  public function getFullNameAttribute()
  {
    return $this->product_color->color . ' ' . $this->product_model->name . ' ' . $this->storage_size->human_size;
  }

  public function getCostPriceAttribute()
  {
    switch ($this->is_local):
      case true:
        return is_numeric($this->localProductPrice->cost_price)  ? $this->product_expenses_sum() + (float)$this->localProductPrice->cost_price : $this->localProductPrice->cost_price;
        break;
      default:
        return is_numeric($this->product_price->cost_price)  ?
        $this->product_expenses_sum() + (float)$this->product_price->cost_price : $this->product_price->cost_price;
    endswitch;
  }

  public function getProposedSellingPriceAttribute()
  {
    switch ($this->is_local):
      case true:
        return is_numeric($this->localProductPrice->proposed_selling_price) ? $this->localProductPrice->proposed_selling_price : $this->localProductPrice->proposed_selling_price;
        break;
      default:
        return is_numeric($this->product_price->proposed_selling_price) ? $this->product_price->proposed_selling_price : $this->product_price->proposed_selling_price;
    endswitch;
  }

  static function superAdminRoutes()
  {
    Route::group(['prefix' => 'products'], function () {
      Route::name('superadmin.products.')->group(function () {
        Route::delete('local-product/{product:product_uuid}/delete', [self::class, 'deleteLocalProduct'])->name('delete_local_product')->defaults('ex', __e('ac', 'archive'));
      });
    });
  }

  static function accountantRoutes()
  {
    Route::group(['prefix' => 'products'], function () {
      Route::name('accountant.products.')->group(function () {
        Route::get('local-product/create', [self::class, 'showCreateLocalProductForm'])->name('create_local_product')->defaults('ex', __e('ac', 'archive'));
        Route::post('local-product/create', [self::class, 'createLocalSupplierProduct'])->name('create_local')->defaults('ex', __e('ac', 'archive'));
      });
    });
  }

  static function stockKeeperRoutes()
  {
    Route::group(['prefix' => 'products'], function () {
      Route::name('stockkeeper.products.')->group(function () {
        Route::get('create', [self::class, 'showCreateProductForm'])->name('create_product')->defaults('ex', __e('sk', 'archive'));
        Route::post('create', [self::class, 'createProduct'])->name('create')->defaults('ex', __e('sk', 'archive'));
      });
    });
  }

  static function qualityControlRoutes()
  {
    Route::group(['prefix' => 'products'], function () {
      Route::name('qualitycontrol.products.')->group(function () {
        Route::put('{product:product_uuid}/qa-test-results', [self::class, 'updateProductQATestResults'])->name('update_qa_result')->defaults('ex', __e('ss,q', null, true));
        Route::put('{product:product_uuid}/mark-undergoing-qa', [self::class, 'markProductAsUndergoingQA'])->name('undergoing_qa')->defaults('ex', __e('ss,q', null, true));
      });
    });
  }

  static function dispatchAdminRoutes()
  {
    Route::group(['prefix' => 'products'], function () {
      Route::name('dispatchadmin.products.')->group(function () {
        Route::post('{product:product_uuid}/return-to-stock', [self::class, 'returnProductToStock'])->name('return_to_stock')->defaults('ex', __e('d', null, true));
      });
    });
  }

  static function multiAccessRoutes()
  {
    Route::group(['prefix' => 'products'], function () {

      $p = function ($name) {
        return 'multiaccess.products.' . $name;
      };

      Route::get('/', [self::class, 'getProducts'])->name($p('view_products'))->defaults('ex', __e('ss,a,ac,d,sk,s,q,w', 'archive'))->middleware('auth:super_admin,stock_keeper,sales_rep,quality_control,admin,dispatch_admin,web_admin,accountant');
      Route::get('/search', [self::class, 'findProduct'])->name($p('find_product'))->defaults('ex', __e('ss,ac', null, true))->middleware('auth:super_admin,accountant');
      Route::get('/receipt/{productReceipt:order_ref}', [AppUserController::class, 'previewReceipt'])->name($p('receipt'))->defaults('ex', __e('ss,ac', null, true))->middleware('auth:super_admin,accountant');
      Route::post('/receipt/{product:product_uuid}', [AppUserController::class, 'resendReceipt'])->name($p('resend_receipt'))->defaults('ex', __e('ss,ac', null, true))->middleware('auth:super_admin,accountant');
      Route::get('daily-records', [self::class, 'showDailyRecordsPage'])->name($p('daily_records'))->defaults('ex', __e('ss,ac', 'archive'))->middleware('auth:super_admin,accountant');
      Route::get('resellers', [self::class, 'getProductsWithResellers'])->name($p('products_with_resellers'))->defaults('ex', __e('ss,sk,a,ac', 'archive'))->middleware('auth:super_admin,stock_keeper,admin,accountant');
      Route::get('/{product:product_uuid}', [self::class, 'getProductDetails'])->name($p('view_product_details'))->defaults('ex', __e('ss,a,ac', 'archive', true))->middleware('auth:super_admin,admin,accountant');
      Route::put('{product}/edit', [self::class, 'editProduct'])->name($p('edit_product'))->defaults('ex', __e('ss', null, true))->middleware('auth:super_admin');
      Route::put('{product}/location', [self::class, 'updateProductLocation'])->name($p('edit_product_location'))->defaults('ex', __e('ss', null, true))->middleware('auth:super_admin');
      Route::get('{product:product_uuid}/qa-test-results', [self::class, 'getProductQATestResults'])->name($p('qa_test_results'))->defaults('ex', __e('ss,q,a', null, true))->middleware('auth:quality_control,admin,super_admin,accountant');
      Route::post('{product:product_uuid}/sold', [self::class, 'markProductAsSold'])->name($p('mark_as_sold'))->defaults('ex', __e('ss,d', null, true))->middleware('auth:sales_rep,dispatch_admin');
      Route::put('{product:product_uuid}/status', [self::class, 'updateProductStatus'])->name($p('update_product_status'))->defaults('ex', __e('ss,q', null, true))->middleware('auth:super_admin,quality_control');
      Route::post('{product:product_uuid}/comment', [self::class, 'commentOnProduct'])->name($p('comment_on_product'))->defaults('ex', __e('ss,a,ac,d,sk', null, true))->middleware('auth:super_admin,admin,accountant');
      Route::get('{product:product_uuid}/qa-tests', [self::class, 'getApplicableProductQATests'])->name($p('applicable_qa_tests'))->defaults('ex', __e('ss', null, true))->middleware('auth:super_admin');
      Route::post('{product:product_uuid}/qa-tests/results/comment', [self::class, 'commentOnProductQATestResults'])->name($p('comment_on_qa_test'))->defaults('ex', __e('ss,d,q', null, true))->middleware('auth:super_admin,stock_keeper,quality_control');
    });
  }

  public function findProduct(Request $request)
  {
    if (!($request->searchQuery)) return generate_422_error('Enter your search parameters');

    if (!$request->searchKey) $products = self::where('imei', 'LIKE', '%' . $request->q . '%')->orWhere('serial_no', 'LIKE', '%' . $request->q . '%')->orWhere('model_no', 'LIKE', '%' . $request->q . '%')->get();

    return back()->withFlash(["search_results" => (new ProductTransformer)->collectionTransformer($products, 'searchResults')]);
  }

  public function getProducts(Request $request)
  {
    $searchKey = $request->searchKey == 'product_name' ? 'product_model_id' : $request->searchKey;
    $searchQuery = $request->searchKey == 'product_name' ? ProductModel::where('name', 'LIKE', '%' . $request->searchQuery . '%')->pluck('id')->toArray() : $request->searchQuery;

    /**
     * ! Filter list based on logged in user.
     */

    if ($request->user()->isStockKeeper()) {
      $products = fn () => (new ProductTransformer)->collectionTransformer(self::search($searchKey, $searchQuery)->inStock()->with(['product_color', 'product_status', 'storage_size', 'product_model', 'product_price', 'product_supplier'])->take(10)->get(), 'productsListing');
    } elseif ($request->user()->isSalesRep()) {
      $products = fn () => (new ProductTransformer)->collectionTransformer(self::search($searchKey, $searchQuery)->inStock()->with(['product_color', 'product_status', 'storage_size', 'product_model', 'product_price', 'product_supplier'])->take(10)->get(), 'productsListing');
    } elseif ($request->user()->isQualityControl()) {
      $products = fn () => (new ProductTransformer)->collectionTransformer(self::search($searchKey, $searchQuery)->untested()->with(['product_color', 'product_status', 'storage_size', 'product_model', 'product_price', 'product_supplier'])->take(10)->get(), 'productsListing');
    } elseif ($request->user()->isDispatchAdmin()) {
      $products = fn () => (new ProductTransformer)->collectionTransformer(self::search($searchKey, $searchQuery)->inStock()->orWhere->outForDelivery()->with(['product_color', 'product_status', 'storage_size', 'product_model', 'product_price', 'product_supplier', 'dispatch_request'])->take(10)->get(), 'dispatchListing');
    } elseif ($request->user()->isWebAdmin()) {
      $products = fn () => (new ProductTransformer)->collectionTransformer(self::search($searchKey, $searchQuery)->inStock()->with(['product_color', 'product_status', 'storage_size', 'product_model', 'product_price', 'product_supplier'])->take(10)->get(), 'productsListing');
    } elseif ($request->user()->isAccountant()) {
      $products = fn () => (new ProductTransformer)->collectionTransformer(self::search($searchKey, $searchQuery)->sold()->orWhere->saleConfirmed()->orWhere->outForDelivery()->with(['product_color', 'product_status', 'storage_size', 'product_model', 'product_price', 'product_supplier'])->take(10)->get(), 'productsListing');
    } elseif ($request->user()->isAdmin() || $request->user()->isSuperAdmin()) {
      $products = fn () => (new ProductTransformer)->collectionTransformer(self::search($searchKey, $searchQuery)->with(['product_color', 'product_status', 'storage_size', 'product_model', 'product_price', 'product_supplier'])->take(10)->get(), 'productsListing');
    } else {
      $products = collect([]);
    }
    $onlineReps = fn () => Cache::rememberForever('onlineReps', fn () => (new SalesRepTransformer)->collectionTransformer(SalesRep::socialMedia()->orWhere->callCenter()->get(), 'transformBasic'));
    $salesChannel = fn () => Cache::rememberForever('salesChannel', fn () => (new SalesChannelTransformer)->collectionTransformer(SalesChannel::all(), 'basic'));
    $resellers = fn () => Cache::rememberForever('resellers', fn () => (new ResellerTransformer)->collectionTransformer(Reseller::all(), 'basic'));

    if ($request->isApi()) return  response()->json($products, 200);
    return Inertia::render('SuperAdmin,Products/ListProducts', compact('products', 'salesChannel', 'resellers', 'onlineReps'));
  }

  public function getProductDetails(Request $request, Product $product)
  {
    $productDetails = $product->load(['productReceipt',
      'product_color',
      'product_grade',
      'product_model',
      'product_brand',
      'product_category',
      'storage_size',
      'product_supplier',
      'product_batch',
      'processor_speed',
      'ram_size',
      'storage_type',
      'product_status',
      'product_price',
      'app_user',
      'location',
      'comments.user' => fn ($query) => $query->withoutGlobalScopes()
    ]);

    if ($request->isApi()) return  response()->json((new ProductTransformer)->detailed($productDetails), 200);
    return Inertia::render('SuperAdmin,Products/ViewProductDetails', [
      'productDetails' => (new ProductTransformer)->detailed($productDetails),
      'productComments' => (new UserCommentTransformer)->collectionTransformer($product->comments, 'commentDetails')
    ]);
  }

  public function showDailyRecordsPage()
  {
    $aggregatedSalesRecords = ProductSaleRecord::addSelect(DB::raw('COUNT(created_at) as num_of_sales,DATE(created_at) as day'))->groupBy('day')->latest('day')->get()->each->setAppends([]);
    $aggregatedProductExpenseRecords = ProductExpense::addSelect(DB::raw('COUNT(created_at) as num_of_product_expenses,DATE(created_at) as day'))->groupBy('day')->latest('day')->get()->each->setAppends([]);
    $aggregatedOtherExpenseRecords = OtherExpense::withoutGlobalScope('latest')->addSelect(DB::raw('COUNT(created_at) as num_of_other_expenses,DATE(created_at) as day'))->groupBy('day')->latest('day')->get()->each->setAppends([]);

    $dailyRecords = ($aggregatedOtherExpenseRecords->concat($aggregatedProductExpenseRecords)->concat($aggregatedSalesRecords)->mapToGroups(fn ($item, $key) => [$item['day'] => $item])->transform(fn ($item) => Arr::collapse($item->toArray()))->except('day'))->toArray();

    return Inertia::render('SuperAdmin,Products/DailyRecords', compact('dailyRecords'));
  }

  public function getProductsWithResellers(Request $request)
  {
    $productsWithResellers = (new ProductTransformer)->collectionTransformer(self::has('with_resellers')->with('with_resellers', 'product_color', 'product_model', 'storage_size')->get(), 'transformWithResellerDetails');
    $swapDealsWithResellers = (new SwapDealTransformer)->collectionTransformer(SwapDeal::has('with_resellers')->with('with_resellers')->get(), 'transformWithResellerDetails');

    /**
     * ! Fix: Call to a member function getKey() on array error when the first collection is empty.
     * @after Update?
     */
    if ($productsWithResellers->isEmpty()) {
      $productsWithResellers = $swapDealsWithResellers->merge($productsWithResellers);
    } else {
      $productsWithResellers = $productsWithResellers->merge($swapDealsWithResellers);
    }

    if ($request->isApi())  return response()->json($productsWithResellers, 200);
    return Inertia::render('SuperAdmin,Products/ProductsWithResellers', compact('productsWithResellers'));
  }

  public function showCreateProductForm()
  {
    return Inertia::render('SuperAdmin,Products/CreateProduct', [
      'batches' => fn () => Cache::remember('batches', (15 * 60 * 60), fn () => (new ProductBatchTransformer)->collectionTransformer(ProductBatch::whereDate('created_at', '>', now()->subDays(4))->foreign()->latest()->take(2)->get(), 'basic')),
      'categories' => fn () => Cache::rememberForever('categories', fn () => (new ProductCategoryTransformer)->collectionTransformer(ProductCategory::all(), 'basic')),
      'models' => fn () => Cache::rememberForever('models', fn () => (new ProductModelTransformer)->collectionTransformer(ProductModel::all(), 'basic')),
      'brands' => fn () => Cache::rememberForever('brands', fn () => (new ProductBrandTransformer)->collectionTransformer(ProductBrand::all(), 'basic')),
      'colors' => fn () => Cache::rememberForever('colors', fn () => (new ProductColorTransformer)->collectionTransformer(ProductColor::all(), 'basic')),
      'grades' => fn () => Cache::rememberForever('grades', fn () => (new ProductGradeTransformer)->collectionTransformer(ProductGrade::all(), 'basic')),
      'suppliers' => fn () => Cache::rememberForever('foreignSuppliers', fn () => (new ProductSupplierTransformer)->collectionTransformer(ProductSupplier::foreign()->get(), 'basic')),
      'storage_sizes' => fn () => Cache::rememberForever('storage_sizes', fn () => (new StorageSizeTransformer)->collectionTransformer(StorageSize::all(), 'basic')),
      'storage_types' => fn () => Cache::rememberForever('storage_types', fn () => (new StorageTypeTransformer)->collectionTransformer(StorageType::all(), 'basic')),
      'processor_speeds' => fn () => Cache::rememberForever('processor_speeds', fn () => (new ProcessorSpeedTransformer)->collectionTransformer(ProcessorSpeed::all(), 'basic')),
    ]);
  }

  public function createProduct(CreateProductValidation $request)
  {
    try {
      $product = self::create(collect($request->validated())->merge([
        'stocked_by' => auth()->id(),
        'stocker_type' => get_class(auth()->user()),
        'office_branch_id' => OfficeBranch::head_office_id(),
        'product_status_id' => ProductStatus::justArrivedId()
      ])->all());

      if ($request->isApi()) return response()->json($product, 201);
      return back()->withFlash(['success'=>'Product created']);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Product not created');
      return response()->json(['err' => 'Product not created'], 500);
    }
  }

  public function showCreateLocalProductForm()
  {
    /**
     * ! Only those who are allowed to set price should see this page
     */
    return Inertia::render('SuperAdmin,Products/CreateLocalProduct', [
      'categories' => fn () => Cache::rememberForever('categories', fn () => (new ProductCategoryTransformer)->collectionTransformer(ProductCategory::all(), 'basic')),
      'models' => fn () => Cache::rememberForever('models', fn () => (new ProductModelTransformer)->collectionTransformer(ProductModel::all(), 'basic')),
      'brands' => fn () => Cache::rememberForever('brands', fn () => (new ProductBrandTransformer)->collectionTransformer(ProductBrand::all(), 'basic')),
      'colors' => fn () => Cache::rememberForever('colors', fn () => (new ProductColorTransformer)->collectionTransformer(ProductColor::all(), 'basic')),
      'grades' => fn () => Cache::rememberForever('grades', fn () => (new ProductGradeTransformer)->collectionTransformer(ProductGrade::all(), 'basic')),
      'suppliers' => fn () => Cache::rememberForever('localSuppliers', fn () => (new ProductSupplierTransformer)->collectionTransformer(ProductSupplier::local()->get(), 'basic')),
      'storage_sizes' => fn () => Cache::rememberForever('storage_sizes', fn () => (new StorageSizeTransformer)->collectionTransformer(StorageSize::all(), 'basic')),
      'storage_types' => fn () => Cache::rememberForever('storage_types', fn () => (new StorageTypeTransformer)->collectionTransformer(StorageType::all(), 'basic')),
      'processor_speeds' => fn () => Cache::rememberForever('processor_speeds', fn () => (new ProcessorSpeedTransformer)->collectionTransformer(ProcessorSpeed::all(), 'basic')),
    ]);
  }

  public function createLocalSupplierProduct(CreateLocalSupplierProductValidation $request)
  {
    DB::beginTransaction();
    try {

      $product = self::create($request->validated());

      try {
        /**
         * create the local product price record
         */

        $product->localProductPrice()->create($request->validated());
      } catch (QueryException $th) {
        if ($th->getCode() == 23000) {
          ErrLog::notifyAdminAndFail($request->user(), $th, 'Local Product not created');
          if ($request->isApi()) return response()->json(['err' => 'Product not created'], 500);
          return back()->withFlash(['error'=>['Product not created']]);
        } else {
          throw_if(true, $th);
        }
      }

      DB::commit();

      if ($request->isApi()) return response()->json($product, 201);
      return back()->withFlash(['success'=>'Product created']);

    } catch (\Throwable $th) {
      ErrLog::notifyAdminAndFail($request->user(), $th, 'Product not created');
      if ($request->isApi()) return response()->json(['err' => 'Product not created'], 500);
      return back()->withFlash(['error'=>['Product not created']]);
    }
  }

  public function editProduct(CreateProductValidation $request, self $product)
  {
    try {
      foreach ($request->validated() as $key => $value) {
        $product->$key = $value;
      }

      $product->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Product not updated');
      return response()->json(['err' => 'Product not updated'], 500);
    }
  }

  public function updateProductLocation(Request $request, self $product)
  {
    if (!$request->office_branch_id) {
      return generate_422_error('Select a location to assign this product');
    }
    try {
      foreach ($request->all() as $key => $value) {
        $product->$key = $value;
      }

      $product->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Product not updated');
      return response()->json(['err' => 'Product not updated'], 500);
    }
  }

  public function returnProductToStock(Request $request, self $product)
  {
    $productDispatchRequest = $product->dispatch_request;

    DB::beginTransaction();

    if ($productDispatchRequest) {
      if ($productDispatchRequest->is_sold()) {
        throw ValidationException::withMessages(['err' => "INCONSISTENT DATA: This product's dispatch request has been marked as sold already."])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
      }
      $productDispatchRequest->product_id = null;
      $productDispatchRequest->product_type = null;
      $productDispatchRequest->scheduled_at = null;
      $productDispatchRequest->save();
    }

    if (!$product->out_for_delivery()) {
      throw ValidationException::withMessages(['err' => "This product is not scheduled for delivery."])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
    } else {
      $product->product_status_id = ProductStatus::inStockId();
      $product->save();
    }

    DB::commit();

    if ($request->isApi()) return response()->json([], 204);
    return back()->withFlash(['success'=>'Product returned back to the stock list']);
  }

  public function updateProductStatus(Request $request, self $product)
  {

    if ($product->product_status_id == $request->product_status_id) {
      return generate_422_error('Nothing changed');
    }

    DB::beginTransaction();

    try {
      $product_status = ProductStatus::findOrFail($request->product_status_id);
    } catch (\Throwable $th) {
      return generate_422_error('Invalid product status selected');
    }

    //notify admin that someone updated a product status
    ActivityLog::notifySuperAdmins($request->user()->email . ' changed product with ' . $product->primary_identifier() . ' to status:  "' . $product_status->status . '"');

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
      $product->product_status_id = $request->product_status_id;
      $product->save();
    }

    DB::commit();

    if ($request->isApi()) return response()->json([], 204);
    return back()->withFlash(['success'=>'Status updated']);
  }

  public function markProductAsUndergoingQA(Request $request, self $product)
  {

    if (!$product->just_arrived()) throw ValidationException::withMessages(['err' => "You can only mark products that just arriced as undergoing QA."])->status(Response::HTTP_UNPROCESSABLE_ENTITY);

    $product->product_status_id = ProductStatus::undergoingQaId();
    $product->save();

    if ($request->isApi()) return response()->json([], 204);
    return back()->withFlash(['success'=>'Product has been marked as undergoing QA.']);
  }


  public function markProductAsSold(MarkProductAsSoldValidation $request, self $product)
  {
    DB::beginTransaction();

    /**
     * Update product status to sold
     */
    $product->product_status_id = ProductStatus::soldId();
    $product->sold_at = now();

    /**
     * Mark dispatch requests as sold.
     */
    if ($request->user()->isDispatchAdmin()) {
      try {
        $product->dispatch_request->sold_at = now();
        $product->dispatch_request->save();
      } catch (\Throwable $th) {
        ErrLog::notifyAdminAndFail(auth()->user(), $th, 'Could not mark dispatch request as processed ' . $request->email);
        if ($request->isApi()) return response()->json(['err' => 'Could not mark dispatch request as processed ' . $request->email], 500);
        return back()->withFlash(['error'=>['Could not mark dispatch request as processed.' . $th->getMessage()]]);
      }
    }

    /**
     * Create a sales record for the product
     */
    try {
      $product->product_sales_record()->create([
        'selling_price' => $request->selling_price,
        'online_rep_id' => $request->online_rep_id,
        'sales_rep_id' => auth()->id(),
        'sales_channel_id' => $request->sales_channel_id,
        'is_swap_transaction' => filter_var($request->is_swap_transaction, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
      ]);
    } catch (\Throwable $th) {
      ErrLog::notifyAdminAndFail(auth()->user(), $th, 'Could not create product sales record ' . $request->email);
      if ($request->isApi()) return response()->json(['err' => 'Could not create product sales record ' . $request->email], 500);
      return back()->withFlash(['error'=>['Could not create product sales record. Try again' . $th->getMessage()]]);
    }

    /**
     * Create or update the buyer's user profile using the email
     */
    try {
      $app_user = AppUser::updateOrCreate(
        [
          'email' => $request->email,
          'email' => $request->email,
        ],
        [
          'phone' => $request->phone,
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
      return back()->withFlash(['error'=>['Could not create account profile for buyer. Try again' . $th->getMessage()]]);
    }

    /**
     * Allocate the item to the user
     */
    $product->app_user_id = $app_user->id;
    $product->save();


    /**
     * ! If swap deal, process the swap device
     */
    if (filter_var($request->is_swap_transaction, FILTER_VALIDATE_BOOLEAN)) {
      // return $request->validated();
      list($id_url, $receipt_url) = SwapDeal::store_documents($request);
      if (!SwapDeal::create_swap_record((object)collect($request->validated())->merge(['app_user_id' => $app_user->id])->all(), $id_url, $receipt_url)) {
        if ($request->isApi()) return response()->json(['err' => 'Transaction not completed. The swap details could not be created'], 500);
        return back()->withFlash(['error'=>['Transaction not completed. The swap details could not be created' . $th->getMessage()]]);
      }
    }

    /**
     * Notify Admin that a product was sold
     */
    ActivityLog::notifySuperAdmins($request->user()->email . ' marked product with UUID no: ' . $product->product_uuid . ' as sold.');

    /**
     * Notify Accountant that a product was marked as sold
     */
    ActivityLog::notifyAccountants($request->user()->email . ' marked product with UUID: ' . $product->product_uuid . ' as sold.');

    DB::commit();

    if ($request->isApi()) return response()->json([], 204);
    return back()->withFlash(['success'=>'Product has been marked as sold. It will no longer be available in stock' . $th->getMessage()]);
  }

  public function commentOnProduct(CreateProductCommentValidation $request, self $product)
  {
    $comment =  $request->user()->comments()->create([
      'subject_id' => $product->id,
      'subject_type' => get_class($product),
      'comment' => $request->comment
    ]);

    if ($request->isApi()) return response()->json($comment, 201);
    return back()->withFlash(['success'=>'Comment created. ']);
  }

  public function deleteLocalProduct(Request $request, self $product)
  {
    if (!$product->is_from_local_supplier()) throw ValidationException::withMessages(['err' => "You can only delete products from local suppliers."])->status(Response::HTTP_UNPROCESSABLE_ENTITY);
    if ($product->is_sold()) throw ValidationException::withMessages(['err' => "This product has been marked as sold already. You cannot delete it any more"])->status(Response::HTTP_UNPROCESSABLE_ENTITY);

    $product->forceDelete();

    return back()->withFlash(['success'=>'Deleted']);
  }

  public function getApplicableProductQATests(Request $request, self $product)
  {
    return response()->json((new QATestTransformer)->collectionTransformer($product->product_model->qa_tests, 'basic'), 200);
  }

  public function getProductQATestResults(Request $request, self $product)
  {
    $productQATestResults = fn () => (new ProductTransformer)->transformWithTestResults($product->load('qa_tests', 'product_model.qa_tests'));
    $productQATestResultsComments = fn () => (new UserCommentTransformer)->collectionTransformer($product->test_result_comments, 'detailed');
    $productStatuses = Cache::rememberForever('productStatuses', fn () => (new ProductStatusTransformer)->collectionTransformer(ProductStatus::qa()->get(), 'basic'));

    if ($request->isApi()) return response()->json(['product' => $productQATestResults, 'comments' => $productQATestResultsComments,], 200);
    return Inertia::render('SuperAdmin,Products/QATestResults', [
      'product' => $productQATestResults,
      'comments' => $productQATestResultsComments,
      'product_statuses' => $productStatuses,
    ]);
  }

  public function updateProductQATestResults(Request $request, self $product)
  {
    if (!$request->qa_test_results) {
      return generate_422_error('Specify valid QA tests results');
    }

    $filtered = Arr::where($request->qa_test_results, function ($value, $key) {
      return !empty($value) && !is_null($value['is_qa_certified']);
    });

    $tests = $product->qa_tests()->sync($filtered);

    if ($request->isApi()) return response()->json($tests, 201);
    return back()->withFlash(['success'=>'Updated Test Results']);
  }

  public function commentOnProductQATestResults(CreateProductCommentValidation $request, self $product)
  {
    $comment =  $request->user()->comments()->create([
      'subject_id' => $product->id,
      'subject_type' => get_class($product),
      'comment' => 'Test Result: ' . $request->comment
    ]);

    if ($request->isApi()) return response()->json((new UserCommentTransformer)->detailed($comment), 201);
    return back()->withFlash(['success'=>'Product created']);
  }

  public function scopeInStock($query)
  {
    return $query->where('product_status_id', ProductStatus::inStockId());
  }

  public function scopeSaleConfirmed($query)
  {
    return $query->where('product_status_id', ProductStatus::saleConfirmedId());
  }

  public function scopeSold($query)
  {
    return $query->where('product_status_id', ProductStatus::soldId())->orWhere('product_status_id', ProductStatus::soldByResellerId());
  }

  public function scopeOutForDelivery($query)
  {
    return $query->where('product_status_id', ProductStatus::scheduledDeliveryId());
  }

  public function scopeJustArrived($query)
  {
    return $query->where('product_status_id', ProductStatus::justArrivedId());
  }

  public function scopeUntested($query)
  {
    return $query->where('product_status_id', ProductStatus::justArrivedId())->orWhere('product_status_id', ProductStatus::undergoingQaId())->orWhere('product_status_id', ProductStatus::outForRepairsId())->orWhere('product_status_id', ProductStatus::rtoId())->orWhere('product_status_id', ProductStatus::backFromRepairsId())->orWhere('product_status_id', ProductStatus::qaFailedId());
  }

  public function scopeLocal($query)
  {
    return $query->where('product_batch_id', ProductBatch::local_supplied_id());
  }

  public function scopeSearch($query, $searchIndex, $searchParam)
  {
    return $searchParam ? (is_array($searchParam) ? $query->whereIn($searchIndex, $searchParam) : $query->where($searchIndex, 'LIKE', '%' . $searchParam . '%')) : $query;
  }

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($product) {
      $product->product_uuid = (string)Str::uuid();
    });

    static::saved(function ($product) {
      Cache::forget($product->office_branch->city . 'officeBranchProducts');
      Cache::forget('products');
      Cache::forget('webAdminProducts');
      Cache::forget('dispatchAdminProducts');
      Cache::forget('stockKeeperProducts');
      Cache::forget('salesRepProducts');
      Cache::forget('qualityControlProducts');
      Cache::forget('brandsWithProductCount');
    });

    static::updating(function ($product) {
      /**
       * add an entry for the product trail that it's status changed
       */
      request()->user()->product_histories()->create([
        'product_id' => $product->id,
        'product_type' => get_class($product),
        'product_status_id' => $product->product_status_id,
      ]);
    });
  }
}
