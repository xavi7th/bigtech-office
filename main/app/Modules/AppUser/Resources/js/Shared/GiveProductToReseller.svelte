<script>
  import { page } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import FlashMessage from "@usershared/FlashMessage.svelte";
  import Modal from "@superadmin-shared/Partials/Modal.svelte";
  import { getErrorString } from "@public-assets/js/bootstrap";

  $: ({ flash, errors } = $page);

  export let resellers = [],
    productToGiveReseller;

  let resellerToGiveProduct;

  let giveProductToReseller = () => {
    BlockToast.fire({
      text: "Allocating product to reseller ..."
    });

    Inertia.post(
      route("superadmin.resellers.give_product", [
        resellerToGiveProduct,
        productToGiveReseller
      ]),
      {},
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "products", 'swapDeals']
      }
    ).then(() => {
      if (flash.success) {
        ToastLarge.fire({
          title: "Successful!",
          html: flash.success
        });

        resellerToGiveProduct = null;
        productToGiveReseller = null;
      } else if (flash.error || _.size(errors) > 0) {
        ToastLarge.fire({
          title: "Oops!",
          html: flash.error || getErrorString(errors),
          timer: 10000,
          icon: "error"
        });
      } else {
        swal.close();
      }
    });
  };
</script>

<Modal modalId="giveProductToReseller" modalTitle="Select Reseller">

  <FlashMessage />

  <div class="row vertical-gap sm-gap">

    <div class="col-12">
      <select class="custom-select " bind:value={resellerToGiveProduct}>
        <option value={null} selected>Select Reseller</option>

        {#each resellers as reseller}
          <option value={reseller.id}>{reseller.business_name}</option>
        {/each}
      </select>
    </div>
  </div>

  <button
    on:click={giveProductToReseller}
    slot="footer-buttons"
    class="btn btn-info btn-long"
    disabled={!resellerToGiveProduct}>
    <span class="text">Give Reseller Product</span>
  </button>
</Modal>
