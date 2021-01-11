<script>
  import { Inertia } from "@inertiajs/inertia";
	import { page } from "@inertiajs/inertia-svelte";

  export let product_statuses = [],
    product = {};

  let updateProductStatus = () => {
    BlockToast.fire({
      text: "Updating product status ..."
    });

    Inertia.put(
      route($page.props.auth.user.user_type + ".multiaccess.products.update_product_status", product.uuid),
      { product_status_id: product.product_status_id },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "product"]
      }
    );
  };
</script>

<label for="productGrade">Update Product Status</label>
<div class="input-group">
  <select class="custom-select" bind:value={product.product_status_id}>
    <option value={null}>Select</option>
    {#each product_statuses as status}
      <option value={status.id}>{status.status}</option>
    {/each}
  </select>
  <button on:click={updateProductStatus} class="btn btn-dark btn-long">
    <span class="text">Update</span>
  </button>
</div>
