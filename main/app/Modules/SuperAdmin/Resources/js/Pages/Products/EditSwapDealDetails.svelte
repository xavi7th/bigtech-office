<script>
  import { Inertia } from "@inertiajs/inertia";
  import { page } from '@inertiajs/inertia-svelte';
  import Layout from "@superadmin-shared/SuperAdminLayout";

  export let swapDealDetails;

  let files

  let updateSwapDealDetails = ()=>{
    BlockToast.fire({
      text: "Updatimg swap details ..."
    });

    Inertia.put(route($page.props.auth.user.user_type + ".multiaccess.products.swap_deal.update",swapDealDetails.product_uuid), swapDealDetails, {
      preserveState: true,
      preserveScroll: true,
      only: ["flash", "errors", 'swapDealDetails'],
    })
  }
</script>

<style>
    textarea {
        max-height: 100px;
    }
</style>

<Layout title="Update Swap Deal">
    <div class="row vertical-gap">
        <div class="col-lg-8 col-xl-6">
            <form class="#" on:submit|preventDefault="{updateSwapDealDetails}">
                <div class="row vertical-gap sm-gap">
                    <div class="col-12">
                        <label for="swapDescription">Description</label>
                        <div class="input-group">
                            <textarea
                                name="swapDescription"
                                id="swapDescription"
                                bind:value="{swapDealDetails.description}"
                                class="form-control"
                                placeholder="Blue samsung s7 edge with small crack on the screen" />
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="swapOwnerDetails">Owner Details</label>
                        <div class="input-group">
                            <textarea
                                name="swapOwnerDetails"
                                id="swapOwnerDetails"
                                bind:value="{swapDealDetails.owner_details}"
                                class="form-control"
                                placeholder="Name, phone, address etc" />
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-between">
                        <div class="custom-control custom-radio">
                            <input
                                type="radio"
                                id="imei-option"
                                name="primary-identifier"
                                value="imei"
                                on:change="{() => {delete swapDealDetails.model_no; delete swapDealDetails.serial_no}}"
                                bind:group="{swapDealDetails.identification_type}"
                                class="custom-control-input" />
                            <label
                                class="custom-control-label"
                                for="imei-option">
                                IMEI
                            </label>
                        </div>
                        <div class="custom-control custom-radio mt-5">
                            <input
                                type="radio"
                                id="serial-no-option"
                                name="primary-identifier"
                                value="serial_no"
                                on:change="{() => {delete swapDealDetails.imei; delete swapDealDetails.model_no}}"
                                bind:group="{swapDealDetails.identification_type}"
                                class="custom-control-input" />
                            <label
                                class="custom-control-label"
                                for="serial-no-option">
                                Serial No.
                            </label>
                        </div>
                        <div class="custom-control custom-radio mt-5">
                            <input
                                type="radio"
                                id="model-no-option"
                                name="primary-identifier"
                                value="model_no"
                                on:change="{() => {delete swapDealDetails.imei; delete swapDealDetails.serial_no}}"
                                bind:group="{swapDealDetails.identification_type}"
                                class="custom-control-input" />
                            <label
                                class="custom-control-label"
                                for="model-no-option">
                                Model No.
                            </label>
                        </div>
                    </div>
                    {#if swapDealDetails.imei || swapDealDetails.identification_type === 'imei'}
                    <div class="col-12">
                        <label for="exampleBase1">Imei No.</label>
                        <input
                            type="text"
                            class="form-control"
                            bind:value="{swapDealDetails.imei}"
                            placeholder="Enter Imei No." />
                    </div>
                    {:else if swapDealDetails.serial_no || swapDealDetails.identification_type === 'serial_no'}
                    <div class="col-12">
                        <label for="exampleBase1">Serial No.</label>
                        <input
                            type="text"
                            class="form-control"
                            bind:value="{swapDealDetails.serial_no}"
                            placeholder="Enter Serial No." />
                    </div>
                    {:else if swapDealDetails.model_no || swapDealDetails.identification_type === 'model_no'}
                    <div class="col-12">
                        <label for="exampleBase1">Model No.</label>
                        <input
                            type="text"
                            class="form-control"
                            bind:value="{swapDealDetails.model_no}"
                            placeholder="Enter Model No." />
                    </div>
                    {/if}
                    <div class="col-12">
                        <label for="exampleBase1">ID Card</label>
                        <input
                            type="file"
                            class="form-control"
                            bind:files
                            on:change="{swapDealDetails.id_card = files[0]}" />
                    </div>
                    <div class="col-12">
                        <label for="exampleBase1">Receipt</label>
                        <input
                            type="file"
                            class="form-control"
                            bind:files
                            on:change="{swapDealDetails.receipt = files[0]}" />
                    </div>
                     <div class="col-12">
                        <label for="swapValue">Swap Value</label>
                        <div class="input-group">
                            <input
                              type="number"
                                name="swapValue"
                                id="swapValue"
                                bind:value="{swapDealDetails.swap_value}"
                                class="form-control"
                                placeholder="The amount the device was valued for" />
                        </div>
                    </div>
                     <div class="col-12">
                        <label for="swapUpdateReason">Update Reason</label>
                        <div class="input-group">
                            <textarea
                                name="swapUpdateReason"
                                id="swapUpdateReason"
                                bind:value="{swapDealDetails.comment}"
                                class="form-control"
                                placeholder="What necesitated this update?" />
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary btn-long">
                            <span class="text">Update</span>
                            <span class="icon">
                                <span
                                    data-feather="check-circle"
                                    class="rui-icon rui-icon-stroke-1_5" />
                            </span>
                        </button>
                        &nbsp;
                    </div>
                </div>
            </form>
        </div>
    </div>
</Layout>
