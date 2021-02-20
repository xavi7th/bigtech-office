<?php

namespace App\Modules\SuperAdmin\Tests\Unit;

use Tests\TestCase;
use App\Modules\SuperAdmin\Models\Reseller;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Models\ResellerProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\SuperAdmin\Tests\Traits\PreparesToCreateProduct;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ResellerTest extends TestCase
{
  use RefreshDatabase, PreparesToCreateProduct;

  /** @test */
  public function resellerCanBeGivenProduct()
  {
    /** @var Reseller */
    $reseller = factory(Reseller::class)->create(['id' => 2]);
    /** @var Product */
    $product = $this->create_product_in_stock();
    $product = $reseller->giveProduct($product->product_uuid);

    $this->assertEquals(ProductStatus::withResellerId(), $product->product_status_id);
    $this->assertCount(1, ResellerProduct::all());
    $this->assertEquals('tenured', ResellerProduct::first()->status);
    $this->assertEquals($reseller->id, ResellerProduct::first()->reseller_id);
    $this->assertEquals($product->id, ResellerProduct::first()->product_id);
  }

  /** @test */
  public function resellerCanNotBeGivenProductNotInStock()
  {
    $this->expectException(HttpException::class);
    $this->expectExceptionMessage('productNotInStock');

    /** @var Product */
    $product = $this->create_product_on_delivery();
    /** @var Reseller */
    $reseller = factory(Reseller::class)->create(['id' => 2]);

    $product = $reseller->giveProduct($product->product_uuid);
  }

  /** @test */
  public function resellerCanReturnProduct()
  {
    /** @var Reseller */
    $reseller = factory(Reseller::class)->create(['id' => 2]);
    /** @var Product */
    $product = $this->create_product_in_stock();

    $product = $reseller->giveProduct($product->product_uuid);
    $product = $reseller->returnProduct($product->product_uuid);

    $this->assertEquals(ProductStatus::inStockId(), $product->product_status_id);
    $this->assertCount(1, ResellerProduct::all());
    $this->assertEquals('returned', ResellerProduct::first()->status);
    $this->assertEquals($reseller->id, ResellerProduct::first()->reseller_id);
    $this->assertEquals($product->id, ResellerProduct::first()->product_id);
  }

  /** @test */
  public function resellerCanNotReturnProductNotCollected()
  {
    $this->expectException(HttpException::class);
    $this->expectExceptionMessage('productNotWithReseller');

    /** @var Reseller */
    $reseller = factory(Reseller::class)->create(['id' => 2]);
    /** @var Product */
    $product = $this->create_product_in_stock();

    $reseller->returnProduct($product->product_uuid);
  }

  /** @test */
  public function resellerCanRecollectReturnedProduct()
  {
    /** @var Reseller */
    $reseller = factory(Reseller::class)->create(['id' => 2]);
    /** @var Product */
    $product = $this->create_product_in_stock();

    $product = $reseller->giveProduct($product->product_uuid);
    $product = $reseller->returnProduct($product->product_uuid);
    $product = $reseller->giveProduct($product->product_uuid);

    // $this->assertEquals(ProductStatus::inStockId(), $product->product_status_id);
    // $this->assertCount(1, ResellerProduct::all());
    // $this->assertEquals('returned', ResellerProduct::first()->status);
    // $this->assertEquals($reseller->id, ResellerProduct::first()->reseller_id);
    // $this->assertEquals($product->id, ResellerProduct::first()->product_id);


    $this->assertEquals(ProductStatus::withResellerId(), $product->product_status_id);
    $this->assertCount(1, ResellerProduct::all());
    $this->assertEquals('tenured', ResellerProduct::first()->status);
    $this->assertEquals($reseller->id, ResellerProduct::first()->reseller_id);
    $this->assertEquals($product->id, ResellerProduct::first()->product_id);
  }
}
