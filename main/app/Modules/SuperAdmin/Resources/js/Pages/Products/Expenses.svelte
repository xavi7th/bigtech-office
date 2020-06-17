<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@user-shared/FlashMessage";
  import route from "ziggy";

  let details = {};
  export let expenses;

  $: ({ app } = $page);
</script>

<Layout title="Product Expenses">
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="table-responsive-md">
        <table class="rui-datatable table table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">
                #
                <span
                  data-feather="chevron-down"
                  class="rui-icon rui-icon-stroke-1_5" />
              </th>
              <th scope="col">
                Amount
                <span
                  data-feather="chevron-down"
                  class="rui-icon rui-icon-stroke-1_5" />
              </th>
              <th scope="col">
                Reason
                <span
                  data-feather="chevron-down"
                  class="rui-icon rui-icon-stroke-1_5" />
              </th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>20,000</td>
              <td>Camera repair</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row vertical-gap mt-5">
    <div class="col-lg-8 col-xl-7 offset-xl-2 mt-5">
      <h2 class="mt-5">Create New Expense</h2>
      <form class="#">
        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="expenseAmount">Amount</label>
            <input
              type="text"
              class="form-control"
              id="expenseAmount"
              placeholder="Enter Amount" />
          </div>
          <div class="col-12">
            <label for="expensePurpose">Purpose</label>
            <input
              type="text"
              class="form-control"
              id="expensePurpose"
              placeholder="What is the expense for?" />
          </div>
          <div class="col-12">
            <button type="button" class="btn btn-brand btn-long">
              <span class="text">Create Expense</span>
              <span class="icon">
                <span
                  data-feather="check-circle"
                  class="rui-icon rui-icon-stroke-1_5" />
              </span>
            </button>
            &nbsp;
          </div>
        </div>
      </form>
    </div>
  </div>
</Layout>
