<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal";
	import { page } from '@inertiajs/inertia-svelte'

  $: ({ auth } = $page.props);

  export let web_admins = [],  officeBranches = [];

  let details = {},
    files, webAdminStatistics={};

  let createWebAdmin = () => {
    BlockToast.fire({
      text: "Creating user account ..."
    });

    if (files) {
      details.avatar = files[0];
    }

    Inertia.post(
      route(auth.user.user_type + ".manage_staff.web_admins.create"),
      details,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "web_admins"],
        onSuccess: () =>{
          details = {};
          files = undefined;
        }
      }
    )
  };

  let updateWebAdmin = () => {
    BlockToast.fire({
      text: "Updating user account ..."
    });

    if (files) {
      details.avatar = files[0];
    }

    details._method = "PUT";

    Inertia.post(
      route(auth.user.user_type + ".manage_staff.web_admins.edit", details.id),
      details,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "web_admins"],
        onSuccess: () => {
          jQuery('#updateWebAdmin').modal('hide');
          details = {};
          files = undefined;
        }
      }
    )
  };

  let suspendWebAdmin = id => {
      swalPreconfirm
        .fire({
          text:
          "This staff will no longer be able to login to their account. It can be restored at a later time",
          confirmButtonText: "Yes, carry on!",
          preConfirm: () => {
            Inertia.put(
              route(auth.user.user_type + ".manage_staff.web_admins.suspend", id),
              {
                preserveState: true,
                preserveScroll: true,
                only: ["flash", "errors", "web_admins"]
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

  let restoreWebAdmin = id => {
    swalPreconfirm
      .fire({
        text:
          "This staff will once again be able to access their accounts.",
        confirmButtonText: "Yes, carry on!",
        preConfirm: () => {
          Inertia.put(
            route(auth.user.user_type + ".manage_staff.web_admins.reactivate", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "web_admins"]
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

<Layout title="Manage Web Admins">
  <div class="row vertical-gap">
    <div class="col-lg-4 col-xl-4 order-1 order-lg-0">
      <form class="#" on:submit|preventDefault={createWebAdmin}>

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
          Available Web Admin Staff
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
            {#each web_admins as web_admin}
              <tr>
                <td>{web_admin.id}</td>
                <td>
                 {web_admin.full_name}
                 <br />
                  <span>{web_admin.email}</span>
                    <br />
                  <span>{web_admin.phone}</span>
                  {#if web_admin.is_deleted}
                    <span class="badge badge-pill badge-danger ml-5">Deleted</span>
                  {/if}
                </td>
                <td>{web_admin.office_branch}</td>
                <td>
                  {#if !web_admin.is_deleted}
                    {#if web_admin.is_suspended}
                      <button
                        type="button"
                        class="btn btn-success btn-xs nowrap"
                        on:click={() => {
                          restoreWebAdmin(web_admin.id);
                        }}>
                        RE-ACTIVATE
                      </button>
                    {:else}
                      <button
                        type="button"
                        class="btn btn-danger btn-xs"
                        on:click={() => {
                          suspendWebAdmin(web_admin.id);
                        }}>
                        SUSPEND
                      </button>
                    {/if}
                    <button
                      type="button"
                      class="btn btn-warning btn-xs"
                      data-toggle="modal"
                      data-target="#updateWebAdmin"
                      on:click={() => {
                        details = web_admin;
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
    <Modal modalId="updateWebAdmin" modalTitle="Update User's Details">
      <form
        on:submit|preventDefault={updateWebAdmin}
        id="updateWebAdminForm">

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
        form="updateWebAdminForm"
        class="btn btn-success btn-long"
        disabled={!details.email || !details.full_name }>
        <span class="text">Update</span>
      </button>
    </Modal>
  </div>
</Layout>
