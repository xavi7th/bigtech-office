<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@user-shared/FlashMessage";
  import route from "ziggy";

  $: ({ app } = $page);
</script>

<Layout title="Manage Product Batches">
  <div class="row vertical-gap">
    <div class="col-lg-12">
      <div class="table-responsive-md">
        <table class="rui-datatable table table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Batch Number</th>
              <th scope="col">Batch Quantity</th>
              <th scope="col">Date</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>AB34</td>
              <td>650</td>
              <td>{new Date().toDateString()}</td>
              <td>
                <InertiaLink
                  type="button"
                  href={route('superadmin.products.by_batch', 1)}
                  class="btn btn-dark">
                  View Devices
                </InertiaLink>
                &nbsp;
              </td>
            </tr>
            <tr>
              <th scope="row">1</th>
              <td>AB34</td>
              <td>650</td>
              <td>{new Date().toDateString()}</td>
              <td>
                <InertiaLink
                  type="button"
                  href={route('superadmin.products.by_batch', 1)}
                  class="btn btn-dark">
                  View Devices
                </InertiaLink>
                &nbsp;
              </td>
            </tr>
            <tr>
              <th scope="row">1</th>
              <td>AB34</td>
              <td>650</td>
              <td>{new Date().toDateString()}</td>
              <td>
                <InertiaLink
                  type="button"
                  href={route('superadmin.products.by_batch', 1)}
                  class="btn btn-dark">
                  View Devices
                </InertiaLink>
                &nbsp;
              </td>
            </tr>
            <tr>
              <th scope="row">1</th>
              <td>AB34</td>
              <td>650</td>
              <td>{new Date().toDateString()}</td>
              <td>
                <InertiaLink
                  type="button"
                  href={route('superadmin.products.by_batch', 1)}
                  class="btn btn-dark">
                  View Devices
                </InertiaLink>
                &nbsp;
              </td>
            </tr>
            <tr>
              <th scope="row">1</th>
              <td>AB34</td>
              <td>650</td>
              <td>{new Date().toDateString()}</td>
              <td>
                <InertiaLink
                  type="button"
                  href={route('superadmin.products.by_batch', 1)}
                  class="btn btn-dark">
                  View Devices
                </InertiaLink>
                &nbsp;
              </td>
            </tr>
            <tr>
              <th scope="row">1</th>
              <td>AB34</td>
              <td>650</td>
              <td>{new Date().toDateString()}</td>
              <td>
                <InertiaLink
                  type="button"
                  href={route('superadmin.products.by_batch', 1)}
                  class="btn btn-dark">
                  View Devices
                </InertiaLink>
                &nbsp;
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-lg-4 offset-lg-4">
      <form class="#">
        <div class="row vertical-gap sm-gap">
          <div class="col-8">
            <label for="exampleBase1">
              Batch No.(Show for only stock keeper)
            </label>
            <input
              type="text"
              class="form-control"
              id="exampleBase1"
              placeholder="Enter Batch No." />
          </div>
          <div class="col-12">
            <div class="custom-control custom-checkbox">
              <input
                type="checkbox"
                class="custom-control-input"
                id="customCheck1" />
              <label class="custom-control-label" for="customCheck1">
                Auto-generate batch no.
              </label>
            </div>
            <br />
            <button type="button" class="btn btn-brand btn-long">
              <span class="text">Add Batch</span>
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
