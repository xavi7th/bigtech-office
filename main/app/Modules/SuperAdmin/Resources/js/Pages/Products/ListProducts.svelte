<script>
  import { Inertia } from "@inertiajs/inertia";
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout.svelte";
  import Icon from "@superadmin-shared/Partials/TableSortIcon";
  import MarkAsSoldModal from "@usershared/MarkAsSoldModal.svelte";
  import GiveProductToReseller from "@usershared/GiveProductToReseller.svelte";
  import SendToDispatchModal from "@usershared/SendToDispatchModal.svelte";


  $: ({ auth } = $page.props);

  export let onlineReps = [],
    products = [],
    resellers = [],
    salesChannel = [];

  let productToMarkAsSold,
    productToGiveReseller,
    productToSendToDispatch,
    dispatchDetails;

  let returnToStock = product => {
    swalPreconfirm
      .fire({
        text: "This will return this product to the stock list",
        confirmButtonText: "Return to Stock",
        preConfirm: () => {
          return Inertia.post(
            route("dispatchadmin.products.return_to_stock", product),
            {},
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "products"]
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

<Layout title="Stock List">
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="table-responsive-md">
        <table
          class="rui-datatable table table-striped table-bordered table-sm" data-order='[0, "asc"]'>
          <thead class="thead-dark">
            <tr>
              <th scope="col">
                #
                <Icon />
              </th>
              <th scope="col">
                Device
                <Icon />
              </th>
              <th scope="col">
                Product ID
                <Icon />
              </th>
              <th scope="col">Selling Price</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each products as product, idx}
              <tr>
                <th scope="row">{idx + 1}</th>
                <td>
                  <span class="text-capitalize">{product.color}</span>
                  {product.model}
                  {product.storage_size}
                </td>
                <td>
                  {product.identifier}
                  {#if auth.user.isAdmin || auth.user.isSuperAdmin}
                  <br>
                    <strong class="small font-weight-bold badge badge-brand">{product.status}</strong>
                  {/if}
                </td>
                <td>{product.selling_price}</td>
                <td>
                  {#if auth.user.isSuperAdmin || auth.user.isAdmin || auth.user.isAccountant}
                    <InertiaLink
                      type="button"
                      href={route('multiaccess.products.view_product_details', product.uuid)}
                      class="btn btn-primary btn-xs btn-sm">
                      Details
                    </InertiaLink>

                    <InertiaLink
                      type="button"
                      href={route('multiaccess.miscellaneous.view_product_history', product.uuid)}
                      class="btn btn-info btn-xs btn-sm">
                      History
                    </InertiaLink>
                  {/if}

                  {#if auth.user.isWalkInRep}
                    {#if product.status == 'in stock'}
                      <button
                        type="button"
                        on:click={() => {
                          productToMarkAsSold = product.uuid;
                        }}
                        data-toggle="modal"
                        data-target="#enterSalesDetails"
                        class="btn btn-success btn-xs btn-sm text-nowrap">
                        Mark Sold
                      </button>
                    {/if}
                  {/if}

                  {#if auth.user.isStockKeeper}
                    {#if product.status == 'in stock'}
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
                  {/if}

                  {#if auth.user.isSocialMediaRep || auth.user.isCallCenterRep}
                    {#if product.status == 'in stock'}
                      <button
                        on:click={() => {
                          productToSendToDispatch = `Device: ${product.color}  ${product.model} ${product.storage_size}`;
                        }}
                        type="button"
                        data-toggle="modal"
                        data-target="#sendToDispatch"
                        class="btn btn-orange btn-xs btn-sm text-nowrap">
                        Send to Dispatch
                      </button>
                    {/if}
                  {/if}

                  {#if auth.user.isDispatchAdmin}
                    {#if product.status == 'out for delivery'}
                      <button
                        type="button"
                        on:click={() => {
                          productToMarkAsSold = product.uuid;
                          dispatchDetails = product.dispatch_request;
                        }}
                        data-toggle="modal"
                        data-target="#enterSalesDetails"
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
                </td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div slot="modals">
    <MarkAsSoldModal
      {salesChannel}
      {productToMarkAsSold}
      {dispatchDetails}
      {onlineReps} />

    <SendToDispatchModal {salesChannel} {productToSendToDispatch} />

    <GiveProductToReseller {resellers} {productToGiveReseller} />
  </div>
</Layout>
