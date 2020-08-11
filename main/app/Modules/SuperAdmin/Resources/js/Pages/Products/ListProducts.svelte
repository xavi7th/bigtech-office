<script>
    import { page, InertiaLink } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import Layout from "@superadmin-shared/SuperAdminLayout";
    import FlashMessage from "@usershared/FlashMessage";
    import Icon from "@superadmin-shared/Partials/TableSortIcon";
    import route from "ziggy";

    $: ({ app } = $page);
</script>

<Layout title="Stock List">
    <div class="row vertical-gap">
        <div class="col-lg-12 col-xl-12">
            <div class="table-responsive-md">
                <table
                    class="rui-datatable table table-striped table-bordered
                    table-sm"
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
                        <tr>
                            <th scope="row">1600</th>
                            <td>XsMax</td>
                            <td>imei: 65879G95ldJMbs5X10VnUL1</td>
                            <td>N206,418.20</td>
                            <td>N306,418.20</td>
                            <td>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-primary btn-xs btn-sm">
                                    Details
                                </InertiaLink>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-success btn-xs btn-sm">
                                    Mark Sold
                                </InertiaLink>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-brand btn-xs btn-sm">
                                    Mark Paid
                                </InertiaLink>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.product_histories.view_product_history', 1)}
                                    class="btn btn-info btn-xs btn-sm">
                                    History
                                </InertiaLink>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">22</th>
                            <td>XsMax</td>
                            <td>imei: 65879rOX5pMFjBAzDjSm</td>
                            <td>N284,249.71</td>
                            <td>N384,249.71</td>
                            <td>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-primary btn-xs btn-sm">
                                    Details
                                </InertiaLink>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-success btn-xs btn-sm">
                                    Mark Sold
                                </InertiaLink>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">76</th>
                            <td>XsMax</td>
                            <td>imei: 65879YlcQGuyw5</td>
                            <td>N284,084.41</td>
                            <td>N384,084.41</td>
                            <td>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-primary btn-xs btn-sm">
                                    Details
                                </InertiaLink>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-success btn-xs btn-sm">
                                    Mark Sold
                                </InertiaLink>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">90</th>
                            <td>XsMax</td>
                            <td>imei: 65879he8QMrpyCU74AY1OU5Qu</td>
                            <td>N289,620.27</td>
                            <td>N389,620.27</td>
                            <td>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-primary btn-xs btn-sm">
                                    Details
                                </InertiaLink>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-success btn-xs btn-sm">
                                    Mark Sold
                                </InertiaLink>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">68</th>
                            <td>XsMax</td>
                            <td>imei: 65879FKfsychPbxx</td>
                            <td>N258,773.30</td>
                            <td>N358,773.30</td>
                            <td>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-primary btn-xs btn-sm">
                                    Details
                                </InertiaLink>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-success btn-xs btn-sm">
                                    Mark Sold
                                </InertiaLink>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">12</th>
                            <td>XsMax</td>
                            <td>imei: 65879bQxivGhNe8qnye</td>
                            <td>N219,687.48</td>
                            <td>N319,687.48</td>
                            <td>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-primary btn-xs btn-sm">
                                    Details
                                </InertiaLink>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-success btn-xs btn-sm">
                                    Mark Sold
                                </InertiaLink>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">44</th>
                            <td>XsMax</td>
                            <td>imei: 658795zkizSbp4eTw83GHMql</td>
                            <td>N221,700.29</td>
                            <td>N321,700.29</td>
                            <td>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-primary btn-xs btn-sm">
                                    Details
                                </InertiaLink>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-success btn-xs btn-sm">
                                    Mark Sold
                                </InertiaLink>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">51</th>
                            <td>XsMax</td>
                            <td>imei: 65879dCaDiu8yeY30A39bQ</td>
                            <td>N203,858.09</td>
                            <td>N303,858.09</td>
                            <td>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-primary btn-xs btn-sm">
                                    Details
                                </InertiaLink>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-success btn-xs btn-sm">
                                    Mark Sold
                                </InertiaLink>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">97</th>
                            <td>XsMax</td>
                            <td>imei: 65879G6zAUlT</td>
                            <td>N256,846.90</td>
                            <td>N356,846.90</td>
                            <td>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-primary btn-xs btn-sm">
                                    Details
                                </InertiaLink>
                                <InertiaLink
                                    type="button"
                                    href={route('superadmin.products.view_product_details', 1)}
                                    class="btn btn-success btn-xs btn-sm">
                                    Mark Sold
                                </InertiaLink>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</Layout>
