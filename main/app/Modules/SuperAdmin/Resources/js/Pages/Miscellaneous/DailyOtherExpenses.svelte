<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import route from "ziggy";

  $: ({ app } = $page);

  export let expenses, date;
</script>

<Layout title="Other Expenses | {date}">
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="table-responsive-md">
        <table class="rui-datatable table table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Time</th>
              <th scope="col">Amount</th>
              <th scope="col">Purpose</th>
              <th scope="col">Recorder</th>
            </tr>
          </thead>
          <tbody>
            {#each expenses as expense, idx}
              <tr>
                <th scope="row">{idx + 1}</th>
                <td>{expense.date}</td>
                <td>{expense.amount}</td>
                <td>{expense.purpose}</td>
                <td>{expense.recorder}</td>
              </tr>
            {/each}

          </tbody>
        </table>
      </div>
    </div>
  </div>
</Layout>
