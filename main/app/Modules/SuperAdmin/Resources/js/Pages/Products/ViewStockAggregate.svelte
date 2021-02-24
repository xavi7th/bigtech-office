<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";

  export let current_stock = [];
</script>

<Layout title="View Stock List">
  <div class="row vertical-gap justify-content-center">
    <div class="col-lg-8 col-xl-8">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">Available Product Stock</h2>
      </div>
      <div>
        <!-- svelte-ignore missing-declaration -->
        <table class="table table-bordered" use:initialiseDatatable>
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Product Name</th>
              <th scope="col">Amount in Stock</th>
            </tr>
          </thead>
          <tbody>
            {#each current_stock as stock_details, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>{stock_details.product_model.name}</td>
                <td class="d-flex justify-content-between align-content-center">
                  {stock_details.total}
                </td>
              </tr>
            {:else}
              <tr>
                <td colspan="3" class="text-center">NONE AVAILABLE</td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>
</Layout>
