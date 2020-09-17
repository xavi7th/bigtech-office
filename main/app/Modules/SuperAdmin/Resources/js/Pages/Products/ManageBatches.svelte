<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import route from "ziggy";
  import FlashMessage from "@usershared/FlashMessage";
  import Icon from "@superadmin-shared/Partials/TableSortIcon";
  import MarkAsPaidModal from "@usershared/MarkAsPaidModal.svelte";
  import MarkAsSoldModal from "@usershared/MarkAsSoldModal.svelte";
  import GiveProductToReseller from "@usershared/GiveProductToReseller.svelte";

  $: ({ app } = $page);

  export let batches = [];
</script>

<Layout title="Manage Product Batches">
  <div class="row vertical-gap">
    <div class="col-lg-4 offset-lg-4 order-1">
      <form class="#">
        <div class="row vertical-gap sm-gap">
          <div class="col-12">
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
    <div class="col-lg-12 order-0">
      <div class="table-responsive-md">
        <table class="rui-datatable table table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Batch Number</th>
              <th scope="col">Date</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>

            {#each batches as batch, idx}
              <tr>
                <th scope="row">{idx + 1}</th>
                <td>
                  {batch.batch_number}
                  <span class="badge badge-pill badge-dark">
                    {batch.num_of_products}
                  </span>
                </td>
                <td class="text-nowrap">
                  {new Date().toDateString(batch.order_date)}
                </td>
                <td class="d-flex">
                  <InertiaLink
                    type="button"
                    href={route('superadmin.products.by_batch', batch.batch_number)}
                    class="btn btn-brand mr-5 btn-xs">
                    Devices
                  </InertiaLink>
                  <InertiaLink
                    href={route('superadmin.products.prices_by_batch', batch.batch_number)}
                    class="btn btn-dark mr-5 btn-xs">
                    Prices
                  </InertiaLink>
                  <InertiaLink
                    href={route('superadmin.products.create_batch_price', batch.batch_number)}
                    class="btn btn-info mr-5 btn-xs text-nowrap">
                    Create Price
                  </InertiaLink>
                  &nbsp;
                </td>
              </tr>
            {/each}

          </tbody>
        </table>
      </div>
    </div>

  </div>

</Layout>
