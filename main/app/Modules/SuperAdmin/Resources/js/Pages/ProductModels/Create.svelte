<script>
  import { remember, page } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@usershared/FlashMessage";


  $: ({ errors, auth } = $page.props);

  export let productBrands = [],
    productCategories = [];

  let details = remember({
    product_brand_id: null,
    product_category_id: null,
    name: null,
    img: null
  });
  let files;

  let createModel = () => {
    BlockToast.fire({
      text: "Creating model ..."
    });

    Inertia.post(
      route(auth.user.user_type + ".multiaccess.product_models.create_product_model"),
      details,
      {
        onSuccess: () =>{
          files = null;
          details = {
            product_brand_id: null,
            product_category_id: null,
            name: null,
            img: null
          };
        }
      }
    )
  };

</script>

<Layout title="Create Product Model">
  <div class="row vertical-gap">
    <div class="col-lg-8 col-xl-6">
      <form class="#">
        <div class="row vertical-gap sm-gap">

          <div class="col-6">
            <label for="model-brand">Model Brand</label>
            <div class="input-group">
              <select
                id="model-brand"
                bind:value={details.product_brand_id}
                class="custom-select text-capitalize">
                <option selected value={null}>Select</option>
                {#each productBrands as brand}
                  <option value={brand.id}>{brand.name}</option>
                {/each}
              </select>
            </div>
            {#if errors.product_brand_id}
              <FlashMessage formError={errors.product_brand_id} />
            {/if}
          </div>
          <div class="col-6">
            <label for="model-category">Model Category</label>
            <div class="input-group">
              <select
                id="model-category"
                bind:value={details.product_category_id}
                class="custom-select text-capitalize">
                <option selected value={null}>Select</option>
                {#each productCategories as cat}
                  <option value={cat.id}>{cat.name}</option>
                {/each}
              </select>
            </div>
            {#if errors.product_category_id}
              <FlashMessage formError={errors.product_category_id} />
            {/if}
          </div>

          <div class="col-6">
            <label for="model-name">Model Name</label>
            <input
              type="text"
              bind:value={details.name}
              class="form-control"
              id="model-name"
              placeholder="Enter Model Name" />
            {#if errors.name}
              <FlashMessage formError={errors.name} />
            {/if}
          </div>
          <div class="col-6">
            <label for="model-image">Poster Image</label>
            <input
              type="file"
              class="form-control"
              accept="image/*"
              bind:files
              on:change={() => (details.img = files[0])}
              id="model-image" />
            {#if errors.img}
              <FlashMessage formError={errors.img} />
            {/if}
          </div>
          <div class="col-12">
            <button
              type="button"
              class="btn btn-primary btn-long"
              on:click={createModel}>
              <span class="text">Create Product</span>
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
