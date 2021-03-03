<?php

namespace App\Modules\SuperAdmin\Models;

use App\BaseModel;
use Inertia\Inertia;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Modules\Auditor\Models\Auditor;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\SalesChannel;
use App\Modules\SuperAdmin\Models\ProductExpense;
use App\Modules\SuperAdmin\Models\ProductHistory;
use App\Modules\SuperAdmin\Models\ResellerHistory;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SalesRep\Transformers\SalesRepTransformer;
use App\Modules\SuperAdmin\Transformers\OfficeBranchTransformer;
use App\Modules\SuperAdmin\Transformers\SalesChannelTransformer;

/**
 * App\Modules\SuperAdmin\Models\OfficeBranch
 *
 * @property int $id
 * @property string $city
 * @property string $country
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Auditor[] $auditors
 * @property-read int|null $auditors_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductExpense[] $product_expenses
 * @property-read int|null $product_expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductHistory[] $product_histories
 * @property-read int|null $product_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ResellerHistory[] $reseller_histories
 * @property-read int|null $reseller_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductSaleRecord[] $sales_records
 * @property-read int|null $sales_records_count
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeBranch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeBranch newQuery()
 * @method static \Illuminate\Database\Query\Builder|OfficeBranch onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeBranch query()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeBranch whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeBranch whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeBranch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeBranch whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeBranch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficeBranch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|OfficeBranch withTrashed()
 * @method static \Illuminate\Database\Query\Builder|OfficeBranch withoutTrashed()
 * @mixin \Eloquent
 */
class OfficeBranch extends BaseModel
{
  use SoftDeletes;

  protected $fillable = ['city', 'country'];

  public function auditors()
  {
    return $this->hasMany(Auditor::class);
  }

  public function products()
  {
    return $this->hasMany(Product::class);
  }

  public function product_sales_records()
  {
    return $this->hasMany(ProductSaleRecord::class);
  }

  // public function sales_reps()
  // {
  //   return $this->hasMany(SalesRep::class);
  // }

  // public function accountants()
  // {
  //   return $this->hasMany(Accountant::class);
  // }


  public function product_expenses()
  {
    return $this->hasManyThrough(ProductExpense::class, Product::class);
  }

  public function product_histories()
  {
    return $this->hasManyThrough(ProductHistory::class, Product::class);
  }

  public function reseller_histories()
  {
    return $this->hasManyThrough(ResellerHistory::class, Product::class);
  }

  public function sales_records()
  {
    return $this->hasManyThrough(ProductSaleRecord::class, Product::class);
  }

  public function staff()
  {
    return [
      'auditors' => (new AuditorUserTransformer)->collectionTransformer($this->auditors, 'basic'),
      'sales_reps' => (new AuditorUserTransformer)->collectionTransformer($this->sales_reps, 'basic'),
      'accountants' => (new AuditorUserTransformer)->collectionTransformer($this->accountants, 'basic'),
    ];
  }

  public function staff_activities()
  {
    return [
      'auditors' => (new AuditorUserTransformer)->collectionTransformer($this->auditors, 'transformWithActivity'),
      'sales_reps' => (new AuditorUserTransformer)->collectionTransformer($this->sales_reps, 'transformWithActivity'),
      'accountants' => (new AuditorUserTransformer)->collectionTransformer($this->accountants, 'transformWithActivity'),
    ];
  }

  static function head_office_id(): int
  {
    return self::where('city', 'Lagos')->first()->id;
  }

  public static function superAdminRoutes()
  {
    Route::name('office_branches.')->prefix('office-branches')->group(function () {
      Route::get('', [self::class, 'getOfficeBranches'])->name('branches')->defaults('ex', __e('ss,a', 'trello', false));
      Route::post('create', [self::class, 'createOfficeBranch'])->name('create');
      Route::put('{officeBranch}/edit', [self::class, 'editOfficeBranch'])->name('edit');
      Route::get('{officeBranch}/products', [self::class, 'getProductsInBranch'])->name('view_products')->defaults('ex', __e('ss,a', 'trello', true));
      Route::get('{officeBranch}/product-expenses', [self::class, 'getBranchProductExpenses'])->name('prod_expenses')->defaults('ex', __e('ss,a', 'trello', true));
      Route::get('{officeBranch}/product-histories', [self::class, 'getBranchProductHistories'])->name('prod_histories')->defaults('ex', __e('ss,a', 'trello', true));
      Route::get('{officeBranch}/reseller-histories', [self::class, 'getBranchResellerHistories'])->name('res_histories')->defaults('ex', __e('ss,a', 'trello', true));
      Route::get('{officeBranch}/products-with-resellers', [self::class, 'getBranchProductWithResellers'])->name('res_prod')->defaults('ex', __e('ss,a', 'trello', true));
      Route::get('{officeBranch}/sales-records', [self::class, 'getBranchSalesRecords'])->name('sales_records')->defaults('ex', __e('ss,a', 'trello', true));
      Route::get('{officeBranch}/staff', [self::class, 'getStaffFromBranch'])->name('view_staff')->defaults('ex', __e('ss,a', 'trello', true));
      Route::get('{officeBranch}/staff/departments', [self::class, 'getStaffFromBranchByDept'])->name('staff_by_depts')->defaults('ex', __e('ss,a', 'trello', true));
      Route::get('{officeBranch}/staff/activities', [self::class, 'getStaffActivitiesFromBranch'])->name('staff_acts')->defaults('ex', __e('ss,a', 'trello', true));
      Route::get('{officeBranch}/sales-records', [self::class, 'getBranchSalesRecords'])->name('sales_records')->defaults('ex', __e('ss,a', 'trello', true));
    });
  }

