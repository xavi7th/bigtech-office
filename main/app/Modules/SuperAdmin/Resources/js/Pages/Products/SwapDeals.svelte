<script>
  import { Inertia } from "@inertiajs/inertia";
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import Icon from "@superadmin-shared/Partials/TableSortIcon";
  import MarkSwapDealAsSoldModal from "@usershared/MarkSwapDealAsSoldModal.svelte";
  import GiveProductToReseller from "@usershared/GiveProductToReseller.svelte";
  import SendToDispatchModal from "@usershared/SendToDispatchModal.svelte";
  import { toCurrency } from '@public-shared/helpers';

  $: ({ auth } = $page.props);

  export let swapDeals = [],
    resellers = [],
    salesChannel = [],
    onlineReps = [];

  let productToMarkAsSold,
    productToGiveReseller,
    dispatchDetails,
    productToSendToDispatch;

  let returnToStock = product => {
    swalPreconfirm
      .fire({
        text: "This will return this product to the stock list",
        confirmButtonText: "Return to Stock",
        preConfirm: () => {
          return Inertia.post(
            route("webadmin.products.swap_return_to_stock", product),
            {},
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "swapDeals"]
            }
          )
        }
      })
      .then(result => {
        if (result.dismiss && result.dismiss == "cancel") {
          swal.fire(
            "Canceled!",
            "You canceled the action. Nothing was changed",
            "info"
          );
        }
      });
  };
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
              {#if !auth.user.isWebAdmin}
                <th scope="col">Action</th>
              {/if}
            </tr>
          </thead>
          <tbody>
            {#each swapDeals as product, idx}
              <tr>
                <th scope="row">{idx + 1}</th>
                <td>{product.description}</td>
                <td>
                  {product.identifier}
                 {#if auth.user.isAuditor || auth.user.isAccountant || auth.user.isSuperAdmin}
                    <br />
                  <span class="small font-weight-bold text-capitalize badge badge-brand">
                    STATUS:
                    {product.status}
                  </span>
                 {/if}
                </td>
                <td>{toCurrency(product.selling_price)}</td>
                {#if !auth.user.isWebAdmin}
                  <td class="nowrap">
                    <InertiaLink
                      type="button"
                      href={route(auth.user.user_type + '.multiaccess.products.swap_deal_details', product.uuid)}
                      class="btn btn-primary btn-xs">
                      Details
                    </InertiaLink>

                    {#if auth.user.isSuperAdmin || auth.user.isAuditor || auth.user.isAccountant}
                      <InertiaLink
                        type="button"
                        href={route(auth.user.user_type + '.multiaccess.miscellaneous.view_swap_history', product.uuid)}
                        class="btn btn-info btn-xs btn-sm">
                        History
                      </InertiaLink>
                    {/if}

                    {#if auth.user.isSocialMediaRep || auth.user.isCallCenterRep}
                      {#if product.status == 'in stock'}
                        <button
                          on:click={() => {
                            productToSendToDispatch = `Awoof Device: ${product.description}, Price: ${toCurrency(product.selling_price)}`;
                          }}
                          type="button"
                          data-toggle="modal"
                          data-target="#sendToDispatch"
                          class="btn btn-orange btn-xs btn-sm text-nowrap">
                          Send to Dispatch
                        </button>
                      {/if}
                    {/if}

                    {#if auth.user.isWebAdmin}
                      {#if product.status == 'out for delivery'}
                        <button
                          type="button"
                          on:click={() => {
                            productToMarkAsSold = product.uuid;
                            dispatchDetails = product.dispatch_request;
                          }}
                          data-toggle="modal"
                          data-target="#enterSwapSalesDetails"
                          class="btn btn-success btn-xs btn-sm">
                          Mark Sold
                        </button>
                        <button
                          type="button"
                          on:click={() => {
                            returnToStock(product.uuid);
                          }}
                          class="btn btn-orange btn-xs btn-sm text-nowrap">
                          Return to Stock
                        </button>
                      {/if}
                    {/if}

                    {#if product.status == 'in stock'}
                      {#if auth.user.isWalkInRep}
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
                      {/if}

                      {#if auth.user.isAccountant}
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
                    {/if}
                  </td>
                {/if}
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
      {productToMarkAsSold}
      {dispatchDetails} />

    <GiveProductToReseller {resellers} {productToGiveReseller} />

    <SendToDispatchModal {salesChannel} {productToSendToDispatch} />
  </div>
</Layout>
