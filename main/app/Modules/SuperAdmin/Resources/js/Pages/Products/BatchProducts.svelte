<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";

  $: ({ auth } = $page.props);

  export let batchWithProducts;

  let deleteProduct = productUUID => {
    swal
      .fire({
        title: "Are you sure?",
        text: "This will delete this comment completely",
        icon: "question",
        showCloseButton: false,
        allowOutsideClick: () => !swal.isLoading(),
        allowEscapeKey: false,
        showCancelButton: true,
        focusCancel: true,
        cancelButtonColor: "#d33",
        confirmButtonColor: "#725ec3",
        confirmButtonText: "Yes, carry on!",
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return Inertia.delete(
            route("superadmin.products.delete_local_product", productUUID),
            {
              preserveState: true,
              preserveScroll: true
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

  let markUndergoingQa = productUUID => {
    BlockToast.fire({ text: "marking as undergoing qa ..." });

    Inertia.put(route("qualitycontrol.products.undergoing_qa", productUUID), null,{
      preserveState: true,
      preserveScroll: true
    })
  };
</script>

<Layout title="Products In Batch: {batchWithProducts.batch_number}">
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="table-responsive-md">
        <table class="rui-datatable table table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Model</th>
              <th scope="col">Expenses</th>
              {#if auth.user.isSuperAdmin || auth.user.isAccountant}
                <th scope="col">Cost</th>
                <th scope="col">Selling</th>
              {/if}
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each batchWithProducts.products as product, idx}
              <tr>
                <th scope="row">{idx + 1}</th>
                <td>
                  {product.color}
                  {product.model}
                  {product.storage_size}
                  <span class="badge badge-dark">{product.status}</span>
                  <br />
                  {product.identifier}
                  <span
                    class:d-none={!batchWithProducts.is_local}>{product.supplier}</span>
                  <br />
                  {#if $page.props.auth.user.isSuperAdmin && batchWithProducts.is_local && product.status !== 'sold' && product.status !== 'sale confirmed'}
                    <button
                      class="btn btn-danger btn-xs"
                      on:click={() => {
                        deleteProduct(product.uuid);
                      }}>DELETE</button>
                  {/if}
                </td>
                <td>{product.product_expenses_sum}</td>
                {#if auth.user.isSuperAdmin || auth.user.isAccountant}
                  <td>
                    {product.cost_price}
                    <span class="d-none">
                      {#if product.is_today}
                        TODAY
                      {:else if product.is_yersteday}Yesterday{/if}
                    </span>
                  </td>
                  <td>{product.selling_price}</td>
                {/if}
                <td>
                  {#if auth.user.isSuperAdmin || auth.user.isAdmin || auth.user.isAccountant}
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

                  {#if auth.user.isQualityControl || auth.user.isAdmin || auth.user.isSuperAdmin}
                    <InertiaLink
                      type="button"
                      href={route(auth.user.user_type + '.multiaccess.products.qa_test_results', product.uuid)}
                      class="btn btn-dark btn-xs">
                      Test/Result
                    </InertiaLink>
                    {#if auth.user.isQualityControl}
                      <InertiaLink
                        href={route(auth.user.user_type + '.multiaccess.products.expenses', product.uuid)}
                        class="btn btn-warning btn-xs text-nowrap">
                        Record Expense
                      </InertiaLink>
                      {#if product.just_arrived}
                        <button
                          class="btn btn-brand btn-xs"
                          on:click={() => {
                            markUndergoingQa(product.uuid);
                          }}>Received</button>
                      {/if}
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
