<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout";


  let editPrices = false,
    details = {};

  export let productBatchWithPriceDetails = {};
</script>

<style>
  td {
    text-transform: capitalize;
  }
</style>

<Layout
  title="View Product Prices for Batch {productBatchWithPriceDetails.batch_number}">
  <div class="row vertical-gap">
   {#if $page.props.auth.user.isAccountant}
      <div class="col-12">
      <InertiaLink
        href={route('accountant.products.create_batch_price', productBatchWithPriceDetails.batch_number)}
        class="btn btn-brand btn-long text-white">
        <span class="text">Create New Price</span>
        <span class="icon">
          <span
            data-feather="check-circle"
            class="rui-icon rui-icon-stroke-1_5" />
        </span>
      </InertiaLink>
    </div>
   {/if}
    <div class="col-lg-12">
      <div class="table-responsive-md">
        <table class="rui-datatable table table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Model</th>
              <th scope="col">Supplier</th>
              <th scope="col">Grade</th>
              <th scope="col">Cost</th>
              <th scope="col">Selling</th>
            </tr>
          </thead>
          <tbody>
            {#each productBatchWithPriceDetails.prices as price, idx}
              <tr>
                <th scope="row">{idx + 1}</th>
                <td>{price.color} {price.model} {price.storage_size}</td>
                <td>{price.supplier}</td>
                <td>{price.grade}</td>
                <td>{price.cost_price}</td>
                <td>
                  {price.proposed_selling_price}
                    {#if $page.props.auth.user.isAccountant}
                      <InertiaLink
                      href={route('accountant.prices.edit_page', price.id)}
                      class="btn btn-link">
                      Edit
                    </InertiaLink>
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
