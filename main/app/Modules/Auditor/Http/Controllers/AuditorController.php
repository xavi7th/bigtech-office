<?php

namespace App\Modules\Auditor\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RachidLaasri\Travel\Travel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\Auditor\Models\Auditor;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\SuperAdmin\Models\ErrLog;
use App\Modules\SuperAdmin\Models\QATest;
use App\Modules\WebAdmin\Models\WebAdmin;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\Reseller;
use App\Modules\SuperAdmin\Models\SwapDeal;
use App\Modules\Accountant\Models\Accountant;
use App\Modules\SuperAdmin\Models\StorageSize;
use App\Modules\SuperAdmin\Models\StorageType;
use App\Modules\SuperAdmin\Models\UserComment;
use App\Modules\SuperAdmin\Models\OfficeBranch;
use App\Modules\SuperAdmin\Models\OtherExpense;
use App\Modules\SuperAdmin\Models\ProductBatch;
use App\Modules\SuperAdmin\Models\ProductBrand;
use App\Modules\SuperAdmin\Models\ProductColor;
use App\Modules\SuperAdmin\Models\ProductGrade;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\SuperAdmin\Models\SalesChannel;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Models\ProcessorSpeed;
use App\Modules\SuperAdmin\Models\ProductExpense;
use App\Modules\SuperAdmin\Models\ProductHistory;
use App\Modules\SuperAdmin\Models\ProductCategory;
use App\Modules\SuperAdmin\Models\ProductSupplier;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\QualityControl\Models\QualityControl;
use App\Modules\SuperAdmin\Models\CompanyBankAccount;
use App\Modules\SuperAdmin\Models\SalesRecordBankAccount;
use App\Modules\SuperAdmin\Models\ProductDescriptionSummary;

