<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@usershared/FlashMessage";
  import route from "ziggy";

  $: ({ app } = $page);

  export let batchWithProducts;
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
              <th scope="col">Cost</th>
              <th scope="col">Selling</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each batchWithProducts.products as product, idx}
              <tr>
                <th scope="row">{idx + 1}</th>
                <td>
                  {product.color} {product.model} {product.storage_size}
                  <span class="badge badge-dark">{product.status}</span>
                  <br />
                  {product.identifier}
                  <span class="d-none">{product.supplier}</span>
                </td>
                <td>{product.product_expenses_sum}</td>
                <td>{product.cost_price}</td>
                <td>{product.selling_price}</td>
                <td>
                  <InertiaLink
                    type="button"
                    href={route('superadmin.products.qa_test_results', product.uuid)}
                    class="btn btn-dark btn-xs">
                    Test/Result
                  </InertiaLink>
                  <InertiaLink
                    type="button"
                    href={route('superadmin.products.expenses', product.uuid)}
                    class="btn btn-warning btn-xs">
                    Record Expense
                  </InertiaLink>
                  &nbsp;
                </td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>
</Layout>
