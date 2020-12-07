<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import FlashMessage from "@usershared/FlashMessage";
  import Modal from "@superadmin-shared/Partials/Modal";
  import route from "ziggy";
  import { getErrorString, toCurrency } from "@public-assets/js/bootstrap";

  $: ({ errors, flash } = $page);

  let details = {},
    files, salesRepStatistics={};

  let createSalesRep = () => {
    BlockToast.fire({
      text: "Creating sales rep ..."
    });

    let formData = new FormData();

    if (files) {
      formData.append("avatar", files[0]);
    }

    _.forEach(details, (val, key) => {
      formData.append(key, val);
    });

    Inertia.post(
      route("superadmin.manage_staff.sales_rep.create"),
      formData,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "salesReps"],
        headers: {
          "Content-Type": "multipart/form-data"
        }
      }
    ).then(() => {
      if (flash.success) {
        ToastLarge.fire({
          title: "Successful!",
          html: flash.success
        });

        details = {};
        files = undefined;
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

  let updateSalesRep = () => {
    BlockToast.fire({
      text: "Updating sales rep ..."
    });

    let formData = new FormData();

    if (files) {
      formData.append("avatar", files[0]);
    }

    _.forEach(details, (val, key) => {
      formData.append(key, val);
    });
    formData.append("_method", "PUT");

    Inertia.post(
      route("superadmin.manage_staff.sales_rep.edit", details.id),
      formData,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "salesReps"],
        headers: {
          "Content-Type": "multipart/form-data"
        }
      }
    ).then(() => {
      if (flash.success) {
        details = {};
        files = undefined;
        jQuery('#updateSalesRep').modal('hide');

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

  let suspendSalesRep = id => {
    swal
      .fire({
        title: "Are you sure?",
        text:
          "This sales rep will no longer be available as a payment option for users. It can be restored at a later time",
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
            route("superadmin.manage_staff.sales_rep.suspend", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "salesReps"]
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

  let restoreSalesRep = id => {
    swal
      .fire({
        title: "Are you sure?",
        text:
          "This sales rep will once again be available as a payment option for users.",
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
            route("superadmin.manage_staff.sales_rep.reactivate", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "salesReps"]
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

  export let salesReps = [];
</script>

<Layout title="Manage Sales Reps">
  <div class="row vertical-gap">
    <div class="col-lg-4 col-xl-4 order-1 order-lg-0">
      <form class="#" on:submit|preventDefault={createSalesRep}>
        <FlashMessage />

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
              <th scope="col">Today's Bonus</th>
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
                </td>
                <td class="text-nowrap">
                  {(toCurrency(salesRep.statistics.today_online_sales_bonus_amount))} / {(toCurrency(salesRep.statistics.today_walk_in_sales_bonus_amount))}
                </td>
                <td class="d-flex justify-content-between align-content-center">
                   <button
                    type="button"
                    class="btn btn-primary btn-xs"
                    data-toggle="modal"
                    data-target="#viewSalesRepStatistics"
                    on:click={() => {
                      salesRepStatistics = salesRep.statistics;
                      salesRepStatistics.full_name = salesRep.full_name;
                    }}>
                    Statistics
                  </button>
                  {#if salesRep.is_suspended}
                    <button
                      type="button"
                      class="btn btn-success btn-xs"
                      on:click={() => {
                        restoreSalesRep(salesRep.id);
                      }}>
                      RESTORE
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
                  <InertiaLink
                    href={route('superadmin.product_sales_records.sales_rep.today', [salesRep.id])}
                    class="btn btn-brand btn-xs text-nowrap">
                    Today's Transactions
                  </InertiaLink>
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
        <FlashMessage />

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
          <li class="list-group-item list-group-item-warning">Today's Online Sales Amount: { toCurrency(salesRepStatistics.today_online_sales_amount) }</li>
          <li class="list-group-item list-group-item-warning">Today's Walk In Sales Amount: { toCurrency(salesRepStatistics.today_walk_in_sales_amount) }</li>
          <li class="list-group-item list-group-item-primary">Today's Online Bonus Amount: { toCurrency(salesRepStatistics.today_online_sales_bonus_amount) }</li>
          <li class="list-group-item list-group-item-primary">Today's Walk In Bonus Amount: { toCurrency(salesRepStatistics.today_walk_in_sales_bonus_amount) }</li>
          <li class="list-group-item list-group-item-secondary">Today's Online Sales Count: {salesRepStatistics.today_online_sales_count}</li>
          <li class="list-group-item list-group-item-secondary">Today's Walk In Sales Count: {salesRepStatistics.today_walk_in_sales_count}</li>
          <li class="list-group-item list-group-item-success">Total's Online Sales Amount: { toCurrency(salesRepStatistics.total_online_sales_amount) }</li>
          <li class="list-group-item list-group-item-success">Total's Walk In Sales Amount: { toCurrency(salesRepStatistics.total_walk_in_sales_amount) }</li>
          <li class="list-group-item list-group-item-info">Total's Online Sales Bonus Amount: { toCurrency(salesRepStatistics.total_online_sales_bonus_amount) }</li>
          <li class="list-group-item list-group-item-info">Total's Walk In Sales Bonus Amount: { toCurrency(salesRepStatistics.total_walk_in_sales_bonus_amount) }</li>
          <li class="list-group-item list-group-item-danger">Total Online Sales Count: {salesRepStatistics.total_online_sales_count}</li>
          <li class="list-group-item list-group-item-danger">Total Walk In Sales Count: {salesRepStatistics.total_walk_in_sales_count}</li>
      </ul>
    </Modal>
{/if}
  </div>
</Layout>
