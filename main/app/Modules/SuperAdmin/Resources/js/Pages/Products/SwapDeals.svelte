<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import Icon from "@superadmin-shared/Partials/TableSortIcon";
  import route from "ziggy";
  import MarkSwapDealAsSoldModal from "@usershared/MarkSwapDealAsSoldModal.svelte";
  import GiveProductToReseller from "@usershared/GiveProductToReseller.svelte";

  $: ({ app } = $page);

  export let swapDeals = [],
  resellers=[],
    salesChannel = [],
    onlineReps = [];

  let productToMarkAsSold, productToGiveReseller;
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
                  <InertiaLink
                    type="button"
                    href={route('superadmin.miscellaneous.view_swap_history', product.uuid)}
                    class="btn btn-info btn-xs btn-sm">
                    History
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

                    <button
                      type="button"
                      on:click={() => {
                        productToGiveReseller = product.uuid;
                      }}
                      data-toggle="modal"
                      data-target="#giveProductToReseller"
                      class="btn btn-warning btn-xs btn-sm">
                      Give Reseller
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

      <GiveProductToReseller {resellers} {productToGiveReseller} />
  </div>
</Layout>
