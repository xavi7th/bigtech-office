<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout.svelte";
  import Icon from "@superadmin-shared/Partials/TableSortIcon.svelte";
  import MarkAsSoldModal from "@usershared/MarkAsSoldModal.svelte";
  import GiveProductToReseller from "@usershared/GiveProductToReseller.svelte";
  import { toCurrency } from '@public-shared/helpers';

  $: ({ auth } = $page.props);
  export let onlineReps = [],
    salesChannel = [],
    resellers = [],
    officeBranch = {
      branchProducts: []
    };

  let productToMarkAsSold, productToGiveReseller;

</script>

<Layout title={`${officeBranch.city}´s Stock List`}>
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
                Product Description
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
                <td class="text-capitalize">
                  {product.description}
                  <span class="badge badge-pill badge-dark">{product.status}</span>
                </td>
                <td>{toCurrency(product.cost_price)}</td>
                <td>{toCurrency(product.selling_price)}</td>
                <td>
                  {#if auth.user.isAccountant}
                    <button
                      type="button"
                      on:click={() => {
                        productToGiveReseller = product.uuid;
                      }}
                      data-toggle="modal"
                      data-target="#giveProductToReseller"
                      class="btn btn-warning btn-xs btn-sm text-nowrap">
                      Give Reseller
                    </button>
                  {/if}
                  {#if auth.user.isSuperAdmin || auth.user.isAuditor || auth.user.isAccountant}
                    <InertiaLink
                      type="button"
                      href={route(auth.user.user_type + '.multiaccess.products.view_product_details', product.uuid)}
                      class="btn btn-primary btn-xs btn-sm">
                      Details
                    </InertiaLink>
                  {/if}
                  {#if auth.user.isSuperAdmin || auth.user.isAuditor}
                    <InertiaLink
                      type="button"
                      preserve-scroll
                      href={route(auth.user.user_type + '.multiaccess.miscellaneous.view_product_history', product.uuid)}
                      class="btn btn-info btn-xs btn-sm">
                      History
                    </InertiaLink>
                  {/if}
                  {#if product.status == 'in stock' && auth.user.isWalkInRep}
                    <button
                      type="button"
                      on:click={() => {
                        productToMarkAsSold = product.uuid;
                      }}
                      data-toggle="modal"
                      data-target="#enterSalesDetails"
                      class="btn btn-success btn-xs btn-sm">
                      Mark Sold
                    </button>
                  {/if}
                </td>
              </tr>
            {:else}
              <tr class="text-center">
                <td colspan="5">No Products In {officeBranch.city}'s Branch</td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div slot="modals">
    <MarkAsSoldModal {salesChannel} {onlineReps} {productToMarkAsSold} />

    <GiveProductToReseller {resellers} {productToGiveReseller} />
  </div>
</Layout>
