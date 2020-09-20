<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@usershared/FlashMessage";
  import Icon from "@superadmin-shared/Partials/TableSortIcon";
  import route from "ziggy";
  import MarkSwapDealAsSoldModal from "@usershared/MarkSwapDealAsSoldModal.svelte";
  import MarkSwapDealAsPaidModal from "@usershared/MarkSwapDealAsPaidModal.svelte";

  $: ({ app } = $page);

  export let swapDeals = [],
    salesChannel = [],
    onlineReps = [],
    companyAccounts = [];

  let productToMarkAsSold, productToMarkAsPaid;
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
            {#each swapDeals as product, idx}
              <tr>
                <th scope="row">{idx + 1}</th>
                <td>{product.description}</td>
                <td>{product.identifier}</td>
                <td>{product.selling_price}</td>
                <td class="nowrap">
                  <InertiaLink
                    type="button"
                    href={route('superadmin.products.swap_deal_details', product.uuid)}
                    class="btn btn-primary btn-xs">
                    Details
                  </InertiaLink>

                  {#if product.status == 'in stock'}
                    <button
                      type="button"
                      on:click={() => {
                        productToMarkAsSold = product.uuid;
                      }}
                      data-toggle="modal"
                      data-target="#enterSwapSalesDetails"
                      class="btn btn-success btn-xs btn-sm">
                      Mark Sold
                    </button>

                    <!-- <button
                      type="button"
                      on:click={() => {
                        productToGiveReseller = product.uuid;
                      }}
                      data-toggle="modal"
                      data-target="#giveProductToReseller"
                      class="btn btn-warning btn-xs btn-sm">
                      Give Reseller
                    </button> -->
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
                </td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div slot="modals">
    <MarkSwapDealAsSoldModal
      {salesChannel}
      {onlineReps}
      {productToMarkAsSold} />

    <MarkSwapDealAsPaidModal {companyAccounts} {productToMarkAsPaid} />
  </div>
</Layout>
