<script>
    import { page, InertiaLink } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import Layout from "@superadmin-shared/SuperAdminLayout";
    import FlashMessage from "@usershared/FlashMessage";
    import route from "ziggy";

    $: ({ app } = $page);
</script>

<Layout title="Create New Stock">
    <div class="row vertical-gap">
        <div class="col-lg-8 col-xl-6">
            <form class="#">
                <div class="row vertical-gap sm-gap">
                    <div class="col-6">
                        <label for="exampleBase1">Product Model</label>
                        <div class="input-group">
                            <select class="custom-select">
                                <option selected>Select</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="exampleBase1">Product Brand</label>
                        <div class="input-group">
                            <select class="custom-select">
                                <option selected>Select</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="exampleBase1">Product Batch</label>
                        <div class="input-group">
                            <select class="custom-select">
                                <option selected>Select</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="exampleBase1">Product Color</label>
                        <div class="input-group">
                            <select class="custom-select">
                                <option selected>Select</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="exampleBase1">Product Grade</label>
                        <div class="input-group">
                            <select class="custom-select">
                                <option selected>Select</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="exampleBase1">Product Supplier</label>
                        <div class="input-group">
                            <select class="custom-select">
                                <option selected>Select</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="exampleBase1">Storage Size</label>
                        <div class="input-group">
                            <select class="custom-select">
                                <option selected>Select</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="exampleBase1">RAM Size</label>
                        <div class="input-group">
                            <select class="custom-select">
                                <option selected>Select</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="exampleBase1">Storage Type</label>
                        <div class="input-group">
                            <select class="custom-select">
                                <option selected>Select</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="exampleBase1">Processor Speed</label>
                        <div class="input-group">
                            <select class="custom-select">
                                <option selected>Select</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <label for="exampleBase1">Imei No.</label>
                        <input
                            type="text"
                            class="form-control"
                            id="exampleBase1"
                            placeholder="Enter Imei No." />
                    </div>
                    <div class="col-4">
                        <label for="exampleBase1">Serial No.</label>
                        <input
                            type="text"
                            class="form-control"
                            id="exampleBase1"
                            placeholder="Enter Serial No." />
                    </div>
                    <div class="col-4">
                        <label for="exampleBase1">Model No.</label>
                        <input
                            type="text"
                            class="form-control"
                            id="exampleBase1"
                            placeholder="Enter Model No." />
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-primary btn-long">
                            <span class="text">Create Product</span>
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
