<script>
import { toCurrency } from '@public-shared/helpers';

  import Layout from "@superadmin-shared/SuperAdminLayout";

  export let branchWithExpenses;
</script>

<Layout title="Products Expenses | {branchWithExpenses.branch} branch">
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="table-responsive-md">
        <table class="rui-datatable table table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Model</th>
              <th scope="col">Product ID</th>
              <th scope="col">Price</th>
              <th scope="col">Expense Amount</th>
              <th scope="col">Expense Reason</th>
            </tr>
          </thead>
          <tbody>
            {#each branchWithExpenses.product_expenses as expense}
              <tr>
                <th scope="row">{expense.id}</th>
                <td class="text-capitalize">
                  {expense.product.full_name}
                </td>
                <td>
                  {expense.product.identifier}
                  <br />
                  <span class="badge badge-dark text-uppercase">
                    STATUS: {expense.product.status}
                  </span>
                </td>
                <td>{toCurrency(expense.product.cost_price)}/ {toCurrency(expense.product.selling_price)}</td>
                <td>{toCurrency(expense.amount)}</td>
                <td>{expense.reason}</td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>
</Layout>
