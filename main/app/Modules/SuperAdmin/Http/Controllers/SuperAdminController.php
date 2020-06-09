<?php

namespace App\Modules\SuperAdmin\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use App\Modules\SuperAdmin\Models\SuperAdmin;

class SuperAdminController extends Controller
{
  /**
   * Return the data for the extras defaults
   *
   * @param bool $navSkip
   * @param string $icon
   *
   * @return array
   */
  private static function __e($icon = null, $navSkip = false)
  {
    return compact(['icon', 'navSkip']);
  }

  public function __construct()
  {
    Inertia::setRootView('superadmin::app');
  }

  static function routes()
  {
    Route::group(['middleware' => ['web', 'auth:super_admin'], 'namespace' => '\App\Modules\SuperAdmin\Http\Controllers'], function () {
      Route::prefix(SuperAdmin::DASHBOARD_ROUTE_PREFIX)->group(function () {
        $p = function ($name) {
          return 'superadmin.products.' . $name;
        };
        $gen = function ($namespace, $name = null) {
          return 'superadmin.product_' . $namespace . $name;
        };
        $others = function ($name) {
          return 'superadmin.' . $name;
        };
        $misc = function ($name) {
          return 'superadmin.miscellaneous.' . $name;
        };

        Route::get('/', [self::class, 'index'])->name('superadmin.dashboard')->defaults('ex', self::__e('home'));
        Route::get('/products', [self::class, 'index'])->name($p('view_products'))->defaults('ex', self::__e('archive'));
        Route::get('/products/detailed', [self::class, 'index'])->name($p('view_detailed_products'))->defaults('ex', self::__e('archive'));
        Route::get('/products/resellers', [self::class, 'index'])->name($p('products_with_resellers'))->defaults('ex', self::__e('archive'));
        Route::get('/products/search', [self::class, 'index'])->name($p('find_product'))->defaults('ex', self::__e('archive'));
        Route::get('/products/create', [self::class, 'index'])->name($p('create_product'))->defaults('ex', self::__e('archive'));
        Route::get('/products/local-supplier/create', [self::class, 'index'])->name($p('create_local_product'))->defaults('ex', self::__e('archive'));
        Route::put('products/{product}/edit', [self::class, 'index'])->name($p('edit_product'))->defaults('ex', self::__e(null, true));
        Route::put('products/{product}/location', [self::class, 'index'])->name($p('edit_product_location'))->defaults('ex', self::__e(null, true));
        Route::post('products/{product}/sold', [self::class, 'index'])->name($p('mark_as_sold'))->defaults('ex', self::__e(null, true));
        Route::put('products/{product}/confirm-sale', [self::class, 'index'])->name($p('confirm_sale'))->defaults('ex', self::__e(null, true));
        Route::put('products/{product}/status', [self::class, 'index'])->name($p('update_product_status'))->defaults('ex', self::__e(null, true));
        Route::post('products/{product}/comment', [self::class, 'index'])->name($p('comment_on_product'))->defaults('ex', self::__e(null, true));

        Route::get('swap-deals', [self::class, 'index'])->name($p('swap_deals'))->defaults('ex', self::__e('refresh-cw', false));
        Route::post('swap-deals/create', [self::class, 'index'])->name($p('create_swap_deal'))->defaults('ex', self::__e('refresh-cw', true));
        Route::put('swap-deals/{size}/edit', [self::class, 'index'])->name($p('edit_swap_deal'))->defaults('ex', self::__e('refresh-cw', true));

        Route::get('products/{product}/qa-tests', [self::class, 'index'])->name($p('applicable_qa_tests'))->defaults('ex', self::__e(null, true));
        Route::get('products/{product}/qa-tests/comments', [self::class, 'index'])->name($p('qa_test_comments'))->defaults('ex', self::__e(null, true));
        Route::post('products/{product}/qa-tests/comment', [self::class, 'index'])->name($p('comment_on_qa_test'))->defaults('ex', self::__e(null, true));
        Route::get('products/{product}/qa-test-results', [self::class, 'index'])->name($p('qa_test_results'))->defaults('ex', self::__e(null, true));
        Route::put('products/{product}/qa-test-results', [self::class, 'index'])->name($p('update_qa_result'))->defaults('ex', self::__e(null, true));

        Route::get('products/{product}/expenses', [self::class, 'index'])->name($p('view_product_expenses'))->defaults('ex', self::__e(null, true));
        Route::post('products/{product}/expense/create', [self::class, 'index'])->name($p('create_product_expense'))->defaults('ex', self::__e(null, true));

        Route::get('product-sales-records', [self::class, 'index'])->name($p('view_sales_records'))->defaults('ex', self::__e(null, false));
        Route::get('product-sales-records/{product}/transactions', [self::class, 'index'])->name($p('view_sales_record_transactions'))->defaults('ex', self::__e(null, true));
        Route::get('product-sales-records/{product}/swap-deal', [self::class, 'index'])->name($p('view_sales_record_swap_deal'))->defaults('ex', self::__e(null, true));
        Route::post('product-sales-records/{product}/confirm', [self::class, 'index'])->name($p('confirm_sales_record'))->defaults('ex', self::__e(null, true));

        Route::get('product-colors', [self::class, 'index'])->name($misc('colors'))->defaults('ex', self::__e('pen-tool', false));
        Route::post('product-colors/create', [self::class, 'index'])->name($misc('create_product_color'))->defaults('ex', self::__e('pen-tool', true));
        Route::put('product-colors/{color}/edit', [self::class, 'index'])->name($misc('edit_product_color'))->defaults('ex', self::__e('pen-tool', true));

        Route::get('product-brands', [self::class, 'index'])->name($gen('brands'))->defaults('ex', self::__e('feather', false));
        Route::post('product-brands/create', [self::class, 'index'])->name($gen('brands', '.create_product_brand'))->defaults('ex', self::__e('feather', true));
        Route::put('product-brands/{brand}/edit', [self::class, 'index'])->name($gen('brands', '.edit_product_brand'))->defaults('ex', self::__e('feather', true));

        Route::get('product-categories', [self::class, 'index'])->name($gen('categories'))->defaults('ex', self::__e('edit-3', false));
        Route::post('product-categories/create', [self::class, 'index'])->name($gen('categories', '.create_product_category'))->defaults('ex', self::__e('edit-3', true));
        Route::put('product-categories/{category}/edit', [self::class, 'index'])->name($gen('categories', '.edit_product_category'))->defaults('ex', self::__e('edit-3', true));

        Route::get('product-models', [self::class, 'index'])->name($gen('models'))->defaults('ex', self::__e('git-branch', false));
        Route::get('product-models/detailed', [self::class, 'index'])->name($gen('models', '.view_detailed_models'))->defaults('ex', self::__e('git-branch', false));
        Route::post('product-models/create', [self::class, 'index'])->name($gen('models', '.create_product_model'))->defaults('ex', self::__e('git-branch', true));
        Route::put('product-models/{model}/edit', [self::class, 'index'])->name($gen('models', '.edit_product_model'))->defaults('ex', self::__e('git-branch', true));
        Route::get('product-models/{model}/qa-tests', [self::class, 'index'])->name($gen('models', '.model_qa_tests'))->defaults('ex', self::__e('git-branch', true));
        Route::put('product-models/{model}/qa-tests', [self::class, 'index'])->name($gen('models', '.update_model_qa_tests'))->defaults('ex', self::__e('git-branch', true));
        Route::get('product-models/{model}/images', [self::class, 'index'])->name($gen('models', '.model_images'))->defaults('ex', self::__e('git-branch', true));
        Route::post('product-models/{model}/images/create', [self::class, 'index'])->name($gen('models', '.create_model_image'))->defaults('ex', self::__e('git-branch', true));
        Route::delete('product-models/images/{image}/delete', [self::class, 'index'])->name($gen('models', '.delete_model_image'))->defaults('ex', self::__e('git-branch', true));

        Route::get('product-qa-test-results', [self::class, 'index'])->name($p('qa_test_results'))->defaults('ex', self::__e('file-text', false));
        Route::get('product-expenses', [self::class, 'index'])->name($p('expenses'))->defaults('ex', self::__e('credit-card', false));

        Route::get('processor-speeds', [self::class, 'index'])->name($misc('processor_speeds'))->defaults('ex', self::__e('cpu', false));
        Route::post('processor-speed/create', [self::class, 'index'])->name($misc('create_processor_speed'))->defaults('ex', self::__e('cpu', true));

        Route::get('product-grades', [self::class, 'index'])->name($gen('grade'))->defaults('ex', self::__e('check-square', false));
        Route::post('product-grades/create', [self::class, 'index'])->name($gen('grade', '.create_product_grade'))->defaults('ex', self::__e('check-square', true));
        Route::put('product-grades/{grade}/edit', [self::class, 'index'])->name($gen('grade', '.edit_product_grade'))->defaults('ex', self::__e('check-square', true));

        Route::get('storage-types', [self::class, 'index'])->name($misc('view_storage_types'))->defaults('ex', self::__e('hard-drive', false));
        Route::post('storage-type/create', [self::class, 'index'])->name($misc('create_storage_type'))->defaults('ex', self::__e('hard-drive', true));
        Route::put('storage-type/{type}/edit', [self::class, 'index'])->name($misc('edit_storage_type'))->defaults('ex', self::__e('hard-drive', true));

        Route::get('storage-sizes', [self::class, 'index'])->name($misc('view_storage_sizes'))->defaults('ex', self::__e('hard-drive', false));
        Route::post('storage-sizes/create', [self::class, 'index'])->name($misc('create_storage_size'))->defaults('ex', self::__e('hard-drive', true));
        Route::put('storage-sizes/{size}/edit', [self::class, 'index'])->name($misc('edit_storage_size'))->defaults('ex', self::__e('hard-drive', true));

        Route::get('qa-tests', [self::class, 'index'])->name($gen('qa-tests'))->defaults('ex', self::__e('award', false));
        Route::post('qa-tests/create', [self::class, 'index'])->name($gen('qa-tests', '.create_qa_test'))->defaults('ex', self::__e('award', true));
        Route::put('qa-tests/{size}/edit', [self::class, 'index'])->name($gen('qa-tests', '.edit_qa_test'))->defaults('ex', self::__e('award', true));

        Route::get('sales-channels', [self::class, 'index'])->name($misc('view_sales_channels'))->defaults('ex', self::__e('airplay', false));
        Route::post('sales-channels/create', [self::class, 'index'])->name($misc('create_sales_channel'))->defaults('ex', self::__e('airplay', true));
        Route::put('sales-channels/{size}/edit', [self::class, 'index'])->name($misc('edit_sales_channel'))->defaults('ex', self::__e('airplay', true));

        Route::get('company-bank-accounts', [self::class, 'index'])->name($misc('view_bank_accounts'))->defaults('ex', self::__e('refresh-cw', false));
        Route::post('company-bank-accounts/create', [self::class, 'index'])->name($misc('create_account'))->defaults('ex', self::__e('refresh-cw', true));
        Route::put('company-bank-accounts/{size}/edit', [self::class, 'index'])->name($misc('edit_account'))->defaults('ex', self::__e('refresh-cw', true));

        Route::get('expenses', [self::class, 'index'])->name($gen('office_expenses'))->defaults('ex', self::__e('clipboard', false));
        Route::post('expenses/create', [self::class, 'index'])->name($gen('office_expenses', '.create_expense'))->defaults('ex', self::__e('clipboard', true));
        Route::put('expenses/{size}/edit', [self::class, 'index'])->name($gen('office_expenses', '.edit_expense'))->defaults('ex', self::__e('clipboard', true));

        Route::get('product-batches', [self::class, 'index'])->name($gen('batches', null))->defaults('ex', self::__e('package', false));
        Route::post('product-batches/create', [self::class, 'index'])->name($gen('batches', 'create_batch'))->defaults('ex', self::__e('package', true));
        Route::post('product-batches/{batch}/comment', [self::class, 'index'])->name($gen('batches', 'create_comment'))->defaults('ex', self::__e('package', true));

        Route::get('product-suppliers', [self::class, 'index'])->name($gen('suppliers', null))->defaults('ex', self::__e('user-plus', false));
        Route::post('product-suppliers/create', [self::class, 'index'])->name($gen('suppliers', 'create_supplier'))->defaults('ex', self::__e('user-plus', true));
        Route::put('product-suppliers/{supplier}/edit', [self::class, 'index'])->name($gen('suppliers', 'edit_supplier'))->defaults('ex', self::__e('user-plus', true));

        Route::get('product-prices', [self::class, 'index'])->name($gen('prices', null))->defaults('ex', self::__e('dollar-sign', false));
        Route::post('product-prices/create', [self::class, 'index'])->name($gen('prices', 'create_price'))->defaults('ex', self::__e('dollar-sign', true));
        Route::put('product-prices/{price}/edit', [self::class, 'index'])->name($gen('prices', 'edit_price'))->defaults('ex', self::__e('dollar-sign', true));

        Route::get('product-statuses', [self::class, 'index'])->name($gen('statuses', null))->defaults('ex', self::__e('aperture', false));
        Route::post('product-statuses/create', [self::class, 'index'])->name($gen('statuses', 'create_status'))->defaults('ex', self::__e('aperture', true));
        Route::put('product-statuses/{statuse}/edit', [self::class, 'index'])->name($gen('statuses', 'edit_status'))->defaults('ex', self::__e('aperture', true));

        Route::get('product-statuses', [self::class, 'index'])->name($misc('statuses'))->defaults('ex', self::__e('aperture', false));
        Route::post('product-statuses/create', [self::class, 'index'])->name($misc('create_status'))->defaults('ex', self::__e('aperture', true));
        Route::put('product-statuses/{status}/edit', [self::class, 'index'])->name($misc('edit_status'))->defaults('ex', self::__e('aperture', true));

        Route::get('product-descriptions', [self::class, 'index'])->name($gen('descriptions'))->defaults('ex', self::__e('edit', false));
        Route::post('product-descriptions/create', [self::class, 'index'])->name($gen('descriptions', 'create_desc'))->defaults('ex', self::__e('edit', true));
        Route::put('product-descriptions/{desc}/edit', [self::class, 'index'])->name($gen('descriptions', 'edit_desc'))->defaults('ex', self::__e('edit', true));

        Route::get('product-histories', [self::class, 'index'])->name($gen('histories', null))->defaults('ex', self::__e('rewind', false));
        Route::get('product-histories/detailed', [self::class, 'index'])->name($gen('histories', '.detailed_product_histories'))->defaults('ex', self::__e('rewind', false));
        Route::get('product-histories/{product}', [self::class, 'index'])->name($gen('histories', '.view_product_history'))->defaults('ex', self::__e('rewind', true));

        Route::get('resellers', [self::class, 'index'])->name($others('resellers'))->defaults('ex', self::__e('at-sign', false));
        Route::get('resellers/products', [self::class, 'index'])->name($others('resellers.resellers_with_products', null))->defaults('ex', self::__e('at-sign', false));
        Route::post('resellers/create', [self::class, 'index'])->name($others('resellers.create_reseller'))->defaults('ex', self::__e('at-sign', true));
        Route::put('resellers/{reseller}/edit', [self::class, 'index'])->name($others('resellers.edit_reseller'))->defaults('ex', self::__e('at-sign', true));
        Route::post('resellers/{reseller}/give-product', [self::class, 'index'])->name($others('resellers.give_product'))->defaults('ex', self::__e('at-sign', true));
        Route::post('resellers/{reseller}/return-product', [self::class, 'index'])->name($others('resellers.return_product'))->defaults('ex', self::__e('at-sign', true));
        Route::post('resellers/{reseller}/pay-for-product', [self::class, 'index'])->name($others('resellers.pay_for_product'))->defaults('ex', self::__e('at-sign', true));

        Route::get('office-branches', [self::class, 'index'])->name($others('office_branches'))->defaults('ex', self::__e('trello', false));
        Route::post('office-branches/create', [self::class, 'index'])->name($others('office_branches.create_office_branch'))->defaults('ex', self::__e('trello', true));
        Route::put('office-branches/{branch}/edit', [self::class, 'index'])->name($others('office_branches.edit_office_branch'))->defaults('ex', self::__e('trello', true));
        Route::get('office-branches/{branch}/products', [self::class, 'index'])->name($others('office_branches.view_products'))->defaults('ex', self::__e('trello', true));
        Route::get('office-branches/{branch}/product-expenses', [self::class, 'index'])->name($others('office_branches.prod_expenses'))->defaults('ex', self::__e('trello', true));
        Route::get('office-branches/{branch}/product-histories', [self::class, 'index'])->name($others('office_branches.prod_histories'))->defaults('ex', self::__e('trello', true));
        Route::get('office-branches/{branch}/reseller-histories', [self::class, 'index'])->name($others('office_branches.res_histories'))->defaults('ex', self::__e('trello', true));
        Route::get('office-branches/{branch}/products-with-resellers', [self::class, 'index'])->name($others('office_branches.res_prod'))->defaults('ex', self::__e('trello', true));
        Route::get('office-branches/{branch}/staff', [self::class, 'index'])->name($others('office_branches.view_staff'))->defaults('ex', self::__e('trello', true));
        Route::get('office-branches/{branch}/staff/departments', [self::class, 'index'])->name($others('office_branches.staff_by_depts'))->defaults('ex', self::__e('trello', true));
        Route::get('office-branches/{branch}/staff/activities', [self::class, 'index'])->name($others('office_branches.staff_acts'))->defaults('ex', self::__e('trello', true));

        Route::get('user-comments', [self::class, 'index'])->name($others('user_comments'))->defaults('ex', self::__e('message-circle', false));
        Route::get('user-comments/product-batch/{batch}', [self::class, 'index'])->name($others('user_comments.batch'))->defaults('ex', self::__e('message-circle', true));
        Route::get('user-comments/product/{product}', [self::class, 'index'])->name($others('user_comments.product'))->defaults('ex', self::__e('message-circle', true));

        Route::get('error-logs', [self::class, 'index'])->name($others('logs.error_logs'))->defaults('ex', self::__e('activity', false));
        Route::get('activity-logs', [self::class, 'index'])->name($others('logs.activity_logs'))->defaults('ex', self::__e('activity', false));
        Route::get('activity-logs/sales-reps', [self::class, 'index'])->name($others('logs.sales_reps_logs'))->defaults('ex', self::__e('activity', false));
        Route::get('activity-logs/accountant', [self::class, 'index'])->name($others('logs.accountant_logs'))->defaults('ex', self::__e('activity', false));
      });
    });
  }

