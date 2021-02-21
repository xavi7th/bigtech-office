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
use App\Modules\SuperAdmin\Models\SuperAdmin;
use App\Modules\AppUser\Models\ProductReceipt;
use App\Modules\SuperAdmin\Models\StorageSize;
use App\Modules\SuperAdmin\Models\StorageType;
use App\Modules\StockKeeper\Models\StockKeeper;
use App\Modules\SuperAdmin\Models\OfficeBranch;
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
use App\Modules\SuperAdmin\Models\LocalProductPrice;
use App\Modules\SuperAdmin\Models\ProductSaleRecord;
use App\Modules\QualityControl\Models\QualityControl;
use App\Modules\SalesRep\Models\ProductDispatchRequest;
use App\Modules\SuperAdmin\Models\SalesRecordBankAccount;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use App\Modules\SuperAdmin\Tests\Traits\PreparesToCreateProduct;
use Illuminate\Auth\AuthenticationException;

class ProductManagementTest extends TestCase
{
  use RefreshDatabase, WithFaker, PreparesToCreateProduct;

  // /**
  //  * @test
  //  */
  // public function a_product_cannot_be_created_without_correct_data_supplied()
  // {
  //   $product = $this->create_product_in_stock();
  //   $response = $this->actingAs(factory(SalesRep::class)->create(), 'sales_rep')->post(route('salesrep.multiaccess.products.mark_as_sold', $product->product_uuid));
  //   $response->assertSessionHasNoErrors();
  // }

  /** @test */
  public function accountant_can_create_local_product()
  {
    $this->prepare_to_create_product();
    $accountant = factory(Accountant::class)->create();

    $this->actingAs($accountant, 'accountant')->post(route('accountant.products.create_local'), array_merge($this->data(), ['cost_price' => 2000, 'proposed_selling_price' => 5000]))
      ->assertSessionHasNoErrors()
      ->assertRedirect()
      ->assertSessionMissing('flash.error')
      ->assertSessionHas('flash.success', 'Product created');


    $this->assertCount(1, Product::all());
    $this->assertCount(1, LocalProductPrice::all());
    $this->assertEquals(2000, Product::first()->cost_price);
    $this->assertEquals(5000, Product::first()->proposed_selling_price);
  }

  /**
   * @test
   * @dataProvider provideDifferentUserTypes
   */
  public function other_users_cannot_create_local_product($getDataSource)
  {
    // $this->withoutExceptionHandling();
    // $this->expectException(AuthenticationException::class);

    [$location, $user] = $getDataSource();
    ray([$location, $user]);

    $this->prepare_to_create_product();

    $this->actingAs($user, Str::snake(class_basename(get_class(($user)))))->post(route('accountant.products.create_local'), array_merge($this->data(), ['cost_price' => 2000, 'proposed_selling_price' => 5000]))
      ->assertRedirect(route('app.login'))
      ->assertSessionMissing('flash.success');
  }

  /** @test */
  public function accountant_can_edit_local_product_price()
  {
    $this->prepare_to_create_product();
    $accountant = factory(Accountant::class)->create();

    $this->actingAs($accountant, 'accountant')->post(route('accountant.products.create_local'), array_merge($this->data(), ['cost_price' => 2000, 'proposed_selling_price' => 5000]));

    $this->assertCount(1, Product::all());

    $product = Product::first();

    $this->actingAs($accountant, 'accountant')->patch(route('accountant.products.local.edit_price', $product->product_uuid), ['cost_price' => 3000, 'proposed_selling_price' => 15000])
      ->assertSessionHasNoErrors()
      ->assertRedirect()
      ->assertSessionHas('flash.success', 'Product price updated');

    $product->refresh();

    $this->assertCount(1, LocalProductPrice::all());
    $this->assertEquals(3000, $product->cost_price);
    $this->assertEquals(15000, $product->proposed_selling_price);
  }

