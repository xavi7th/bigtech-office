<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import Modal from "@superadmin-shared/Partials/Modal";
	import { page } from '@inertiajs/inertia-svelte'
  import { Inertia } from "@inertiajs/inertia";

  $: ({auth} = $page.props);

  export let salesChannels = [];
  let salesChannelName = null, salesChannelId;

  let createSalesChannel = () => {
    BlockToast.fire({
      text: "Creating sales channel ..."
    });

    Inertia.post(
      route(auth.user.user_type + ".multiaccess.miscellaneous.create_sales_channel"),
      {
        channel_name: salesChannelName
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "salesChannels"],
        onSuccess: () =>{
          salesChannelName = null;
        },
      }
    )
  };

  let updateSalesChannel = () => {
    BlockToast.fire({
      text: "Updating sales channel ..."
    });

    Inertia.put(
      route(auth.user.user_type + ".multiaccess.miscellaneous.edit_sales_channel", salesChannelId),
      {
        channel_name: salesChannelName
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "salesChannels"],
        onSuccess: () =>{
          salesChannelName = null;
        },
      }
    )
  };

  let deleteSalesChannel = id => {
    swalPreconfirm
      .fire({
        text: "This sales channel will be permanently deleted",
        confirmButtonText: "Yes, carry on!",
        preConfirm: () => {
            return Inertia.delete(
              route(auth.user.user_type + ".multiaccess.miscellaneous.delete_sales_channel", id),
              {
                preserveState: true,
                preserveScroll: true,
                only: ["flash", "errors", "salesChannels"]
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

<Layout title="Manage Sales Channels">
  <div class="row vertical-gap">
    <div class="col-lg-4 col-xl-4">

      <form class="#" on:submit|preventDefault={createSalesChannel}>

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="name">Enter New Sales Channel</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="Sales Channel Name"
              bind:value={salesChannelName} />
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
        <h2 class="mnb-2" id="formBase">Available Sales Channels</h2>
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
            {#each salesChannels as salesChannel, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>{salesChannel.channel_name}</td>
                <td class="d-flex justify-content-between align-content-center">
                  <!-- <button
                    type="button"
                    class="btn btn-danger btn-xs"
                    on:click={() => {
                      deleteSalesChannel(salesChannel.id);
                    }}>
                    DELETE
                  </button> -->
                  <button
                    type="button"
                    class="btn btn-warning btn-xs"
                    data-toggle="modal"
                    data-target="#updateSalesChannel"
                    on:click={() => {
                      salesChannelName = salesChannel.channel_name;
                      salesChannelId = salesChannel.id;
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
    <Modal modalId="updateSalesChannel" modalTitle="Update Sales Channel">
      <form class="#" on:submit|preventDefault={updateSalesChannel}>

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="name">Change Sales Channel</label>
            <input
              type="text"
              class="form-control"
              id="name"
              placeholder="Sales Channel Name"
              bind:value={salesChannelName} />
          </div>

          <div class="col-12">
            <button
              type="submit"
              class="btn btn-success btn-long"
              disabled={!salesChannelName}>
              <span class="text">Update</span>
            </button>
          </div>
        </div>
      </form>
    </Modal>
  </div>
</Layout>
