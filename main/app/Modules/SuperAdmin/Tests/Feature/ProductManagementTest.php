<?php

namespace App\Modules\SuperAdmin\Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use App\Modules\Admin\Models\Admin;
use App\Modules\AppUser\Models\AppUser;
use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\WebAdmin\Models\WebAdmin;
use App\Modules\SuperAdmin\Models\Product;
use App\Modules\SuperAdmin\Models\SwapDeal;
use Illuminate\Foundation\Testing\WithFaker;
use App\Modules\Accountant\Models\Accountant;
use App\Modules\AppUser\Models\ProductReceipt;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\StockKeeper\Models\StockKeeper;
use App\Modules\SuperAdmin\Models\SalesChannel;
use App\Modules\SuperAdmin\Models\ProductStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\DispatchAdmin\Models\DispatchAdmin;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\QualityControl\Models\QualityControl;
use App\Modules\SalesRep\Models\ProductDispatchRequest;
use App\Modules\SuperAdmin\Models\SalesRecordBankAccount;
use App\Modules\SuperAdmin\Tests\Traits\PreparesToCreateProduct;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class ProductManagementTest extends TestCase
{
  use RefreshDatabase, WithFaker, PreparesToCreateProduct;

  /** @test */
  public function a_sales_rep_can_mark_a_product_as_sold()
  {
    // $this->withoutExceptionHandling();

    $product = $this->create_product_in_stock();
    $response = $this->actingAs(factory(SalesRep::class)->create(), 'sales_rep')->post(route('salesrep.multiaccess.products.mark_as_sold', $product->product_uuid), $this->data());

    $response->assertSessionHasNoErrors();
    $response->assertRedirect();
    $response->assertSessionMissing('flash.error');
    $response->assertSessionHas('flash.success');


    $product->refresh();

    $this->assertEquals(ProductStatus::soldId(), $product->product_status_id);
    $this->assertInstanceOf(Carbon::class, $product->sold_at);
    $this->assertCount(1, ProductSaleRecord::all());
    $this->assertCount(1, AppUser::all());
    $this->assertEquals($product->app_user_id, AppUser::first()->id);
  }

  /** @test */
  public function a_dispatch_admin_can_mark_a_product_as_sold()
  {

    $this->withoutExceptionHandling();

    $product = $this->create_product_on_delivery();

    $response = $this->actingAs(factory(DispatchAdmin::class)->create(), 'dispatch_admin')->post(route('dispatchadmin.multiaccess.products.mark_as_sold', $product->product_uuid), $this->data());

    // $response->dumpSession();
    // // dump($product->toArray(), request()->all());
    // // dump(AppUser::all()->toArray());

    $response->assertSessionHasNoErrors();
    $response->assertRedirect();
    $response->assertSessionMissing('flash.error');
    $response->assertSessionHas('flash.success');

    $product->refresh();

    $this->assertEquals(ProductStatus::soldId(), $product->product_status_id);
    $this->assertInstanceOf(Carbon::class, $product->sold_at);
    $this->assertCount(1, ProductDispatchRequest::all());
    $this->assertInstanceOf(Carbon::class, ProductDispatchRequest::first()->sold_at);
    $this->assertCount(1, ProductSaleRecord::all());
    $this->assertCount(1, AppUser::all());
    $this->assertEquals($product->app_user_id, AppUser::first()->id);
  }

  /** @test */
  public function a_dispatch_admin_cannot_mark_a_product_in_stock_as_sold()
  {
    $product = $this->create_product_in_stock();
    $response = $this->actingAs(factory(DispatchAdmin::class)->create(), 'dispatch_admin')->post(route('dispatchadmin.multiaccess.products.mark_as_sold', $product->product_uuid), $this->data());

    $response->assertRedirect();
    $response->assertSessionHas('flash.error', "Dispatch Admins can only mark dispatch requests as sold");
    $response->assertSessionMissing('flash.success');

    $product->refresh();

    $this->assertEquals(ProductStatus::inStockId(), $product->product_status_id);
    $this->assertNull($product->sold_at);
    $this->assertCount(0, ProductSaleRecord::all());
    $this->assertCount(0, AppUser::all());
  }


  /** @test */
  public function a_swap_deal_record_will_be_created_if_sold_product_is_a_swap_deal()
  {

    $product = $this->create_product_in_stock();
    $this->actingAs(factory(SalesRep::class)->create(), 'sales_rep')->post(route('salesrep.multiaccess.products.mark_as_sold', $product->product_uuid), array_merge($this->data(), ['is_swap_transaction' => true]));

    $this->assertCount(1, SwapDeal::all());
  }

  /** @test */
  public function only_a_logged_in_user_can_mark_product_as_sold()
  {

    $product = $this->create_product_in_stock();

    $response = $this->post(route('salesrep.multiaccess.products.mark_as_sold', $product));
    $response->assertRedirect(route('app.login'));
  }

  /** @test */
  public function a_product_cannot_be_created_without_correct_data_supplied()
  {
    $product = $this->create_product_in_stock();
    $response = $this->actingAs(factory(SalesRep::class)->create(), 'sales_rep')->post(route('salesrep.multiaccess.products.mark_as_sold', $product->product_uuid));
    $response->assertSessionHasErrors();
  }

  /** @test */
  public function a_product_cannot_be_marked_as_sold_by_unauthorised_users()
  {

    $this->expectException(RouteNotFoundException::class);

    $product = $this->create_product_in_stock();

    $this->actingAs(factory(SuperAdmin::class)->create(), 'super_admin')->post(route('superadmin.multiaccess.products.mark_as_sold', $product->product_uuid))->assertRedirect(route('app.login'));
    $this->actingAs(factory(Admin::class)->create(), 'admin')->post(route('admin.multiaccess.products.mark_as_sold', $product->product_uuid))->assertRedirect(route('app.login'));
    $this->actingAs(factory(WebAdmin::class)->create(), 'web_admin')->post(route('webadmin.multiaccess.products.mark_as_sold', $product->product_uuid))->assertRedirect(route('app.login'));
    $this->actingAs(factory(Accountant::class)->create(), 'accountant')->post(route('accountant.multiaccess.products.mark_as_sold', $product->product_uuid))->assertRedirect(route('app.login'));
    $this->actingAs(factory(QualityControl::class)->create(), 'quality_control')->post(route('qualitycontrol.multiaccess.products.mark_as_sold', $product->product_uuid))->assertRedirect(route('app.login'));
    $this->actingAs(factory(StockKeeper::class)->create(), 'stock_keeper')->post(route('stockkeeper.multiaccess.products.mark_as_sold', $product->product_uuid))->assertRedirect(route('app.login'));
    $this->actingAs(factory(AppUser::class)->create())->post(route('salesrep.multiaccess.products.mark_as_sold', $product->product_uuid))->assertRedirect(route('app.login'));

    /**
     * Make sure the product is still in stock
     */
    $this->assertEquals(ProductStatus::inStockId(), $product->refresh()->product_status_id);

    /**
     * Test this after other tests cos test breaks on exception thrown
     */
    $this->actingAs(factory(AppUser::class)->create())->post(route('appuser.multiaccess.products.mark_as_sold', $product->product_uuid));
  }

  /** @test */
  public function an_existing_user_will_have_their_details_updated_on_mark_product_as_sold()
  {
    $product = $this->create_product_in_stock();

    $this->actingAs(factory(SalesRep::class)->create(), 'sales_rep')->post(route('salesrep.multiaccess.products.mark_as_sold', $product->product_uuid), $this->data());

    $product = factory(Product::class)->create(['product_status_id' => ProductStatus::inStockId()]);
    $this->actingAs(factory(SalesRep::class)->create(), 'sales_rep')->post(route('salesrep.multiaccess.products.mark_as_sold', $product->product_uuid), array_merge($this->data(), ['phone' => '08034411661']));

    $product = factory(Product::class)->create(['product_status_id' => ProductStatus::inStockId()]);
    $this->actingAs(factory(SalesRep::class)->create(), 'sales_rep')->post(route('salesrep.multiaccess.products.mark_as_sold', $product->product_uuid), array_merge($this->data(), ['phone' => '08034411661', 'email' => 'xavi7th@gmail.com']));

    $this->assertCount(2, AppUser::all());
    $this->assertEquals('xavi7th@gmail.com', AppUser::latest('id')->first()->email);
  }

  /** @test */
  public function superadmin_can_reverse_a_product_from_sold_to_in_stock()
  {
    $product = $this->create_sold_product();
    $this->actingAs($superAdmin = factory(SuperAdmin::class)->create(), 'super_admin')->put(route('superadmin.products.mark_as_sold.reverse', $product->product_uuid));

    $product->refresh();

    $this->assertEquals(ProductStatus::inStockId(), $product->product_status_id);
    $this->assertCount(0, ProductSaleRecord::all());
    $this->assertCount(0, AppUser::all());
    $this->assertNull($product->app_user_id);
    $this->assertNull($product->sold_at);

    /** LOGOUT required before acting as another user because of authenticatesSession middleware */
    $this->actingAs($superAdmin, 'super_admin')->post(route('app.logout'));

    /** Test that a sales rep can now mark that same product as sold again */
    $response = $this->actingAs(factory(SalesRep::class)->create(), 'sales_rep')->post(route('salesrep.multiaccess.products.mark_as_sold', $product->product_uuid), $this->data());

    $response->assertSessionHasNoErrors();
    $response->assertRedirect();
    $response->assertSessionMissing('flash.error');
    $response->assertSessionHas('flash.success');

    $product->refresh();

    $this->assertEquals(ProductStatus::soldId(), $product->product_status_id);
    $this->assertInstanceOf(Carbon::class, $product->sold_at);
    $this->assertCount(1, ProductSaleRecord::all());
    $this->assertCount(1, AppUser::all());
    $this->assertEquals($product->app_user_id, AppUser::first()->id);
  }

  /** @test */
  public function superadmin_can_reverse_a_product_from_sale_confirmed_to_in_stock()
  {
    $this->withoutExceptionHandling();

    $product = $this->create_sale_confirmed_product();
    $this->actingAs($superAdmin = factory(SuperAdmin::class)->create(), 'super_admin')->put(route('superadmin.products.confirm_sale.reverse', $product->product_uuid));

    $product->refresh();

    $this->assertEquals(ProductStatus::inStockId(), $product->product_status_id);
    $this->assertCount(0, ProductSaleRecord::all());
    $this->assertCount(0, AppUser::all());
    $this->assertCount(0, SalesRecordBankAccount::all());
    $this->assertCount(0, ProductReceipt::all());
    $this->assertNull($product->app_user_id);
    $this->assertNull($product->sold_at);

    /** LOGOUT required before acting as another user because of authenticatesSession middleware */
    $this->actingAs($superAdmin, 'super_admin')->post(route('app.logout'));

    /** Test that a sales rep can now mark that same product as sold again */
    $response = $this->actingAs(factory(SalesRep::class)->create(), 'sales_rep')->post(route('salesrep.multiaccess.products.mark_as_sold', $product->product_uuid), $this->data());

    $response->assertSessionHasNoErrors();
    $response->assertRedirect();
    $response->assertSessionMissing('flash.error');
    $response->assertSessionHas('flash.success');

    $product->refresh();

    $this->assertEquals(ProductStatus::soldId(), $product->product_status_id);
    $this->assertInstanceOf(Carbon::class, $product->sold_at);
    $this->assertCount(1, ProductSaleRecord::all());
    $this->assertCount(1, AppUser::all());
    $this->assertEquals($product->app_user_id, AppUser::first()->id);
  }

  /** @test */
  public function super_admin_can_mark_a_local_product_as_supplier_paid()
  {
    // Test that the correct history is recorded in the static boot method of the prioduct model
    $product = $this->create_local_product($unpaid = true);
    $response = $this->actingAs(factory(SuperAdmin::class)->create(), 'super_admin')->put(route('superadmin.products.mark_local_product_as_paid', $product->product_uuid));

    $product->refresh();

    $this->assertEquals(true, $product->is_paid);
    $response->assertSessionHasNoErrors();
    $response->assertRedirect();
    $response->assertSessionMissing('flash.error');
    $response->assertSessionHas('flash.success', 'Marked as paid');
  }

  private function data()
  {
    return [
      'selling_price' => 1000000,
      'first_name' => $this->faker->firstName,
      'last_name' => $this->faker->lastName,
      'phone' => $this->faker->e164PhoneNumber,
      'email' => $this->faker->email,
      'address' => $this->faker->address,
      'city' => $this->faker->city,
      'sales_channel_id' => SalesChannel::inRandomOrder()->first()->id,
      'ig_handle' => $this->faker->domainWord,
      'online_rep_id' => SalesRep::inRandomOrder()->first()->id,
      'is_swap_transaction' => null, //$is_swap = $this->faker->randomElement([true, null]),
      'description' => $this->faker->sentence,
      'owner_details' =>  $this->faker->name,
      'id_card' =>  UploadedFile::fake()->image('id_card.jpg'),
      'receipt' =>  UploadedFile::fake()->image('receipt.jpg'),
      'swap_value' =>  $this->faker->randomNumber(5),
      'imei' => ($imei = $this->faker->randomElement([true, false]) ? Str::random(16) : null),
      'serial_no' => ($serial_no = $imei == null ? ($this->faker->randomElement([true, false]) ? Str::random(16) : null) : null),
      'model_no' => ($serial_no == null && $imei == null ? Str::random(16) : null),
    ];
  }
}
