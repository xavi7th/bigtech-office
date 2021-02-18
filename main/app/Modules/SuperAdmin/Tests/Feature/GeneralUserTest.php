<?php

namespace App\Modules\SuperAdmin\Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Modules\Admin\Models\Admin;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\WebAdmin\Models\WebAdmin;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\WithFaker;
use App\Modules\Accountant\Models\Accountant;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\StockKeeper\Models\StockKeeper;
use App\Modules\SuperAdmin\Models\OfficeBranch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\DispatchAdmin\Models\DispatchAdmin;
use App\Modules\QualityControl\Models\QualityControl;

class GeneralUserTest extends TestCase
{
  use RefreshDatabase;
   /** @test */
  public function function_an_inactive_user_cannot_login()
  {
    $this->withoutExceptionHandling();
    factory(OfficeBranch::class)->create();

    /** @var SalesRep */
    $user = factory(SalesRep::class)->create(['is_active' => false]);
    $this->test_inactive_login($user, 'sales_rep');

    /** @var Admin */
    $user = factory(Admin::class)->create(['is_active' => false]);
    $this->test_inactive_login($user, 'admin');

      /** @var StockKeeper */
    $user = factory(StockKeeper::class)->create(['is_active' => false]);
    $this->test_inactive_login($user, 'stock_keeper');

     /** @var QualityControl */
    $user = factory(QualityControl::class)->create(['is_active' => false]);
    $this->test_inactive_login($user, 'quality_control');

     /** @var Accountant */
    $user = factory(Accountant::class)->create(['is_active' => false]);
    $this->test_inactive_login($user, 'accountant');

     /** @var DispatchAdmin */
    $user = factory(DispatchAdmin::class)->create(['is_active' => false]);
    $this->test_inactive_login($user, 'dispatch_admin');

     /** @var WebAdmin */
    $user = factory(WebAdmin::class)->create(['is_active' => false]);
    $this->test_inactive_login($user, 'web_admin');
  }

   /** @test */
  public function function_an_active_user_can_login()
  {
    // $this->withoutExceptionHandling();
    factory(OfficeBranch::class)->create();

    /** @var SalesRep */
    $user = factory(SalesRep::class)->create(['is_active' => true]);
    $this->test_active_login($user, 'sales_rep');

    /** @var Admin */
    $user = factory(Admin::class)->create();
    $this->test_active_login($user, 'admin');

      /** @var StockKeeper */
    $user = factory(StockKeeper::class)->create();
    $this->test_active_login($user, 'stock_keeper');

     /** @var QualityControl */
    $user = factory(QualityControl::class)->create();
    $this->test_active_login($user, 'quality_control');

     /** @var Accountant */
    $user = factory(Accountant::class)->create();
    $this->test_active_login($user, 'accountant');

     /** @var DispatchAdmin */
    $user = factory(DispatchAdmin::class)->create();
    $this->test_active_login($user, 'dispatch_admin');

     /** @var WebAdmin */
    $user = factory(WebAdmin::class)->create();
    $this->test_active_login($user, 'web_admin');
  }

  /** @test */
  public function function_admin_can_mark_user_as_inactive()
  {
    $this->withoutExceptionHandling();

    factory(OfficeBranch::class)->create();

    $response = $this->actingAs(factory(SuperAdmin::class)->create(),'super_admin')->put(route('superadmin.manage_staff.sales_rep.suspend', $salesRep = factory(SalesRep::class)->create(['id' => 2])));
    $salesRep->refresh();
    $response->assertSessionHasNoErrors();
    $response->assertRedirect();
    $this->assertEquals(false, $salesRep->is_active);
    $response->assertSessionHas('flash.success', 'User account suspended');

    $response = $this->actingAs(factory(SuperAdmin::class)->create(),'super_admin')->put(route('superadmin.manage_staff.admin.suspend', $admin = factory(Admin::class)->create(['id' => 2])));
    $admin->refresh();
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('flash.success', 'User account suspended');
    $this->assertEquals(false, $salesRep->is_active);
    $response->assertRedirect();

    $response = $this->actingAs(factory(SuperAdmin::class)->create(),'super_admin')->put(route('superadmin.manage_staff.accountant.suspend', $accountant = factory(Accountant::class)->create(['id' => 2])));
    $accountant->refresh();
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('flash.success', 'User account suspended');
    $this->assertEquals(false, $salesRep->is_active);
    $response->assertRedirect();

    $response = $this->actingAs(factory(SuperAdmin::class)->create(),'super_admin')->put(route('superadmin.manage_staff.web_admin.suspend', $webAdmin = factory(WebAdmin::class)->create(['id' => 2])));
    $webAdmin->refresh();
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('flash.success', 'User account suspended');
    $this->assertEquals(false, $salesRep->is_active);
    $response->assertRedirect();

    $response = $this->actingAs(factory(SuperAdmin::class)->create(),'super_admin')->put(route('superadmin.manage_staff.quality_control.suspend', $qualityCOntrol = factory(QualityControl::class)->create(['id' => 2])));
    $qualityCOntrol->refresh();
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('flash.success', 'User account suspended');
    $this->assertEquals(false, $salesRep->is_active);
    $response->assertRedirect();

    $response = $this->actingAs(factory(SuperAdmin::class)->create(),'super_admin')->put(route('superadmin.manage_staff.stock_keeper.suspend', $stockKeeper = factory(StockKeeper::class)->create(['id' => 2])));
    $stockKeeper->refresh();
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('flash.success', 'User account suspended');
    $this->assertEquals(false, $salesRep->is_active);
    $response->assertRedirect();

    $response = $this->actingAs(factory(SuperAdmin::class)->create(),'super_admin')->put(route('superadmin.manage_staff.dispatch_admin.suspend', $dispatchAdmin = factory(DispatchAdmin::class)->create(['id' => 2])));
    $dispatchAdmin->refresh();
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('flash.success', 'User account suspended');
    $this->assertEquals(false, $salesRep->is_active);
    $response->assertRedirect();

  }

