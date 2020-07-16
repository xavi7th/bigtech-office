<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@user-shared/FlashMessage";
  import Icon from "@superadmin-shared/Partials/TableSortIcon";
  import route from "ziggy";

  $: ({ app, swapDeals } = $page);
  console.log(swapDeals);
</script>

<Layout title="Awoof Deals">
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="table-responsive">
        <table
          class="rui-datatable table table-striped table-bordered table-sm"
          data-datatable-order="0:desc">
          <thead class="thead-dark">
            <tr>
              <th scope="col">
                #
                <Icon />
              </th>
              <th scope="col">
                Description
                <Icon />
              </th>
              <th scope="col">
                Product ID
                <Icon />
              </th>
              <th scope="col">
                Selling Price
                <Icon />
              </th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">16</th>
              <td>Blue samsung s7 edge with small crack on the screen</td>
              <td>imei: 65879G95ldJMbs5X10VnUL1</td>
              <td>N306,418.20</td>
              <td class="nowrap">
                <InertiaLink
                  type="button"
                  href={route('superadmin.products.swap_deal_details', '0a93adb9-94d7-4eaf-9916-90e198478d38')}
                  class="btn btn-primary btn-sm">
                  Details
                </InertiaLink>
                <InertiaLink
                  type="button"
                  href={route('superadmin.products.view_product_details', 2)}
                  class="btn btn-success btn-sm">
                  Sold
                </InertiaLink>
                <InertiaLink
                  type="button"
                  href={route('superadmin.products.view_product_details', 1)}
                  class="btn btn-brand btn-sm">
                  Paid
                </InertiaLink>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</Layout>
