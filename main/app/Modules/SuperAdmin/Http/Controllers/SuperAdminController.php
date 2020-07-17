<?php

namespace App\Modules\SuperAdmin\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Modules\Admin\Models\Admin;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\QATest;
use App\Modules\SuperAdmin\Models\OtherExpense;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\Reseller;
use App\Modules\SuperAdmin\Models\SwapDeal;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\SuperAdmin\Models\StorageSize;
use App\Modules\SuperAdmin\Models\StorageType;
use App\Modules\SuperAdmin\Models\UserComment;
use App\Modules\SuperAdmin\Models\OfficeBranch;
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
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\SuperAdmin\Models\CompanyBankAccount;
use App\Modules\SuperAdmin\Models\ProductQATestResult;
use App\Modules\SuperAdmin\Models\ProductDescriptionSummary;
use App\Modules\AppUser\Http\Controllers\Auth\LoginController;

class SuperAdminController extends Controller
{

  public function __construct()
  {
    Inertia::setRootView('superadmin::app');
  }

  static function routes()
  {
    Route::group(['middleware' => ['web', 'auth:super_admin'], 'prefix' => SuperAdmin::DASHBOARD_ROUTE_PREFIX], function () {

      Route::get('/', [self::class, 'index'])->name('superadmin.dashboard')->defaults('ex', __e('ss,a', 'home'));

      AppUser::routes();

      Product::routes();

      ProductPrice::routes();

      ProductModel::routes();

      ProductBrand::routes();

      ProductSupplier::routes();

      ProductColor::routes();

      ProductCategory::routes();

      ProductQATestResult::routes();

      ProcessorSpeed::routes();

      ProductGrade::routes();

      StorageSize::routes();

      StorageType::routes();

      ProductStatus::routes();

      ProductBatch::routes();

      ProductHistory::routes();

      ProductExpense::routes();

      ProductSaleRecord::routes();

      ProductDescriptionSummary::routes();

      UserComment::routes();

      Reseller::routes();

      QATest::routes();

      SalesChannel::routes();

      SwapDeal::routes();

      CompanyBankAccount::routes();

      OfficeBranch::routes();

      OtherExpense::routes();

      ErrLog::routes();
    });
  }

  public function index(Request $request)
  {
    return Inertia::render('SuperAdminDashboard', $this->getDashboardStatistics())->withViewData([
      'title' => 'Hello theEects',
      'metaDesc' => ' This page is ...'
    ]);
  }

  protected function getDashboardStatistics()
  {
    // return ProductSaleRecord::with('product.product_price')->today()->get();

    $sales_record_today = ProductSaleRecord::with('product.product_price')->today()->get();
    $stock_sales_records = $sales_record_today->where('product.product_batch_id', '<>', ProductBatch::local_supplied_id());
    $local_supplier_sales_records = $sales_record_today->where('product.product_batch_id', ProductBatch::local_supplied_id());

    $payments_breakdown = CompanyBankAccount::with(['sales_records' => function ($query) {
      $query->today();
    }])->get()->groupBy('bank')->map(function ($value, $key) {
      return $value[0]->sales_records->sum('payment_record.amount');
    });

    $total_cost_price = $sales_record_today->sum('product.product_price.cost_price');
    $total_cash_payments = $payments_breakdown->only('Cash')->sum();
    $total_bank_payments = $payments_breakdown->except('Cash')->sum();
    $total_local_supplier_sales = $local_supplier_sales_records->sum('selling_price');
    $total_stock_sales = $stock_sales_records->sum('selling_price');

    return [
      'total_daily_sale_count' => $sales_record_today->count(),
      'total_daily_confirmed_sale_count' => $sales_record_today->where('sale_confirmed_by', '<>', null)->count(),
      'total_daily_unconfirmed_sale_count' => $sales_record_today->where('sale_confirmed_by', null)->count(),
      'total_daily_sales_selling_price' => $sales_record_today->sum('selling_price'),
      'total_daily_confirmed_sale_amount' => $sales_record_today->where('sale_confirmed_by', '<>', null)->sum('selling_price'),
      'total_daily_unconfirmed_sale_amount' => $sales_record_today->where('sale_confirmed_by', null)->sum('selling_price'),
      'total_bank_payments' => $total_bank_payments,
      'total_cash_payments' => $total_cash_payments,
      'total_daily_sales_cost_price' => $total_cost_price,
      'total_daily_sales_stock' => $total_stock_sales,
      'total_daily_sales_local_suppliers' => $total_local_supplier_sales,
      'total_daily_profit' => '',
      'total_daily_expenses' => '',
      'total_daily_repairs_cost' => '',
      'total_swap_deals_value' => '',
      'total_direct_swap_cost' => 'swap deals without a swapped_with',
      'total_local_purchases' => 'products without local batch id',
      'balance_after_deductions' => 'bank cash minus expenses, swap deals value, direct swap cost, local_purchases',
      'payments_breakdown' => collect($payments_breakdown)->merge(['total' => $payments_breakdown->sum()]),
    ];
  }
}
