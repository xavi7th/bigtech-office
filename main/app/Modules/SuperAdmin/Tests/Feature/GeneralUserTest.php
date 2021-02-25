<?php

namespace App\Modules\SuperAdmin\Tests\Feature;

use App\User;
use Tests\TestCase;
use App\Modules\Admin\Models\Admin;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\WebAdmin\Models\WebAdmin;
use Illuminate\Foundation\Testing\WithFaker;
use App\Modules\Accountant\Models\Accountant;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\StockKeeper\Models\StockKeeper;
use App\Modules\SuperAdmin\Models\OfficeBranch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\DispatchAdmin\Models\DispatchAdmin;
use App\Modules\QualityControl\Models\QualityControl;
use App\Modules\SuperAdmin\Tests\Traits\ProvidesDifferentUserDataTypes;
use Illuminate\Auth\AuthenticationException;
use Str;

class GeneralUserTest extends TestCase
{
  use RefreshDatabase, ProvidesDifferentUserDataTypes;
   /** @test */
  public function an_inactive_user_cannot_login()
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
  public function an_active_user_can_login()
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

  /**
   * @test
   * @dataProvider provideDifferentUserTypesWithoutSuperAdmin
   */
  public function admin_can_mark_user_as_inactive($dataSource)
  {
    $this->withoutExceptionHandling();
    [$location, $user] = $dataSource();
    $superAdmin = factory(SuperAdmin::class)->create();

    $response = $this->actingAs($superAdmin, 'super_admin')->put(route('superadmin.manage_staff.' . Str::snake(class_basename(get_class(($user)))) . '.suspend', $user));
    $user->refresh();
    $response->assertSessionHasNoErrors();
    $response->assertRedirect();
    $this->assertEquals(false, $user->is_active);
    $response->assertSessionHas('flash.success', 'User account suspended');
  }

  /**
   * @test
   * @dataProvider provideDifferentUserTypesWithoutSuperAdmin
   */
  public function admin_can_restore_suspended_user($dataSource)
  {
    [$location, $user] = $dataSource();
    $user->is_active = false;
    $user->save();
    ray($user);
    $superAdmin = factory(SuperAdmin::class)->create();

    $response = $this->actingAs($superAdmin, 'super_admin')->put(route('superadmin.manage_staff.' . Str::of(class_basename(get_class(($user))))->snake()->plural() . '.reactivate', $user));
    $user->refresh();
    $response->assertSessionHasNoErrors();
    $response->assertRedirect();
    $this->assertEquals(true, $user->is_active);
    $response->assertSessionHas('flash.success', 'User account re-activated');
  }

  private function test_inactive_login(User $user, string $guard)
  {
    try {
      $this->actingAs($user, $guard)->get(route($user->getDashboardRoute()));
    } catch (\Throwable $th) {

      $this->assertEquals(AuthenticationException::class, get_class($th));
      $this->assertEquals('Unauthenticated.', $th->getMessage());
      $this->assertEquals('Account Suspended. Contact your manager.', session()->get('errors')->getBag('default')->messages()['email'][0]);
    }
  }

  private function test_active_login(User $user, string $guard)
  {
    $response = $this->actingAs($user, $guard)->get(route($user->getDashboardRoute()));

    $response->assertOk();

    /**
     *? Logout required before testing next user because of AuthenticatesSession Middleware
     */
    $this->actingAs($user, $guard)->post(route('app.logout'));
  }

}
