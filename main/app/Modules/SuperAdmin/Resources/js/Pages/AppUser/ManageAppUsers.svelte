<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal";
  import SearchComponent from "@superadmin-shared/Partials/SearchComponent.svelte";
  import { toCurrency } from "@public-shared/helpers";
	import { page } from '@inertiajs/inertia-svelte'

  $: ({ auth } = $page.props);

  export let app_users = [];

  let details = {},
    files, appUserDetails={},
    searchKeys={'email': 'Email','first_name':'First Name','last_name':'Last Name'},
    isSearching = false;

  let createAppUser = () => {
    BlockToast.fire({
      text: "Creating app users ..."
    });

    let formData = new FormData();

    if (files) {
      formData.append("avatar", files[0]);
    }

    _.forEach(details, (val, key) => {
      formData.append(key, val);
    });

    Inertia.post(
      route(auth.user.user_type + ".manage_staff.sales_rep.create"),
      formData,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "app_users"],
        onSuccess: () =>{
          details = {};
          files = undefined;
        },
        headers: {
          "Content-Type": "multipart/form-data"
        }
      }
    )
  };

  let updateAppUser = () => {
    BlockToast.fire({
      text: "Updating user details ..."
    });

    Inertia.put(
      route(auth.user.user_type + ".appusers.update_user", details.id),
      details,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "app_users"],
        onSuccess: () => {
          jQuery('#updateAppUser').modal('hide');
          details = {};
          files = undefined;
        }
      }
    )
  };

  let suspendAppUser = id => {
      swalPreconfirm
        .fire({
          text:
          "This app users will no longer be able to login to their account. It can be restored at a later time",
          confirmButtonText: "Yes, carry on!",
          preConfirm: () => {
          return Inertia.delete(
            route(auth.user.user_type + ".manage_staff.sales_rep.suspend", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "app_users"]
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

  let restoreAppUser = id => {
    swalPreconfirm
      .fire({
        text:
          "This app users will once again be ableto acces their accounts.",
        confirmButtonText: "Yes, carry on!",
        preConfirm: () => {
          return Inertia.put(
            route(auth.user.user_type + ".manage_staff.sales_rep.reactivate", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "app_users"]
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

<Layout title="Manage App Users">
  <div class="row vertical-gap">
    <div class="col-lg-10">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">
          Available App Users
        </h2>
      </div>
      <SearchComponent dataKey='app_users' {searchKeys} on:isSearching={e => isSearching = e.detail}/>
      <div class="table-responsive" class:is-searching={isSearching}>
        <!-- svelte-ignore missing-declaration -->
        <table class="table table-bordered" use:initialiseBasicDataTable>
          <thead class="thead-dark">
            <tr>
              <th scope="col">S/No</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each app_users as appUser}
              <tr>
                <td>{appUser.id}</td>
                <td>{appUser.first_name} {appUser.last_name || ''}</td>
                <td class="text-nowrap">
                  <span>{appUser.email}</span>
                </td>
                <td class="d-flex justify-content-between align-content-center">
                   <!-- <button
                    type="button"
                    class="btn btn-primary btn-xs"
                    data-toggle="modal"
                    data-target="#viewAppUserDetails"
                    on:click={() => {
                      appUserDetails = appUser.statistics;
                      appUserDetails.first_mame = appUser.first_mame;
                      appUserDetails.last_name = appUser.last_name;
                      appUserDetails.is_online_sales_rep = appUser.is_online_sales_rep;
                    }}>
                    Details
                  </button> -->
                  <!-- {#if appUser.is_suspended}
                    <button
                      type="button"
                      class="btn btn-success btn-xs"
                      on:click={() => {
                        restoreAppUser(appUser.id);
                      }}>
                      RESTORE
                    </button>
                  {:else}
                    <button
                      type="button"
                      class="btn btn-danger btn-xs"
                      on:click={() => {
                        suspendAppUser(appUser.id);
                      }}>
                      SUSPEND
                    </button>
                  {/if} -->
                  <!-- <InertiaLink
                    href={route(auth.user.user_type + '.product_sales_records.sales_rep.today', [appUser.id])}
                    class="btn btn-brand btn-xs text-nowrap">
                    Today's Transactions
                  </InertiaLink> -->
                  <button
                    type="button"
                    class="btn btn-warning btn-xs"
                    data-toggle="modal"
                    data-target="#updateAppUser"
                    on:click={() => {
                      details = appUser;
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
    <Modal modalId="updateAppUser" modalTitle="Update App User">
      <form
        on:submit|preventDefault={updateAppUser}
        id="updateAppUserForm">

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="edit-first-name">Change First Name</label>
            <input
              type="text"
              class="form-control"
              id="edit-first-name"
              placeholder="First Name"
              bind:value={details.first_name} />
          </div>

          <div class="col-12">
            <label for="edit-last-name">Change Last Name</label>
            <input
              type="text"
              class="form-control"
              id="edit-last-name"
              placeholder="Last Name"
              bind:value={details.last_name} />
          </div>

          <div class="col-12">
            <label for="edit-email">Change Email</label>
            <input
              type="text"
              class="form-control"
              id="edit-email"
              placeholder="App User Email"
              bind:value={details.email} />
          </div>

        </div>
      </form>

      <button
        type="submit"
        slot="footer-buttons"
        form="updateAppUserForm"
        class="btn btn-success btn-long"
        disabled={!details.email || !details.first_name }>
        <span class="text">Update</span>
      </button>
    </Modal>

  {#if appUserDetails.full_name}
      <Modal modalId="viewAppUserDetails" modalTitle="{appUserDetails.full_name}´s Sales Statistics">
        <ul class="list-group">
            <li class="list-group-item list-group-item-secondary">Today's Sales Count: {appUserDetails.today_online_sales_count}</li>
            <li class="list-group-item list-group-item-primary">Today's Bonus Amount: { toCurrency(appUserDetails.today_online_sales_bonus_amount) }</li>
            <li class="list-group-item list-group-item-warning">Today's Sales Amount: { toCurrency(appUserDetails.today_online_sales_amount) }</li>
            <li class="list-group-item list-group-item-secondary">Monthly Sales Count: {appUserDetails.monthly_online_sales_count}</li>
            <li class="list-group-item list-group-item-primary">Monthly Bonus Amount: { toCurrency(appUserDetails.monthly_online_sales_bonus_amount) }</li>
            <li class="list-group-item list-group-item-warning">Monthly Sales Amount: { toCurrency(appUserDetails.monthly_online_sales_amount) }</li>
            <li class="list-group-item list-group-item-danger">Total Sales Count: {appUserDetails.total_online_sales_count}</li>
            <li class="list-group-item list-group-item-info">Total's Sales Bonus Amount: { toCurrency(appUserDetails.total_online_sales_bonus_amount) }</li>
            <li class="list-group-item list-group-item-success">Total's Sales Amount: { toCurrency(appUserDetails.total_online_sales_amount) }</li>
        </ul>
      </Modal>
  {/if}
  </div>
</Layout>
