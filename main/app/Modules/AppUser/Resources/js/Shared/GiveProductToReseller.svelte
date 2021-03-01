<script>
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal.svelte";

  export let resellers = [],
    productToGiveReseller;

  let resellerToGiveProduct;

  let giveProductToReseller = () => {
    BlockToast.fire({
      text: "Marking product as out to reseller ..."
    });

    Inertia.post(
      route("accountant.resellers.give_product", [
        resellerToGiveProduct,
        productToGiveReseller
      ]),
      {},
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "products", 'swapDeals'],
        onSuccess: () => {
          resellerToGiveProduct = null;
          productToGiveReseller = null;
        }
      }
    );
  };
</script>

<Modal modalId="giveProductToReseller" modalTitle="Select Reseller">

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