  /**
   * The admin routes
   * @return Response
   */
  public static function apiRoutes()
  {
    Route::group(['middleware' => ['api', 'throttle:20,1'], 'prefix' =>  Admin::DASHBOARD_ROUTE_PREFIX . '/api/',  'namespace' => '\App\Modules\Admin\Http\Controllers'], function () {

      LoginController::routes();

      Product::apiRoutes();

      ProductColor::apiRoutes();

      ProductCategory::apiRoutes();

      ProductBrand::apiRoutes();

      ProductModel::apiRoutes();

      ProductQATestResult::apiRoutes();

      ProcessorSpeed::apiRoutes();

      ProductGrade::apiRoutes();

      StorageSize::apiRoutes();

      StorageType::apiRoutes();

      ProductSupplier::apiRoutes();

      ProductStatus::apiRoutes();

      ProductBatch::apiRoutes();

      ProductPrice::apiRoutes();

      ProductHistory::apiRoutes();

      ProductExpense::apiRoutes();

      ProductSaleRecord::apiRoutes();

      ProductDescriptionSummary::apiRoutes();

      UserComment::apiRoutes();

      Reseller::apiRoutes();

      QATest::apiRoutes();

      SalesChannel::apiRoutes();

      SwapDeal::apiRoutes();

      CompanyBankAccount::apiRoutes();

      OfficeBranch::apiRoutes();

      Expense::apiRoutes();

      ErrLog::apiRoutes();
    });
  }

