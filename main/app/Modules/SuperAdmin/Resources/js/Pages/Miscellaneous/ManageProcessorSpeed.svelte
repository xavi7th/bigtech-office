<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal";

  $: ({ auth } = $page.props);

  let processorSpeedName, processorSpeedId;

  let createProcessorSpeed = () => {
    BlockToast.fire({
      text: "Creating processor speed ..."
    });

    Inertia.post(
      route("multiaccess.miscellaneous.create_processor_speed"),
      {
        speed: processorSpeedName
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "processorSpeeds"],
        onSuccess: () =>{
          processorSpeedName = null;
        },
      }
    )
  };

  let updateProcessorSpeed = () => {
    BlockToast.fire({
      text: "Updating processor speed ..."
    });

    Inertia.put(
      route("multiaccess.miscellaneous.edit_processor_speed", processorSpeedId),
      {
        speed: processorSpeedName
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "processorSpeeds"],
        onSuccess: () =>{
          processorSpeedName = null;
        },
      }
    )
  };

  let deleteProcessorSpeed = id => {
    swal
      .fire({
        title: "Are you sure?",
        text:
          "This processor speed will be permanently deleted and products can no longer be created under it",
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
            route("multiaccess.miscellaneous.delete_processor_speed", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "processorSpeeds"]
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

  export let processorSpeeds = [];
</script>

<Layout title="Manage Processor Speeds">
  <div class="row vertical-gap">
    {#if auth.user.isAdmin}
      <div class="col-lg-4 col-xl-4">
        <form class="#" on:submit|preventDefault={createProcessorSpeed}>

          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="name">Enter New Processor Speed</label>
              <input
                type="text"
                class="form-control"
                id="name"
                placeholder="Processor Speed Name"
                bind:value={processorSpeedName} />
            </div>

            <div class="col-12">
              <button
                type="submit"
                class="btn btn-success btn-long"
                disabled={!processorSpeedName}>
                <span class="text">Create</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    {/if}
    <div class="col-lg-8 col-xl-8">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">Available Processor Speeds</h2>
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
            {#each processorSpeeds as processorSpeed, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>{processorSpeed.speed}</td>
                {#if auth.user.isAdmin}
                  <td
                    class="d-flex justify-content-between align-content-center">
                    <!-- <button
                    type="button"
                    class="btn btn-danger btn-xs"
                    on:click={() => {
                      deleteProcessorSpeed(processorSpeed.id);
                    }}>
                    DELETE
                  </button> -->
                    <button
                      type="button"
                      class="btn btn-warning btn-xs"
                      data-toggle="modal"
                      data-target="#updateProcessorSpeed"
                      on:click={() => {
                        processorSpeedName = processorSpeed.speed;
                        processorSpeedId = processorSpeed.id;
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
    <Modal modalId="updateProcessorSpeed" modalTitle="Update Processor Speed">

      <div class="row vertical-gap sm-gap">
        <div class="col-12">
          <label for="name">Change Processor Speed</label>
          <input
            type="text"
            class="form-control"
            id="name"
            placeholder="Processor Speed Name"
            bind:value={processorSpeedName} />
        </div>
      </div>
      <button
        on:click={updateProcessorSpeed}
        slot="footer-buttons"
        class="btn btn-success btn-long"
        disabled={!processorSpeedName}>
        <span class="text">Update</span>
      </button>
    </Modal>
  </div>
</Layout>
