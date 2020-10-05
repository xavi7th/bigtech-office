<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal";
  import route from "ziggy";
  import { getErrorString } from "@public-assets/js/bootstrap";

  $: ({ errors, auth, flash } = $page);

  let colorName, colorId;

  let createProductColor = () => {
    BlockToast.fire({
      text: "Creating color ..."
    });


    Inertia.post(
      route("superadmin.miscellaneous.create_product_color"),
      {name:colorName},
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productColors"],
        headers: {
          "Content-Type": "multipart/form-data"
        }
      }
    ).then(() => {
      if (flash.success) {
        ToastLarge.fire({
          title: "Successful!",
          html: flash.success
        });

        colorName = null;
      } else {
        ToastLarge.fire({
          title: "Oops!",
          html: flash.error || getErrorString(errors),
          timer: 10000,
          icon: "error"
        });
      }
    });
  };

  let updateProductColor = () => {
    BlockToast.fire({
      text: "Updating color ..."
    });
    let formData = new FormData();

    formData.append("name", colorName);
    formData.append("_method", "PUT");

    Inertia.post(
      route("superadmin.miscellaneous.edit_product_color", colorId),
      formData,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productColors"],
        headers: {
          "Content-Type": "multipart/form-data"
        }
      }
    ).then(() => {
      if (flash.success) {
        colorName = null;

        ToastLarge.fire({
          title: "Successful!",
          html: flash.success
        });
      } else {
        ToastLarge.fire({
          title: "Oops!",
          html: flash.error || getErrorString(errors),
          timer: 10000,
          icon: "error"
        });
      }
    });
  };

  let deleteColor = id => {
    swal
      .fire({
        title: "Are you sure?",
        text:
          "This color will be permanently deleted and products can no longer be created under this color",
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
            route("superadmin.miscellaneous.delete_product_color", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "productColors"]
            }
          )
            .then(() => {
              if (flash.success) {
                return true;
              } else {
                throw new Error(flash.error || getErrorString(errors));
              }
            })
            .catch(error => {
              swal.showValidationMessage(`Request failed: ${error}`);
            });
        }
      })
      .then(result => {
        if (result.dismiss && result.dismiss == "cancel") {
          swal.fire(
            "Canceled!",
            "You canceled the action. Nothing was changed",
            "info"
          );
        } else if (flash.success) {
          ToastLarge.fire({
            title: "Successful!",
            html: flash.success
          });
        }
      });
  };

  export let productColors = [];
</script>

<Layout title="Manage Product Colors">
  <div class="row vertical-gap">
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
            <button
              type="submit"
              class="btn btn-success btn-long">
              <span class="text">Create</span>
            </button>
          </div>
        </div>
      </form>
    </div>
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
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each productColors as color, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>{color.name} ({color.products_count} products)</td>
                <td class="d-flex justify-content-between align-content-center">
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
