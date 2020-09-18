<script>
    import { page, InertiaLink } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import Layout from "@superadmin-shared/SuperAdminLayout";
    import FlashMessage from "@usershared/FlashMessage";
    import route from "ziggy";
import { getErrorString } from "@public-assets/js/bootstrap";

    export let models,brands,colors,grades,suppliers,storage_sizes, price;

    $: ({ app,flash,errors } = $page);

  let updateBatchPrice = () => {
    BlockToast.fire({
      text: "Editing batch price ..."
    });

    Inertia.put(
      route("superadmin.prices.edit", price.id),
      price,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", 'price']
      }
    ).then(() => {
      if (flash.success) {
        ToastLarge.fire({
          title: "Successful!",
          html: flash.success
        });

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

<style>
  select{
    text-transform: capitalize;
  }
</style>

<Layout title="Edit Product Price For {price.product_batch.batch_number}">
    <div class="row vertical-gap">
        <div class="col-lg-8 col-xl-7">
            <form class="#" on:submit|preventDefault="{updateBatchPrice}">
                <div class="row vertical-gap sm-gap">
                    <div class="col-6">
                        <label for="exampleBase1">Product Model</label>
                        <div class="input-group">
                            <select class="custom-select" bind:value="{price.product_model_id}">
                                <option value={null} >Select</option>
                                {#each models as model}
                                  <option value="{model.id}">{model.name}</option>
                                {/each}
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="exampleBase1">Product Brand</label>
                        <div class="input-group">
                             <select class="custom-select" bind:value="{price.product_brand_id}">
                                <option value={null} >Select</option>
                                {#each brands as brand}
                                  <option value="{brand.id}">{brand.name}</option>
                                {/each}
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="exampleBase1">Product Color</label>
                        <div class="input-group">
                             <select class="custom-select" bind:value="{price.product_color_id}">
                                <option value={null} >Select</option>
                                {#each colors as color}
                                  <option value="{color.id}">{color.name}</option>
                                {/each}
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="exampleBase1">Product Grade</label>
                        <div class="input-group">
                             <select class="custom-select" bind:value="{price.product_grade_id}">
                                <option value={null} >Select</option>
                                {#each grades as grade}
                                  <option value="{grade.id}">{grade.grade}</option>
                                {/each}
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="exampleBase1">Product Supplier</label>
                        <div class="input-group">
                             <select class="custom-select" bind:value="{price.product_supplier_id}">
                                <option value={null} >Select</option>
                                {#each suppliers as supplier}
                                  <option value="{supplier.id}">{supplier.name}</option>
                                {/each}
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="exampleBase1">Storage Size</label>
                        <div class="input-group">
                             <select class="custom-select" bind:value="{price.storage_size_id}">
                                <option value={null} >Select</option>
                                {#each storage_sizes as storage_size}
                                  <option value="{storage_size.id}">{storage_size.human_size}</option>
                                {/each}
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="exampleBase1">Cost Price</label>
                        <input
                            type="text"
                            class="form-control"
                            bind:value={price.cost_price}
                            placeholder="Enter cost price" />
                    </div>
                    <div class="col-6">
                        <label for="exampleBase1">Proposed Selling Price</label>
                        <input
                            type="text"
                            class="form-control"
                            bind:value={price.proposed_selling_price}
                            placeholder="Enter proposed selling price" />
                    </div>
                    <div class="col-12">
                        <button class="btn btn-warning btn-long">
                            <span class="text">Update Product Price</span>
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
