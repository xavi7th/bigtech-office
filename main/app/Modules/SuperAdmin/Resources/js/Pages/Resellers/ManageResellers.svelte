<script>
    import Layout from "@superadmin-shared/SuperAdminLayout";
    import { page, InertiaLink } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import FlashMessage from "@usershared/FlashMessage";
    import route from "ziggy";

    $: ({ errors, auth } = $page);
    let createResellers = () => {};
</script>

<Layout title="Manage Resellers">
    <div class="row vertical-gap">
        <div class="col-lg-8 col-xl-8">
            <div
                class="d-flex align-items-center justify-content-between mb-25">
                <h2 class="mnb-2" id="formBase">Available Resellers</h2>
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
                            <th scope="col">Number of products</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Red</td>
                            <td>15</td>
                            <td
                                class="d-flex justify-content-between
                                align-content-center">
                                <button
                                    type="button"
                                    class="btn btn-danger btn-xs">
                                    DELETE
                                </button>
                                <InertiaLink
                                    href={route('superadmin.resellers.products', 1)}
                                    class="btn btn-brand btn-xs">
                                    Products
                                </InertiaLink>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-4 col-xl-4">

            <form class="#" class:was-validated={createResellers}>
                <FlashMessage />
                <template v-if="errors">
                    <div
                        class="d-flex align-items-center justify-content-between
                        flex-column mb-25">
                        {#each Object.entries(errors) as [err], idx}
                            <FlashMessage msg={err[0]} />
                        {/each}
                    </div>
                </template>
                <div class="row vertical-gap sm-gap">
                    <div class="col-12">
                        <label for="amount">Enter New Reseller</label>
                        <input
                            type="text"
                            class="form-control {errors.amount ? ' is-invalid' : ' is-valid'}"
                            id="amount"
                            placeholder="Enter amount to auto save"
                            v-model="details.amount" />
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-success btn-long">
                            <span class="text">Create</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>
</Layout>
