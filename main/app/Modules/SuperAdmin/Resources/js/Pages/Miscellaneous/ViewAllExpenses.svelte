<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import FlashMessage from "@usershared/FlashMessage";
  import Modal from "@superadmin-shared/Partials/Modal";

  $: ({ errors, auth, flash } = $page);

  export let dailyExpenses = [];
</script>

<Layout title="Manage Daily Expenses">
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">All Expenses</h2>
      </div>
      <div class="table-responsive">
        <table
          class="rui-datatable table table-striped table-bordered table-sm
          table-hover"
          data-datatable-order="3:desc">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Amount</th>
              <th scope="col">Purpose</th>
              <th scope="col">Date</th>
            </tr>
          </thead>
          <tbody>
            {#each dailyExpenses as dailyExpense, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>{dailyExpense.amount}</td>
                <td>{dailyExpense.purpose}</td>
                <td>{dailyExpense.date}</td>

              </tr>
            {:else}
              <tr>
                <td colspan="4" class="text-center">
                  No Expense Recorded For Today.
                </td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>

  </div>

</Layout>
