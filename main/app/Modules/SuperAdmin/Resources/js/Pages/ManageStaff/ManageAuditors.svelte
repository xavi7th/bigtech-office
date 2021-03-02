<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal";
	import { page } from '@inertiajs/inertia-svelte'

  $: ({ auth } = $page.props);

  export let auditors = [],  officeBranches = [];

  let details = {},
    files, auditorStatistics={};

  let createAuditor = () => {
    BlockToast.fire({
      text: "Creating user account ..."
    });

    if (files) {
      details.avatar = files[0];
    }

    Inertia.post(
      route(auth.user.user_type + ".manage_staff.auditors.create"),
      details,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "auditors"],
        onSuccess: () =>{
          details = {};
          files = undefined;
        }
      }
    )
  };

  let updateAuditor = () => {
    BlockToast.fire({
      text: "Updating user account ..."
    });

    if (files) {
      details.avatar = files[0];
    }

    details._method = "PUT";

    Inertia.post(
      route(auth.user.user_type + ".manage_staff.auditors.edit", details.id),
      details,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "auditors"],
        onSuccess: () => {
          jQuery('#updateAuditor').modal('hide');
          details = {};
          files = undefined;
        }
      }
    )
  };

  let suspendAuditor = id => {
      swalPreconfirm
        .fire({
          text:
          "This staff will no longer be able to login to their account. It can be restored at a later time",
          confirmButtonText: "Yes, carry on!",
          preConfirm: () => {
            Inertia.put(
              route(auth.user.user_type + ".manage_staff.auditors.suspend", id),
              {
                preserveState: true,
                preserveScroll: true,
                only: ["flash", "errors", "auditors"]
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

  let restoreAuditor = id => {
    swalPreconfirm
      .fire({
        text:
          "This staff will once again be able to access their accounts.",
        confirmButtonText: "Yes, carry on!",
        preConfirm: () => {
          Inertia.put(
            route(auth.user.user_type + ".manage_staff.auditors.reactivate", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "auditors"]
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

<Layout title="Manage Auditors">
  <div class="row vertical-gap">
    <div class="col-lg-4 col-xl-4 order-1 order-lg-0">
      <form class="#" on:submit|preventDefault={createAuditor}>

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="full-name">Full Name</label>
            <input
              type="text"
              class="form-control"
              id="full-name"
              placeholder="Name"
              bind:value={details.full_name} />
          </div>

          <div class="col-12">
            <label for="email">Email</label>
            <input
              type="text"
              class="form-control"
              id="email"
              placeholder="Email"
              bind:value={details.email} />
          </div>

          <div class="col-12">
            <label for="phone">Phone</label>
            <input
              type="text"
              class="form-control"
              id="phone"
              placeholder="Phone"
              bind:value={details.phone} />
          </div>

          <div class="col-12">
            <label for="avatar">User's Avatar</label>
            <input
              type="file"
              id="avatar"
              bind:files
              accept="image/*"
              class="form-control" />
          </div>

          <div class="col-12">
            <label for="office-branch">Office Branch</label>
             <select
                id="office-branch"
                class="custom-select"
                bind:value={details.office_branch_id}>
                <option value={null}>Select</option>
                {#each officeBranches as branch}
                  <option value={branch.id}>{branch.city}</option>
                {/each}
              </select>
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
    <div class="col-lg-8 col-xl-8 order-0 order-lg-1">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">
          Available Auditor Staff
        </h2>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th scope="col">S/No</th>
              <th scope="col">Details</th>
              <th scope="col">Branch</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each auditors as auditor}
              <tr>
                <td>{auditor.id}</td>
                <td>
                 {auditor.full_name}
                 <br />
                  <span>{auditor.email}</span>
                    <br />
                  <span>{auditor.phone}</span>
                  {#if auditor.is_deleted}
                    <span class="badge badge-pill badge-danger ml-5">Deleted</span>
                  {/if}
                </td>
                <td>{auditor.office_branch}</td>
                <td>
                  {#if !auditor.is_deleted}
                    {#if auditor.is_suspended}
                      <button
                        type="button"
                        class="btn btn-success btn-xs nowrap"
                        on:click={() => {
                          restoreAuditor(auditor.id);
                        }}>
                        RE-ACTIVATE
                      </button>
                    {:else}
                      <button
                        type="button"
                        class="btn btn-danger btn-xs"
                        on:click={() => {
                          suspendAuditor(auditor.id);
                        }}>
                        SUSPEND
                      </button>
                    {/if}
                    <button
                      type="button"
                      class="btn btn-warning btn-xs"
                      data-toggle="modal"
                      data-target="#updateAuditor"
                      on:click={() => {
                        details = auditor;
                      }}>
                      EDIT
                    </button>
                  {/if}
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
    <Modal modalId="updateAuditor" modalTitle="Update User's Details">
      <form
        on:submit|preventDefault={updateAuditor}
        id="updateAuditorForm">

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="edit-full-name">Change Full Name</label>
            <input
              type="text"
              class="form-control"
              id="edit-full-name"
              placeholder="Name"
              bind:value={details.full_name} />
          </div>

          <div class="col-12">
            <label for="edit-email">Change Email</label>
            <input
              type="text"
              class="form-control"
              id="edit-email"
              placeholder="Email"
              bind:value={details.email} />
          </div>

          <div class="col-12">
            <label for="phone">Phone</label>
            <input
              type="text"
              class="form-control"
              id="edit-phone"
              placeholder="Phone"
              bind:value={details.phone} />
          </div>

          <div class="col-12">
            <label for="office-branch">Office Branch</label>
             <select
                id="edit-office-branch"
                class="custom-select"
                bind:value={details.office_branch_id}>
                <option value={null}>Select</option>
                {#each officeBranches as branch}
                  <option value={branch.id}>{branch.city}</option>
                {/each}
              </select>
          </div>

          <div class="col-12">
            <label for="edit-avatar">Change User's Avatar</label>
            <input
              type="file"
              id="edit-avatar"
              bind:files
              accept="image/*"
              class="form-control" />
          </div>
        </div>
      </form>

      <button
        type="submit"
        slot="footer-buttons"
        form="updateAuditorForm"
        class="btn btn-success btn-long"
        disabled={!details.email || !details.full_name }>
        <span class="text">Update</span>
      </button>
    </Modal>
  </div>
</Layout>
