<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal";

  $: ({ auth } = $page.props);

  let categoryName, categoryId, files;

  let createProductCategory = () => {
    BlockToast.fire({
      text: "Creating category ..."
    });
    let formData = new FormData();

    if (files) {
      formData.append("img", files[0]);
    }

    formData.append("name", categoryName);

    Inertia.post(
      route(auth.user.user_type + ".multiaccess.miscellaneous.create_product_category"),
      formData,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productCategories"],
        headers: {
          "Content-Type": "multipart/form-data"
        }
      }
    )
  };

  let updateProductCategory = () => {
    BlockToast.fire({
      text: "Updating category ..."
    });
    let formData = new FormData();

    if (files) {
      formData.append("img", files[0]);
    }
    formData.append("name", categoryName);
    formData.append("_method", "PUT");

    Inertia.post(
      route(auth.user.user_type + ".multiaccess.miscellaneous.edit_product_category", categoryId),
      formData,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productCategories"],
        onSuccess: () =>{
          categoryName = null;
          files = null;
        },
        headers: {
          "Content-Type": "multipart/form-data"
        }
      }
    )
  };

  let deleteCategory = id => {
      swalPreconfirm
        .fire({
          text:
                "This category will be permanently deleted and products can no longer be created under this category",
          confirmButtonText: "Yes, carry on!",
          preConfirm: () => {
            return Inertia.delete(
              route(auth.user.user_type + ".multiaccess.miscellaneous.delete_product_category", id),
              {
                preserveState: true,
                preserveScroll: true,
                only: ["flash", "errors", "productCategories"]
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

  export let productCategories = [];
</script>

<style>
  img {
    max-height: 50px;
  }
</style>

<Layout title="Manage Product Categories">
  <div class="row vertical-gap">
    {#if auth.user.isAuditor || auth.user.isWebAdmin}
      <div class="col-lg-4 col-xl-4">
        <form class="#" on:submit|preventDefault={createProductCategory}>

          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="name">Enter New Product Category</label>
              <input
                type="text"
                class="form-control"
                id="name"
                placeholder="Category Name"
                bind:value={categoryName} />
            </div>
            <div class="col-12">
              <label for="category-logo">Category Sample Image</label>
              <input
                type="file"
                id="category-logo"
                bind:files
                accept="image/*"
                class="form-control" />
            </div>

            <div class="col-12">
              <button
                type="submit"
                class="btn btn-success btn-long"
                disabled={!categoryName}>
                <span class="text">Create</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    {/if}
    <div class="col-lg-8 col-xl-8">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">Available Product Categories</h2>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Sample Image</th>
              {#if auth.user.isAuditor || auth.user.isWebAdmin}
                <th scope="col">Action</th>
              {/if}
            </tr>
          </thead>
          <tbody>
            {#each productCategories as category, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>{category.name} ({category.products_count} products)</td>
                  <td>
                    <img
                      src={category.img_url}
                      alt="{category.name}'s logo"
                      class="img-fluid img-responsive" />
                  </td>
                {#if auth.user.isAuditor || auth.user.isWebAdmin}
                  <td class="">
                    <!-- <button
                    type="button"
                    class="btn btn-danger btn-xs"
                    on:click={() => {
                      deleteCategory(category.id);
                    }}>
                    DELETE
                  </button> -->
                    <button
                      type="button"
                      class="btn btn-warning btn-xs"
                      data-toggle="modal"
                      data-target="#updateCategory"
                      on:click={() => {
                        categoryName = category.name;
                        categoryId = category.id;
                      }}>
                      EDIT
                    </button>
                  </td>
                {/if}
              </tr>
            {:else}
              <tr>
                <td colspan="5" class="text-center">
                  NO PRODUCT COLORS AVAILABLE
                </td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div slot="modals">
    <Modal modalId="updateCategory" modalTitle="Update Product Category">
      <form class="#" on:submit|preventDefault={updateProductCategory}>

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="name">Enter New Product Category</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="Category Name"
              bind:value={categoryName} />
          </div>
          <div class="col-12">
            <label for="category-logo">Category Sample Image</label>
            <input
              type="file"
              id="category-logo"
              bind:files
              accept="image/*"
              class="form-control" />
          </div>

          <div class="col-12">
            <button
              type="submit"
              class="btn btn-success btn-long"
              disabled={!categoryName}>
              <span class="text">Update</span>
            </button>
          </div>
        </div>
      </form>
    </Modal>
  </div>
</Layout>
