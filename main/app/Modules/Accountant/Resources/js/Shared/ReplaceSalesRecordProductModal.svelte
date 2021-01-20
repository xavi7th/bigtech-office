<script>
  import { Inertia } from "@inertiajs/inertia";
  import Modal from "@superadmin-shared/Partials/Modal.svelte";

  export let productSaleRecordToReplaceProduct;

  let replacementProductId, replacementProductIdType, replacementProductAmount;

  let replaceProduct = () => {
    console.log(productSaleRecordToReplaceProduct);

    BlockToast.fire({
      text: "Replacing sale record product ..."
    });

    Inertia.put(
      route("accountant.product_sales_records.swap_product", productSaleRecordToReplaceProduct),
      {
        replacement_product_identifier: replacementProductId,
        replacement_product_identifier_type: replacementProductIdType,
        replacement_product_amount: replacementProductAmount,
      },
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "salesRecords"],
        onSuccess: () => {

          jQuery('#replaceSalesRecordProduct').modal('hide');
        }
      }
    );
  };
</script>

<Modal modalId="replaceSalesRecordProduct" modalTitle="Replace Sales Record Product">

  <div class="row vertical-gap sm-gap">

      <div class="col-12">

        <select class="custom-select " bind:value={replacementProductIdType}>
          <option value='imei'>IMEI</option>
          <option value='serial_no'>Serial Number</option>
          <option value='model_no'>Model Number</option>

        </select>
      </div>

      <div class="col-12">
        <input
          type="text"
          class="form-control"
          placeholder="Replacement product identifier"
          bind:value={replacementProductId} />
      </div>

      <div class="col-12">
        <input
          type="number"
          min="0"
          class="form-control"
          placeholder="New Amount (optional)"
          bind:value={replacementProductAmount} />
      </div>

  </div>

  <button
    on:click={replaceProduct}
    slot="footer-buttons"
    class="btn btn-success btn-long"
    disabled={!replacementProductId}>
    <span class="text">Replace Product</span>
  </button>
</Modal>