class AuditorController extends Controller
{
  static function routes()
  {
    Route::group(['middleware' => ['web']], function () {
      Route::prefix(Auditor::DASHBOARD_ROUTE_PREFIX)->group(function () {
        Route::name('auditor.')->middleware('auth:auditor')->group(function () {
          Route::get('/', [self::class, 'index'])->name('dashboard')->defaults('ex', __e('a', 'home', true));

          SalesRep::superAdminRoutes();
          Accountant::superAdminRoutes();
          QualityControl::superAdminRoutes();
          WebAdmin::superAdminRoutes();
          AppUser::superAdminRoutes();
          ProductSaleRecord::superAdminRoutes();
          ProductSupplier::superAdminRoutes();
          ProductStatus::superAdminRoutes();
          Reseller::superAdminRoutes();
          UserComment::superAdminRoutes();
          CompanyBankAccount::superAdminRoutes();
          OfficeBranch::superAdminRoutes();
          ErrLog::superAdminRoutes();
        });

        Route::name('auditor.')->group(function () {
          Product::multiAccessRoutes();
          ProductHistory::multiAccessRoutes();
          ProductBatch::multiAccessRoutes();
          ProductModel::multiAccessRoutes();
          ProductBrand::multiAccessRoutes();
          SwapDeal::multiAccessRoutes();
          Reseller::multiAccessRoutes();
          ProductColor::multiAccessRoutes();
          ProductGrade::multiAccessRoutes();
          ProductCategory::multiAccessRoutes();
          ProductStatus::multiAccessRoutes();
          SalesChannel::multiAccessRoutes();
          QATest::multiAccessRoutes();
          ProcessorSpeed::multiAccessRoutes();
          StorageSize::multiAccessRoutes();
          StorageType::multiAccessRoutes();
          OtherExpense::multiAccessRoutes();
          ProductDescriptionSummary::multiAccessRoutes();
        });
      });
    });
  }


  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    return Inertia::render('Auditor,AuditorDashboard', $this->getDashboardStatistics())->withViewData([
      'title' => 'Hello theEects',
      'metaDesc' => ' This page is ...'
    ]);
  }


  protected function getDashboardStatistics()
  {
    // Travel::to('- 13 days');

    $sales_record_today = ProductSaleRecord::with('product.product_price')->today()->get();
    $most_recent_sales = ProductSaleRecord::with('product.product_model', 'sales_rep')->today()->latest('id')->take(5)->get()->transform(fn ($record) => ['desc' => $record->product->shortDescription(), 'uuid' => $record->product->product_uuid, 'sales_rep' => $record->sales_rep->full_name]);
    $daily_expenses_list = OtherExpense::today()->get();
    $sales_record_this_month = ProductSaleRecord::with('product.product_price')->thisMonth()->get();
    $stock_sales_records = $sales_record_today->where('product.product_batch_id', '<>', ProductBatch::local_supplied_id());
    $local_supplier_sales_records = $sales_record_today->where('product.product_batch_id', ProductBatch::local_supplied_id());

    $payments_breakdown = CompanyBankAccount::with(['sales_records' => function ($query) {
      $query->today();
    }])->get()->groupBy('bank')->map(function ($value, $key) {
      return $value[0]->sales_records->sum('payment_record.amount');
    });

    return [
      'statistics' => fn () => [
        'total_monthly_sale_count' => (int) $sales_record_this_month->count(),
        'total_monthly_sale_profit' => (float) $sales_record_this_month->sum('selling_price') - $sales_record_this_month->sum('product.product_price.cost_price'),
        'total_daily_sale_count' => (int) $sales_record_today->count(),
        'total_daily_confirmed_sale_count' => (int) $sales_record_today->whereNotNull('sale_confirmed_by')->count(),
        'total_daily_confirmed_sale_amount' => (float)$sales_record_today->whereNotNull('sale_confirmed_by')->sum('selling_price'),
        'total_daily_unconfirmed_sale_count' => (int)$sales_record_today->whereNull('sale_confirmed_by')->count(),
        'total_daily_unconfirmed_sale_amount' => (float)$sales_record_today->whereNull('sale_confirmed_by')->sum('selling_price'),
        'total_daily_sales_cost_price' => (float)$total_daily_sales_cost_price = $sales_record_today->sum('product.product_price.cost_price'), # Not Displayed
        'total_daily_sales_selling_price' => (float) $total_daily_sales_selling_price = $sales_record_today->sum('selling_price'),
        'total_daily_sales_proposed_selling_price' => (float)$sales_record_today->sum('product.product_price.proposed_selling_price'), # Not Displayed
        'total_bank_payments' => (float)$payments_breakdown->except('Cash')->sum(), # Not Displayed
        'total_cash_payments' => (float)$cash_collected = $payments_breakdown->only('Cash')->sum(), # Not Displayed
        'total_daily_sales_stock' => (float)$stock_sales_records->sum('selling_price'),
        'total_daily_sales_local_suppliers' => (float)$local_supplier_sales_records->sum('selling_price'),
        'total_daily_profit' => (float) $total_daily_sales_selling_price - $total_daily_sales_cost_price,
        'total_daily_repairs_cost' => (float)ProductExpense::today()->sum('amount'),
        'total_monthly_expenses' => (float)OtherExpense::thisMonth()->sum('amount'),
        'total_monthly_repairs_cost' => (float)ProductExpense::thisMonth()->sum('amount'),
        'total_swap_deals_value' => (float)SwapDeal::today()->sum('swap_value'),
        'total_swap_deals_count' => (float)SwapDeal::today()->count('swap_value'),
        'total_local_purchases_count' => Product::local()->today()->count(),
        'balance_after_expenses' => (float)$cash_collected - $daily_expenses_list->sum('amount'),
        'payments_breakdown' => collect($payments_breakdown)->merge(['total' => $payments_breakdown->sum()]),
        'daily_expenses_list' => collect($daily_expenses_list)->merge([['purpose' => 'Total', 'amount' => $daily_expenses_list->sum('amount')]]),
        'most_recent_sales' => $most_recent_sales,
        'live_account_payments' => Cache::rememberForever('bank_payments', fn () => SalesRecordBankAccount::with('company_bank_account')->today()->get()->transform(fn ($rec) => ['bank' => $rec->company_bank_account->bank, 'amount' => $rec->amount])),
      ]
    ];
  }


}
