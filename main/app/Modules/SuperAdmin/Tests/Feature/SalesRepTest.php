<?php

namespace App\Modules\SuperAdmin\Tests\Feature;

use App\Modules\SalesRep\Models\SalesRep;
use App\Modules\SuperAdmin\Models\OfficeBranch;
use App\Modules\SuperAdmin\Models\SuperAdmin;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SalesRepTest extends TestCase
{
  use RefreshDatabase;

    /** @test */
  public function function_super_admin_can_view_sales_reps_list()
  {
    $this->withoutExceptionHandling();

    factory(OfficeBranch::class)->create();
    factory(SalesRep::class, 20)->create();

    $response = $this->actingAs(factory(SuperAdmin::class)->create(), 'super_admin')->get(route('superadmin.manage_staff.sales_reps'));

    $page = $this->_arrayToObject($response->getOriginalContent()->getData()['page']);

    // ray($page);

    $this->assertEquals('SuperAdmin,ManageStaff/ManageSalesReps', $page->component);
    $this->assertNull($page->props->errors);
    /** Asserting 19 because of the globalQueryScope */
    $this->assertCount(19, (array)$page->props->salesReps);
  }
}
