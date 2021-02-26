<script>
import { Inertia } from "@inertiajs/inertia";
import { fade, fly } from 'svelte/transition';

  export let details = {};

  let updateLocalPrice = comment => {
      swalPreconfirm
        .fire({
          text:
          "This will update the selling and the cost prices",
          confirmButtonText: "Yes, carry on!",
          preConfirm: () => {
            return Inertia.patch(
              route("accountant.products.local.edit_price", details.uuid), details,
              {
                preserveState: true,
                preserveScroll: true,
                only:['errors', 'flash', 'productDetails']
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

<div  in:fly="{{ y: 20, duration: 2000 }}" out:fade>
   <div class="col-12">
    <div class="d-flex flex-column">
      <input
        type="text"
        class="form-control"
        id="cost-price"
        bind:value={details.cost_price}
        placeholder="Cost Price" />
      <input
        type="text"
        class="form-control"
        id="proposed-selling-price"
        bind:value={details.proposed_selling_price}
        placeholder="Proposed Selling Price" />
      <button
        type="button"
        on:click={updateLocalPrice}
        class="btn btn-danger btn-hover-danger text-center">
        Update Price
      </button>
    </div>
  </div>
</div>
