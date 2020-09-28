<?php

namespace App\Modules\SuperAdmin\Models;

use Cache;
use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Awobaz\Compoships\Compoships;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\QueryException;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\QATest;
use App\Modules\SuperAdmin\Models\RamSize;
use App\Modules\SuperAdmin\Models\Reseller;
use App\Modules\SuperAdmin\Models\SwapDeal;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ActivityLog;
use App\Modules\SuperAdmin\Models\StorageSize;
use App\Modules\SuperAdmin\Models\StorageType;
use App\Modules\SuperAdmin\Traits\Commentable;
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
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SuperAdmin\Models\CompanyBankAccount;
use App\Modules\SalesRep\Transformers\SalesRepTransformer;
use App\Modules\SuperAdmin\Transformers\QATestTransformer;
use App\Modules\SuperAdmin\Transformers\ProductTransformer;
use App\Modules\SuperAdmin\Transformers\ResellerTransformer;
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
use App\Modules\SuperAdmin\Transformers\CompanyBankAccountTransformer;
use App\Modules\SuperAdmin\Http\Validations\MarkProductAsSoldValidation;
use App\Modules\SuperAdmin\Http\Validations\CreateProductCommentValidation;
use App\Modules\SuperAdmin\Http\Validations\CreateLocalSupplierProductValidation;

class Product extends BaseModel
{
  use SoftDeletes, Compoships, Commentable;

  protected $fillable = [
    'product_category_id', 'product_model_id', 'product_brand_id', 'product_batch_id', 'product_color_id', 'product_grade_id',
    'product_supplier_id', 'storage_size_id', 'imei', 'serial_no', 'model_no', 'product_uuid', 'processor_speed_id', 'ram_size_id',
    'storage_type_id', 'stocked_by', 'stocker_type', 'office_branch_id'
  ];

