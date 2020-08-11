<script>
    import { page, InertiaLink } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import Layout from "@superadmin-shared/SuperAdminLayout";
    import FlashMessage from "@usershared/FlashMessage";
    import route from "ziggy";

    let details = {};

    $: ({ app } = $page);
</script>

<Layout title="Create Expense Record">
    <div class="row vertical-gap">
        <div class="col-lg-8 col-xl-7">
            <form class="#">
                <div class="row vertical-gap sm-gap">
                    <div class="col-12">
                        <label for="expenseAmount">Amount</label>
                        <input
                            type="text"
                            class="form-control"
                            id="expenseAmount"
                            placeholder="Enter Amount" />
                    </div>
                    <div class="col-12">
                        <label for="expensePurpose">Purpose</label>
                        <input
                            type="text"
                            class="form-control"
                            id="expensePurpose"
                            placeholder="What is the expense for?" />
                    </div>
                    <div class="col-12">
                        <button type="button" class="btn btn-brand btn-long">
                            <span class="text">Create Expense</span>
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
