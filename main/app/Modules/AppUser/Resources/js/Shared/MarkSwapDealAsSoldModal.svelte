<script>
  import { page } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import FlashMessage from "@usershared/FlashMessage.svelte";
  import Modal from "@superadmin-shared/Partials/Modal.svelte";
  import { getErrorString } from "@public-assets/js/bootstrap";

  $: ({ flash, errors } = $page);

  export let onlineReps = [],
    salesChannel = [],
    productToMarkAsSold;

  let details = {
      identification_type: "imei"
    },
    files;

  let toggleSwap = () => {
    if (!details.is_swap_transaction) {
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
    swal
      .fire({
        title: "Are you sure?",
        text:
          "This will mark this product as sold for and update the sales reps daily sales",
        icon: "question",
        showCloseButton: false,
        allowOutsideClick: () => !swal.isLoading(),
        allowEscapeKey: false,
        showCancelButton: true,
        focusCancel: true,
        cancelButtonColor: "#d33",
        confirmButtonColor: "#725ec3",
        confirmButtonText: "Yes, carry on!",
        showLoaderOnConfirm: true,
        preConfirm: () => {
          let formData = new FormData();

          _.forEach(
            _.omit(details, ["set", "update", "subscribe"]),
            (val, key) => {
              formData.append(key, val);
            }
          );
          return Inertia.post(
            route(
              "multiaccess.products.mark_swap_as_sold",
              productToMarkAsSold
            ),
            formData,
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "swapDeals"]
            }
          )
            .then(() => {
              if (flash.success) {
                return true;
              } else {
                throw new Error(flash.error || getErrorString(errors));
              }
            })
            .catch(error => {
              swal.showValidationMessage(`Request failed: ${error}`);
            });
        }
      })
      .then(result => {
        if (result.dismiss && result.dismiss == "cancel") {
          swal.fire(
            "Canceled!",
            "You canceled the action. Nothing was changed",
            "info"
          );
        } else if (flash.success) {
          ToastLarge.fire({
            title: "Successful!",
            html: flash.success
          });
        }
      });
  };
</script>

<Modal modalId="enterSwapSalesDetails" modalTitle="Enter Sales Details">
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
      <select class="custom-select" bind:value={details.sales_channel_id}>
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
          bind:checked={details.is_swap_transaction}
          on:change={toggleSwap} />
        <label class="custom-control-label" for="is-swap-deal">
          Is this a Swap Deal?
        </label>
      </div>
    </div>

    {#if details.is_swap_transaction}
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
        <label for="idType">Choose Primary Identifier</label>
      </div>
      <div class="col-12 d-flex justify-content-between">
        <div class="custom-control custom-radio">
          <input
            type="radio"
            id="imei-option"
            name="primary-identifier"
            value="imei"
            on:change={() => {
              delete details.model_no;
              delete details.serial_no;
            }}
            bind:group={details.identification_type}
            class="custom-control-input" />
          <label class="custom-control-label" for="imei-option">IMEI</label>
        </div>
        <div class="custom-control custom-radio mt-5">
          <input
            type="radio"
            id="serial-no-option"
            name="primary-identifier"
            value="serial_no"
            on:change={() => {
              delete details.imei;
              delete details.model_no;
            }}
            bind:group={details.identification_type}
            class="custom-control-input" />
          <label class="custom-control-label" for="serial-no-option">
            Serial No.
          </label>
        </div>
        <div class="custom-control custom-radio mt-5">
          <input
            type="radio"
            id="model-no-option"
            name="primary-identifier"
            value="model_no"
            on:change={() => {
              delete details.imei;
              delete details.serial_no;
            }}
            bind:group={details.identification_type}
            class="custom-control-input" />
          <label class="custom-control-label" for="model-no-option">
            Model No.
          </label>
        </div>
      </div>

      {#if details.identification_type === 'imei'}
        <div class="col-12">
          <label for="imeiNo">Imei No.</label>
          <input
            type="number"
            class="form-control"
            bind:value={details.imei}
            placeholder="Enter Imei No." />
        </div>
      {:else if details.identification_type === 'serial_no'}
        <div class="col-12">
          <label for="serialNo">Serial No.</label>
          <input
            type="text"
            class="form-control"
            bind:value={details.serial_no}
            placeholder="Enter S/No" />
        </div>
      {:else if details.identification_type === 'model_no'}
        <div class="col-12">
          <label for="modelNo">Model No.</label>
          <input
            type="text"
            class="form-control"
            bind:value={details.model_no}
            placeholder="Enter Model No." />
        </div>
      {/if}

      <div class="col-12">
        <input
          type="number"
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
