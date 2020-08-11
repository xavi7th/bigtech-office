<script>
    import { page, InertiaLink } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import Layout from "@superadmin-shared/SuperAdminLayout";
    import FlashMessage from "@usershared/FlashMessage";
    import route from "ziggy";

    $: ({ app } = $page);

    // export let details;
</script>

<style>
    textarea {
        max-height: 100px;
    }
</style>

<Layout title="Create New Swap Deal">
    <div class="row vertical-gap">
        <div class="col-lg-8 col-xl-6">
            <form class="#">
                <div class="row vertical-gap sm-gap">
                    <div class="col-12">
                        <label for="swapDescription">Description</label>
                        <div class="input-group">
                            <textarea
                                name="swapDescription"
                                id="swapDescription"
                                class="form-control"
                                placeholder="Blue samsung s7 edge with small
                                crack on the screen" />
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="swapDetails">Owner Details</label>
                        <div class="input-group">
                            <textarea
                                name="swapDetails"
                                id="swapDetails"
                                class="form-control"
                                placeholder="Name, phone, address etc" />
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-between">
                        <div class="custom-control custom-radio">
                            <input
                                type="radio"
                                id="customRadio1"
                                name="customRadio"
                                class="custom-control-input" />
                            <label
                                class="custom-control-label"
                                for="customRadio1">
                                IMEI
                            </label>
                        </div>
                        <div class="custom-control custom-radio mt-5">
                            <input
                                type="radio"
                                id="customRadio2"
                                name="customRadio"
                                class="custom-control-input" />
                            <label
                                class="custom-control-label"
                                for="customRadio2">
                                Serial No.
                            </label>
                        </div>
                        <div class="custom-control custom-radio mt-5">
                            <input
                                type="radio"
                                id="customRadio3"
                                name="customRadio"
                                class="custom-control-input" />
                            <label
                                class="custom-control-label"
                                for="customRadio3">
                                Model No.
                            </label>
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="exampleBase1">Imei No.</label>
                        <input
                            type="text"
                            class="form-control"
                            id="exampleBase1"
                            placeholder="Enter Imei No." />
                    </div>
                    <div class="col-12">
                        <label for="exampleBase1">Serial No.</label>
                        <input
                            type="text"
                            class="form-control"
                            id="exampleBase1"
                            placeholder="Enter Serial No." />
                    </div>
                    <div class="col-12">
                        <label for="exampleBase1">Model No.</label>
                        <input
                            type="text"
                            class="form-control"
                            id="exampleBase1"
                            placeholder="Enter Model No." />
                    </div>
                    <div class="col-12">
                        <label for="exampleBase1">ID Card</label>
                        <input
                            type="file"
                            class="form-control"
                            id="exampleBase1" />
                    </div>
                    <div class="col-12">
                        <label for="exampleBase1">Receipt</label>
                        <input
                            type="file"
                            class="form-control"
                            id="exampleBase1" />
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-primary btn-long">
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