  public function getOfficeBranches(Request $request)
  {
    $officeBranches = Cache::rememberForever('officeBranches', function () {
      return (new OfficeBranchTransformer)->collectionTransformer(self::withCount(['products', 'product_sales_records', 'product_sales_records as today_sales_count' => fn ($query) => $query->today()])->get(), 'basic');
    });

    if ($request->isApi())  return response()->json($officeBranches, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/ManageOfficeBranches', compact('officeBranches'));
  }

  public function createOfficeBranch(Request $request)
  {

    if (!$request->country || !$request->city) return generate_422_error('A name and city for this branch is required');
    if (self::where('city', $request->city)->where('country', $request->country)->exists()) return generate_422_error('This branch exists already');

    try {
      $account = self::create([
        'city' => $request->city,
        'country' => $request->country,
      ]);

      Cache::forget('officeBranches');

      if ($request->isApi()) return response()->json((new OfficeBranchTransformer)->basic($account), 201);
      return back()->withFlash(['success'=>'Office branch created.']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Office Branch not created');

      if ($request->isApi()) return response()->json(['err' => 'Office Branch not created'], 500);
      return back()->withFlash(['error'=>['Office Branch creation failed']]);
    }
  }

  public function editOfficeBranch(Request $request, self $officeBranch)
  {

    if (!$request->country || !$request->city) return generate_422_error('A name and city for this branch is required');
    if (self::where('city', $request->city)->where('country', $request->country)->exists()) return generate_422_error('This branch exists already');

    try {

      $officeBranch->city = $request->city;
      $officeBranch->country = $request->country;

      $officeBranch->save();

      Cache::forget('officeBranches');

      if ($request->isApi()) return response()->json([], 204);
      return back()->withFlash(['success'=>'Office branch updated']);
    } catch (\Throwable $th) {
      ErrLog::notifyAuditor($request->user(), $th, 'Branch details NOT updated');

      if ($request->isApi()) return response()->json(['err' => 'Branch details NOT updated'], 500);
      return back()->withFlash(['error'=>['Branch update failed']]);
    }
  }

  public function getProductsInBranch(Request $request, self $officeBranch)
  {
    $officeBranch = Cache::rememberForever($officeBranch->city . 'officeBranchProducts', function () use ($officeBranch) {
      return (new OfficeBranchTransformer)->transformWithProducts($officeBranch->load(['products' => fn($query) => $query->inStock(), 'products.product_model', 'products.product_color', 'products.storage_size', 'products.product_status', 'products.product_supplier', 'products.product_expenses_amount', 'products.product_price']));
    });
    $onlineReps = Cache::rememberForever('onlineReps', function () {
      return (new SalesRepTransformer)->collectionTransformer(SalesRep::onlineReps()->get(), 'transformBasic');
    });

    $salesChannel = Cache::rememberForever('salesChannel', function () {
      return (new SalesChannelTransformer)->collectionTransformer(SalesChannel::all(), 'basic');
    });

    if ($request->isApi()) return response()->json($officeBranch, 200);
    return Inertia::render('SuperAdmin,Miscellaneous/ManageOfficeBranchProducts', compact('officeBranch', 'onlineReps', 'salesChannel'));
  }

  public function getBranchProductExpenses(self $office_branch)
  {
    return response()->json((new OfficeBranchTransformer)->transformWithProductExpenses($office_branch->load('product_expenses')), 200);
  }

  public function getBranchProductHistories(self $office_branch)
  {
    return response()->json((new OfficeBranchTransformer)->transformWithProductHistories($office_branch->load('product_histories')), 200);
  }

  public function getBranchResellerHistories(self $office_branch)
  {
    return response()->json((new OfficeBranchTransformer)->transformWithResellerHistories($office_branch->load('reseller_histories')), 200);
  }

  public function getBranchProductWithResellers(self $office_branch)
  {
    $results = $office_branch->load(['products' => function ($query) {
      $query->has('with_resellers')->with('with_resellers');
    }]);
    return response()->json((new OfficeBranchTransformer)->transformWithResellerAndProducts($results), 200);
  }

  public function getBranchSalesRecords(Request $request, self $officeBranch)
  {
    $branchSalesRecords = $officeBranch->load(['sales_records' => function ($query) {
      $query->with(
        'product:id,product_model_id,imei,serial_no,model_no,product_supplier_id,product_uuid',
        'product.product_supplier',
        'product.product_price',
        'product.product_model:id,name',
        'sales_rep:id,full_name,email',
        'online_rep:id,full_name,email',
        'sale_confirmer:id,full_name,email',
        'sales_channel:id,channel_name',
        'bank_account_payments'
      );
    }]);

    if ($request->isApi()) return response()->json((new OfficeBranchTransformer)->transformWithSalesRecords($branchSalesRecords), 200);
    return Inertia::render('SuperAdmin,Miscellaneous/BranchSalesRecords', [
      'branchSalesRecords' => (new OfficeBranchTransformer)->transformWithSalesRecords($branchSalesRecords)
    ]);
  }

  public function getStaffActivitiesFromBranch(self $office_branch)
  {
    return response()->json(Arr::collapse($office_branch->staff_activities()), 200);
  }

  public function getStaffFromBranch(self $office_branch)
  {
    return Arr::collapse($office_branch->staff());
  }

  public function getStaffFromBranchByDept(self $office_branch)
  {
    return $office_branch->staff();
  }
}
