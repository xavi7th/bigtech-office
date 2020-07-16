<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@user-shared/FlashMessage";
  import route from "ziggy";

  $: ({ app } = $page);
</script>

<Layout title="Products with Resellers">
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="table-responsive-md">
        <table
          class="rui-datatable table table-striped"
          data-datatable-order="0:desc">
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
                Model
                <span
                  data-feather="chevron-down"
                  class="rui-icon rui-icon-stroke-1_5" />
              </th>
              <th scope="col">
                Grade
                <span
                  data-feather="chevron-down"
                  class="rui-icon rui-icon-stroke-1_5" />
              </th>
              <th scope="col">
                Supplier
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
              <td>XMAX</td>
              <td>2</td>
              <td>Tadesco</td>
              <td>919VDV456</td>
              <td>919VDV456</td>
              <td>919VDV456919VDV456</td>
              <td>
                <a
                  type="button"
                  href="product-view.html"
                  class="btn btn-primary">
                  View Product
                </a>
                &nbsp;
              </td>
            </tr>
            <tr>
              <th scope="row">2</th>
              <td>iPhone</td>
              <td>XMAX</td>
              <td>2</td>
              <td>Tadesco</td>
              <td>919VDV456</td>
              <td>919VDV456</td>
              <td>919VDV456919VDV456</td>
              <td>
                <InertiaLink
                  type="button"
                  href={route('superadmin.products.view_product_details', 1)}
                  class="btn btn-primary">
                  View Product
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
