<script>
    import { Inertia } from "@inertiajs/inertia";
    import Layout from "@superadmin-shared/SuperAdminLayout";

    let details = {}, files

    let createDirectSwapDeal = ()=>{
      BlockToast.fire({
        text: "Creating reseller ..."
      });

      Inertia.post(route("accountant.products.swap_deal.create"), details, {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors"],
        onSuccess: () =>{
            details = {};
        }
      })
    }


</script>

<style>
    textarea {
        max-height: 100px;
    }
</style>

<Layout title="Create New Swap Deal">
    <div class="row vertical-gap">
        <div class="col-lg-8 col-xl-6">
            <form class="#" on:submit|preventDefault="{createDirectSwapDeal}">
                <div class="row vertical-gap sm-gap">
                    <div class="col-12">
                        <label for="swapDescription">Description</label>
                        <div class="input-group">
                            <textarea
                                name="swapDescription"
                                id="swapDescription"
                                bind:value="{details.description}"
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
                                bind:value="{details.owner_details}"
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
                                on:change="{() => {delete details.model_no; delete details.serial_no}}"
                                bind:group="{details.identification_type}"
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
                                on:change="{() => {delete details.imei; delete details.model_no}}"
                                bind:group="{details.identification_type}"
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
                                on:change="{() => {delete details.imei; delete details.serial_no}}"
                                bind:group="{details.identification_type}"
                                class="custom-control-input" />
                            <label
                                class="custom-control-label"
                                for="model-no-option">
                                Model No.
                            </label>
                        </div>
                    </div>
                    {#if details.identification_type === 'imei'}
                    <div class="col-12">
                        <label for="exampleBase1">Imei No.</label>
                        <input
                            type="text"
                            class="form-control"
                            bind:value="{details.imei}"
                            placeholder="Enter Imei No." />
                    </div>
                    {:else if details.identification_type === 'serial_no'}
                    <div class="col-12">
                        <label for="exampleBase1">Serial No.</label>
                        <input
                            type="text"
                            class="form-control"
                            bind:value="{details.serial_no}"
                            placeholder="Enter Serial No." />
                    </div>
                    {:else if details.identification_type === 'model_no'}
                    <div class="col-12">
                        <label for="exampleBase1">Model No.</label>
                        <input
                            type="text"
                            class="form-control"
                            bind:value="{details.model_no}"
                            placeholder="Enter Model No." />
                    </div>
                    {/if}
                    <div class="col-12">
                        <label for="exampleBase1">ID Card</label>
                        <input
                            type="file"
                            class="form-control"
                            bind:files
                            on:change="{details.id_card = files[0]}" />
                    </div>
                    <div class="col-12">
                        <label for="exampleBase1">Receipt</label>
                        <input
                            type="file"
                            class="form-control"
                            bind:files
                            on:change="{details.receipt = files[0]}" />
                    </div>
                     <div class="col-12">
                        <label for="swapValue">Swap Value</label>
                        <div class="input-group">
                            <input
                              type="number"
                                name="swapValue"
                                id="swapValue"
                                bind:value="{details.swap_value}"
                                class="form-control"
                                placeholder="The amount the device was valued for" />
                        </div>
                    </div>
                     <div class="col-12">
                        <label for="sellingPrice">Selling Price</label>
                        <div class="input-group">
                            <input
                              type="number"
                                name="sellingPrice"
                                id="sellingPrice"
                                bind:value="{details.selling_price}"
                                class="form-control"
                                placeholder="The amount we want to sell the device for" />
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary btn-long">
                            <span class="text">Create Swap Deal</span>
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
