<script>
    import { page, InertiaLink } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import Layout from "@superadmin-shared/SuperAdminLayout";
    import FlashMessage from "@usershared/FlashMessage";

import { getErrorString } from "@public-assets/js/bootstrap";

    export let batch,models,brands,colors,grades,suppliers,storage_sizes;

    let details = {
        product_batch_id: batch.id
    };

    $: ({ flash,errors } = $page);


  let createBatchPrice = () => {
    BlockToast.fire({
      text: "Creating batch price ..."
    });

    Inertia.post(
      route("accountant.prices.create"),
      details,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", 'batch']
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

<Layout title="Create Product Price For {batch.batch_number}">
    <div class="row vertical-gap">
        <div class="col-lg-8 col-xl-7">
            <form class="#" on:submit|preventDefault="{createBatchPrice}">
                <div class="row vertical-gap sm-gap">
                    <div class="col-6">
                        <label for="exampleBase1">Product Model</label>
                        <div class="input-group">
                            <select class="custom-select" bind:value="{details.product_model_id}">
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
                             <select class="custom-select" bind:value="{details.product_brand_id}">
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
                             <select class="custom-select" bind:value="{details.product_color_id}">
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
                             <select class="custom-select" bind:value="{details.product_grade_id}">
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
                             <select class="custom-select" bind:value="{details.product_supplier_id}">
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
                             <select class="custom-select" bind:value="{details.storage_size_id}">
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
                            bind:value={details.cost_price}
                            placeholder="Enter cost price" />
                    </div>
                    <div class="col-6">
                        <label for="exampleBase1">Proposed Selling Price</label>
                        <input
                            type="text"
                            class="form-control"
                            bind:value={details.proposed_selling_price}
                            placeholder="Enter proposed selling price" />
                    </div>
                    <div class="col-12">
                        <button class="btn btn-brand btn-long">
                            <span class="text">Create Product Price</span>
                            <span class="icon">
                                <span
                                    data-feather="check-circle"
                                    class="rui-icon rui-icon-stroke-1_5" />
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</Layout>
