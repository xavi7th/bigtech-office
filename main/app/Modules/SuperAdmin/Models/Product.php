<?php

namespace App\Modules\SuperAdmin\Models;

use Cache;
use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Awobaz\Compoships\Compoships;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use Illuminate\Database\Eloquent\Model;
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
use App\Modules\SuperAdmin\Models\ProductBatch;
use App\Modules\SuperAdmin\Models\ProductBrand;
use App\Modules\SuperAdmin\Models\ProductColor;
use App\Modules\SuperAdmin\Models\ProductGrade;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\SuperAdmin\Models\ProductPrice;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Models\ProcessorSpeed;
use App\Modules\SuperAdmin\Models\ProductExpense;
use App\Modules\SuperAdmin\Models\ProductHistory;
use App\Modules\SuperAdmin\Models\ProductCategory;
use App\Modules\SuperAdmin\Models\ProductSupplier;
use App\Modules\SuperAdmin\Models\ResellerHistory;
use App\Modules\SuperAdmin\Models\ResellerProduct;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SuperAdmin\Transformers\QATestTransformer;
use App\Modules\SuperAdmin\Transformers\ProductTransformer;
use App\Modules\SuperAdmin\Transformers\UserCommentTransformer;
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
    return $this->hasMany(ProductHistory::class);
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
    return $this->hasMany(ProductExpense::class);
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
    return $this->product_status_id === ProductStatus::sold_id() || $this->product_status_id === ProductStatus::sale_confirmed_id();
  }

  public function in_stock(): bool
  {
    /**
     * Check if the product has been sold already or confirmed
     */
    return $this->product_status_id === ProductStatus::in_stock();
  }

  public function with_reseller(): bool
  {
    return $this->product_status_id === ProductStatus::with_reseller();
  }

  public function getCostPriceAttribute()
  {
    return is_numeric($this->product_price->cost_price) ?
      to_naira($this->total_product_expenses() + (float)$this->product_price->cost_price) : $this->product_price->cost_price;
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
      Route::put('{product:product_uuid}/confirm-sale', [self::class, 'confirmProductSale'])->name($p('confirm_sale'))->defaults('ex', __e('ss', null, true));
      Route::put('{product}/status', [self::class, 'updateProductStatus'])->name($p('update_product_status'))->defaults('ex', __e('ss', null, true));
      Route::post('{product:product_uuid}/comment', [self::class, 'commentOnProduct'])->name($p('comment_on_product'))->defaults('ex', __e('ss', null, true));
      Route::get('{product}/qa-tests', [self::class, 'getApplicableProductQATests'])->name($p('applicable_qa_tests'))->defaults('ex', __e('ss', null, true));
      Route::get('{product}/qa-tests/comments', [self::class, 'getCommentsOnProductQATestResults'])->name($p('qa_test_comments'))->defaults('ex', __e('ss', null, true));
      Route::post('{product}/qa-tests/comment', [self::class, 'commentOnProductQATestResults'])->name($p('comment_on_qa_test'))->defaults('ex', __e('ss', null, true));
      Route::get('{product}/qa-test-results', [self::class, 'getProductQATestResults'])->name($p('qa_test_results'))->defaults('ex', __e('ss', null, true));
      Route::put('{product}/qa-test-results', [self::class, 'updateProductQATestResults'])->name($p('update_qa_result'))->defaults('ex', __e('ss', null, true));
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
    // $price = ProductPrice::find(1);
    // dd($price->products->toArray());
    if ($request->isApi()) {
      return  response()->json((new ProductTransformer)->collectionTransformer(self::all(), 'basic'), 200);
    } else {
      return Inertia::render('SuperAdmin,Products/ListProducts');
    }
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
    $aggregatedOtherExpenseRecords = OtherExpense::addSelect(DB::raw('COUNT(created_at) as num_of_other_expenses,DATE(created_at) as day'))->groupBy('day')->latest('day')->get()->each->setAppends([]);
    return Inertia::render('SuperAdmin,Products/DailyRecords', compact('aggregatedSalesRecords', 'aggregatedProductExpenseRecords', 'aggregatedOtherExpenseRecords'));
  }

  public function getProductsWithResellers(Request $request)
  {
    $productsWithResellers = (new ProductTransformer)->collectionTransformer(self::has('with_resellers')->with('with_resellers')->get(), 'transformWithResellerDetails');
    if ($request->isApi()) {
      return response()->json($productsWithResellers, 200);
    }
    return Inertia::render('SuperAdmin,Products/ProductsWithResellers', compact('productsWithResellers'));
  }

  public function showCreateProductForm()
  {
    return Inertia::render('SuperAdmin,Products/CreateProduct');
  }

  public function createProduct(CreateProductValidation $request)
  {
    try {
      $product = self::create(collect($request->validated())->merge([
        'stocked_by' => auth()->id(),
        'stocker_type' => get_class(auth()->user()),
        'office_branch_id' => OfficeBranch::head_office_id()
      ])->all());

      if ($request->isApi()) {
        return response()->json($product, 201);
      } else {
        return back()->withSuccess('Product created');
      }
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin($request->user(), $th, 'Product not created');
      return response()->json(['err' => 'Product not created'], 500);
    }
  }

  public function showCreateLocalProductForm()
  {
    return Inertia::render('SuperAdmin,Products/CreateLocalProduct');
  }

  public function createLocalSupplierProduct(CreateLocalSupplierProductValidation $request)
  {
    DB::beginTransaction();
    try {
      /**
       * Create the product with predefined batch_num
       */

      $product = self::create(collect($request->validated())->merge([
        'stocked_by' => auth()->id(),
        'stocker_type' => get_class(auth()->user()),
        'office_branch_id' => OfficeBranch::head_office_id(),
        'product_batch_id' => $local_supplier_id = ProductBatch::local_supplied_id()
      ])->all());


      /**
       * create the product price record
       */

      ProductPrice::create(collect($request->validated())->merge([
        'product_batch_id' => $local_supplier_id
      ])->all());

      DB::commit();

      return response()->json($product, 201);
    } catch (\Throwable $th) {
      ErrLog::notifyAdminAndFail($request->user(), $th, 'Product not created');
      return response()->json(['err' => 'Product not created'], 500);
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

  public function updateProductStatus(Request $request, self $product)
  {
    DB::beginTransaction();

    $product_status = ProductStatus::find($request->product_status_id);
    if (is_null($product_status)) {
      return generate_422_error('Invalid product status selected');
    }
    //notify admin that someone updated a product status
    ActivityLog::notifySuperAdmins($request->user()->email . ' changed product with ' . $product->primary_identifier() . ' to status:  "' . $product_status->status . '"');

    /**
     * Update the status
     */
    if ($product_status->id === ProductStatus::sold_id()) {
      return generate_422_error('Mark this product as sold instead');
    } elseif ($product_status->id === ProductStatus::sale_confirmed_id()) {
      return generate_422_error('Confirm this product as sold instead');
    } else {
      $product->product_status_id = $request->product_status_id;
      $product->save();
    }

    DB::commit();
    return response()->json([], 204);
  }

  public function markProductAsSold(MarkProductAsSoldValidation $request, self $product)
  {

    DB::beginTransaction();

    /**
     * Update product status to sold
     */
    $product->product_status_id = $status_id = ProductStatus::sold_id();

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
      SwapDeal::create_swap_record((object)collect($request->validated())->merge(['app_user_id' => $app_user->id])->all(), $id_url, $receipt_url);
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

    Cache::forget('officeBranchProducts');
    Cache::forget('products');

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

    $status_id = ProductStatus::sale_confirmed_id();

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


    Cache::forget('officeBranchProducts');
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

  public function getProductQATestResults(Request $request, Product $product)
  {
    $productQATestResults = (new ProductTransformer)->transformWithTestResults($product->load('qa_tests', 'product_model.qa_tests'));

    if ($request->isApi()) {
      return response()->json($productQATestResults, 200);
    }
    return Inertia::render('SuperAdmin,Products/QATestResults', [
      'details' => $productQATestResults
    ]);
  }

  public function updateProductQATestResults(Request $request, self $product)
  {
    // dd($request->all());
    if (!$request->qa_test_results) {
      return generate_422_error('Specify valid QA tests results');
    }

    $tests = $product->qa_tests()->sync($request->qa_test_results);

    return response()->json($tests, 201);
  }

  public function getCommentsOnProductQATestResults(self $product)
  {
    return response()->json((new UserCommentTransformer)->collectionTransformer($product->test_result_comments, 'detailed'), 200);
  }

  public function commentOnProductQATestResults(CreateProductCommentValidation $request, self $product)
  {
    $comment =  $request->user()->comments()->create([
      'subject_id' => $product->id,
      'subject_type' => get_class($product),
      'comment' => 'Test Result: ' . $request->comment
    ]);

    return response()->json((new UserCommentTransformer)->detailed($comment), 201);
  }

  protected static function boot()
  {
    parent::boot();

    static::creating(function ($product) {
      $product->product_uuid = (string)Str::uuid();
    });

    // static::retrieved(function ($product) {
    // 	$product->load('product_price');
    // });

    static::updating(function ($product) {

      // dump($product->getOriginal());
      // dd($product->toArray());

      /**
       * add an entry for the product trail that it's status changed
       */
      request()->user()->product_histories()->create([
        'product_id' => $product->id,
        'product_status_id' => $product->product_status_id,
      ]);
    });
  }
}