  public static function oldRoutes()
  {

    Route::group(['middleware' => 'web', 'prefix' => Admin::DASHBOARD_ROUTE_PREFIX,  'namespace' => '\App\Modules\Admin\Http\Controllers'], function () {

      /**
       * ? Route to get the type of user.
       * ! This is used to populate the $user object prototyped in the app.js file
       */
      Route::get('/user-instance', 'AdminController@getLoggedInUserInstance')->middleware('web');

      Route::get('/site/setup/{key?}',  'AdminController@setupApplication');

      LoginController::routes();

      Route::group(['prefix' => 'api'], function () {

        Route::post('test-route-permission', 'AdminController@testRoutePermission')->middleware('auth:admin');

        Route::get('statistics', 'AdminController@getDashboardStatistics')->middleware('auth:admin');

        AppUser::adminRoutes();

        Admin::adminRoutes();

        NormalAdmin::adminRoutes();

        Accountant::adminRoutes();

        AccountOfficer::adminRoutes();

        CardAdmin::adminRoutes();

        CustomerSupport::adminRoutes();

        SalesRep::adminRoutes();

        StockRequest::adminRoutes();

        StockRequest::salesRepRoutes();

        Merchant::adminRoutes();

        Voucher::adminRoutes();

        MerchantCategory::adminRoutes();

        ActivityLog::adminRoutes();

        SupportTicket::adminRoutes();
      });

      Route::group(['middleware' => ['auth:admin', 'admins']], function () {
        Route::get('/{subcat?}', 'AdminController@loadAdminApp')->name('admin.dashboard')->where('subcat', '^((?!(api)).)*');
      });
    });
  }

  public function getDashboardStatistics()
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

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    // auth()->logout();
    return Inertia::render('SuperAdminDashboard');
  }
}
