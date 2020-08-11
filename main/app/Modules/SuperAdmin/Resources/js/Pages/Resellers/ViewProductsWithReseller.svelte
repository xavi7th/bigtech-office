<script>
    import Layout from "@superadmin-shared/SuperAdminLayout";
    import { page, InertiaLink } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import FlashMessage from "@usershared/FlashMessage";
    import route from "ziggy";

    $: ({ errors, auth } = $page);
</script>

<Layout title="Manage Resellers">
    <div class="row vertical-gap">
        <div class="col-lg-4 col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="row vertical-gap">
                        <div class="col-auto">
                            <div class="rui-profile-img">
                                <img
                                    src="/img/logo.png"
                                    alt="user id card"
                                    width="100" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="rui-profile-info">
                                <h3 class="rui-profile-info-title h4">
                                    Ugo Sam Company
                                </h3>
                                <small class="text-grey-6 mt-2 mb-15">
                                    Registered: 25 days ago
                                </small>
                                <a class="rui-profile-info-mail" href="#">
                                    ugosam@hello.com
                                </a>
                                <br />
                                <a class="rui-profile-info-phone" href="#">
                                    0908 426 6543
                                </a>
                            </div>
                            <br />
                        </div>
                    </div>
                    <div class="rui-profile-numbers">
                        <div class="row justify-content-center">
                            <div class="col" />
                            <div class="col-auto">
                                <div class="rui-profile-number text-center">
                                    <h4 class="rui-profile-number-title h2">
                                        Male
                                    </h4>
                                    <small class="text-grey-6">Gender</small>
                                </div>
                            </div>
                            <div class="col p-0" />
                            <div class="col-auto">
                                <div class="rui-profile-number text-center">
                                    <h4 class="rui-profile-number-title h2">
                                        N/A
                                    </h4>
                                    <small class="text-grey-6">
                                        Date of Birth
                                    </small>
                                </div>
                            </div>
                            <div class="col" />
                        </div>
                    </div>
                </div>
            </div>

            <hr />
        </div>

        <div class="col-lg-8 col-xl-8">
            <div
                class="d-flex align-items-center justify-content-between mb-25">
                <h2 class="mnb-2" id="formBase">Tenured Products</h2>
            </div>
            <div class="table-responsive-md">
                <table
                    class="rui-datatable table table-bordered table-bordered
                    table-sm"
                    data-order="[]">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Product Code</th>
                            <th scope="col">Collection Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Red</td>
                            <td>15</td>
                            <td>June 12th 2020 15:32</td>
                            <td
                                class="d-flex justify-content-between
                                align-content-center">
                                <InertiaLink
                                    href={route('superadmin.resellers.return_product', 1)}
                                    method="post"
                                    preserve-scroll
                                    preserve-state
                                    data={{ product_code: 'htghfg', code_type: 'imei' }}
                                    class="btn btn-danger btn-xs">
                                    Return
                                </InertiaLink>
                                <InertiaLink
                                    href={route('superadmin.resellers.pay_for_product', 1)}
                                    method="post"
                                    preserve-scroll
                                    preserve-state
                                    data={{ product_code: 'htghfg', code_type: 'imei', selling_price: 230000 }}
                                    class="btn btn-brand btn-xs">
                                    Mark Paid
                                </InertiaLink>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</Layout>
