<script>
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal.svelte";

  export let salesChannel = [], productToSendToDispatch;

 let details = {
      sales_channel_id: null,
    };
$: details.product_description = productToSendToDispatch;

  let requestProductDispatch = () => {
    swal
      .fire({
        title: "Are you sure?",
        text:
          "Send request to Dispatch? The dispatch team will see this as a pending delivery request and proceed to process it",
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
          return Inertia.post(
            route("salesrep.products.send_for_dispatch"),
            details,
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors"],
              onSuccess: () =>{
                details = {
                  sales_channel_id: null
                };
              }
            }
          )
        }
      })
      .then(result => {
        if (result.dismiss && result.dismiss == "cancel") {
          swal.fire(
            "Canceled!",
            "You canceled the action. Nothing was changed",
            "info"
          );
        }
      });
  };

</script>

<style>
  textarea{
    height:120px;
  }
</style>

<Modal modalId="sendToDispatch" modalTitle="Send Product to Dispatch">

  <div class="row vertical-gap sm-gap">

    <div class="col-12">
      <select class="custom-select" bind:value={details.sales_channel_id}>
        <option value={null}>Sales Channel</option>
        {#each salesChannel as channel}
          <option value={channel.id}>{channel.channel_name}</option>
        {/each}
      </select>
    </div>

    <div class="col-12">
      <textarea
        class="form-control"
        placeholder="Details of the delivery request"
        bind:value={details.product_description}></textarea>
    </div>
    <div class="col-12">
      <input
        type="number"
        class="form-control"
        placeholder="Selling Price"
        bind:value={details.proposed_selling_price} />
    </div>

    <div class="col-12">
      <input
        type="text"
        class="form-control"
        placeholder="Buyer's First Name"
        bind:value={details.customer_first_name} />
    </div>

    <div class="col-12">
      <input
        type="text"
        class="form-control"
        placeholder="Buyer's Last Name"
        bind:value={details.customer_last_name} />
    </div>

    <div class="col-12">
      <input
        type="text"
        class="form-control"
        placeholder="Buyer's Phone Number"
        bind:value={details.customer_phone} />
    </div>

    <div class="col-12">
      <input
        type="text"
        class="form-control"
        placeholder="Buyer's IG Handle"
        bind:value={details.customer_ig_handle} />
    </div>

    <div class="col-12">
      <input
        type="email"
        class="form-control"
        placeholder="Buyer's Email Address"
        bind:value={details.customer_email} />
    </div>

    <div class="col-12">
      <input
        type="text"
        class="form-control"
        placeholder="Buyer's Residential Address"
        bind:value={details.customer_address} />
    </div>

    <div class="col-12">
      <input
        type="text"
        class="form-control"
        placeholder="Buyer's Residential City"
        bind:value={details.customer_city} />
    </div>
  </div>

  <button
    on:click={requestProductDispatch}
    slot="footer-buttons"
    class="btn btn-orange btn-long">
    <span class="text">Request Dispatch</span>
  </button>
</Modal>
