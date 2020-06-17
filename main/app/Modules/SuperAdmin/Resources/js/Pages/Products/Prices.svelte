<script>
  import { InertiaLink } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import route from "ziggy";

  let editPrices = false,
    details = {};
</script>

<Layout title="View Product Prices">
  <div class="row vertical-gap">
    <div class="col-12">
      <InertiaLink
        href={route('superadmin.prices.create_page', 'LOCAL-SUPPLIER')}
        class="btn btn-brand btn-long text-white">
        <span class="text">Create New Price</span>
        <span class="icon">
          <span
            data-feather="check-circle"
            class="rui-icon rui-icon-stroke-1_5" />
        </span>
      </InertiaLink>
    </div>
    <div class="col-lg-12">
      <div class="table-responsive-md">
        <table class="rui-datatable table table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Model</th>
              <th scope="col">Color</th>
              <th scope="col">Storage</th>
              <th scope="col">Grade</th>
              <th scope="col">Supplier</th>
              <th scope="col">Cost</th>
              <th scope="col">Selling</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Iphone 7+</td>
              <td>Rose Gold</td>
              <td>16gb</td>
              <td>B+</td>
              <td>Ontronix</td>
              <td>N75,000</td>
              <td>
                N25,000
                {#if editPrices}
                  <input type="text" bind:value={details.cost_price} />
                {:else}
                  <button
                    on:click={() => {
                      editPrices = true;
                    }}
                    class="btn btn-link">
                    Edit
                  </button>
                {/if}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>

</Layout>
