<?php

namespace App\Modules\SuperAdmin\Tests\Feature;

use Tests\TestCase;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\Reseller;
use Illuminate\Foundation\Testing\WithFaker;
use App\Modules\StockKeeper\Models\StockKeeper;
use App\Modules\SuperAdmin\Models\OfficeBranch;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Models\ResellerHistory;
use App\Modules\SuperAdmin\Models\ResellerProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\SuperAdmin\Tests\Traits\PreparesToCreateProduct;

class ResellerManagementTest extends TestCase
{
  use RefreshDatabase, PreparesToCreateProduct;

  /** @test */
  public function functionStockKeeperCanGiveProductToReseller()
  {
    $this->withoutExceptionHandling();

    factory(OfficeBranch::class)->create();
    /** @var StockKeeper */
    $user = factory(StockKeeper::class)->create(['id' => 2]);
    /** @var Product */
    $product = $this->create_product_in_stock();
    /** @var Reseller */
    $reseller = factory(Reseller::class)->create(['id' => 2]);

    // ray($user);

    $response = $this->actingAs($user, 'stock_keeper')->post(route('stockkeeper.resellers.give_product', [$reseller, $product->product_uuid]));
    $product->refresh();


    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
    $response->assertSessionHas('flash.success','Done. Product has been removed from stock list');
    $this->assertEquals(ProductStatus::withResellerId(), $product->product_status_id);
    $this->assertCount(1, ResellerHistory::all());
    $this->assertCount(1, ResellerProduct::all());
    $this->assertEquals($product->id, ResellerHistory::first()->product_id);
    $this->assertEquals($user->id, ResellerHistory::first()->handled_by);
    $this->assertEquals(StockKeeper::class, ResellerHistory::first()->handler_type);
    $this->assertEquals('tenured', ResellerProduct::first()->status);


  }
}
