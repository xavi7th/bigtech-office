<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal";

  $: ({ auth } = $page.props);

  export let productBrands = [];

  let brandName, files, brandId;

  let createProductBrand = () => {
    BlockToast.fire({
      text: "Creating brand ..."
    });
    let formData = new FormData();

    if (files) {
      formData.append("img", files[0]);
    }
    formData.append("name", brandName);

    Inertia.post(
      route("multiaccess.product_brands.create_product_brand"),
      formData,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productBrands"],
        onSuccess: () =>{
          files = null;
          brandName = null;
        },
        headers: {
          "Content-Type": "multipart/form-data"
        }
      }
    )
  };

  let updateProductBrand = () => {
    BlockToast.fire({
      text: "Updating brand ..."
    });
    let formData = new FormData();

    if (files) {
      formData.append("img", files[0]);
    }
    formData.append("name", brandName);
    formData.append("_method", "PUT");

    Inertia.post(
      route("multiaccess.product_brands.edit_product_brand", brandId),
      formData,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productBrands"],
        onSuccess: () =>{
          files = null;
          brandName = null;
        },
        headers: {
          "Content-Type": "multipart/form-data"
        }
      }
    )
  };

  let deleteBrand = id => {
    swal
      .fire({
        title: "Are you sure?",
        text:
          "This brand and all associated models will be permanently deleted and it may no longer be possible to create products under this brand",
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
          return Inertia.delete(
            route("multiaccess.product_brands.delete_product_brand", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "productBrands"]
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
  img {
    max-height: 50px;
  }
</style>

<Layout title="Manage Product Brands">
  <div class="row vertical-gap">
    {#if auth.user.isAdmin}
      <div class="col-lg-4 col-xl-4">
        <form class="#" on:submit|preventDefault={createProductBrand}>
          <div
            class="d-flex align-items-center justify-content-between flex-column
              mb-25">
          </div>

          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="name">Enter New Product Brand</label>
              <input
                type="text"
                class="form-control"
                id="name"
                placeholder="Brand Name"
                bind:value={brandName} />
            </div>
            <div class="col-12">
              <label for="brand-logo">Brand logo</label>
              <input
                type="file"
                id="brand-logo"
                bind:files
                accept="image/*"
                class="form-control" />
            </div>

            <div class="col-12">
              <button
                type="submit"
                class="btn btn-success btn-long"
                disabled={!brandName}>
                <span class="text">Create</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    {/if}
    <div class="col-lg-8 col-xl-8">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">Available Product Brands</h2>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Logo</th>
              <th scope="col">Name</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each productBrands as brand, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>
                  <img
                    src={brand.logo_url}
                    alt="{brand.name}'s logo"
                    class="img-fluid img-responsive" />
                </td>
                <td>{brand.name} ({brand.products_count} products)</td>
                <td class="d-flex justify-content-between align-content-center">
                  {#if auth.user.isSuperAdmin}
                    <button
                      type="button"
                      class="btn btn-danger btn-xs"
                      on:click={() => {
                        deleteBrand(brand.id);
                      }}>
                      DELETE
                    </button>
                  {/if}
                  <button
                    type="button"
                    class="btn btn-warning btn-xs"
                    data-toggle="modal"
                    data-target="#updateBrand"
                    on:click={() => {
                      brandName = brand.name;
                      brandId = brand.id;
                    }}>
                    EDIT
                  </button>
                </td>
              </tr>
            {:else}
              <tr>
                <td colspan="5" class="text-center">
                  NO PRODUCT BRANDS AVAILABLE
                </td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div slot="modals">
    <form class="#" on:submit|preventDefault={updateProductBrand}>
      <Modal modalId="updateBrand" modalTitle="Add Image to Product Model">
        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="name">Enter New Product Brand</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="Brand Name"
              bind:value={brandName} />
          </div>
          <div class="col-12">
            <label for="brand-logo">Brand logo</label>
            <input
              type="file"
              id="brand-logo"
              bind:files
              accept="image/*"
              class="form-control" />
          </div>
        </div>
        <button
          slot="footer-buttons"
          type="submit"
          class="btn btn-success btn-long"
          disabled={!brandName}>
          <span class="text">Update</span>
        </button>
      </Modal>
    </form>
  </div>
</Layout>
