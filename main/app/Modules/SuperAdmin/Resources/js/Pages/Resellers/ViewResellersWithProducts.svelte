<script>
    import Layout from "@superadmin-shared/SuperAdminLayout";
    import { page, InertiaLink } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import FlashMessage from "@usershared/FlashMessage";
    import route from "ziggy";

    $: ({ errors, auth } = $page);
</script>

<Layout title="View Resellers With Products">

    <div class="container-fluid">
        <div class="row vertical-gap">
            <div class="col-12 col-lg-8 offset-lg-2">
                <div class="table-responsive">
                    <table
                        class="table table-bordered rui-datatable"
                        data-order="[]">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Records</th>
                            </tr>
                        </thead>
                        <tbody
                            class="list-group list-group-flush
                            rui-project-releases-list m-0">
                            <tr class="list-group-item p-0">
                                <td class="rui-changelog d-block">
                                    <h3 class="rui-changelog-title">
                                        Reseller: Emiwizzy
                                    </h3>
                                    <div class="rui-changelog-subtitle">
                                        <a href="#">Contact Number:</a>
                                        08034411661
                                    </div>
                                    <ul class="list-unstyled">
                                        <li>
                                            <div
                                                class="rui-changelog-item
                                                rui-changelog-success">
                                                <span
                                                    class="rui-changelog-item-type">
                                                    Iphone 11 (IMEI: 7798)
                                                    collected on 15th Mar 2019
                                                </span>
                                            </div>
                                        </li>
                                        <li>
                                            <div
                                                class="rui-changelog-item
                                                rui-changelog-danger">
                                                <span
                                                    class="rui-changelog-item-type">
                                                    Iphone 11 (IMEI: 7798)
                                                    collected on 15th Mar 2019
                                                </span>
                                            </div>
                                        </li>
                                        <li>
                                            <div
                                                class="rui-changelog-item
                                                rui-changelog-info">
                                                <span
                                                    class="rui-changelog-item-type">
                                                    Iphone 11 (IMEI: 7798)
                                                    collected on 15th Mar 2019
                                                </span>
                                            </div>
                                        </li>
                                    </ul>
                                    <ul class="list-unstyled">
                                        <li>
                                            <a
                                                class="rui-changelog-file
                                                text-capitalize"
                                                href="#">
                                                <span class="fa fa-history" />
                                                <strong class="mx-5">
                                                    Transaction Type:
                                                </strong>
                                                yjthhtgh
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</Layout>