  protected $casts = [
    'product_status_id' => 'int'
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

  public function product_sales_record()
  {
    return $this->hasOne(ProductSaleRecord::class);
  }

  public function product_histories()
  {
    return $this->morphMany(ProductHistory::class, 'product')->latest();
  }

  public function reseller_histories()
  {
    return $this->hasMany(ResellerHistory::class);
  }

  public function with_resellers()
  {
    return $this->belongsToMany(Reseller::class, $table = 'reseller_product')->using(ResellerProduct::class)->wherePivot('status', 'tenured')->withPivot('status')->withTimestamps()->as('tenure_record');
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
    return $this->belongsTo(RamSize::class);
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

  public function with_reseller(): bool
  {
    return $this->product_status_id === ProductStatus::withResellerId();
  }

  public function getCostPriceAttribute()
  {
    return is_numeric($this->product_price->cost_price)  ?
      to_naira($this->product_expenses_sum() + (float)$this->product_price->cost_price) : $this->product_price->cost_price;
  }

  public function getProposedSellingPriceAttribute()
  {
    return is_numeric($this->product_price->proposed_selling_price) ? to_naira($this->product_price->proposed_selling_price) : $this->product_price->proposed_selling_price;
  }

  static function routes()
  {
    Route::group(['prefix' => 'products'], function () {

      $p = function ($name) {
        return 'superadmin.products.' . $name;
      };

      Route::get('/', [self::class, 'getProducts'])->name($p('view_products'))->defaults('ex', __e('ss', 'archive'));
      Route::get('daily-records', [self::class, 'showDailyRecordsPage'])->name($p('daily_records'))->defaults('ex', __e('ss', 'archive'));
      Route::get('resellers', [self::class, 'getProductsWithResellers'])->name($p('products_with_resellers'))->defaults('ex', __e('ss', 'archive'));
      Route::get('create', [self::class, 'showCreateProductForm'])->name($p('create_product'))->defaults('ex', __e('ss', 'archive'));
      Route::post('create', [self::class, 'createProduct'])->name($p('create'))->defaults('ex', __e('ss', 'archive'));
      Route::get('local-supplier/create', [self::class, 'showCreateLocalProductForm'])->name($p('create_local_product'))->defaults('ex', __e('ss', 'archive'));
      Route::post('local-supplier/create', [self::class, 'createLocalSupplierProduct'])->name($p('create_local'))->defaults('ex', __e('ss', 'archive'));
      Route::get('/{product:product_uuid}', [self::class, 'getProductDetails'])->name($p('view_product_details'))->defaults('ex', __e('ss', 'archive', true));
      Route::put('{product}/edit', [self::class, 'editProduct'])->name($p('edit_product'))->defaults('ex', __e('ss', null, true));
      Route::put('{product}/location', [self::class, 'updateProductLocation'])->name($p('edit_product_location'))->defaults('ex', __e('ss', null, true));
      Route::post('{product:product_uuid}/sold', [self::class, 'markProductAsSold'])->name($p('mark_as_sold'))->defaults('ex', __e('ss', null, true));
      Route::post('{product:product_uuid}/schedule-delivery', [self::class, 'scheduleProductForDelivery'])->name($p('schedule_delivery'))->defaults('ex', __e('ss', null, true));
      Route::post('{product:product_uuid}/return-to-stock', [self::class, 'returnProductToStock'])->name($p('return_to_stock'))->defaults('ex', __e('ss', null, true));
      Route::put('{product:product_uuid}/confirm-sale', [self::class, 'confirmProductSale'])->name($p('confirm_sale'))->defaults('ex', __e('ss', null, true));
      Route::put('{product:product_uuid}/status', [self::class, 'updateProductStatus'])->name($p('update_product_status'))->defaults('ex', __e('ss', null, true));
      Route::post('{product:product_uuid}/comment', [self::class, 'commentOnProduct'])->name($p('comment_on_product'))->defaults('ex', __e('ss', null, true));
      Route::get('{product:product_uuid}/qa-tests', [self::class, 'getApplicableProductQATests'])->name($p('applicable_qa_tests'))->defaults('ex', __e('ss', null, true));
      Route::post('{product:product_uuid}/qa-tests/results/comment', [self::class, 'commentOnProductQATestResults'])->name($p('comment_on_qa_test'))->defaults('ex', __e('ss', null, true));
      Route::get('{product:product_uuid}/qa-test-results', [self::class, 'getProductQATestResults'])->name($p('qa_test_results'))->defaults('ex', __e('ss', null, true));
      Route::put('{product:product_uuid}/qa-test-results', [self::class, 'updateProductQATestResults'])->name($p('update_qa_result'))->defaults('ex', __e('ss', null, true));
      Route::get('search', [self::class, 'findProduct'])->name($p('find_product'))->defaults('ex', __e('archive'));
    });
  }

  public function findProduct(Request $request)
  {
    if (!($request->search_key && $request->search_string)) {
      return generate_422_error('Enter your search parameters');
    }
    return response()->json((new ProductTransformer)->detailed(self::where($request->search_key, $request->search_string)->first()), 200);
  }

  public function getProducts(Request $request)
  {
    /**
     * ! Filter list based on logged in user.
     */

    $products = fn () => Cache::rememberForever('products', fn () => (new ProductTransformer)->collectionTransformer(self::with(['product_color', 'storage_size', 'product_status', 'product_model', 'product_price', 'product_expenses_amount'])->get(), 'basic'));
    $onlineReps = fn () => Cache::rememberForever('onlineReps', fn () => (new SalesRepTransformer)->collectionTransformer(SalesRep::socialMedia()->get(), 'transformBasic'));
    $salesChannel = fn () => Cache::rememberForever('salesChannel', fn () => (new SalesChannelTransformer)->collectionTransformer(SalesChannel::all(), 'basic'));
    $companyAccounts = fn () => Cache::rememberForever('companyAccounts', fn () => (new CompanyBankAccountTransformer)->collectionTransformer(CompanyBankAccount::all(), 'basic'));
    $resellers = fn () => Cache::rememberForever('resellers', fn () => (new ResellerTransformer)->collectionTransformer(Reseller::all(), 'basic'));

    if ($request->isApi()) return  response()->json($products, 200);
    return Inertia::render('SuperAdmin,Products/ListProducts', compact('products', 'onlineReps', 'salesChannel', 'companyAccounts', 'resellers'));
  }

  public function getProductDetails(Request $request, Product $product)
  {
    $productDetails = $product->load(
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
      'comments.user'
    );

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
    $productsWithResellers = (new ProductTransformer)->collectionTransformer(self::has('with_resellers')->with('with_resellers', 'product_color', 'product_model')->get(), 'transformWithResellerDetails');
    if ($request->isApi())  return response()->json($productsWithResellers, 200);
    return Inertia::render('SuperAdmin,Products/ProductsWithResellers', compact('productsWithResellers'));
  }

  public function showCreateProductForm()
  {
    return Inertia::render('SuperAdmin,Products/CreateProduct', [
      'batches' => fn () => Cache::remember('batches', (15 * 60 * 60), fn () => (new ProductBatchTransformer)->collectionTransformer(ProductBatch::latest()->take(10)->get(), 'basic')),
      'categories' => fn () => Cache::rememberForever('categories', fn () => (new ProductCategoryTransformer)->collectionTransformer(ProductCategory::all(), 'basic')),
      'models' => fn () => Cache::rememberForever('models', fn () => (new ProductModelTransformer)->collectionTransformer(ProductModel::all(), 'basic')),
      'brands' => fn () => Cache::rememberForever('brands', fn () => (new ProductBrandTransformer)->collectionTransformer(ProductBrand::all(), 'basic')),
      'colors' => fn () => Cache::rememberForever('colors', fn () => (new ProductColorTransformer)->collectionTransformer(ProductColor::all(), 'basic')),
      'grades' => fn () => Cache::rememberForever('grades', fn () => (new ProductGradeTransformer)->collectionTransformer(ProductGrade::all(), 'basic')),
      'suppliers' => fn () => Cache::rememberForever('suppliers', fn () => (new ProductSupplierTransformer)->collectionTransformer(ProductSupplier::all(), 'basic')),
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
        'office_branch_id' => OfficeBranch::head_office_id()
      ])->all());

      if ($request->isApi()) return response()->json($product, 201);
      return back()->withSuccess('Product created');
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
      'suppliers' => fn () => Cache::rememberForever('suppliers', fn () => (new ProductSupplierTransformer)->collectionTransformer(ProductSupplier::all(), 'basic')),
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
       * create the product price record
       */

        ProductPrice::create(collect($request->validated())->merge(['product_batch_id' => $request->localSupplierId
      ])->all());
      } catch (QueryException $th) {
        if ($th->getCode() == 23000) {
        } else {
          throw_if(true, $th);
        }
      }

      DB::commit();

      if ($request->isApi()) return response()->json($product, 201);
      return back()->withSuccess('Product created');

    } catch (\Throwable $th) {
      ErrLog::notifyAdminAndFail($request->user(), $th, 'Product not created');
      if ($request->isApi()) return response()->json(['err' => 'Product not created'], 500);
      return back()->withError('Product not created');
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

  public function scheduleProductForDelivery(Request $request, self $product)
  {

    /**
     * Update the status
     */
    if (!$product->in_stock()) {
      return generate_422_error('This product is sold already');
    } else {
      $product->product_status_id = ProductStatus::scheduledDeliveryId();
      $product->save();
    }

    if ($request->isApi()) return response()->json([], 204);
    return back()->withSuccess('Product removed from stock list and scheduled for delivery');
  }

  public function returnProductToStock(Request $request, self $product)
  {

    DB::beginTransaction();

    if (!$product->out_for_delivery()) {
      return generate_422_error('This product is bot scheduled for delivery');
    } else {
      $product->product_status_id = ProductStatus::inStockId();
      $product->save();
    }

    DB::commit();

    if ($request->isApi()) return response()->json([], 204);
    return back()->withSuccess('Product returned back to the stock list');
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
    return back()->withSuccess('Status updated');

  }

  public function markProductAsSold(MarkProductAsSoldValidation $request, self $product)
  {

    // dd($product);

    DB::beginTransaction();

    /**
     * Update product status to sold
     */
    $product->product_status_id = $status_id = ProductStatus::soldId();
    $product->sold_at = now();

    /**
     * Create a sales record for the product
     */
    try {
      $product->product_sales_record()->create([
        'selling_price' => $request->selling_price,
        'online_rep_id' => $request->online_rep_id,
        'sales_rep_id' => auth()->id(),
        'sales_channel_id' => $request->sales_channel_id,
        'is_swap_deal' => filter_var($request->is_swap_deal, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
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
      return back()->withError('Could not create account profile for buyer. Try again');
    }

    /**
     * Allocate the item to the user
     */
    $product->app_user_id = $app_user->id;
    $product->save();


    /**
     * ! If swap deal, process the swap device
     */
    if (filter_var($request->is_swap_deal, FILTER_VALIDATE_BOOLEAN)) {
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
    ActivityLog::notifySuperAdmins($request->user()->email . ' marked product with UUID no: ' . $product->product_uuid . ' as sold.');

    /**
     * Notify Accountant that a product was marked as sold
     */
    ActivityLog::notifyAccountants($request->user()->email . ' marked product with UUID: ' . $product->product_uuid . ' as sold.');

    DB::commit();

    if ($request->isApi()) return response()->json([], 204);
    return back()->withSuccess('Product has been marked as sold. It will no longer be available in stock');
  }

  /**
   * !This belongs to accountants only
   * @param Product $product The product to mark as sold
   */
  public function confirmProductSale(Request $request, self $product)
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

    $product_sales_record = $product->product_sales_record;

    /**
     * Check if the product has been marked as sold.
     * @throws JsonResponse
     */
    if (is_null($product_sales_record)) {
      return generate_422_error('This product has not being sold');
    }

    $status_id = ProductStatus::saleConfirmedId();

    if ($product->product_status_id === $status_id) {
      return generate_422_error('This product has being confirmed sold already');
    }
    DB::beginTransaction();

    /**
     * Update the product's status to confirmed sold
     */
    $product->product_status_id = $status_id;
    $product->save();

    /**
     * Mark the product's sales record as confirmed
     */
    $product_sales_record->sale_confirmed_by = $request->user()->id;
    $product_sales_record->sale_confirmer_type = get_class($request->user());
    $product_sales_record->save();

    /**
     * Record the bank account payments breakdown for this transaction
     */
    $product_sales_record->bank_account_payments()->sync($paymentRecords);

    /**
     * add an entry for the product trail that it's status changed in the static updating boot method
     */


    /**
     * // generate the receipt and save it in the DB.
     * ? This is so that even if the user should change his details in the future,
     * ? this receipt will still carry this his current records
     */
    try {
      $receipt = $product->generate_receipt();
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
      ErrLog::notifyAdmin($request->user(), $th, 'Failed to send receipt to user', $product->app_user->email);
      // if ($request->isApi()) return response()->json(['err' => 'Failed to send receipt to user ' . $product->app_user->emai], 500);
      // return back()->withError('Failed to send receipt to user  ' . $product->app_user->emai);
    }


    /**
     * Notify Admin that a product was sold
     */
    ActivityLog::notifySuperAdmins($request->user()->email . ' marked product with ' . $product->primary_identifier() . ' as confirmed sold.');

    /**
     * Notify Accountant that a product was marked as sold
     */
    ActivityLog::notifyAccountants($request->user()->email . ' marked product with ' . $product->primary_identifier() . ' as confirmed sold.');

    DB::commit();


    Cache::forget($product->office_branch->city . 'officeBranchProducts');
    Cache::forget('products');

    if ($request->isApi()) return response()->json([], 204);
    return back()->withSuccess('Product has been marked as sold. It will no longer be available in stock');
  }

  public function commentOnProduct(CreateProductCommentValidation $request, self $product)
  {
    $comment =  $request->user()->comments()->create([
      'subject_id' => $product->id,
      'subject_type' => get_class($product),
      'comment' => $request->comment
    ]);

    if ($request->isApi()) return response()->json($comment, 201);
    return back()->withSuccess('Comment created. ');
  }

  public function getApplicableProductQATests(Request $request, self $product)
  {
    return response()->json((new QATestTransformer)->collectionTransformer($product->product_model->qa_tests, 'basic'), 200);
  }

  public function getProductQATestResults(Request $request, self $product)
  {
    $productQATestResults = fn () => (new ProductTransformer)->transformWithTestResults($product->load('qa_tests', 'product_model.qa_tests'));
    $productQATestResultsComments = fn () => (new UserCommentTransformer)->collectionTransformer($product->test_result_comments, 'detailed');
    $productStatuses = Cache::rememberForever('productStatuses', fn () => (new ProductStatusTransformer)->collectionTransformer(ProductStatus::notSaleStatus()->get(), 'basic'));

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
    return back()->withSuccess('Updated Test Results');
  }

  public function commentOnProductQATestResults(CreateProductCommentValidation $request, self $product)
  {
    $comment =  $request->user()->comments()->create([
      'subject_id' => $product->id,
      'subject_type' => get_class($product),
      'comment' => 'Test Result: ' . $request->comment
    ]);

    if ($request->isApi()) return response()->json((new UserCommentTransformer)->detailed($comment), 201);
    return back()->withSuccess('Product created');
  }

  public function scopeInStock($query)
  {
    return $query->where('product_status_id', ProductStatus::inStockId());
  }

  public function scopeJustArrived($query)
  {
    return $query->where('product_status_id', ProductStatus::justArrivedId());
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
