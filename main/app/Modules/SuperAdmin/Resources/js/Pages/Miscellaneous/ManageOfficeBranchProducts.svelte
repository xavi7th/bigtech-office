<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@usershared/FlashMessage";
  import Icon from "@superadmin-shared/Partials/TableSortIcon";
  import route from "ziggy";

  $: ({ app } = $page);
  export let officeBranch = {
    branchProducts: []
  };
</script>

<Layout title={`${officeBranch}´s Stock List`}>
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="table-responsive-md">
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
                Model
                <Icon />
              </th>
              <th scope="col">
                Product ID
                <Icon />
              </th>
              <th scope="col">
                Cost Price
                <Icon />
              </th>
              <th scope="col">
                Sold At
                <Icon />
              </th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each officeBranch.branchProducts as product, idx}
              <tr>
                <th scope="row">{idx + 1}</th>
                <td>{product.model}</td>
                <td>{product.identifier}</td>
                <td>{product.cost_price}</td>
                <td>{product.selling_price}</td>
                <td>
                  <InertiaLink
                    type="button"
                    href={route('superadmin.products.view_product_details', product.uuid)}
                    class="btn btn-primary btn-xs btn-sm">
                    Details
                  </InertiaLink>
                  <InertiaLink
                    type="button"
                    href={route('superadmin.products.view_product_details', 1)}
                    class="btn btn-success btn-xs btn-sm">
                    Mark Sold
                  </InertiaLink>
                  <InertiaLink
                    type="button"
                    href={route('superadmin.products.view_product_details', 1)}
                    class="btn btn-brand btn-xs btn-sm">
                    Mark Paid
                  </InertiaLink>
                  <InertiaLink
                    type="button"
                    href={route('superadmin.product_histories.view_product_history', 1)}
                    class="btn btn-info btn-xs btn-sm">
                    History
                  </InertiaLink>
                </td>
              </tr>
            {:else}
              <tr>
                <th scope="row" colspan="7">
                  <!-- No Products In {officeBranch.city}'s Branch -->
                </th>
              </tr>
            {/each}

          </tbody>
        </table>
      </div>
    </div>
  </div>
</Layout>