  /** @test */
  public function function_admin_can_restore_suspended_user()
  {
    $this->withoutExceptionHandling();

    factory(OfficeBranch::class)->create();

    $response = $this->actingAs(factory(SuperAdmin::class)->create(),'super_admin')->put(route('superadmin.manage_staff.sales_rep.reactivate', $salesRep = factory(SalesRep::class)->create(['id' => 2, 'is_active' => false])));
    $salesRep->refresh();
    $response->assertSessionHasNoErrors();
    $response->assertRedirect();
    $this->assertEquals(true, $salesRep->is_active);
    $response->assertSessionHas('flash.success', 'User account re-activated');

    $response = $this->actingAs(factory(SuperAdmin::class)->create(),'super_admin')->put(route('superadmin.manage_staff.admin.reactivate', $admin = factory(Admin::class)->create(['id' => 2, 'is_active' => false])));
    $admin->refresh();
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('flash.success', 'User account re-activated');
    $this->assertEquals(true, $salesRep->is_active);
    $response->assertRedirect();

    $response = $this->actingAs(factory(SuperAdmin::class)->create(),'super_admin')->put(route('superadmin.manage_staff.accountant.reactivate', $accountant = factory(Accountant::class)->create(['id' => 2, 'is_active' => false])));
    $accountant->refresh();
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('flash.success', 'User account re-activated');
    $this->assertEquals(true, $salesRep->is_active);
    $response->assertRedirect();

    $response = $this->actingAs(factory(SuperAdmin::class)->create(),'super_admin')->put(route('superadmin.manage_staff.web_admin.reactivate', $webAdmin = factory(WebAdmin::class)->create(['id' => 2, 'is_active' => false])));
    $webAdmin->refresh();
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('flash.success', 'User account re-activated');
    $this->assertEquals(true, $salesRep->is_active);
    $response->assertRedirect();

    $response = $this->actingAs(factory(SuperAdmin::class)->create(),'super_admin')->put(route('superadmin.manage_staff.quality_control.reactivate', $qualityCOntrol = factory(QualityControl::class)->create(['id' => 2, 'is_active' => false])));
    $qualityCOntrol->refresh();
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('flash.success', 'User account re-activated');
    $this->assertEquals(true, $salesRep->is_active);
    $response->assertRedirect();

    $response = $this->actingAs(factory(SuperAdmin::class)->create(),'super_admin')->put(route('superadmin.manage_staff.stock_keeper.reactivate', $stockKeeper = factory(StockKeeper::class)->create(['id' => 2, 'is_active' => false])));
    $stockKeeper->refresh();
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('flash.success', 'User account re-activated');
    $this->assertEquals(true, $salesRep->is_active);
    $response->assertRedirect();

    $response = $this->actingAs(factory(SuperAdmin::class)->create(),'super_admin')->put(route('superadmin.manage_staff.dispatch_admin.reactivate', $dispatchAdmin = factory(DispatchAdmin::class)->create(['id' => 2, 'is_active' => false])));
    $dispatchAdmin->refresh();
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('flash.success', 'User account re-activated');
    $this->assertEquals(true, $salesRep->is_active);
    $response->assertRedirect();

  }

  private function test_inactive_login(User $user, string $guard)
  {
    try {
     $this->actingAs($user, $guard)->get(route($user->getDashboardRoute()));
    } catch (\Throwable $th) {
      $this->assertEquals(AuthenticationException::class, get_class($th));
      $this->assertEquals('Account Suspended. Contact your manager.', $th->getMessage());
    }
  }

  private function test_active_login(User $user, string $guard)
  {
    $response = $this->actingAs($user, $guard)->get(route($user->getDashboardRoute()));

    $response->assertOk();

  }
}
