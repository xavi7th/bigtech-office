<script>
  import { Inertia } from "@inertiajs/inertia";
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout.svelte";
  import SearchComponent from "@superadmin-shared/Partials/SearchComponent.svelte";
  import MarkAsSoldModal from "@usershared/MarkAsSoldModal.svelte";
  import GiveProductToReseller from "@usershared/GiveProductToReseller.svelte";
  import SendToDispatchModal from "@usershared/SendToDispatchModal.svelte";
  import { toCurrency } from '@public-shared/helpers';

  $: ({ auth } = $page.props);

  export let onlineReps = [],
    products = [],
    resellers = [],
    salesChannel = [];

  let productToMarkAsSold,
    productToGiveReseller,
    productToSendToDispatch,
    dispatchDetails,
    searchKeys={'imei': 'IMEI','serial_no':'Serial No','model_no':'Model No', 'product_name':'Product Name'},
    isSearching = false;

  let returnToStock = product => {
    swalPreconfirm
      .fire({
        text: "This will return this product to the stock list",
        confirmButtonText: "Return to Stock",
        preConfirm: () => {
          return Inertia.post(
            route("webadmin.products.return_to_stock", product),
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

<svelte:window on:popstate={ Inertia.reload() }></svelte:window>

<Layout title="Stock List">
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      {#if !auth.user.isOnlineSalesRep}
        <SearchComponent dataKey='products' {searchKeys} on:isSearching={e => isSearching = e.detail}/>
      {/if}
      <div class="table-responsive-md" class:is-searching={isSearching} >
        <!-- svelte-ignore missing-declaration -->
        {#if auth.user.isOnlineSalesRep}
           <table
              class="rui-datatable table table-striped table-bordered table-sm" data-order='[0, "asc"]' use:initialiseDatatable>
              <thead class="thead-dark">
                <tr>
                  <th scope="col">
                    #
                  </th>
                  <th scope="col">
                    Device
                  </th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tfoot class="thead-dark">
                <tr>
                  <th scope="col">
                    #
                  </th>
                  <th scope="col">
                    Device
                  </th>
                  <th scope="col">Action</th>
                </tr>
              </tfoot>
              <tbody>
                {#each products as product, idx}
                  <tr>
                    <th scope="row">{idx + 1}</th>
                    <td class="text-capitalize"> {product.brand} {product.model}</td>
                      <td>
                        <button
                          on:click={() => {
                            productToSendToDispatch = `Device: ${product.brand} ${product.model}`;
                          }}
                          type="button"
                          data-toggle="modal"
                          data-target="#sendToDispatch"
                          class="btn btn-orange btn-xs btn-sm text-nowrap">
                          Send to Dispatch
                        </button>
                      </td>
                  </tr>
                {/each}
              </tbody>
            </table>
        {:else}
           <table
            class="rui-datatable table table-striped table-bordered table-sm" data-order='[0, "asc"]' use:initialiseBasicDataTable>
            <thead class="thead-dark">
              <tr>
                <th scope="col">
                  #
                </th>
                <th scope="col">
                  Device
                </th>
                <th scope="col">
                  Product ID
                </th>
                <th scope="col">Selling Price</th>
                {#if !auth.user.isWebAdmin}
                  <th scope="col">Action</th>
                {/if}
              </tr>
            </thead>
            <tfoot class="thead-dark">
              <tr>
                <th scope="col">
                  #
                </th>
                <th scope="col">
                  Device
                </th>
                <th scope="col">
                  Product ID
                </th>
                <th scope="col">Selling Price</th>
                {#if !auth.user.isWebAdmin}
                  <th scope="col">Action</th>
                {/if}
              </tr>
            </tfoot>
            <tbody>
              {#each products as product, idx}
                <tr>
                  <th scope="row">{idx + 1}</th>
                  <td class="text-capitalize">{product.full_name}</td>
                  <td>
                    {product.identifier}
                    {#if auth.user.isAuditor || auth.user.isSuperAdmin}
                    <br>
                      <strong class="small font-weight-bold badge badge-brand">{product.status}</strong>
                    {/if}
                  </td>
                  <td>{toCurrency(product.selling_price)}</td>
                  {#if !auth.user.isWebAdmin}
                    <td>
                      {#if auth.user.isSuperAdmin || auth.user.isAuditor || auth.user.isAccountant}
                        <InertiaLink
                          type="button"
                          href={route(auth.user.user_type + '.multiaccess.products.view_product_details', product.uuid)}
                          class="btn btn-primary btn-xs btn-sm">
                          Details
                        </InertiaLink>

                        <InertiaLink
                          type="button"
                          href={route(auth.user.user_type + '.multiaccess.miscellaneous.view_product_history', product.uuid)}
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
                              productToSendToDispatch = `Device: ${product.full_name}`;
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
                  {/if}
                </tr>
              {/each}
            </tbody>
          </table>
        {/if}


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
