<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";

  $: ({ auth } = $page.props);

  export let batches = [];
  let batch_number, auto_generate, order_date;

  let createNewBatch = () => {
    BlockToast.fire({
      text: "Creating new batch for today ..."
    });

    Inertia.post(
      route("accountant.products.create_batch"),
      { batch_number, auto_generate, order_date },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "batches"]
      }
    )
  };
</script>

<Layout title="Manage Product Batches">
  <div class="row vertical-gap">
    {#if auth.user.isAccountant}
      <div class="col-lg-4 offset-lg-4 order-1">
        <form class="#" on:submit|preventDefault={createNewBatch}>
          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="orderDate"> Date of Order </label>
              <input
                type="date"
                class="form-control"
                id="orderDate"
                bind:value={order_date}
                placeholder="Enter Order Date." />
            </div>
            <div class="col-12">
              <label for="batchNumber">
                Batch No.(Show for only stock keeper)
              </label>
              <input
                type="text"
                id="batchNumber"
                class="form-control"
                bind:value={batch_number}
                placeholder="Enter Batch No." />
            </div>
            <div class="col-12">
              <div class="custom-control custom-checkbox">
                <input
                  type="checkbox"
                  class="custom-control-input"
                  bind:checked={auto_generate}
                  id="autoGenerate" />
                <label class="custom-control-label" for="autoGenerate">
                  Auto-generate batch no.
                </label>
              </div>
              <br />
              <button class="btn btn-brand btn-long">
                <span class="text">Create New Batch</span>
                <span class="icon">
                  <span
                    data-feather="check-circle"
                    class="rui-icon rui-icon-stroke-1_5" />
                </span>
              </button>
            </div>
          </div>
        </form>
      </div>
    {/if}
    <div class="col-lg-12 order-0">
      <div class="table-responsive-md">
        <!-- svelte-ignore missing-declaration -->
        <table class="rui-datatable table table-striped" use:initialiseDatatable>
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Batch Number</th>
              <th scope="col">Date</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each batches as batch, idx}
              <tr>
                <th scope="row">{idx + 1}</th>
                <td>
                  {batch.batch_number}
                  <span class="badge badge-pill badge-dark">
                    {batch.num_of_products}
                  </span>
                  {#if auth.user.isQualityControl}
                     <span class="badge badge-pill badge-danger">
                      {batch.num_of_untested_products}
                    </span>
                  {/if}
                </td>
                <td class="text-nowrap">
                  {new Date(batch.order_date).toDateString()}
                </td>
                <td class="d-flex">
                  {#if auth.user.isStockKeeper || auth.user.isQualityControl || auth.user.isAuditor || auth.user.isSuperAdmin || auth.user.isAccountant}
                    <InertiaLink
                      type="button"
                      href={route(auth.user.user_type + '.multiaccess.products.by_batch', batch.batch_number)}
                      class="btn btn-brand mr-5 btn-xs">
                      Devices
                    </InertiaLink>
                  {/if}
                  {#if (auth.user.isSuperAdmin || auth.user.isAccountant) && batch.id !== 1} <!--Local product price not viewable here-->
                    <InertiaLink
                      href={route(auth.user.user_type + '.multiaccess.products.prices_by_batch', batch.batch_number)}
                      class="btn btn-dark mr-5 btn-xs">
                      Prices
                    </InertiaLink>
                   {#if auth.user.isAccountant}
                      <InertiaLink
                      href={route('accountant.products.create_batch_price', batch.batch_number)}
                      class="btn btn-info mr-5 btn-xs text-nowrap">
                      Create Price
                    </InertiaLink>
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
