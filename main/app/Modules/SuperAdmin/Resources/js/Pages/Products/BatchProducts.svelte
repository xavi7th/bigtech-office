<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@user-shared/FlashMessage";
  import route from "ziggy";

  $: ({ app } = $page);
</script>

<Layout title="Products In Batch">
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
                Brand
                <span
                  data-feather="chevron-down"
                  class="rui-icon rui-icon-stroke-1_5" />
              </th>
              <th scope="col">
                Status
                <span
                  data-feather="chevron-down"
                  class="rui-icon rui-icon-stroke-1_5" />
              </th>
              <th scope="col">
                Model No.
                <span
                  data-feather="chevron-down"
                  class="rui-icon rui-icon-stroke-1_5" />
              </th>
              <th scope="col">
                Serial No.
                <span
                  data-feather="chevron-down"
                  class="rui-icon rui-icon-stroke-1_5" />
              </th>
              <th scope="col">
                Imei No.
                <span
                  data-feather="chevron-down"
                  class="rui-icon rui-icon-stroke-1_5" />
              </th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>iPhone</td>
              <td>
                <span class="badge badge-success">Pass</span>
              </td>
              <td>919VDV456</td>
              <td>919VDV456</td>
              <td>919VDV456919VDV456</td>
              <td>
                <InertiaLink
                  type="button"
                  href={route('superadmin.products.qa_test_results', 13)}
                  class="btn btn-dark btn-sm">
                  Test/Result
                </InertiaLink>
                <InertiaLink
                  type="button"
                  href={route('superadmin.products.expenses', 27)}
                  class="btn btn-warning btn-sm">
                  Record Expense
                </InertiaLink>
                &nbsp;
              </td>
            </tr>
            <tr>
              <th scope="row">1</th>
              <td>iPhone</td>
              <td>
                <span class="badge badge-warning">Repair</span>
              </td>
              <td>919VDV456</td>
              <td>919VDV456</td>
              <td>919VDV456919VDV456</td>
              <td>
                <InertiaLink
                  type="button"
                  href={route('superadmin.products.qa_test_results', 13)}
                  class="btn btn-dark">
                  Test/Result
                </InertiaLink>
                &nbsp;
              </td>
            </tr>
            <tr>
              <th scope="row">1</th>
              <td>iPhone</td>
              <td>
                <span class="badge badge-danger">Returned</span>
              </td>
              <td>919VDV456</td>
              <td>919VDV456</td>
              <td>919VDV456919VDV456</td>
              <td>
                <InertiaLink
                  type="button"
                  href={route('superadmin.products.qa_test_results', 13)}
                  class="btn btn-dark">
                  Test/Result
                </InertiaLink>
                &nbsp;
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</Layout>
