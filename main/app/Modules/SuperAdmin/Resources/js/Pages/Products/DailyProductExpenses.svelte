<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import route from "ziggy";

  $: ({ app } = $page);

  export let expenses, date;
</script>

<Layout title="Products Expenses | {date}">
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="table-responsive-md">
        <table class="rui-datatable table table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Model</th>
              <th scope="col">Product ID</th>
              <th scope="col">Cost Price</th>
              <th scope="col">Expense Amount</th>
              <th scope="col">Expense Reason</th>
            </tr>
          </thead>
          <tbody>
            {#each expenses as expense}
              <tr>
                <th scope="row">{expense.id}</th>
                <td class="text-capitalize">
                  {expense.product.color} {expense.product.model}
                  {expense.product.storage_size}
                </td>
                <td>
                  {expense.product.identifier}
                  <br />
                  <span class="badge badge-danger text-uppercase">
                    STATUS: {expense.product.status}
                  </span>
                </td>
                <td>{expense.product.cost_price}</td>
                <td>{expense.amount}</td>
                <td>{expense.reason}</td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>
</Layout>
