<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal";

  import { getErrorString } from "@public-assets/js/bootstrap";

  $: ({ errors, flash,auth } = $page.props);

  let productGradeName, productGradeId;

  let createProductGrade = () => {
    BlockToast.fire({
      text: "Creating product grade ..."
    });

    Inertia.post(
      route("multiaccess.miscellaneous.create_product_grade"),
      {
        grade: productGradeName
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productGrades"]
      }
    ).then(() => {
      if (flash.success) {
        ToastLarge.fire({
          title: "Successful!",
          html: flash.success
        });

        productGradeName = null;
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

  let updateProductGrade = () => {
    BlockToast.fire({
      text: "Updating product grade ..."
    });

    Inertia.put(
      route("multiaccess.miscellaneous.edit_product_grade", productGradeId),
      {
        grade: productGradeName
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productGrades"]
      }
    ).then(() => {
      if (flash.success) {
        productGradeName = null;

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

  let deleteProductGrade = id => {
    swal
      .fire({
        title: "Are you sure?",
        text:
          "This product grade will be permanently deleted and products can no longer be created under it",
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
            route("multiaccess.miscellaneous.delete_product_grade", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "productGrades"]
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

  export let productGrades = [];
</script>

<Layout title="Manage Product Grades">
  <div class="row vertical-gap">
    {#if auth.user.isAdmin}
      <div class="col-lg-4 col-xl-4">

      <form class="#" on:submit|preventDefault={createProductGrade}>
        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="name">Enter New Product Grade</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="Product Grade Name"
              bind:value={productGradeName} />
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
    {/if}
    <div class="col-lg-8 col-xl-8">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">Available Product Grades</h2>
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
            {#each productGrades as productGrade, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>{productGrade.grade}</td>
                {#if auth.user.isAdmin}
                  <td class="d-flex justify-content-between align-content-center">
                  <!-- <button
                    type="button"
                    class="btn btn-danger btn-xs"
                    on:click={() => {
                      deleteProductGrade(productGrade.id);
                    }}>
                    DELETE
                  </button> -->
                  <button
                    type="button"
                    class="btn btn-warning btn-xs"
                    data-toggle="modal"
                    data-target="#updateProductGrade"
                    on:click={() => {
                      productGradeName = productGrade.grade;
                      productGradeId = productGrade.id;
                    }}>
                    EDIT
                  </button>
                </td>
                {/if}
              </tr>
            {:else}
              <tr>
                <td colspan="5" class="text-center">NONE AVAILABLE</td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>

  </div>
  <div slot="modals">
    <Modal modalId="updateProductGrade" modalTitle="Update Product Grade">
      <form class="#" on:submit|preventDefault={updateProductGrade}>
        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="name">Chenge Product Grade</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="Product Grade Name"
              bind:value={productGradeName} />
          </div>

          <div class="col-12">
            <button
              type="submit"
              class="btn btn-success btn-long"
              disabled={!productGradeName}>
              <span class="text">Update</span>
            </button>
          </div>
        </div>
      </form>
    </Modal>
  </div>
</Layout>
