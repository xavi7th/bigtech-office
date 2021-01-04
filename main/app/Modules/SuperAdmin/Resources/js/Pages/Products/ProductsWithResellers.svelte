<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@usershared/FlashMessage";


  $: ({ auth } = $page.props);

  export let productsWithResellers;
</script>

<Layout title="Products with Resellers">
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="table-responsive-md">
        <table
          class="rui-datatable table table-striped"
          data-datatable-order="0:desc">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Model</th>
              <th scope="col">Reseller</th>
              <th scope="col">Identifier</th>
              <th scope="col">Date Collected</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each productsWithResellers as product, idx}
              <tr>
                <th scope="row">{idx + 1}</th>
                <td>{product.color || ''} {product.model}</td>
                <td>{product.reseller} <br /> {product.reseller_phone}</td>
                <td>{product.identifier}</td>
                <td>{product.date_collected}</td>
                <td>
                  {#if auth.user.isSuperAdmin || auth.user.isAdmin || auth.user.isAccountant}
                    {#if product.is_swap_deal}
                      <InertiaLink
                        type="button"
                        href={route('multiaccess.products.swap_deal_details', product.uuid)}
                        class="btn btn-primary btn-xs btn-sm">
                        Details
                      </InertiaLink>
                    {:else}
                      <InertiaLink
                        type="button"
                        href={route('multiaccess.products.view_product_details', product.uuid)}
                        class="btn btn-primary btn-xs btn-sm">
                        Details
                      </InertiaLink>
                    {/if}
                  {/if}
                </td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>
</Layout>
