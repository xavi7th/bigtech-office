<?php

namespace App\Modules\SuperAdmin\Tests\Unit;

use Carbon\Factory;
use Tests\TestCase;
use Illuminate\Support\Str;
use RachidLaasri\Travel\Travel;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\SuperAdmin\Models\OfficeBranch;
use App\Modules\SuperAdmin\Models\ProductModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\SuperAdmin\Models\CompanyBankAccount;
use App\Modules\SuperAdmin\Tests\Traits\PreparesToCreateProduct;

class SuperAdminManagementTest extends TestCase
{
  use RefreshDatabase, PreparesToCreateProduct;

  /** @test */
  public function super_admin_can_visit_dashboard()
  {
    $this->prepare_to_create_product();
    factory(OfficeBranch::class)->create();
    /** @var SuperAdmin */
    $superAdmin = factory(SuperAdmin::class)->create();

    $rsp = $this->actingAs($superAdmin, Str::snake(class_basename(get_class(($superAdmin)))))->get(route($superAdmin->getDashboardRoute()))
      ->assertOk()
      ->assertSessionHasNoErrors()
      ->assertSessionMissing('flash.error');

    $page = $this->getResponseData($rsp);

    $this->assertEquals('SuperAdmin,SuperAdminDashboard', $page->component);
    $this->assertNull($page->props->errors);
    $this->assertArrayHasKey('total_monthly_sale_count', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_monthly_sale_profit', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_daily_sale_count', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_daily_confirmed_sale_count', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_daily_confirmed_sale_amount', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_daily_unconfirmed_sale_count', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_daily_unconfirmed_sale_amount', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_daily_sales_cost_price', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_daily_sales_selling_price', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_daily_sales_proposed_selling_price', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_bank_payments', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_cash_payments', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_daily_sales_stock', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_daily_sales_local_suppliers', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_daily_profit', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_monthly_expenses', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_daily_repairs_cost', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_monthly_repairs_cost', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_swap_deals_value', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_swap_deals_count', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_local_purchases_count', (array)$page->props->statistics);
    $this->assertArrayHasKey('balance_after_expenses', (array)$page->props->statistics);
    $this->assertArrayHasKey('payments_breakdown', (array)$page->props->statistics);
    $this->assertArrayHasKey('daily_expenses_list', (array)$page->props->statistics);
    $this->assertArrayHasKey('most_recent_sales', (array)$page->props->statistics);
    $this->assertArrayHasKey('live_account_payments', (array)$page->props->statistics);
    /** +1 to make room for the total index merged into the payments breakdown array */
    $this->assertCount(CompanyBankAccount::count() + 1, (array)$page->props->statistics->payments_breakdown);
  }

  /** @test */
  public function super_admin_should_be_able_to_see_stock_aggregate()
  {
    $this->withoutExceptionHandling();

    $this->prepare_to_create_product();

    factory(ProductModel::class, 10)->create();
    factory(Product::class, 50)->create();

    factory(OfficeBranch::class)->create();

    $superAdmin = factory(SuperAdmin::class)->create();


    $rsp = $this->actingAs($superAdmin, Str::snake(class_basename(get_class(($superAdmin)))))->get(route('superadmin.multiaccess.products.view_stock'))
    ->assertOk()
      ->assertSessionHasNoErrors()
      ->assertSessionMissing('flash.error');


    $page = $this->getResponseData($rsp);

    $this->assertEquals('SuperAdmin,Products/ViewStockAggregate', $page->component);
    $this->assertNull($page->props->errors);
    $this->assertArrayHasKey('current_stock', (array)$page->props);
  }

  /** @test */
  public function super_admin_can_view_sales_reps_list()
  {
    $this->withoutExceptionHandling();

    factory(OfficeBranch::class)->create();
    factory(SalesRep::class, 20)->create();

    $response = $this->actingAs(factory(SuperAdmin::class)->create(), 'super_admin')->get(route('superadmin.manage_staff.sales_reps'));

    $page = $this->getResponseData($response);

    $this->assertEquals('SuperAdmin,ManageStaff/ManageSalesReps', $page->component);
    $this->assertNull($page->props->errors);
    /** Asserting 19 because of the globalQueryScope */
    $this->assertCount(19, (array)$page->props->salesReps);
  }
}
