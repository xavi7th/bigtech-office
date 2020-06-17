<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import route from "ziggy";

  export let aggregatedSalesRecords,
    aggregatedProductExpenseRecords,
    aggregatedOtherExpenseRecords;

  console.log(
    aggregatedSalesRecords,
    aggregatedProductExpenseRecords,
    aggregatedOtherExpenseRecords
  );

  $: ({ app } = $page);
</script>

<Layout title="Daily Records">
  <div class="container-fluid">
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
                  Date
                  <span
                    data-feather="chevron-down"
                    class="rui-icon rui-icon-stroke-1_5" />
                </th>
                <th scope="col">
                  Sales
                  <span
                    data-feather="chevron-down"
                    class="rui-icon rui-icon-stroke-1_5" />
                </th>
                <th scope="col">
                  Product Expenses
                  <span
                    data-feather="chevron-down"
                    class="rui-icon rui-icon-stroke-1_5" />
                </th>
                <th scope="col">
                  Other Expenses
                  <span
                    data-feather="chevron-down"
                    class="rui-icon rui-icon-stroke-1_5" />
                </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>
                  <strong>21st March, 2020</strong>
                </td>
                <td>
                  <InertiaLink
                    href={route('superadmin.product_sales_records.daily', '2020-06-17')}>
                    <strong>
                      <u>Sales</u>
                    </strong>
                    <span class="ml-10 badge badge-success">121</span>
                  </InertiaLink>
                </td>
                <td>
                  <InertiaLink
                    href={route('superadmin.products.daily_expenses', '2020-06-17')}>
                    <strong>
                      <u>Product Expenses</u>
                    </strong>
                    <span class="ml-10 badge badge-danger">74</span>
                  </InertiaLink>
                </td>
                <td>
                  <InertiaLink
                    href={route('superadmin.miscellaneous.daily_expenses', '2020-06-17')}>
                    <strong>
                      <u>Other Expenses</u>
                    </strong>
                    <span class="ml-10 badge badge-danger">74</span>
                  </InertiaLink>
                </td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>
                  <strong>22nd March, 2020</strong>
                </td>
                <td>
                  <a href="sales-record.html">
                    <strong>
                      <u>Sales</u>
                    </strong>
                    <span class="ml-10 badge badge-success">221</span>
                  </a>
                </td>
                <td>
                  <a href="expenses-record.html">
                    <strong>
                      <u>Expenses</u>
                    </strong>
                    <span class="ml-10 badge badge-danger">29</span>
                  </a>
                </td>
                <td>
                  <a href="expenses-record.html">
                    <strong>
                      <u>Expenses</u>
                    </strong>
                    <span class="ml-10 badge badge-danger">29</span>
                  </a>
                </td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>
                  <strong>23rd March, 2020</strong>
                </td>
                <td>
                  <a href="sales-record.html">
                    <strong>
                      <u>Sales</u>
                    </strong>
                    <span class="ml-10 badge badge-success">67</span>
                  </a>
                </td>
                <td>
                  <a href="expenses-record.html">
                    <strong>
                      <u>Expenses</u>
                    </strong>
                    <span class="ml-10 badge badge-danger">12</span>
                  </a>
                </td>
                <td>
                  <a href="expenses-record.html">
                    <strong>
                      <u>Other Expenses</u>
                    </strong>
                    <span class="ml-10 badge badge-danger">12</span>
                  </a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</Layout>