  /**
   * @test
   * @dataProvider provideDifferentUserTypes
   */
  public function other_users_cannot_edit_local_product_price($getDataSource)
  {
    // $this->withoutExceptionHandling();
    // $this->expectException(AuthenticationException::class);

    [$location, $user] = $getDataSource();

    $this->prepare_to_create_product();
    $accountant = factory(Accountant::class)->create();
    $this->actingAs($accountant, 'accountant')->post(route('accountant.products.create_local'), array_merge($this->data(), ['cost_price' => 2000, 'proposed_selling_price' => 5000]));
    $this->assertCount(1, Product::all());
    $this->actingAs($accountant)->post(route('app.logout'));

    $product = Product::first();

    $this->actingAs($user, Str::snake(class_basename(get_class(($user)))))->patch(route('accountant.products.local.edit_price', $product->product_uuid), array_merge($this->data(), ['cost_price' => 3000, 'proposed_selling_price' => 15000]))
      ->assertRedirect(route('app.login'))
      ->assertSessionMissing('flash.success');
  }

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

  /**
   * @test
   * @dataProvider markProductAsSoldValidationDataProvider
   */
  public function a_product_cannot_be_marked_as_sold_without_correct_data_supplied($formInput, $formInputValue)
  {
    ray($formInput, $formInputValue);

    $product = $this->create_product_in_stock();
    $response = $this->actingAs(factory(SalesRep::class)->create(), 'sales_rep')->post(route('salesrep.multiaccess.products.mark_as_sold', $product->product_uuid), is_array($formInputValue) ? $formInputValue : [$formInput => $formInputValue]);
    $response->assertSessionHasErrors($formInput);
    // $response->assertSessionHasErrors('other');
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
    $product = $this->create_local_product(['is_paid' => true]);
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
      'proposed_selling_price' => 1000000,
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
      'processor_speed_id' => ProcessorSpeed::first()->id,
      'product_category_id' => ProductCategory::first()->id,
      'storage_type_id' => StorageType::first()->id,
      'storage_size_id' => StorageSize::first()->id,
      'product_color_id' => ProductColor::first()->id,
      'product_supplier_id' => ProductSupplier::inRandomOrder()->first()->id,
      'product_grade_id' => ProductGrade::first()->id,
      'product_brand_id' => ProductBrand::first()->id,
      'product_model_id' => ProductModel::first()->id,
    ];
  }

  public function createProductValidationDataProvider()
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

  public function markProductAsSoldValidationDataProvider()
  {
    return [
      'selling_price_required' => ['selling_price', ''],
      'selling_price_numeric' => ['selling_price', 'yjyu'],
      'first_name_required' => ['first_name', ''],
      'phone_required' => ['phone', ''],
      'phone_regex' => ['phone', '54uhgj'],
      'email_required' => ['email', ''],
      'email_valid' => ['email', 'lorem-ipsum'],
      'address_required' => ['address', ''],
      'city_required' => ['city', ''],
      'sales_channel_id_required' => ['sales_channel_id', ''],
      'sales_channel_id_exists' => ['sales_channel_id', 30],
      'online_rep_id_exists' => ['online_rep_id', 5],
      'description_required_if' => ['description',  ['description' => '', 'is_swap_transaction' => true]],
      'owner_details_required_if' => ['owner_details',  ['owner_details' => '', 'is_swap_transaction' => true]],
      'id_card_required_if' => ['id_card',  ['id_card' => '', 'is_swap_transaction' => true]],
      'receipt_required_if' => ['receipt',  ['receipt' => '', 'is_swap_transaction' => true]],
      'swap_value_required_if' => ['swap_value',  ['swap_value' => '', 'is_swap_transaction' => true]],
      // 'imei_required_if' => ['imei',  ['imei' => '', 'is_swap_transaction' => true]],
      // 'serial_no_required_if' => ['serial_no',  ['serial_no' => '', 'is_swap_transaction' => true]],
      // 'model_no_required_if' => ['model_no',  ['model_no' => '', 'is_swap_transaction' => true]],
    ];
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
      // 'accountant' => [
      //   fn () => [factory(OfficeBranch::class)->create(), factory(Accountant::class)->create(['id' => 30])],
      // ],
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
