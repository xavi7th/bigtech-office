<script>
    import { page, InertiaLink } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import Layout from "@superadmin-shared/SuperAdminLayout";
    import FlashMessage from "@usershared/FlashMessage";
    import route from "ziggy";

    $: ({ app } = $page);
</script>

<Layout title="Stock List">
    <div class="row vertical-gap">
        <div class="col-lg-2">
            <a
                href="/img/iphone-11.png"
                data-fancybox="images"
                class="rui-gallery-item">
                <img src="/img/iphone-11.png" class="rui-img" alt="" />
            </a>
        </div>
        <div class="col-lg-5">
            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" colspan="2">IPHONE 11</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-primary">
                            <strong>Product Category</strong>
                        </td>
                        <th scope="row">
                            <strong>Not Available</strong>
                        </th>
                    </tr>
                    <tr>
                        <td class="text-primary">
                            <strong>Product Model</strong>
                        </td>
                        <th scope="row">
                            <strong>Not Available</strong>
                        </th>
                    </tr>
                    <tr>
                        <td class="text-primary">
                            <strong>Product Brand</strong>
                        </td>
                        <th scope="row">
                            <strong>Not Available</strong>
                        </th>
                    </tr>
                    <tr>
                        <td class="text-primary">
                            <strong>Product Batch</strong>
                        </td>
                        <th scope="row">
                            <strong>Not Available</strong>
                        </th>
                    </tr>
                    <tr>
                        <td class="text-primary">
                            <strong>Product Color</strong>
                        </td>
                        <th scope="row">
                            <strong>Not Available</strong>
                        </th>
                    </tr>
                    <tr>
                        <td class="text-primary">
                            <strong>Product Grade</strong>
                        </td>
                        <th scope="row">
                            <strong>Not Available</strong>
                        </th>
                    </tr>
                    <tr>
                        <td class="text-primary">
                            <strong>Product Supplier</strong>
                        </td>
                        <th scope="row">
                            <strong>Not Available</strong>
                        </th>
                    </tr>
                    <tr>
                        <td class="text-primary">
                            <strong>Storage Size</strong>
                        </td>
                        <th scope="row">
                            <strong>Not Available</strong>
                        </th>
                    </tr>
                    <tr>
                        <td class="text-primary">
                            <strong>RAM Size</strong>
                        </td>
                        <th scope="row">
                            <strong>Not Available</strong>
                        </th>
                    </tr>
                    <tr>
                        <td class="text-primary">
                            <strong>Storage Type</strong>
                        </td>
                        <th scope="row">
                            <strong>Not Available</strong>
                        </th>
                    </tr>
                    <tr>
                        <td class="text-primary">
                            <strong>Processor Speed</strong>
                        </td>
                        <th scope="row">
                            <strong>Not Available</strong>
                        </th>
                    </tr>
                    <tr>
                        <td class="text-primary">
                            <strong>IMEI No.</strong>
                        </td>
                        <th scope="row">
                            <strong>Not Available</strong>
                        </th>
                    </tr>
                    <tr>
                        <td class="text-primary">
                            <strong>Serial No.</strong>
                        </td>
                        <th scope="row">
                            <strong>Not Available</strong>
                        </th>
                    </tr>
                    <tr>
                        <td class="text-primary">
                            <strong>Model No.</strong>
                        </td>
                        <th scope="row">
                            <strong>Not Available</strong>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-lg-5">
            <div class="col-12">
                <label for="exampleBase1">Comment on this device</label>
                <div class="a" style="display: flex;">
                    <input
                        type="text"
                        class="form-control"
                        id="exampleBase1"
                        placeholder="Enter Comment" />
                    <button
                        type="button"
                        style="margin-left: 20px;"
                        class="btn btn-brand btn-hover-primary">
                        Comment
                    </button>
                </div>
            </div>
            <hr />
            <div
                class="tab-pane fade show active"
                id="activity"
                role="tabpanel"
                aria-labelledby="activity-tab">
                <ul
                    class="list-group list-group-flush rui-profile-activity-list">
                    <li class="list-group-item">
                        <div class="media media-success media-retiring">
                            <a href="#" class="media-link">
                                <span class="media-body">
                                    <span class="media-title">
                                        Amber Smith
                                        <span class="media-time">09:10</span>
                                    </span>
                                    <small class="media-subtitle">
                                        Amet viverra dolor per mollis morbi
                                        sagittis cursus sollicitudin cubilia.
                                    </small>
                                </span>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="media media-success media-retiring">
                            <a href="#" class="media-link">
                                <span class="media-body">
                                    <span class="media-title">
                                        Amber Smith
                                        <span class="media-time">09:10</span>
                                    </span>
                                    <small class="media-subtitle">
                                        Amet viverra dolor per mollis morbi
                                        sagittis cursus sollicitudin cubilia.
                                    </small>
                                </span>
                            </a>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="media media-success media-retiring">
                            <a href="#" class="media-link">
                                <span class="media-body">
                                    <span class="media-title">
                                        Amber Smith
                                        <span class="media-time">09:10</span>
                                    </span>
                                    <small class="media-subtitle">
                                        Amet viverra dolor per mollis morbi
                                        sagittis cursus sollicitudin cubilia.
                                    </small>
                                </span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</Layout>
