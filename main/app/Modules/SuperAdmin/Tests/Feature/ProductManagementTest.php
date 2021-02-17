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
use App\Modules\SuperAdmin\Models\StorageSize;
use App\Modules\SuperAdmin\Models\StorageType;
use App\Modules\StockKeeper\Models\StockKeeper;
use App\Modules\SuperAdmin\Models\OfficeBranch;
use App\Modules\SuperAdmin\Models\ProductBatch;
use App\Modules\SuperAdmin\Models\ProductBrand;
use App\Modules\SuperAdmin\Models\ProductColor;
use App\Modules\SuperAdmin\Models\ProductGrade;
use App\Modules\SuperAdmin\Models\ProductModel;
use App\Modules\SuperAdmin\Models\SalesChannel;
use App\Modules\SuperAdmin\Models\ProductStatus;
use App\Modules\SuperAdmin\Models\ProcessorSpeed;
use App\Modules\SuperAdmin\Models\ProductCategory;
use App\Modules\SuperAdmin\Models\ProductSupplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\DispatchAdmin\Models\DispatchAdmin;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\QualityControl\Models\QualityControl;
use App\Modules\SalesRep\Models\ProductDispatchRequest;
use App\Modules\SuperAdmin\Models\CompanyBankAccount;
use App\Modules\SuperAdmin\Models\SalesRecordBankAccount;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class ProductManagementTest extends TestCase
{
  use RefreshDatabase, WithFaker;

  /** @test */
  public function function_a_sales_rep_can_mark_a_product_as_sold()
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
  public function function_a_dispatch_admin_can_mark_a_product_as_sold()
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
  public function function_a_dispatch_admin_cannot_mark_a_product_in_stock_as_sold()
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
  public function function_a_swap_deal_record_will_be_created_if_sold_product_is_a_swap_deal()
  {

    $product = $this->create_product_in_stock();
    $this->actingAs(factory(SalesRep::class)->create(), 'sales_rep')->post(route('salesrep.multiaccess.products.mark_as_sold', $product->product_uuid), array_merge($this->data(), ['is_swap_transaction' => true]));

    $this->assertCount(1, SwapDeal::all());
  }

  /** @test */
  public function function_only_a_logged_in_user_can_mark_product_as_sold()
  {

    $product = $this->create_product_in_stock();

    $response = $this->post(route('salesrep.multiaccess.products.mark_as_sold', $product));
    $response->assertRedirect(route('app.login'));
  }

  /** @test */
  public function function_a_product_cannot_be_created_without_correct_data_supplied()
  {
    $product = $this->create_product_in_stock();
    $response = $this->actingAs(factory(SalesRep::class)->create(), 'sales_rep')->post(route('salesrep.multiaccess.products.mark_as_sold', $product->product_uuid));
    $response->assertSessionHasErrors();
  }

  /** @test */
  public function function_a_product_cannot_be_marked_as_sold_by_unauthorised_users()
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
  public function function_an_existing_user_will_have_their_details_updated_on_mark_product_as_sold()
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
  public function function_superadmin_can_reverse_a_product_from_sold_to_in_stock()
  {
    $product = $this->create_sold_product();
    $this->actingAs(factory(SuperAdmin::class)->create(), 'super_admin')->put(route('superadmin.products.mark_as_sold.reverse', $product->product_uuid));

    $product->refresh();

    $this->assertEquals(ProductStatus::inStockId(), $product->product_status_id);
    $this->assertCount(0, ProductSaleRecord::all());
    $this->assertCount(0, AppUser::all());
    $this->assertNull($product->app_user_id);
    $this->assertNull($product->sold_at);

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
  public function function_superadmin_can_reverse_a_product_from_sale_confirmed_to_in_stock()
  {
    $this->withoutExceptionHandling();

    $product = $this->create_sale_confirmed_product();
    $this->actingAs(factory(SuperAdmin::class)->create(), 'super_admin')->put(route('superadmin.products.confirm_sale.reverse', $product->product_uuid));

    $product->refresh();

    $this->assertEquals(ProductStatus::inStockId(), $product->product_status_id);
    $this->assertCount(0, ProductSaleRecord::all());
    $this->assertCount(0, AppUser::all());
    $this->assertCount(0, SalesRecordBankAccount::all());
    $this->assertCount(0, ProductReceipt::all());
    $this->assertNull($product->app_user_id);
    $this->assertNull($product->sold_at);

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
  public function function_super_admin_can_mark_a_local_product_as_supplier_paid()
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

  private function create_product_in_stock()
  {
    $this->prepare_to_create_product();
    $product = factory(Product::class)->create(['product_status_id' => ProductStatus::inStockId()]);

    $this->assertEquals(ProductStatus::inStockId(), $product->product_status_id);

    return $product;
  }

  private function create_product_on_delivery()
  {
    $this->prepare_to_create_product();


    $product = factory(Product::class)->create(['product_status_id' => ProductStatus::scheduledDeliveryId()]);
    $user = factory(SalesRep::class)->create(['unit' => 'social-media']);

    $user->product_dispatch_requests()->create([
      'product_description' => $this->faker->sentence,
      'proposed_selling_price' => $this->faker->randomFloat(2, 40000),
      'customer_first_name' => $this->faker->firstName,
      'customer_last_name' => $this->faker->lastName,
      'customer_phone' => $this->faker->phoneNumber,
      'customer_email' => $this->faker->email,
      'customer_address' => $this->faker->address,
      'customer_city' => $this->faker->city,
      'sales_channel_id' => SalesChannel::inRandomOrder()->first()->id,
      'customer_ig_handle' => $this->faker->word,
      'product_id' => $product->id,
      'product_type' => get_class($product),
      'scheduled_at' => now(),
    ]);


    $this->assertEquals(ProductStatus::scheduledDeliveryId(), $product->product_status_id);
    $this->assertEquals(true, $product->dispatch_request()->exists());

    return $product;
  }

  private function create_sold_product(): Product
  {
    $this->prepare_to_create_product();

    $appUser = factory(AppUser::class)->create();
    $product = factory(Product::class)->create(['product_status_id' => ProductStatus::soldId(), 'app_user_id' => $appUser->id]);
    factory(SalesRep::class)->create(['unit' => 'walk-in']);
    factory(SalesRep::class)->create(['unit' => 'social-media']);

    $product->product_sales_record()->create([
      'selling_price' => $this->faker->randomFloat(2, 40000),
      'online_rep_id' => SalesRep::socialMedia()->inRandomOrder()->first()->id,
      'sales_rep_id' => ($salesRep = SalesRep::walkIn()->inRandomOrder()->first())->id,
      'sales_rep_type' => get_class($salesRep),
      'sales_channel_id' => SalesChannel::first()->id,
      'is_swap_transaction' => false
    ]);

    $this->assertCount(1, ProductSaleRecord::all());
    $this->assertCount(1, AppUser::all());
    $this->assertEquals(true, $product->product_sales_record()->exists());
    $this->assertEquals($appUser->id, $product->app_user_id);

    return $product;
  }

  private function create_sale_confirmed_product(): Product
  {
    $this->prepare_to_create_product();

    $appUser = factory(AppUser::class)->create();
    $product = factory(Product::class)->create(['product_status_id' => ProductStatus::soldId(), 'app_user_id' => $appUser->id]);
    factory(SalesRep::class)->create(['unit' => 'walk-in']);
    factory(SalesRep::class)->create(['unit' => 'social-media']);
    $companyBankAccount = factory(CompanyBankAccount::class)->create();

    $product->product_sales_record()->create([
      'selling_price' => $this->faker->randomFloat(2, 40000),
      'online_rep_id' => SalesRep::socialMedia()->inRandomOrder()->first()->id,
      'sales_rep_id' => ($salesRep = SalesRep::walkIn()->inRandomOrder()->first())->id,
      'sales_rep_type' => get_class($salesRep),
      'sales_channel_id' => SalesChannel::first()->id,
      'is_swap_transaction' => false
    ]);

    $product->product_sales_record()->latest('id')->first()->bank_account_payments()->save($companyBankAccount, [
      'amount' => 600000
    ]);

    $product->generateReceipt(600000);

    $this->assertCount(1, ProductSaleRecord::all());
    $this->assertCount(1, CompanyBankAccount::all());
    $this->assertCount(1, SalesRecordBankAccount::all());
    $this->assertCount(1, AppUser::all());
    $this->assertCount(1, ProductReceipt::all());
    $this->assertEquals(true, $product->product_sales_record()->exists());
    $this->assertEquals($appUser->id, $product->app_user_id);

    return $product;
  }

  private function create_local_product(bool $unpaid): Product
  {
    $this->prepare_to_create_product();

    $product = factory(Product::class)->create(['is_local' => true, 'is_paid' => $unpaid]);

    $this->assertCount(1, Product::all());

    return $product;
  }

  private function prepare_to_create_product()
  {
    factory(OfficeBranch::class)->create();
    factory(ProductCategory::class)->create();
    factory(ProductBrand::class)->create();
    factory(ProductModel::class)->create();
    factory(ProductBatch::class)->create();
    factory(ProductColor::class)->create();
    factory(ProductGrade::class)->create();
    factory(ProductSupplier::class)->create();
    factory(ProductStatus::class)->create(['status' => 'in stock']);
    factory(ProductStatus::class)->create(['status' => 'out for delivery']);
    factory(ProductStatus::class)->create(['status' => 'sold']);
    factory(ProductStatus::class)->create(['status' => 'sale confirmed']);
    factory(ProductStatus::class)->create(['status' => 'sold by reseller']);
    factory(ProductStatus::class)->create(['status' => 'undergoing qa']);
    factory(StorageSize::class)->create();
    factory(ProcessorSpeed::class)->create();
    factory(StorageType::class)->create();
    factory(StockKeeper::class, 2)->create();
    factory(SalesChannel::class)->create(['channel_name' => 'Instagram']);
    factory(SalesRep::class, 2)->create();
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
