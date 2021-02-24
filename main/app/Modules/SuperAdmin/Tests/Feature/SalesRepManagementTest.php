<?php

namespace App\Modules\SuperAdmin\Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\SuperAdmin\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\SuperAdmin\Models\OfficeBranch;
use App\Modules\SuperAdmin\Models\ProductModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\SuperAdmin\Tests\Traits\PreparesToCreateProduct;

class SalesRepManagementTest extends TestCase
{
  use RefreshDatabase, PreparesToCreateProduct;

  /** @test */
  public function a_social_media_rep_can_only_see_available_product_models_in_product_list()
  {
    $this->prepare_to_create_product();
    factory(OfficeBranch::class)->create();
    factory(ProductModel::class, 123)->create();
    factory(Product::class, 1000)->create();
    /** @var SalesRep */
    $salesRep = factory(SalesRep::class)->create(['unit' => 'social-media']);

    $rsp = $this->actingAs($salesRep, Str::snake(class_basename(get_class(($salesRep)))))->get(route(strtolower($salesRep->getType()) . '.multiaccess.products.view_products'))
    ->assertOk()
      ->assertSessionHasNoErrors()
      ->assertSessionMissing('flash.error');

    $page = $this->getResponseData($rsp);

    $this->assertEquals('SalesRep,SalesRepDashboard', $page->component);
    $this->assertNull($page->props->errors);
    $this->assertArrayHasKey('total_monthly_sale_count', (array)$page->props->statistics);
    $this->assertArrayHasKey('total_monthly_sale_profit', (array)$page->props->statistics);
  }
}
