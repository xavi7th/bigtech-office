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
use Illuminate\Auth\AuthenticationException;
use Str;

class GeneralUserTest extends TestCase
{
  use RefreshDatabase;
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
   * @dataProvider provideDifferentUserTypes
   */
  public function admin_can_mark_user_as_inactive($dataSource)
  {
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
   * @dataProvider provideDifferentUserTypes
   */
  public function admin_can_restore_suspended_user($dataSource)
  {
    [$location, $user] = $dataSource();
    $user->is_active = false;
    $user->save();
    ray($user);
    $superAdmin = factory(SuperAdmin::class)->create();

    $response = $this->actingAs($superAdmin, 'super_admin')->put(route('superadmin.manage_staff.' . Str::snake(class_basename(get_class(($user)))) . '.reactivate', $user));
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


  public function provideDifferentUserTypes()
  {
    /**
     * @key salesrep is a handle for the test to refer to that pasrticular dataset
     * @fn() is required because data providers are fired before the test class is initialised. The application and the IOC is bootstrapped when the calss is initialised ao factories and other stuffs like that fail and trigger not found errors
     * @factoryOffice branch is required because the data is fired and cached before the test is initialised. When the test is initialised the database is refreshed so we need to re fire the office location factory for each dataset otherwise there will be no location in the DB
     * @factoryUser is the main thin we are needing as we see grabbed from the method using destructuring
     */
    return [
      'salesrep' => [
        fn () => [factory(OfficeBranch::class)->create(), factory(SalesRep::class)->create(['id' => 30])]
      ],
      'admin' => [
        fn () => [factory(OfficeBranch::class)->create(), factory(Admin::class)->create(['id' => 30])],
      ],
      'accountant' => [
        fn () => [factory(OfficeBranch::class)->create(), factory(Accountant::class)->create(['id' => 30])],
      ],
      'webAdmin' => [
        fn () => [factory(OfficeBranch::class)->create(), factory(WebAdmin::class)->create(['id' => 30])],
      ],
      'qualityCOntrol' => [
        fn () => [factory(OfficeBranch::class)->create(), factory(QualityControl::class)->create(['id' => 30])],
      ],
      'stockKeeper' => [
        fn () => [factory(OfficeBranch::class)->create(), factory(StockKeeper::class)->create(['id' => 30])],
      ],
      'dispatchAdmin' => [
        fn () => [factory(OfficeBranch::class)->create(), factory(DispatchAdmin::class)->create(['id' => 30])],
      ],






    ];
  }
}
