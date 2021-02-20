<script>
  import { Inertia } from "@inertiajs/inertia";
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout.svelte";
  import SearchComponent from "@superadmin-shared/Partials/SearchComponent.svelte";
  import { toCurrency } from '@public-shared/helpers';

  $: ({ auth } = $page.props);

  export let products = [];

  let
    searchKeys={'imei': 'IMEI','serial_no':'Serial No','model_no':'Model No', 'product_name':'Product Name'},
    isSearching = false;

  let deleteLocalProduct = product => {
    swalPreconfirm
      .fire({
        text: "This will completely remove the product from our records",
        confirmButtonText: "Delete Product",
        preConfirm: () => {
          return Inertia.delete(
            route("accountant.products.delete_local_product", product),
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

  let markPaid = product => {
    swalPreconfirm
      .fire({
        text: "This will mark the product as paid and remove it from this list",
        confirmButtonText: "Mark Paid",
        preConfirm: () => {
          return Inertia.put(
            route("superadmin.products.mark_local_product_as_paid", product),
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
      <SearchComponent dataKey='products' {searchKeys} on:isSearching={e => isSearching = e.detail}/>
      <div class="table-responsive-md" class:is-searching={isSearching} >
        <!-- svelte-ignore missing-declaration -->
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
                Reseller
              </th>
              <th scope="col">Price</th>
              <th scope="col">Collected</th>
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
              <th scope="col">
                Reseller
              </th>
              <th scope="col">Price</th>
              <th scope="col">Collected</th>
              <th scope="col">Action</th>
            </tr>
          </tfoot>
          <tbody>
            {#each products as product, idx}
              <tr>
                <th scope="row">{idx + 1}</th>
                <td>
                  <span class="text-capitalize">{product.full_name}</span>
                  <br>
                  {product.identifier}
                  <strong class="small font-weight-bold badge badge-dark">{product.status}</strong>
                  {#if !product.is_paid}
                    <strong class="small font-weight-bold badge badge-danger">Not Paid</strong>
                  {/if}
                </td>
                <td>
                  {product.supplier}
                </td>
                <td>{toCurrency(product.cost_price)} / {toCurrency(product.selling_price)}</td>
                <td>{product.collection_date}</td>
                <td>
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

                  {#if auth.user.isAccountant}
                    <button
                      type="button"
                      on:click={() => { deleteLocalProduct(product.uuid) }}
                      class="btn btn-danger btn-xs btn-sm text-nowrap">
                      Mark Returned
                    </button>
                  {/if}

                  {#if auth.user.isSuperAdmin}
                    <button
                      type="button"
                      on:click={() => { markPaid(product.uuid) }}
                      class="btn btn-success btn-xs btn-sm text-nowrap">
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
</Layout>
