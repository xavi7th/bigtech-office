<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout.svelte";
  import FlashMessage from "@usershared/FlashMessage.svelte";
  import Icon from "@superadmin-shared/Partials/TableSortIcon.svelte";
  import Modal from "@superadmin-shared/Partials/Modal.svelte";
  import route from "ziggy";
  import { getErrorString } from "@public-assets/js/bootstrap";
  import { onMount } from "svelte";
  import { lang } from "moment";
  import MarkAsPaidModal from "@usershared/MarkAsPaidModal.svelte";
  import MarkAsSoldModal from "@usershared/MarkAsSoldModal.svelte";

  $: ({ app, flash, errors } = $page);
  export let onlineReps = [],
    companyAccounts = [],
    salesChannel = [],
    officeBranch = {
      branchProducts: []
    };

  let productToMarkAsPaid, productToMarkAsSold;

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
                  <InertiaLink
                    type="button"
                    href={route('superadmin.products.view_product_details', product.uuid)}
                    class="btn btn-primary btn-xs btn-sm">
                    Details
                  </InertiaLink>
                  {#if product.status == 'in stock'}
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
                  {#if product.status == 'sold'}
                    <button
                      on:click={() => {
                        productToMarkAsPaid = product.uuid;
                      }}
                      data-toggle="modal"
                      data-target="#enterProductPaymentDetails"
                      class="btn btn-brand btn-xs btn-sm">
                      Mark Paid
                    </button>
                  {/if}
                  <InertiaLink
                    type="button"
                    preserve-scroll
                    href={route('superadmin.miscellaneous.view_product_history', product.uuid)}
                    class="btn btn-info btn-xs btn-sm">
                    History
                  </InertiaLink>
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
    <MarkAsPaidModal {companyAccounts} {productToMarkAsPaid} />

    <MarkAsSoldModal {salesChannel} {onlineReps} {productToMarkAsSold} />
  </div>
</Layout>
