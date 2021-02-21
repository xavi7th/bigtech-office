<?php

namespace App\Modules\SuperAdmin\Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\DispatchAdmin\Models\DispatchAdmin;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Tests\Traits\PreparesToCreateProduct;
use App\Modules\SuperAdmin\Tests\Traits\ProvidesDifferentUserDataTypes;

class DispatchAdminManagementTest extends TestCase
{
  use RefreshDatabase, PreparesToCreateProduct, ProvidesDifferentUserDataTypes;

  /** @test */
  public function dispatch_admin_can_view_product_list()
  {
    // $this->withoutExceptionHandling();

    $this->prepare_to_create_product();
    factory(Product::class, 200)->create(['is_local' => false]);
    /** @var DispatchAdmin */
    $dispatchAdmin = factory(DispatchAdmin::class)->create();

    $rsp = $this->actingAs($dispatchAdmin, Str::snake(class_basename(get_class(($dispatchAdmin)))))->get(route(strtolower($dispatchAdmin->getType()) . '.multiaccess.products.view_products'));

    $page = $this->_arrayToObject($rsp->getOriginalContent()->getData()['page']);

    // ray()->clearAll();
    // ray((array)$page->props);

    $this->assertEquals('SuperAdmin,Products/ListProducts', $page->component);
    $this->assertNull($page->props->errors);
    $this->assertArrayHasKey('products', (array)$page->props);
    $this->assertCount(10, (array)$page->props->products);
    $this->assertArrayHasKey('salesChannel', (array)$page->props);
    $this->assertNotCount(0, (array)$page->props->salesChannel);
  }

  /** @test */
  public function dispatch_admin_can_view_dispatch_requests()
  {
    $this->prepare_to_create_product();
    factory(Product::class, 200)->create(['is_local' => false, 'product_status_id' => ProductStatus::inStockId()]);
    factory(Product::class, 12)->create(['is_local' => false, 'product_status_id' => ProductStatus::scheduledDeliveryId()]);
    /** @var DispatchAdmin */
    $dispatchAdmin = factory(DispatchAdmin::class)->create();

    $this->assertCount(212, Product::all());

    $rsp = $this->actingAs($dispatchAdmin, Str::snake(class_basename(get_class(($dispatchAdmin)))))->get(route(strtolower($dispatchAdmin->getType()) . '.products.products_on_delivery'))
      ->assertOk()
      ->assertSessionHasNoErrors()
      ->assertSessionMissing('flash.error');

    $page = $this->_arrayToObject($rsp->getOriginalContent()->getData()['page']);

    ray()->clearAll();
    ray((array)$page->props);

    $this->assertEquals('SuperAdmin,Products/ListProducts', $page->component);
    $this->assertNull($page->props->errors);
    $this->assertArrayHasKey('products', (array)$page->props);
    $this->assertCount(12, (array)$page->props->products);
    $this->assertArrayHasKey('salesChannel', (array)$page->props);
    $this->assertNotCount(0, (array)$page->props->salesChannel);
  }

  /**
   * @test
   * @dataProvider provideDifferentUserTypesWithoutDispatchAdmin
   */
  public function other_users_cannot_view_dispatch_requests($dataSource)
  {
    // $this->withoutExceptionHandling();

    [$location, $user] = $dataSource();

    $rsp = $this->actingAs($user, Str::snake(class_basename(get_class(($user)))))->get(route('dispatchadmin.products.products_on_delivery'))
      ->assertRedirect(route('app.login'))
      ->assertSessionHasNoErrors()
      ->assertSessionMissing('flash.error');
  }
}
