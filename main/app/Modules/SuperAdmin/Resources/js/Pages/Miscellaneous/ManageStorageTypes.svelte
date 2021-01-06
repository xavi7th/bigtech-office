<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal";

  $: ({ auth } = $page.props);

  let storageTypeName, storageTypeId;

  let createStorageType = () => {
    BlockToast.fire({
      text: "Creating storage type ..."
    });

    Inertia.post(
      route(auth.user.user_type + ".multiaccess.miscellaneous.create_storage_type"),
      {
        type: storageTypeName
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "storageTypes"],
        onSuccess: () =>{
          storageTypeName = null;
        },
      }
    )
  };

  let updateStorageType = () => {
    BlockToast.fire({
      text: "Updating storage type ..."
    });

    Inertia.put(
      route(auth.user.user_type + ".multiaccess.miscellaneous.edit_storage_type", storageTypeId),
      {
        type: storageTypeName
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "storageTypes"],
        onSuccess: () =>{
          storageTypeName = null;
        },
      }
    )
  };

  let deleteStorageType = id => {
    swal
      .fire({
        title: "Are you sure?",
        text:
          "This storage type will be permanently deleted and products can no longer be created under it",
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
            route(auth.user.user_type + ".multiaccess.miscellaneous.delete_storage_type", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "storageTypes"]
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

  export let storageTypes = [];
</script>

<Layout title="Manage Storage Types">
  <div class="row vertical-gap">
    {#if auth.user.isAdmin}
      <div class="col-lg-4 col-xl-4">
        <form class="#" on:submit|preventDefault={createStorageType}>

          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="name">Enter New Storage Type</label>
              <input
                type="text"
                class="form-control"
                id="name"
                placeholder="Storage Type Name"
                bind:value={storageTypeName} />
            </div>

            <div class="col-12">
              <button
                type="submit"
                class="btn btn-success btn-long"
                disabled={!storageTypeName}>
                <span class="text">Create</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    {/if}
    <div class="col-lg-8 col-xl-8">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">Available Storage Types</h2>
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
            {#each storageTypes as storageType, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>{storageType.type}</td>
                {#if auth.user.isAdmin}
                  <td
                    class="d-flex justify-content-between align-content-center">
                    <!-- <button
                    type="button"
                    class="btn btn-danger btn-xs"
                    on:click={() => {
                      deleteStorageType(storageType.id);
                    }}>
                    DELETE
                  </button> -->
                    <button
                      type="button"
                      class="btn btn-warning btn-xs"
                      data-toggle="modal"
                      data-target="#updateStorageType"
                      on:click={() => {
                        storageTypeName = storageType.type;
                        storageTypeId = storageType.id;
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
    <Modal modalId="updateStorageType" modalTitle="Update Storage Type">
      <form class="#" on:submit|preventDefault={updateStorageType}>

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="name">Chenge Storage Type</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="Storage Type Name"
              bind:value={storageTypeName} />
          </div>

          <div class="col-12">
            <button
              type="submit"
              class="btn btn-success btn-long"
              disabled={!storageTypeName}>
              <span class="text">Update</span>
            </button>
          </div>
        </div>
      </form>
    </Modal>
  </div>
</Layout>
