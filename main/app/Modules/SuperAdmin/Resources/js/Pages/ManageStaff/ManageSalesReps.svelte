<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal";
	import { page } from '@inertiajs/inertia-svelte'
  import { toCurrency } from "@public-shared/helpers";

  $: ({ auth } = $page.props);

  let details = {},
    files, salesRepStatistics={};

  let createSalesRep = () => {
    BlockToast.fire({
      text: "Creating sales rep ..."
    });

    if (files) {
      details.avatar = files[0];
    }

    Inertia.post(
      route(auth.user.user_type + ".manage_staff.sales_reps.create"),
      details,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "salesReps"],
        onSuccess: () =>{
          details = {};
          files = undefined;
        }
      }
    )
  };

  let updateSalesRep = () => {
    BlockToast.fire({
      text: "Updating sales rep ..."
    });

    if (files) {
      details.avatar = files[0];
    }

    details._method = "PUT";

    Inertia.post(
      route(auth.user.user_type + ".manage_staff.sales_reps.edit", details.id),
      details,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "salesReps"],
        onSuccess: () => {
          jQuery('#updateSalesRep').modal('hide');
          details = {};
          files = undefined;
        }
      }
    )
  };

  let suspendSalesRep = id => {
      swalPreconfirm
        .fire({
          text:
          "This sales rep will no longer be able to login to their account. It can be restored at a later time",
          confirmButtonText: "Yes, carry on!",
          preConfirm: () => {
            Inertia.put(
              route(auth.user.user_type + ".manage_staff.sales_reps.suspend", id),
              {
                preserveState: true,
                preserveScroll: true,
                only: ["flash", "errors", "salesReps"]
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

  let restoreSalesRep = id => {
    swalPreconfirm
      .fire({
        text:
          "This sales rep will once again be ableto acces their accounts.",
        confirmButtonText: "Yes, carry on!",
        preConfirm: () => {
          Inertia.put(
            route(auth.user.user_type + ".manage_staff.sales_reps.reactivate", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "salesReps"]
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

  export let salesReps = [];
</script>

<Layout title="Manage Sales Reps">
  <div class="row vertical-gap">
    <div class="col-lg-4 col-xl-4 order-1 order-lg-0">
      <form class="#" on:submit|preventDefault={createSalesRep}>

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="full-name">Full Name</label>
            <input
              type="text"
              class="form-control"
              id="full-name"
              placeholder="Sales Rep Name"
              bind:value={details.full_name} />
          </div>

          <div class="col-12">
            <label for="email">Email</label>
            <input
              type="text"
              class="form-control"
              id="email"
              placeholder="Sales Rep Email"
              bind:value={details.email} />
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
            <button
              type="submit"
              class="btn btn-success btn-long"
              disabled={!details.email || !details.full_name || !files}>
              <span class="text">Create</span>
            </button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-lg-8 col-xl-8 order-0 order-lg-1">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">
          Available Sales Reps
        </h2>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th scope="col">S/No</th>
              <th scope="col">Name/Email</th>
              <!-- <th scope="col">Monthly Bonus</th> -->
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each salesReps as salesRep}
              <tr>
                <td>{salesRep.id}</td>
                <td>
                 {salesRep.full_name}
                 <br />
                  <span>{salesRep.email}</span>
                  {#if salesRep.is_deleted}
                    <span class="badge badge-pill badge-danger ml-5">Deleted</span>
                  {/if}
                </td>
                <!-- <td class="text-nowrap">
                  {#if salesRep.is_online_sales_rep}
                    {(toCurrency(salesRep.statistics.monthly_online_sales_bonus_amount))}
                  {:else}
                     {(toCurrency(salesRep.statistics.monthly_walk_in_sales_bonus_amount))}
                  {/if}
                </td> -->
                <td class="d-flex justify-content-between align-content-center">
                  {#if !salesRep.is_deleted}
                    <!-- <button
                      type="button"
                      class="btn btn-primary btn-xs"
                      data-toggle="modal"
                      data-target="#viewSalesRepStatistics"
                      on:click={() => {
                        salesRepStatistics = salesRep.statistics;
                        salesRepStatistics.full_name = salesRep.full_name;
                        salesRepStatistics.is_online_sales_rep = salesRep.is_online_sales_rep;
                      }}>
                      Statistics
                    </button> -->
                    {#if salesRep.is_suspended}
                      <button
                        type="button"
                        class="btn btn-success btn-xs nowrap"
                        on:click={() => {
                          restoreSalesRep(salesRep.id);
                        }}>
                        RE-ACTIVATE
                      </button>
                    {:else}
                      <button
                        type="button"
                        class="btn btn-danger btn-xs"
                        on:click={() => {
                          suspendSalesRep(salesRep.id);
                        }}>
                        SUSPEND
                      </button>
                    {/if}
                    <!-- <InertiaLink
                      href={route(auth.user.user_type + '.product_sales_records.sales_reps.today', [salesRep.id])}
                      class="btn btn-brand btn-xs text-nowrap">
                      Today's Transactions
                    </InertiaLink> -->
                    <button
                      type="button"
                      class="btn btn-warning btn-xs"
                      data-toggle="modal"
                      data-target="#updateSalesRep"
                      on:click={() => {
                        details = salesRep;
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
    <Modal modalId="updateSalesRep" modalTitle="Update Sales Rep">
      <form
        on:submit|preventDefault={updateSalesRep}
        id="updateSalesRepForm">

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
              placeholder="Sales Rep Email"
              bind:value={details.email} />
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
        form="updateSalesRepForm"
        class="btn btn-success btn-long"
        disabled={!details.email || !details.full_name }>
        <span class="text">Update</span>
      </button>
    </Modal>
{#if salesRepStatistics.full_name}
    <Modal modalId="viewSalesRepStatistics" modalTitle="{salesRepStatistics.full_name}´s Sales Statistics">
      <ul class="list-group">
        {#if salesRepStatistics.is_online_sales_rep}
          <li class="list-group-item list-group-item-secondary">Today's Sales Count: {salesRepStatistics.today_online_sales_count}</li>
          <li class="list-group-item list-group-item-primary">Today's Bonus Amount: { toCurrency(salesRepStatistics.today_online_sales_bonus_amount) }</li>
          <li class="list-group-item list-group-item-warning">Today's Sales Amount: { toCurrency(salesRepStatistics.today_online_sales_amount) }</li>
          <li class="list-group-item list-group-item-secondary">Monthly Sales Count: {salesRepStatistics.monthly_online_sales_count}</li>
          <li class="list-group-item list-group-item-primary">Monthly Bonus Amount: { toCurrency(salesRepStatistics.monthly_online_sales_bonus_amount) }</li>
          <li class="list-group-item list-group-item-warning">Monthly Sales Amount: { toCurrency(salesRepStatistics.monthly_online_sales_amount) }</li>
          <li class="list-group-item list-group-item-secondary">Last Month's Sales Count: {salesRepStatistics.last_month_online_sales_count}</li>
          <li class="list-group-item list-group-item-primary">Last Month's Bonus Amount: { toCurrency(salesRepStatistics.last_month_online_sales_bonus_amount) }</li>
          <li class="list-group-item list-group-item-warning">Last Month's Sales Amount: { toCurrency(salesRepStatistics.last_month_online_sales_amount) }</li>
          <li class="list-group-item list-group-item-danger">Total Sales Count: {salesRepStatistics.total_online_sales_count}</li>
          <li class="list-group-item list-group-item-info">Total's Sales Bonus Amount: { toCurrency(salesRepStatistics.total_online_sales_bonus_amount) }</li>
          <li class="list-group-item list-group-item-success">Total's Sales Amount: { toCurrency(salesRepStatistics.total_online_sales_amount) }</li>
        {:else}
          <li class="list-group-item list-group-item-secondary">Today's Sales Count: {salesRepStatistics.today_walk_in_sales_count}</li>
          <li class="list-group-item list-group-item-primary">Today's Bonus Amount: { toCurrency(salesRepStatistics.today_walk_in_sales_bonus_amount) }</li>
          <li class="list-group-item list-group-item-warning">Today's Sales Amount: { toCurrency(salesRepStatistics.today_walk_in_sales_amount) }</li>
          <li class="list-group-item list-group-item-secondary">Monthly Sales Count: {salesRepStatistics.monthly_walk_in_sales_count}</li>
          <li class="list-group-item list-group-item-primary">Monthly Bonus Amount: { toCurrency(salesRepStatistics.monthly_walk_in_sales_bonus_amount) }</li>
          <li class="list-group-item list-group-item-warning">Monthly Sales Amount: { toCurrency(salesRepStatistics.monthly_walk_in_sales_amount) }</li>
          <li class="list-group-item list-group-item-secondary">Last Month's Sales Count: {salesRepStatistics.last_month_walk_in_sales_count}</li>
          <li class="list-group-item list-group-item-primary">Last Month's Bonus Amount: { toCurrency(salesRepStatistics.last_month_walk_in_sales_bonus_amount) }</li>
          <li class="list-group-item list-group-item-warning">Last Month's Sales Amount: { toCurrency(salesRepStatistics.last_month_walk_in_sales_amount) }</li>
          <li class="list-group-item list-group-item-danger">Total Sales Count: {salesRepStatistics.total_walk_in_sales_count}</li>
          <li class="list-group-item list-group-item-info">Total's Sales Bonus Amount: { toCurrency(salesRepStatistics.total_walk_in_sales_bonus_amount) }</li>
          <li class="list-group-item list-group-item-success">Total's Sales Amount: { toCurrency(salesRepStatistics.total_walk_in_sales_amount) }</li>
        {/if}


      </ul>
    </Modal>
{/if}
  </div>
</Layout>
