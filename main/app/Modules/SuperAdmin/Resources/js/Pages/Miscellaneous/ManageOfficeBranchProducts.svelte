<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout.svelte";
  import Icon from "@superadmin-shared/Partials/TableSortIcon.svelte";

  import { getErrorString } from "@public-assets/js/bootstrap";
  import { onMount } from "svelte";
  import MarkAsSoldModal from "@usershared/MarkAsSoldModal.svelte";
  import { AuthenticatorAssertionResponse } from "lodash/_freeGlobal";

  $: ({ auth, flash, errors } = $page);
  export let onlineReps = [],
    salesChannel = [],
    officeBranch = {
      branchProducts: []
    };

  let productToMarkAsSold;

  onMount(() => {
    if (flash.success) {
      ToastLarge.fire({
        title: "Successful!",
        html: flash.success
      });

      details = {};
    } else if (flash.error || _.size(errors) > 0) {
      ToastLarge.fire({
        title: "Oops!",
        html: flash.error || getErrorString(errors),
        timer: 10000,
        icon: "error"
      });
    }
  });
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
                  {#if auth.user.isSuperAdmin}
                    <InertiaLink
                      type="button"
                      href={route('multiaccess.products.view_product_details', product.uuid)}
                      class="btn btn-primary btn-xs btn-sm">
                      Details
                    </InertiaLink>
                    <InertiaLink
                      type="button"
                      preserve-scroll
                      href={route('multiaccess.miscellaneous.view_product_history', product.uuid)}
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
  </div>
</Layout>
