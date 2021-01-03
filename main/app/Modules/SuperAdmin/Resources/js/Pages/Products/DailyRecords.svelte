<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout";


  export let dailyRecords = [];

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

              {#each Object.entries(dailyRecords) as [day, record], idx}
                <tr>
                  <th scope="row">{idx + 1}</th>
                  <td>
                    <strong>{day}</strong>
                  </td>
                  <td>
                    <InertiaLink
                      href={route('multiaccess.product_sales_records.daily', day)}>
                      <strong>
                        <u>Sales</u>
                      </strong>
                      <span class="ml-10 badge badge-success">
                        {record.num_of_sales || 0}
                      </span>
                    </InertiaLink>
                  </td>
                  <td>
                    <InertiaLink
                      href={route('multiaccess.products.daily_expenses', day)}>
                      <strong>
                        <u>Product Expenses</u>
                      </strong>
                      <span class="ml-10 badge badge-danger">
                        {record.num_of_product_expenses || 0}
                      </span>
                    </InertiaLink>
                  </td>
                  <td>
                    <InertiaLink
                      href={route('multiaccess.miscellaneous.daily_expenses', day)}>
                      <strong>
                        <u>Other Expenses</u>
                      </strong>
                      <span class="ml-10 badge badge-danger">
                        {record.num_of_other_expenses || 0}
                      </span>
                    </InertiaLink>
                  </td>
                </tr>
              {/each}

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</Layout>
