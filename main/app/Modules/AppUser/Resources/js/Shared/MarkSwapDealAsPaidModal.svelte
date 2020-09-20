<script>
  import { page } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import FlashMessage from "@usershared/FlashMessage.svelte";
  import Modal from "@superadmin-shared/Partials/Modal.svelte";
import { getErrorString } from "@public-assets/js/bootstrap";

  $: ({ flash, errors } = $page);

  export let companyAccounts = [],
    productToMarkAsPaid;

  let details = {},
    numOfBanks = 1,
    paymentRecords = [],
    bankRecords = [];

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
      text: "Marking product as paid for ..."
    });

    _.each(bankRecords, (val, key, coll) => {
      payment_records[bankRecords[key]] = { amount: paymentRecords[key] };
    });

    Inertia.put(
      route("superadmin.products.confirm_swap_sale", productToMarkAsPaid),
      { payment_records },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "swapDeals"]
      }
    ).then(() => {
      if (flash.success) {
        ToastLarge.fire({
          title: "Successful!",
          html: flash.success
        });

        payment_records = [];
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
      } else {
        swal.close();
      }
    });
  };
</script>

<Modal modalId="enterProductPaymentDetails" modalTitle="Enter Payment Details">

  <FlashMessage />

  <div class="row vertical-gap sm-gap">

    {#each Array(numOfBanks) as i, idx}
      <div class="col-12">

        <select class="custom-select " bind:value={bankRecords[idx]}>
          <option value={null} selected>Bank Name</option>

          {#each companyAccounts as acc}
            <option value={acc.id}>{acc.bank} - {acc.account_number}</option>
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
    <span class="text">Mark As Paid</span>
  </button>
</Modal>
