<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal";
	import { page } from '@inertiajs/inertia-svelte'

  $: ({ auth } = $page.props);

  export let accountants = [],  officeBranches = [];

  let details = {},
    files, accountantStatistics={};

  let createAccountant = () => {
    BlockToast.fire({
      text: "Creating accountant ..."
    });

    if (files) {
      details.avatar = files[0];
    }

    Inertia.post(
      route(auth.user.user_type + ".manage_staff.accountants.create"),
      details,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "accountants"],
        onSuccess: () =>{
          details = {};
          files = undefined;
        }
      }
    )
  };

  let updateAccountant = () => {
    BlockToast.fire({
      text: "Updating accountant ..."
    });

    if (files) {
      details.avatar = files[0];
    }

    details._method = "PUT";

    Inertia.post(
      route(auth.user.user_type + ".manage_staff.accountants.edit", details.id),
      details,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "accountants"],
        onSuccess: () => {
          jQuery('#updateAccountant').modal('hide');
          details = {};
          files = undefined;
        }
      }
    )
  };

  let suspendAccountant = id => {
      swalPreconfirm
        .fire({
          text:
          "This accountant will no longer be able to login to their account. It can be restored at a later time",
          confirmButtonText: "Yes, carry on!",
          preConfirm: () => {
            Inertia.put(
              route(auth.user.user_type + ".manage_staff.accountants.suspend", id),
              {
                preserveState: true,
                preserveScroll: true,
                only: ["flash", "errors", "accountants"]
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

  let restoreAccountant = id => {
    swalPreconfirm
      .fire({
        text:
          "This accountant will once again be ableto acces their accounts.",
        confirmButtonText: "Yes, carry on!",
        preConfirm: () => {
          Inertia.put(
            route(auth.user.user_type + ".manage_staff.accountants.reactivate", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "accountants"]
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

<Layout title="Manage Accountants">
  <div class="row vertical-gap">
    <div class="col-lg-4 col-xl-4 order-1 order-lg-0">
      <form class="#" on:submit|preventDefault={createAccountant}>

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="full-name">Full Name</label>
            <input
              type="text"
              class="form-control"
              id="full-name"
              placeholder="Accountant Name"
              bind:value={details.full_name} />
          </div>

          <div class="col-12">
            <label for="email">Email</label>
            <input
              type="text"
              class="form-control"
              id="email"
              placeholder="Accountant Email"
              bind:value={details.email} />
          </div>

          <div class="col-12">
            <label for="phone">Phone</label>
            <input
              type="text"
              class="form-control"
              id="phone"
              placeholder="Sales Rep Phone"
              bind:value={details.phone} />
          </div>

          <div class="col-12">
            <label for="avatar">Rep's Avatar</label>
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
          Available Accountants
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
            {#each accountants as accountant}
              <tr>
                <td>{accountant.id}</td>
                <td>
                 {accountant.full_name}
                 <br />
                  <span>{accountant.email}</span>
                    <br />
                  <span>{accountant.phone}</span>
                  {#if accountant.is_deleted}
                    <span class="badge badge-pill badge-danger ml-5">Deleted</span>
                  {/if}
                </td>
                <td>{accountant.office_branch}</td>
                <td>
                  {#if !accountant.is_deleted}
                    {#if accountant.is_suspended}
                      <button
                        type="button"
                        class="btn btn-success btn-xs nowrap"
                        on:click={() => {
                          restoreAccountant(accountant.id);
                        }}>
                        RE-ACTIVATE
                      </button>
                    {:else}
                      <button
                        type="button"
                        class="btn btn-danger btn-xs"
                        on:click={() => {
                          suspendAccountant(accountant.id);
                        }}>
                        SUSPEND
                      </button>
                    {/if}
                    <button
                      type="button"
                      class="btn btn-warning btn-xs"
                      data-toggle="modal"
                      data-target="#updateAccountant"
                      on:click={() => {
                        details = accountant;
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
    <Modal modalId="updateAccountant" modalTitle="Update Accountant">
      <form
        on:submit|preventDefault={updateAccountant}
        id="updateAccountantForm">

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="edit-full-name">Change Full Name Name</label>
            <input
              type="text"
              class="form-control"
              id="edit-full-name"
              placeholder="Rep's Name"
              bind:value={details.full_name} />
          </div>

          <div class="col-12">
            <label for="edit-email">Change Email</label>
            <input
              type="text"
              class="form-control"
              id="edit-email"
              placeholder="Accountant Email"
              bind:value={details.email} />
          </div>

          <div class="col-12">
            <label for="phone">Phone</label>
            <input
              type="text"
              class="form-control"
              id="edit-phone"
              placeholder="Sales Rep Phone"
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
            <label for="edit-avatar">Change Rep's Avatar</label>
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
        form="updateAccountantForm"
        class="btn btn-success btn-long"
        disabled={!details.email || !details.full_name }>
        <span class="text">Update</span>
      </button>
    </Modal>
  </div>
</Layout>
