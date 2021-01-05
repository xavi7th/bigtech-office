<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal";

  $: ({ auth } = $page.props);

  export let productStatuses = [];

  let productStatusName, productStatusId;

  let createProductStatus = () => {
    BlockToast.fire({
      text: "Creating product status ..."
    });

    Inertia.post(
      route("superadmin.miscellaneous.create_product_status"),
      {
        status: productStatusName
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productStatuses"],
        onSuccess: () =>{
          productStatusName = null;
        },
      }
    )
  };

  let updateProductStatus = () => {
    BlockToast.fire({
      text: "Updating product status ..."
    });

    Inertia.put(
      route("superadmin.miscellaneous.edit_product_status", productStatusId),
      {
        status: productStatusName
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productStatuses"],
         onSuccess: () =>{
          productStatusName = null;
        },
      }
    )
  };

  let deleteProductStatus = id => {
    swal
      .fire({
        title: "Are you sure?",
        text:
          "This product status will be permanently deleted and products can no longer be created under it",
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
            route("superadmin.miscellaneous.delete_product_status", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "productStatuses"]
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

<Layout title="Manage Statuses">
  <div class="row vertical-gap">
  {#if auth.user.isSuperAdmin}

    <div class="col-lg-4 col-xl-4">

      <form class="#" on:submit|preventDefault={createProductStatus}>

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="name">Enter New Status</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="Status Name"
              bind:value={productStatusName} />
          </div>

          <div class="col-12">
            <button
              type="submit"
              class="btn btn-success btn-long"
              disabled={!productStatusName}>
              <span class="text">Create</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  {/if}
    <div class="col-lg-8 col-xl-8">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">Available Statuses</h2>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              {#if auth.user.isSuperAdmin}
                <th scope="col">Action</th>
              {/if}
            </tr>
          </thead>
          <tbody>
            {#each productStatuses as productStatus, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>{productStatus.status}</td>
                {#if auth.user.isSuperAdmin}
                  <td class="d-flex justify-content-between align-content-center">
                  <!-- <button
                    type="button"
                    class="btn btn-danger btn-xs"
                    on:click={() => {
                      deleteProductStatus(productStatus.id);
                    }}>
                    DELETE
                  </button> -->
                  <button
                    type="button"
                    class="btn btn-warning btn-xs"
                    data-toggle="modal"
                    data-target="#updateProductStatus"
                    on:click={() => {
                      productStatusName = productStatus.status;
                      productStatusId = productStatus.id;
                    }}>
                    EDIT
                  </button>
                </td>
                {/if}
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>

  </div>
  <div slot="modals">
    <Modal modalId="updateProductStatus" modalTitle="Update Status">
      <form class="#" on:submit|preventDefault={updateProductStatus}>

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="name">Change Status</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="Status Name"
              bind:value={productStatusName} />
          </div>

          <div class="col-12">
            <button
              type="submit"
              class="btn btn-success btn-long"
              disabled={!productStatusName}>
              <span class="text">Update</span>
            </button>
          </div>
        </div>
      </form>
    </Modal>
  </div>
</Layout>
