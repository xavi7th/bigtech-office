<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import FlashMessage from "@usershared/FlashMessage";
  import Modal from "@superadmin-shared/Partials/Modal";
  import route from "ziggy";
  import { getErrorString } from "@public-assets/js/bootstrap";

  $: ({ errors, auth, flash } = $page);

  let processorSpeedName, processorSpeedId;

  let createProcessorSpeeed = () => {
    BlockToast.fire({
      text: "Creating processor speed ..."
    });

    Inertia.post(
      route("superadmin.miscellaneous.create_processor_speed"),
      {
        speed: processorSpeedName
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "processorSpeeds"]
      }
    ).then(() => {
      if (flash.success) {
        ToastLarge.fire({
          title: "Successful!",
          html: flash.success
        });

        processorSpeedName = null;
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

  let updateProcessorSpeeed = () => {
    BlockToast.fire({
      text: "Updating processor speed ..."
    });

    Inertia.put(
      route("superadmin.miscellaneous.edit_processor_speed", processorSpeedId),
      {
        speed: processorSpeedName
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "processorSpeeds"]
      }
    ).then(() => {
      if (flash.success) {
        processorSpeedName = null;

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
            route("superadmin.miscellaneous.delete_processor_speed", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "processorSpeeds"]
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

  export let processorSpeeds = [];
</script>

<style>
  img {
    max-height: 50px;
  }
</style>

<Layout title="Manage Processor Speeds">
  <div class="row vertical-gap">
    <div class="col-lg-4 col-xl-4">

      <form class="#" on:submit|preventDefault={createProcessorSpeeed}>
        <FlashMessage />

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
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each processorSpeeds as processorSpeed, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>{processorSpeed.speed}</td>
                <td class="d-flex justify-content-between align-content-center">
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
      <form class="#" on:submit|preventDefault={updateProcessorSpeeed}>
        <FlashMessage />

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="name">Chenge Processor Speed</label>
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
              <span class="text">Update</span>
            </button>
          </div>
        </div>
      </form>
    </Modal>
  </div>
</Layout>
