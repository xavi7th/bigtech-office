<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import FlashMessage from "@usershared/FlashMessage";
  import Modal from "@superadmin-shared/Partials/Modal";

  import { getErrorString } from "@public-assets/js/bootstrap";

  $: ({ errors, auth, flash } = $page);

  let details = {},
    officeBranchId;

  let createOfficeBranch = () => {
    BlockToast.fire({
      text: "Creating office branch ..."
    });

    Inertia.post(
      route("superadmin.miscellaneous.create_office_branch"),
      details,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "officeBranches"]
      }
    ).then(() => {
      if (flash.success) {
        ToastLarge.fire({
          title: "Successful!",
          html: flash.success
        });

        details = {};
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

  let updateOfficeBranch = () => {
    BlockToast.fire({
      text: "Updating office branch ..."
    });

    Inertia.put(
      route("superadmin.miscellaneous.edit_office_branch", details.id),
      details,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "officeBranches"]
      }
    ).then(() => {
      if (flash.success) {
        details = {};

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

  let deleteOfficeBranch = id => {
    swal
      .fire({
        title: "Are you sure?",
        text:
          "This office branch will be permanently deleted and products can no longer be created under it",
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
            route("superadmin.miscellaneous.delete_office_branch", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "officeBranches"]
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

  export let officeBranches = [];
</script>

<Layout title="Manage Office Branches">
  <div class="row vertical-gap">
    <div class="col-lg-4 col-xl-4">

      <form class="#" on:submit|preventDefault={createOfficeBranch}>
        <FlashMessage />

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="city">Branch City</label>
            <input
              type="text"
              class="form-control"
              id="city"
              placeholder="Branch Designated City"
              bind:value={details.city} />
          </div>
          <div class="col-12">
            <label for="country">Country</label>
            <input
              type="text"
              class="form-control"
              id="country"
              placeholder="Country"
              bind:value={details.country} />
          </div>

          <div class="col-12">
            <button
              type="submit"
              class="btn btn-success btn-long"
              disabled={!details.country || !details.city}>
              <span class="text">Create</span>
            </button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-lg-8 col-xl-8">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">Available Office Branches</h2>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">City</th>
              <th scope="col">Country</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each officeBranches as officeBranch, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>{officeBranch.city}</td>
                <td>{officeBranch.country}</td>
                <td class="d-flex justify-content-between align-content-center">
                  <!-- <button
                    type="button"
                    class="btn btn-danger btn-xs"
                    on:click={() => {
                      deleteOfficeBranch(officeBranch.id);
                    }}>
                    DELETE
                  </button> -->
                  <button
                    type="button"
                    class="btn btn-warning btn-xs"
                    data-toggle="modal"
                    data-target="#updateOfficeBranch"
                    on:click={() => {
                      details = officeBranch;
                    }}>
                    EDIT
                  </button>
                  <InertiaLink
                    href={route('superadmin.miscellaneous.office_branches.view_products', officeBranch.id)}
                    class="btn btn-brand btn-xs text-nowrap">
                    PRODUCTS ({officeBranch.products_count})
                  </InertiaLink>
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
    <Modal modalId="updateOfficeBranch" modalTitle="Update Office Branch">
      <form
        id="updateOfficeBranchForm"
        on:submit|preventDefault={updateOfficeBranch}>
        <FlashMessage />

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="city">Branch City</label>
            <input
              type="text"
              class="form-control"
              id="city"
              placeholder="Branch Designated City"
              bind:value={details.city} />
          </div>
          <div class="col-12">
            <label for="country">Country</label>
            <input
              type="text"
              class="form-control"
              id="country"
              placeholder="Country"
              bind:value={details.country} />
          </div>
        </div>
      </form>
      <button
        type="submit"
        form="updateOfficeBranchForm"
        class="btn btn-success btn-long"
        disabled={!details.city || !details.country}>
        <span class="text">Update</span>
      </button>
    </Modal>
  </div>
</Layout>
