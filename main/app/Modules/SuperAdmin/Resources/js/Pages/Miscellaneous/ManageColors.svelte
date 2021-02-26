<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal";

  $: ({ auth } = $page.props);

  let colorName, colorId;

  let createProductColor = () => {
    BlockToast.fire({
      text: "Creating color ..."
    });

    Inertia.post(
      route(auth.user.user_type + ".multiaccess.miscellaneous.create_product_color"),
      { name: colorName },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productColors"],
        headers: {
          "Content-Type": "multipart/form-data"
        }
      }
    );
  };

  let updateProductColor = () => {
    BlockToast.fire({
      text: "Updating color ..."
    });
    let formData = new FormData();

    formData.append("name", colorName);
    formData.append("_method", "PUT");

    Inertia.post(
      route(auth.user.user_type + ".multiaccess.miscellaneous.edit_product_color", colorId),
      formData,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productColors"],
        onSuccess: () =>{
          colorName = null;
        },
        headers: {
          "Content-Type": "multipart/form-data"
        }
      }
    )
  };

  let deleteColor = id => {
      swalPreconfirm
        .fire({
          text:
          "This color will be permanently deleted and products can no longer be created under this color",
          confirmButtonText: "Yes, carry on!",
          preConfirm: () => {
            return Inertia.delete(
              route("superadmin.miscellaneous.delete_product_color", id),
              {
                preserveState: true,
                preserveScroll: true,
                only: ["flash", "errors", "productColors"]
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

  export let productColors = [];
</script>

<Layout title="Manage Product Colors">
  <div class="row vertical-gap">
    {#if auth.user.isAdmin}
      <div class="col-lg-4 col-xl-4">
        <form class="#" on:submit|preventDefault={createProductColor}>
          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="name">Enter New Product Color</label>
              <input
                type="text"
                class="form-control"
                id="name"
                placeholder="Color Name"
                bind:value={colorName} />
            </div>

            <div class="col-12">
              <button type="submit" class="btn btn-success btn-long">
                <span class="text">Create</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    {/if}
    <div class="col-lg-8 col-xl-8">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">Available Product Colors</h2>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              {#if auth.user.isAdmin}
                <th scope="col">Action</th>
              {/if}
            </tr>
          </thead>
          <tbody>
            {#each productColors as color, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>{color.name} ({color.products_count} products)</td>
                {#if auth.user.isAdmin}
                  <td
                    class="d-flex justify-content-between align-content-center">
                    <!-- <button
                    type="button"
                    class="btn btn-danger btn-xs"
                    on:click={() => {
                      deleteColor(color.id);
                    }}>
                    DELETE
                  </button> -->
                    <button
                      type="button"
                      class="btn btn-warning btn-xs"
                      data-toggle="modal"
                      data-target="#updateColor"
                      on:click={() => {
                        colorName = color.name;
                        colorId = color.id;
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
    <Modal modalId="updateColor" modalTitle="Update Product Color">
      <form class="#" on:submit|preventDefault={updateProductColor}>
        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="name">Change Product Color</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="Color Name"
              bind:value={colorName} />
          </div>

          <div class="col-12">
            <button
              type="submit"
              class="btn btn-success btn-long"
              disabled={!colorName}>
              <span class="text">Update</span>
            </button>
          </div>
        </div>
      </form>
    </Modal>
  </div>
</Layout>
