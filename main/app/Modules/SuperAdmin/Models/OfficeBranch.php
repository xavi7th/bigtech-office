<?php

namespace App\Modules\SuperAdmin\Models;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Modules\Admin\Models\Admin;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Model;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\SuperAdmin\Models\ProductExpense;
use App\Modules\SuperAdmin\Models\ProductHistory;
use App\Modules\SuperAdmin\Models\ResellerHistory;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SuperAdmin\Transformers\AdminUserTransformer;
use App\Modules\SuperAdmin\Transformers\OfficeBranchTransformer;

/**
 * App\Modules\SuperAdmin\Models\OfficeBranch
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\Admin\Models\Admin[] $admins
 * @property-read int|null $admins_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ProductExpense[] $product_expenses
 * @property-read int|null $product_expenses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ProductHistory[] $product_histories
 * @property-read int|null $product_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ResellerHistory[] $reseller_histories
 * @property-read int|null $reseller_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\SuperAdmin\Models\ProductSaleRecord[] $sales_records
 * @property-read int|null $sales_records_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\OfficeBranch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\OfficeBranch newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\OfficeBranch onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\OfficeBranch query()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\OfficeBranch withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\SuperAdmin\Models\OfficeBranch withoutTrashed()
 * @mixin \Eloquent
 * @property int $id
 * @property string $city
 * @property string $country
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\OfficeBranch whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\OfficeBranch whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\OfficeBranch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\OfficeBranch whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\OfficeBranch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\SuperAdmin\Models\OfficeBranch whereUpdatedAt($value)
 */
class OfficeBranch extends Model
{
  use SoftDeletes;

  /**
   * Duration in seconds to cache all queries from this model
   *
   * @var $rememberFor
   */
  protected $rememberFor = 5;
  protected $fillable = ['city', 'country'];


  public function admins()
  {
    return $this->hasMany(Admin::class);
  }

  public function products()
  {
    return $this->hasMany(Product::class);
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
      'admins' => (new AdminUserTransformer)->collectionTransformer($this->admins, 'basic'),
      'sales_reps' => (new AdminUserTransformer)->collectionTransformer($this->sales_reps, 'basic'),
      'accountants' => (new AdminUserTransformer)->collectionTransformer($this->accountants, 'basic'),
    ];
  }

  public function staff_activities()
  {
    return [
      'admins' => (new AdminUserTransformer)->collectionTransformer($this->admins, 'transformWithActivity'),
      'sales_reps' => (new AdminUserTransformer)->collectionTransformer($this->sales_reps, 'transformWithActivity'),
      'accountants' => (new AdminUserTransformer)->collectionTransformer($this->accountants, 'transformWithActivity'),
    ];
  }

  static function head_office_id(): int
  {
    return self::where('city', 'Lagos')->first()->id;
  }

  public static function routes()
  {
    Route::group(['prefix' => 'office-branches', 'namespace' => '\App\Modules\Admin\Models'], function () {

      $others = function ($name) {
        return 'superadmin.miscellaneous.' . $name;
      };

      Route::get('', [self::class, 'getOfficeBranches'])->name($others('office_branches'))->defaults('ex', __e('ss', 'trello', false));
      Route::post('create', [self::class, 'createOfficeBranch'])->name($others('office_branches.create_office_branch'))->defaults('ex', __e('ss', 'trello', true));
      Route::put('{branch}/edit', [self::class, 'editOfficeBranch'])->name($others('office_branches.edit_office_branch'))->defaults('ex', __e('ss', 'trello', true));
      Route::get('{branch}/products', [self::class, 'getProductsInBranch'])->name($others('office_branches.view_products'))->defaults('ex', __e('ss', 'trello', true));
      Route::get('{branch}/product-expenses', [self::class, 'getBranchProductExpenses'])->name($others('office_branches.prod_expenses'))->defaults('ex', __e('ss', 'trello', true));
      Route::get('{branch}/product-histories', [self::class, 'getBranchProductHistories'])->name($others('office_branches.prod_histories'))->defaults('ex', __e('ss', 'trello', true));
      Route::get('{branch}/reseller-histories', [self::class, 'getBranchResellerHistories'])->name($others('office_branches.res_histories'))->defaults('ex', __e('ss', 'trello', true));
      Route::get('{branch}/products-with-resellers', [self::class, 'getBranchProductWithResellers'])->name($others('office_branches.res_prod'))->defaults('ex', __e('ss', 'trello', true));
      Route::get('{branch}/sales-records', [self::class, 'getBranchSalesRecords'])->name($others('office_branches.sales_records'))->defaults('ex', __e('ss', 'trello', true));
      Route::get('{branch}/staff', [self::class, 'getStaffFromBranch'])->name($others('office_branches.view_staff'))->defaults('ex', __e('ss', 'trello', true));
      Route::get('{branch}/staff/departments', [self::class, 'getStaffFromBranchByDept'])->name($others('office_branches.staff_by_depts'))->defaults('ex', __e('ss', 'trello', true));
      Route::get('{branch}/staff/activities', [self::class, 'getStaffActivitiesFromBranch'])->name($others('office_branches.staff_acts'))->defaults('ex', __e('ss', 'trello', true));
    });
  }

  public function getOfficeBranches()
  {
    return response()->json((new OfficeBranchTransformer)->collectionTransformer(self::all(), 'basic'), 200);
  }

  public function getProductsInBranch(self $office_branch)
  {
    return response()->json((new OfficeBranchTransformer)->transformWithProducts($office_branch->load('products')), 200);
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

  public function getBranchSalesRecords(self $office_branch)
  {
    $results = $office_branch->load(['sales_records' => function ($query) {
      $query->with(
        'product:id,product_model_id,imei,serial_no,model_no',
        'product.product_price',
        'product.product_model:id,name',
        'sales_rep:id,full_name,email',
        'online_rep:id,full_name,email',
        'sale_confirmer:id,full_name,email',
        'sales_channel:id,channel_name',
        'bank_account_payments'
      );
    }]);
    return response()->json((new OfficeBranchTransformer)->transformWithSalesRecords($results), 200);
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

  public function createOfficeBranch(Request $request)
  {
    try {
      $account = self::create([
        'city' => $request->city,
        'country' => $request->country,
      ]);

      return response()->json((new OfficeBranchTransformer)->basic($account), 201);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Office Branch not created');
      return response()->json(['err' => 'Office Branch not created'], 500);
    }
  }

  public function editOfficeBranch(Request $request, self $office_branch)
  {
    // return $request;
    try {
      foreach ($request->all() as $key => $value) {
        $office_branch->$key = $value;
      }

      $office_branch->save();

      return response()->json([], 204);
    } catch (\Throwable $th) {
      ErrLog::notifyAdmin(auth(auth()->getDefaultDriver())->user(), $th, 'Branch details NOT updated');
      return response()->json(['err' => 'Branch details NOT updated'], 500);
    }
  }
}
