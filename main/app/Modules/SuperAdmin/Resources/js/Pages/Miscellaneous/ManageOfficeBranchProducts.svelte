<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@usershared/FlashMessage";
  import Icon from "@superadmin-shared/Partials/TableSortIcon";
  import Modal from "@superadmin-shared/Partials/Modal";
  import route from "ziggy";
  import { getErrorString } from "@public-assets/js/bootstrap";

  $: ({ app, flash, errors } = $page);
  export let onlineReps = [],
    salesChannel = [],
    officeBranch = {
      branchProducts: []
    };

  let details = {},
    productToMarkAsSold,
    files;

  let toggleSwap = () => {
    if (!details.is_swap_deal) {
      delete details.description;
      delete details.owner_details;
      delete details.id_card;
      delete details.receipt;
      delete details.swap_value;
      delete details.imei;
      delete details.serial_no;
      delete details.model_no;
    }
  };

  let markProductAsSold = () => {
    BlockToast.fire({
      text: "Marking product as sold ..."
    });

    let formData = new FormData();

    _.forEach(_.omit(details, ["set", "update", "subscribe"]), (val, key) => {
      formData.append(key, val);
    });

    Inertia.post(
      route("superadmin.products.mark_as_sold", productToMarkAsSold),
      formData,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "branchProducts"]
      }
    ).then(() => {
      if (flash.success) {
        ToastLarge.fire({
          title: "Successful!",
          html: flash.success
        });

        details = {};
      } else {
        ToastLarge.fire({
          title: "Oops!",
          html: flash.error || getErrorString(errors),
          timer: 10000,
          icon: "error"
        });
      }
    });
  };
</script>

<Layout title={`${officeBranch.city}´s Stock List`}>
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="table-responsive-md">
        <table
          class="rui-datatable table table-striped table-bordered table-sm"
          data-datatable-order="0:desc">
          <thead class="thead-dark">
            <tr>
              <th scope="col">
                #
                <Icon />
              </th>
              <th scope="col">
                Model
                <Icon />
              </th>
              <th scope="col">
                Product ID
                <Icon />
              </th>
              <th scope="col">
                Cost Price
                <Icon />
              </th>
              <th scope="col">
                Sold At
                <Icon />
              </th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each officeBranch.branchProducts as product, idx}
              <tr>
                <th scope="row">{idx + 1}</th>
                <td>{product.model}</td>
                <td>{product.identifier}</td>
                <td>{product.cost_price}</td>
                <td>{product.selling_price}</td>
                <td>
                  <InertiaLink
                    type="button"
                    href={route('superadmin.products.view_product_details', product.uuid)}
                    class="btn btn-primary btn-xs btn-sm">
                    Details
                  </InertiaLink>
                  {#if product.status == 'in stock'}
                    <button
                      type="button"
                      on:click={() => {
                        productToMarkAsSold = product.uuid;
                      }}
                      data-toggle="modal"
                      data-target="#enterSalesDetails"
                      class="btn btn-success btn-xs btn-sm">
                      Mark Sold
                    </button>
                  {/if}
                  <InertiaLink
                    type="button"
                    href={route('superadmin.products.view_product_details', 1)}
                    class="btn btn-brand btn-xs btn-sm">
                    Mark Paid
                  </InertiaLink>
                  <InertiaLink
                    type="button"
                    href={route('superadmin.product_histories.view_product_history', 1)}
                    class="btn btn-info btn-xs btn-sm">
                    History
                  </InertiaLink>
                </td>
              </tr>
            {:else}
              <tr class="text-center">
                <td colspan="5">No Products In {officeBranch.city}'s Branch</td>
              </tr>
            {/each}

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div slot="modals">
    <Modal modalId="enterSalesDetails" modalTitle="Enter Sales Details">

      <FlashMessage />

      <div class="row vertical-gap sm-gap">
        <div class="col-12">
          <input
            type="number"
            class="form-control"
            placeholder="Selling Price"
            bind:value={details.selling_price} />
        </div>

        <div class="col-12">
          <input
            type="text"
            class="form-control"
            placeholder="Buyer First Name"
            bind:value={details.first_name} />
        </div>

        <div class="col-12">
          <input
            type="text"
            class="form-control"
            placeholder="Buyer Last Name"
            bind:value={details.last_name} />
        </div>

        <div class="col-12">
          <input
            type="text"
            class="form-control"
            placeholder="Buyer Phone Number"
            bind:value={details.phone} />
        </div>

        <div class="col-12">
          <input
            type="email"
            class="form-control"
            placeholder="Buyer Email Address"
            bind:value={details.email} />
        </div>

        <div class="col-12">
          <input
            type="text"
            class="form-control"
            placeholder="Buyer Residential Address"
            bind:value={details.address} />
        </div>

        <div class="col-12">
          <input
            type="text"
            class="form-control"
            placeholder="Buyer Residential City"
            bind:value={details.city} />
        </div>

        <div class="col-12">

          <select class="custom-select " bind:value={details.sales_channel_id}>
            <option selected>How did buyer come?</option>
            {#each salesChannel as channel}
              <option value={channel.id}>{channel.channel_name}</option>
            {/each}
          </select>
        </div>

        <div class="col-12">
          <input
            type="text"
            class="form-control"
            placeholder="Buyer's IG Handle"
            bind:value={details.ig_handle} />
        </div>

        <div class="col-12">

          <select class="custom-select" bind:value={details.online_rep_id}>
            <option selected>Select Online Rep</option>
            {#each onlineReps as rep}
              <option value={rep.id}>{rep.full_name}</option>
            {/each}
          </select>
        </div>

        <div class="col-12">
          <div class="custom-control custom-switch">
            <input
              type="checkbox"
              class="custom-control-input"
              id="is-swap-deal"
              bind:checked={details.is_swap_deal}
              on:change={toggleSwap} />
            <label class="custom-control-label" for="is-swap-deal">
              Is this a Swap Deal?
            </label>
          </div>

        </div>

        {#if details.is_swap_deal}
          <div class="col-12">
            <input
              type="text"
              class="form-control"
              placeholder="Describe Swap Phone"
              bind:value={details.description} />
          </div>

          <div class="col-12">
            <input
              type="text"
              class="form-control"
              placeholder="Owner Details"
              bind:value={details.owner_details} />
          </div>

          <div class="col-12">
            <input
              type="file"
              class="form-control"
              bind:files
              on:change={(details.id_card = files[0])} />
          </div>

          <div class="col-12">
            <input
              type="file"
              class="form-control"
              bind:files
              on:change={(details.receipt = files[0])} />
          </div>

          <div class="col-12">
            <input
              type="text"
              class="form-control"
              placeholder="IMEI"
              bind:value={details.imei} />
          </div>

          <div class="col-12">
            <input
              type="text"
              class="form-control"
              placeholder="S/No"
              bind:value={details.serial_no} />
          </div>

          <div class="col-12">
            <input
              type="text"
              class="form-control"
              placeholder="Model No"
              bind:value={details.model_no} />
          </div>

          <div class="col-12">
            <input
              type="numeric"
              class="form-control"
              placeholder="Swap Value"
              bind:value={details.swap_value} />
          </div>
        {/if}

      </div>

      <button
        on:click={markProductAsSold}
        slot="footer-buttons"
        class="btn btn-success btn-long"
        disabled={!details.selling_price}>
        <span class="text">Mark As Sold</span>
      </button>
    </Modal>
  </div>
</Layout>
