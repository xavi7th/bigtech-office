<?php

namespace App\Modules\SuperAdmin\Tests\Feature;

use Tests\TestCase;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\SuperAdmin\Models\OfficeBranch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\SuperAdmin\Tests\Traits\ProvidesDifferentUserDataTypes;
use Illuminate\Auth\AuthenticationException;
use Str;

class GeneralUserTest extends TestCase
{
  use RefreshDatabase, ProvidesDifferentUserDataTypes;
  /**
   * @test
   * @dataProvider provideDifferentUserTypesWithoutSuperAdmin
   */
  public function an_inactive_user_cannot_login($dataSource)
  {
    $this->withoutExceptionHandling();
    factory(OfficeBranch::class)->create();
    [$location, $user] = $dataSource();
    $user->is_active = false;
    $user->save();
    $user->refresh();

    try {
      $this->actingAs($user, Str::snake(class_basename(get_class(($user)))))->get(route($user->getDashboardRoute()));
    } catch (\Throwable $th) {

      $this->assertEquals(AuthenticationException::class, get_class($th));
      $this->assertEquals('Unauthenticated.', $th->getMessage());
      $this->assertEquals('Account Suspended. Contact your manager.', session()->get('errors')->getBag('default')->messages()['email'][0]);
    }
  }

  /**
   * @test
   * @dataProvider provideDifferentUserTypesWithoutSuperAdmin
   */
  public function an_active_user_can_login($dataSource)
  {
    factory(OfficeBranch::class)->create();
    [$location, $user] = $dataSource();
    $user->is_active = true;
    $user->save();
    $user->refresh();

    $this->actingAs($user, Str::snake(class_basename(get_class(($user)))))->get(route($user->getDashboardRoute()))->assertOk();
  }

  /**
   * @test
   * @dataProvider provideDifferentUserTypesWithoutSuperAdmin
   */
  public function super_admin_can_mark_user_as_inactive($dataSource)
  {
    $this->withoutExceptionHandling();
    [$location, $user] = $dataSource();
    $superAdmin = factory(SuperAdmin::class)->create();

    $response = $this->actingAs($superAdmin, 'super_admin')->put(route('superadmin.manage_staff.' . Str::of(class_basename(get_class(($user))))->snake()->plural() . '.suspend', $user));
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
  public function super_admin_can_restore_suspended_user($dataSource)
  {
    [$location, $user] = $dataSource();
    $user->is_active = false;
    $user->save();

    $superAdmin = factory(SuperAdmin::class)->create();

    $response = $this->actingAs($superAdmin, 'super_admin')->put(route('superadmin.manage_staff.' . Str::of(class_basename(get_class(($user))))->snake()->plural() . '.reactivate', $user));
    $user->refresh();
    $response->assertSessionHasNoErrors();
    $response->assertRedirect();
    $this->assertEquals(true, $user->is_active);
    $response->assertSessionHas('flash.success', 'User account re-activated');
  }
}
