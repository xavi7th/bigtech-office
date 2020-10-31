<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import FlashMessage from "@usershared/FlashMessage";
  import Modal from "@superadmin-shared/Partials/Modal";
  import route from "ziggy";
  import { getErrorString, toCurrency } from "@public-assets/js/bootstrap";
  import { __dirname } from "lodash/_freeGlobal";

  $: ({ errors, auth, flash } = $page);

  let details = {},
    files;

  let createBankAccount = () => {
    BlockToast.fire({
      text: "Creating bank account ..."
    });

    let formData = new FormData();

    if (files) {
      formData.append("img", files[0]);
    }

    _.forEach(details, (val, key) => {
      formData.append(key, val);
    });

    Inertia.post(
      route("superadmin.miscellaneous.create_bank_account"),
      formData,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "bankAccounts"],
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

  let updateBankAccount = () => {
    BlockToast.fire({
      text: "Updating bank account ..."
    });

    let formData = new FormData();

    if (files) {
      formData.append("img", files[0]);
    }

    _.forEach(details, (val, key) => {
      formData.append(key, val);
    });
    formData.append("_method", "PUT");

    Inertia.post(
      route("superadmin.miscellaneous.edit_bank_account", details.id),
      formData,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "bankAccounts"],
        headers: {
          "Content-Type": "multipart/form-data"
        }
      }
    ).then(() => {
      if (flash.success) {
        details = {};
        files = undefined;

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

  let suspendBankAccount = id => {
    swal
      .fire({
        title: "Are you sure?",
        text:
          "This bank account will no longer be available as a payment option for users. It can be restored at a later time",
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
            route("superadmin.miscellaneous.suspend_bank_account", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "bankAccounts"]
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

  let restoreBankAccount = id => {
    swal
      .fire({
        title: "Are you sure?",
        text:
          "This bank account will once again be available as a payment option for users.",
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
            route("superadmin.miscellaneous.restore_bank_account", id),
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "bankAccounts"]
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

  export let bankAccounts = [];
</script>

<style>
  img {
    max-height: 50px;
  }
  select {
    text-transform: capitalize;
  }
</style>

<Layout title="Manage Bank Accounts">
  <div class="row vertical-gap">
    <div class="col-lg-4 col-xl-4 order-1 order-lg-0">
      <form class="#" on:submit|preventDefault={createBankAccount}>
        <FlashMessage />

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="bank-name">Bank Name</label>
            <input
              type="text"
              class="form-control"
              id="bank-name"
              placeholder="Bank Name"
              bind:value={details.bank} />
          </div>

          <div class="col-12">
            <label for="acc-name">Account Name</label>
            <input
              type="text"
              class="form-control"
              id="acc-name"
              placeholder="Bank Account Name"
              bind:value={details.account_name} />
          </div>
          <div class="col-12">
            <label for="acc-number">Account Number</label>
            <input
              type="text"
              class="form-control"
              id="acc-number"
              placeholder="Bank Account Number"
              bind:value={details.account_number} />
          </div>

          <div class="col-12">
            <label for="acc-type">Account Type</label>
            <select
              name="acc-type"
              class="form-control"
              id="acc-type"
              bind:value={details.account_type}>
              <option>savings</option>
              <option>current</option>
              <option>third-party</option>
            </select>
          </div>

          <div class="col-12">
            <label for="acc-description">Account Description</label>
            <textarea
              bind:value={details.account_description}
              class="form-control"
              id="acc-description"
              cols="30"
              rows="10"
              placeholder="Romzy's personal GTB account" />
          </div>

          <div class="col-12">
            <label for="bank-logo">Bank logo</label>
            <input
              type="file"
              id="bank-logo"
              bind:files
              accept="image/*"
              class="form-control" />
          </div>

          <div class="col-12">
            <button
              type="submit"
              class="btn btn-success btn-long"
              disabled={!details.account_number || !files}>
              <span class="text">Create</span>
            </button>
          </div>
        </div>
      </form>
    </div>
    <div class="col-lg-8 col-xl-8 order-0 order-lg-1">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">
          Available Bank Accounts
        </h2>
          <InertiaLink href={route('superadmin.miscellaneous.bank_accounts_daily_transactions')} class="btn btn-brand ml-auto">
            <span>Today's Transactions</span>
          </InertiaLink>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name/Logo</th>
              <th scope="col">Acc Number</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each bankAccounts as bankAccount, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>
                  <img
                    class="img-responsive img-fluid"
                    src={bankAccount.img_url}
                    alt="" />
                  <span>{bankAccount.account_name}</span>
                </td>
                <td>
                  {bankAccount.bank}/{bankAccount.account_number}
                  <br />
                  (Total Today: {(toCurrency(bankAccount.total_payments_received))})
                </td>
                <td class="d-flex justify-content-between align-content-center">
                  {#if bankAccount.is_suspended}
                    <button
                      type="button"
                      class="btn btn-success btn-xs"
                      on:click={() => {
                        restoreBankAccount(bankAccount.id);
                      }}>
                      RESTORE
                    </button>
                  {:else}
                    <button
                      type="button"
                      class="btn btn-danger btn-xs"
                      on:click={() => {
                        suspendBankAccount(bankAccount.id);
                      }}>
                      SUSPEND
                    </button>
                  {/if}
                  <InertiaLink
                    href={route('superadmin.miscellaneous.bank_account_daily_transactions', bankAccount.account_number)}
                    class="btn btn-brand btn-xs text-nowrap">
                    Today's Transactions
                  </InertiaLink>
                  <button
                    type="button"
                    class="btn btn-warning btn-xs"
                    data-toggle="modal"
                    data-target="#updateBankAccount"
                    on:click={() => {
                      details = bankAccount;
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
    <Modal modalId="updateBankAccount" modalTitle="Update Bank Account">
      <form
        on:submit|preventDefault={updateBankAccount}
        id="updateBankAccountForm">
        <FlashMessage />

        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="edit-bank-name">Change Bank Name</label>
            <input
              type="text"
              class="form-control"
              id="edit-bank-name"
              placeholder="Bank Name"
              bind:value={details.bank} />
          </div>

          <div class="col-12">
            <label for="edit-acc-name">Change Account Name</label>
            <input
              type="text"
              class="form-control"
              id="edit-acc-name"
              placeholder="Bank Account Name"
              bind:value={details.account_name} />
          </div>
          <div class="col-12">
            <label for="edit-acc-number">Change Account Number</label>
            <input
              type="text"
              class="form-control"
              id="edit-acc-number"
              placeholder="Bank Account Number"
              bind:value={details.account_number} />
          </div>

          <div class="col-12">
            <label for="edit-acc-type">Change Account Type</label>
            <select
              name="acc-type"
              class="form-control"
              id="edit-acc-type"
              bind:value={details.account_type}>
              <option>savings</option>
              <option>current</option>
              <option>third-party</option>
            </select>
          </div>

          <div class="col-12">
            <label for="edit-acc-description">Change Account Description</label>
            <textarea
              bind:value={details.account_description}
              class="form-control"
              id="edit-acc-description"
              cols="30"
              rows="10"
              placeholder="Romzy's personal GTB account" />
          </div>

          <div class="col-12">
            <label for="bank-logo">Change Bank logo</label>
            <input
              type="file"
              id="edit-bank-logo"
              bind:files
              accept="image/*"
              class="form-control" />
          </div>
        </div>
      </form>

      <button
        type="submit"
        slot="footer-buttons"
        form="updateBankAccountForm"
        class="btn btn-success btn-long"
        disabled={!details.account_number}>
        <span class="text">Update</span>
      </button>
    </Modal>
  </div>
</Layout>
