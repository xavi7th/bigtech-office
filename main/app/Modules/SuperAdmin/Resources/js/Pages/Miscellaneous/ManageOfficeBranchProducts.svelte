<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import FlashMessage from "@usershared/FlashMessage";
  import Icon from "@superadmin-shared/Partials/TableSortIcon";
  import Modal from "@superadmin-shared/Partials/Modal";
  import route from "ziggy";
  import { getErrorString } from "@public-assets/js/bootstrap";
  import { onMount } from "svelte";
  import { lang } from "moment";

  $: ({ app, flash, errors } = $page);
  export let onlineReps = [],
    companyAccounts = [],
    salesChannel = [],
    officeBranch = {
      branchProducts: []
    };

  let details = {},
    paymentRecords = [],
    bankRecords = [],
    productToMarkAsSold,
    productToMarkAsPaid,
    numOfBanks = 1,
    files;

  let toggleSwap = () => {
    if (!details.is_swap_deal) {
      delete details.description;
      delete details.owner_details;
      delete details.id_card;
      delete details.receipt;
      delete details.swap_value;
      delete details.imei;
      delete details.serial_no;
      delete details.model_no;
    }
  };

  let markProductAsPaid = () => {
    /** ! Make sure the form was properly filled **/
    let isValid = true,
      payment_records = {},
      errMsg = "";

    _.each(bankRecords, (val, key) => {
      if (_.uniq(bankRecords).length !== bankRecords.length) {
        isValid = false;
        errMsg = "You selected an account twice. Correct your selections";
      } else if (
        _.compact(bankRecords).length == 0 ||
        _.compact(paymentRecords).length == 0
      ) {
        isValid = false;
        errMsg = "Enter at least one bank and the amount paid";
      } else if (
        (!bankRecords[key] && paymentRecords[key]) ||
        (bankRecords[key] && !paymentRecords[key])
      ) {
        isValid = false;
        errMsg = "You The banks and the amounts are not properly matched";
      } else if (!_.every(paymentRecords, Number)) {
        isValid = false;
        errMsg = "All amounts must be numbers";
      }
    });

    if (!isValid) {
      ToastLarge.fire("Oops", errMsg, "error");
      return;
    }

    BlockToast.fire({
      text: "Marking product as sold ..."
    });

    _.each(bankRecords, (val, key, coll) => {
      payment_records[bankRecords[key]] = { amount: paymentRecords[key] };
    });

    Inertia.put(
      route("superadmin.products.confirm_sale", productToMarkAsPaid),
      { payment_records },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "officeBranch"]
      }
    ).then(() => {
      if (flash.success) {
        ToastLarge.fire({
          title: "Successful!",
          html: flash.success
        });

        bankRecords = [];
        paymentRecords = [];
        numOfBanks = 1;
      } else if (flash.error || _.size(errors) > 0) {
        ToastLarge.fire({
          title: "Oops!",
          html: flash.error || getErrorString(errors),
          timer: 10000,
          icon: "error"
        });
      }
    });
  };

  let markProductAsSold = () => {
    swal
      .fire({
        title: "Are you sure?",
        text:
          "This will mark this product as sold for and update the sales reps daily sales",
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
          let formData = new FormData();

          _.forEach(
            _.omit(details, ["set", "update", "subscribe"]),
            (val, key) => {
              formData.append(key, val);
            }
          );
          return Inertia.post(
            route("superadmin.products.mark_as_sold", productToMarkAsSold),
            formData,
            {
              preserveState: true,
              preserveScroll: true,
              only: ["flash", "errors", "officeBranch"]
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

  onMount(() => {
    if (flash.success) {
      ToastLarge.fire({
        title: "Successful!",
        html: flash.success
      });

      details = {};
    } else if (flash.error || _.size(errors) > 0) {
      ToastLarge.fire({
        title: "Oops!",
        html: flash.error || getErrorString(errors),
        timer: 10000,
        icon: "error"
      });
    }
  });
</script>

<Layout title={`${officeBranch.city}´s Stock List`}>
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="table-responsive-md">
        <table
          class="rui-datatable table table-striped table-bordered table-sm"
          data-datatable-order="0:desc">
          <thead class="thead-dark">
            <tr>
              <th scope="col">
                #
                <Icon />
              </th>
              <th scope="col">
                Model
                <Icon />
              </th>
              <th scope="col">
                Product ID
                <Icon />
              </th>
              <th scope="col">
                Cost Price
                <Icon />
              </th>
              <th scope="col">
                Sold At
                <Icon />
              </th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {#each officeBranch.branchProducts as product, idx}
              <tr>
                <th scope="row">{idx + 1}</th>
                <td>{product.model}</td>
                <td>{product.identifier}</td>
                <td>{product.cost_price}</td>
                <td>{product.selling_price}</td>
                <td>
                  <InertiaLink
                    type="button"
                    href={route('superadmin.products.view_product_details', product.uuid)}
                    class="btn btn-primary btn-xs btn-sm">
                    Details
                  </InertiaLink>
                  {#if product.status == 'in stock'}
                    <button
                      type="button"
                      on:click={() => {
                        productToMarkAsSold = product.uuid;
                      }}
                      data-toggle="modal"
                      data-target="#enterSalesDetails"
                      class="btn btn-success btn-xs btn-sm">
                      Mark Sold
                    </button>
                  {/if}
                  {#if product.status == 'sold'}
                    <button
                      on:click={() => {
                        productToMarkAsPaid = product.uuid;
                      }}
                      data-toggle="modal"
                      data-target="#enterProductPaymentDetails"
                      class="btn btn-brand btn-xs btn-sm">
                      Mark Paid
                    </button>
                  {/if}
                  <InertiaLink
                    type="button"
                    preserve-scroll
                    preserve-state
                    replace
                    href={route('superadmin.product_histories.view_product_history', 1)}
                    class="btn btn-info btn-xs btn-sm">
                    History
                  </InertiaLink>
                </td>
              </tr>
            {:else}
              <tr class="text-center">
                <td colspan="5">No Products In {officeBranch.city}'s Branch</td>
              </tr>
            {/each}

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div slot="modals">
    <Modal modalId="enterSalesDetails" modalTitle="Enter Sales Details">

      <FlashMessage />

      <div class="row vertical-gap sm-gap">
        <div class="col-12">
          <input
            type="number"
            class="form-control"
            placeholder="Selling Price"
            bind:value={details.selling_price} />
        </div>

        <div class="col-12">
          <input
            type="text"
            class="form-control"
            placeholder="Buyer First Name"
            bind:value={details.first_name} />
        </div>

        <div class="col-12">
          <input
            type="text"
            class="form-control"
            placeholder="Buyer Last Name"
            bind:value={details.last_name} />
        </div>

        <div class="col-12">
          <input
            type="text"
            class="form-control"
            placeholder="Buyer Phone Number"
            bind:value={details.phone} />
        </div>

        <div class="col-12">
          <input
            type="email"
            class="form-control"
            placeholder="Buyer Email Address"
            bind:value={details.email} />
        </div>

        <div class="col-12">
          <input
            type="text"
            class="form-control"
            placeholder="Buyer Residential Address"
            bind:value={details.address} />
        </div>

        <div class="col-12">
          <input
            type="text"
            class="form-control"
            placeholder="Buyer Residential City"
            bind:value={details.city} />
        </div>

        <div class="col-12">

          <select class="custom-select " bind:value={details.sales_channel_id}>
            <option selected>How did buyer come?</option>
            {#each salesChannel as channel}
              <option value={channel.id}>{channel.channel_name}</option>
            {/each}
          </select>
        </div>

        <div class="col-12">
          <input
            type="text"
            class="form-control"
            placeholder="Buyer's IG Handle"
            bind:value={details.ig_handle} />
        </div>

        <div class="col-12">

          <select class="custom-select" bind:value={details.online_rep_id}>
            <option selected>Select Online Rep</option>
            {#each onlineReps as rep}
              <option value={rep.id}>{rep.full_name}</option>
            {/each}
          </select>
        </div>

        <div class="col-12">
          <div class="custom-control custom-switch">
            <input
              type="checkbox"
              class="custom-control-input"
              id="is-swap-deal"
              bind:checked={details.is_swap_deal}
              on:change={toggleSwap} />
            <label class="custom-control-label" for="is-swap-deal">
              Is this a Swap Deal?
            </label>
          </div>

        </div>

        {#if details.is_swap_deal}
          <div class="col-12">
            <input
              type="text"
              class="form-control"
              placeholder="Describe Swap Phone"
              bind:value={details.description} />
          </div>

          <div class="col-12">
            <input
              type="text"
              class="form-control"
              placeholder="Owner Details"
              bind:value={details.owner_details} />
          </div>

          <div class="col-12">
            <input
              type="file"
              class="form-control"
              bind:files
              on:change={(details.id_card = files[0])} />
          </div>

          <div class="col-12">
            <input
              type="file"
              class="form-control"
              bind:files
              on:change={(details.receipt = files[0])} />
          </div>

          <div class="col-12">
            <input
              type="text"
              class="form-control"
              placeholder="IMEI"
              bind:value={details.imei} />
          </div>

          <div class="col-12">
            <input
              type="text"
              class="form-control"
              placeholder="S/No"
              bind:value={details.serial_no} />
          </div>

          <div class="col-12">
            <input
              type="text"
              class="form-control"
              placeholder="Model No"
              bind:value={details.model_no} />
          </div>

          <div class="col-12">
            <input
              type="numeric"
              class="form-control"
              placeholder="Swap Value"
              bind:value={details.swap_value} />
          </div>
        {/if}

      </div>

      <button
        on:click={markProductAsSold}
        slot="footer-buttons"
        class="btn btn-success btn-long"
        disabled={!details.selling_price}>
        <span class="text">Mark As Sold</span>
      </button>
    </Modal>

    <Modal
      modalId="enterProductPaymentDetails"
      modalTitle="Enter Payment Details">

      <FlashMessage />

      <div class="row vertical-gap sm-gap">

        {#each Array(numOfBanks) as i, idx}
          <div class="col-12">

            <select class="custom-select " bind:value={bankRecords[idx]}>
              <option value={null} selected>Bank Name</option>
              {#each companyAccounts as acc}
                <option value={acc.id}>
                  {acc.bank} - {acc.account_number}
                </option>
              {/each}
            </select>
          </div>

          <div class="col-12">
            <input
              type="number"
              min="0"
              class="form-control"
              placeholder="Amount Paid"
              bind:value={paymentRecords[idx]} />
          </div>
        {/each}

      </div>

      <button
        on:click={() => ++numOfBanks}
        slot="footer-buttons"
        class="btn btn-dark btn-long">
        <span class="text">Add Another Bank</span>
      </button>

      <button
        on:click={markProductAsPaid}
        slot="footer-buttons"
        class="btn btn-success btn-long"
        disabled={!numOfBanks}>
        <span class="text">Mark As Sold</span>
      </button>
    </Modal>
  </div>
</Layout>
