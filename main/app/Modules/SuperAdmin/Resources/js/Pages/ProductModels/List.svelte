<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@usershared/FlashMessage";
  import route from "ziggy";

  $: ({ auth, errors, flash } = $page);

  export let productModels = [],
    productBrands = [],
    productCategories = [];

  let details = {},
    files;

  let editModel = () => {
    console.log(details);
    BlockToast.fire({
      text: "Updating product model details ..."
    });
    let formData = new FormData();

    details._method = "PUT";

    _.forEach(details, (val, key) => {
      formData.append(key, val);
    });

    Inertia.post(
      route("multiaccess.product_models.edit_product_model", details.id),
      formData,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["productModels", "flash", "errors"],

        headers: {
          "Content-Type": "multipart/form-data"
        }
      }
    ).then(() => {
      // swal.close();
      if (flash.success) {
        files = null;
        details = {
          product_brand_id: null,
          product_category_id: null,
          name: null,
          img: null
        };
        ToastLarge.fire({
          title: "Successful!",
          html: flash.success,
          timer: 10000
        });
      } else {
        swal.close();
      }
    });
  };
</script>

<Layout title="Product Models">
  <div class="row vertical-gap">
    <div class="col-12">

      <div class="table-responsive-md">
        <table
          class="rui-datatable table table-striped table-bordered table-sm">
          <thead>
            <tr>
              <th class="p-0">
               {#if auth.user.isAdmin}
                  <InertiaLink
                  href={route('multiaccess.product_models.create_product_model')}
                  class="btn btn-brand m-10">
                  <span>Create Product Model</span>
                </InertiaLink>
               {/if}
              </th>
              <th class="d-none">
                NOSIGN
              </th>
              <th class="d-none">
                NOSIGN
              </th>
            </tr>
          </thead>
          <tbody class="list-group list-group-flush">
            {#each productModels as model (model.id)}
              <tr class="list-group-item p-0">
                <td class="media media-success media-filled p-0">
                  <div class="media-link">
                    <img
                      src={model.img_url}
                      alt="{model.name} poster"
                      class="media-img" />
                    <span class="media-body">
                      <span class="media-title">{model.name}</span>
                      <small class="media-subtitle">
                        {model.product_category}, {model.product_brand}
                      </small>
                    </span>
                    <button
                      on:click={() => (details = model)}
                      class="btn btn-warning btn-sm mr-10"
                      data-toggle="modal"
                      data-target="#editModelModal">
                      <span>Edit</span>
                    </button>
                    <InertiaLink
                      href={route('multiaccess.product_models.details', model.id)}
                      class="btn btn-brand btn-sm">
                      <span>Details</span>
                      <span class="badge badge-light">
                        {model.product_count}
                      </span>
                    </InertiaLink>
                  </div>
                </td>
                <td class="d-none">
                  NOSIGN
                </td>
                <td class="d-none">
                  NOSIGN
                </td>
              </tr>
            {:else}
              <tr class="list-group-item p-0">
                <td class="media media-warning media-filled p-0">
                  <a href="#home" class="media-link">
                    <span class="media-img">S</span>
                    <span class="media-body">
                      <span class="media-title">No Product Models</span>
                      <small class="media-subtitle">N/A</small>
                    </span>
                  </a>
                </td>
                 <td  class="d-none">
                  NOSIGN
                </td>
                 <td  class="d-none">
                  NOSIGN
                </td>
              </tr>
            {/each}
          </tbody>
        </table>

      </div>
    </div>
  </div>
</Layout>

<div
  class="modal fade"
  id="editModelModal"
  tabindex="-1"
  role="dialog"
  aria-labelledby="editModelModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModelModalLabel">
          Edit {details.name} details
        </h5>
        <button
          type="button"
          class="close"
          data-dismiss="modal"
          aria-label="Close">
          <span data-feather="x" class="rui-icon rui-icon-stroke-1_5" />
        </button>
      </div>
      <div class="modal-body">
        <form class="#">
          <div class="row vertical-gap sm-gap">

            <div class="col-6">
              <label for="model-brand">Model Brand</label>
              <div class="input-group">
                <select
                  id="model-brand"
                  bind:value={details.product_brand_id}
                  class="custom-select text-capitalize">
                  {#each productBrands as brand}
                    <option
                      value={brand.id}
                      selected={brand.name == details.product_brand}>
                      {brand.name}
                    </option>
                  {/each}
                </select>
              </div>
              {#if errors.product_brand_id}
                <FlashMessage formError={errors.product_brand_id[0]} />
              {/if}
            </div>
            <div class="col-6">
              <label for="model-category">Model Category</label>
              <div class="input-group">
                <select
                  id="model-category"
                  bind:value={details.product_category_id}
                  class="custom-select text-capitalize">
                  {#each productCategories as cat}
                    <option
                      value={cat.id}
                      selected={cat.name == details.product_category}>
                      {cat.name}
                    </option>
                  {/each}
                </select>
              </div>
              {#if errors.product_category_id}
                <FlashMessage formError={errors.product_category_id[0]} />
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
                <FlashMessage formError={errors.name[0]} />
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
                <FlashMessage formError={errors.img[0]} />
              {/if}
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">
          Close
        </button>
        <button
          type="button"
          class="btn btn-primary btn-long"
          data-dismiss="modal"
          on:click={editModel}>
          <span class="text">Update Model</span>
          <span class="icon">
            <span
              data-feather="check-circle"
              class="rui-icon rui-icon-stroke-1_5" />
          </span>
        </button>
      </div>
    </div>
  </div>
</div>
