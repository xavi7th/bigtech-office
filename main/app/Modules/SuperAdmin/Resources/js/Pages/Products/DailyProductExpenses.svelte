<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import route from "ziggy";

  $: ({ app, salesRecords, date } = $page);

  console.log(salesRecords);
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
            <tr>
              <th scope="row">33</th>
              <td>iPhone 7+</td>
              <td>imei:45467798097654534235467</td>
              <td>N24,476</td>
              <td>N12,500</td>
              <td>Camera and battery replacement</td>
            </tr>

          </tbody>
        </table>
      </div>
    </div>
  </div>
</Layout>
