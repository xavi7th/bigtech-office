<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page, } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal";

  $: ({ auth } = $page.props);

  let storageSizeName, storageSizeId;

  let createStorageSize = () => {
    BlockToast.fire({
      text: "Creating storage size ..."
    });

    Inertia.post(
      route(auth.user.user_type + ".multiaccess.miscellaneous.create_storage_size"),
      {
        size: storageSizeName
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "storageSizes"],
        onSuccess: () =>{
          storageSizeName = null;
        },
      }
    )
  };

  let updateStorageSize = () => {
    BlockToast.fire({
      text: "Updating storage size ..."
    });

    Inertia.put(
      route(auth.user.user_type + ".multiaccess.miscellaneous.edit_storage_size", storageSizeId),
      {
        size: storageSizeName
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "storageSizes"],
         onSuccess: () =>{
          storageSizeName = null;
        },
      }
    )
  };

  let deleteStorageSize = id => {
    swalPreconfirm
      .fire({
        text:
          "This storage size will be permanently deleted and products can no longer be created under it",
        confirmButtonText: "Yes, carry on!",
        preConfirm: () => {
          return Inertia.delete(
            route(auth.user.user_type + ".multiaccess.miscellaneous.delete_storage_size", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "storageSizes"]
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

  export let storageSizes = [];
</script>

<Layout title="Manage Storage Sizes">
  <div class="row vertical-gap">
    {#if auth.user.isAuditor || auth.user.isWebAdmin}
      <div class="col-lg-4 col-xl-4">

      <form class="#" on:submit|preventDefault={createStorageSize}>

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="name">Enter New Storage Size</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="Storage Size Name"
              bind:value={storageSizeName} />
          </div>

          <div class="col-12">
            <button
              type="submit"
              class="btn btn-success btn-long"
              disabled={!storageSizeName}>
              <span class="text">Create</span>
            </button>
          </div>
        </div>
      </form>
    </div>
    {/if}
    <div class="col-lg-8 col-xl-8">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">Available Storage Sizes</h2>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              {#if auth.user.isAuditor || auth.user.isWebAdmin}
                <th scope="col">Action</th>
              {/if}
            </tr>
          </thead>
          <tbody>
            {#each storageSizes as storageSize, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>{storageSize.size}</td>
               {#if auth.user.isAuditor || auth.user.isWebAdmin}
                  <td class="d-flex justify-content-between align-content-center">
                  <!-- <button
                    type="button"
                    class="btn btn-danger btn-xs"
                    on:click={() => {
                      deleteStorageSize(storageSize.id);
                    }}>
                    DELETE
                  </button> -->
                {#if auth.user.isAuditor || auth.user.isWebAdmin}
                    <button
                    type="button"
                    class="btn btn-warning btn-xs"
                    data-toggle="modal"
                    data-target="#updateStorageSize"
                    on:click={() => {
                      storageSizeName = storageSize.size;
                      storageSizeId = storageSize.id;
                    }}>
                    EDIT
                  </button>
                {/if}
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
    <Modal modalId="updateStorageSize" modalTitle="Update Storage Size">
      <form class="#" on:submit|preventDefault={updateStorageSize}>

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="name">Chenge Storage Size</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="Storage Size Name"
              bind:value={storageSizeName} />
          </div>

          <div class="col-12">
            <button
              type="submit"
              class="btn btn-success btn-long"
              disabled={!storageSizeName}>
              <span class="text">Update</span>
            </button>
          </div>
        </div>
      </form>
    </Modal>
  </div>
</Layout>
