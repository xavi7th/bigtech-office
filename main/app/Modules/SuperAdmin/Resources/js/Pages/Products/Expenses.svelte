<script>
  import { page } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import route from "ziggy";
  import { getErrorString } from "@public-assets/js/bootstrap";

  $: ({ app, flash, errors } = $page);

  let details = {};
  export let productWithExpenses, product;

  let createExpense = () => {
    BlockToast.fire({
      title: "Creating expense...."
    });

    Inertia.post(
      route("superadmin.products.create_product_expense", product.uuid),
      details,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "productWithExpenses"]
      }
    ).then(() => {
      if (flash.success) {
        ToastLarge.fire({
          title: "Successful!",
          html: flash.success
        });

        details = {};
      } else if (flash.error || _.size(errors) > 0) {
        ToastLarge.fire({
          title: "Oops!",
          html: flash.error || getErrorString(errors),
          timer: 5000,
          icon: "error"
        });
      } else {
        swal.close();
      }
    });
  };

  $: ({ app } = $page);
</script>

<Layout title="Expenses for {product.identifier}">
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="table-responsive-md">
        <table class="rui-datatable table table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Amount</th>
              <th scope="col">Reason</th>
              <th scope="col">Date</th>
            </tr>
          </thead>
          <tbody>
            {#each productWithExpenses as expense, idx}
              <tr>
                <th scope="row">{idx + 1}</th>
                <td>{expense.amount}</td>
                <td>{expense.reason}</td>
                <td>{expense.date}</td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="row vertical-gap mt-5">
    <div class="col-lg-8 col-xl-7 offset-xl-2 mt-5">
      <h2 class="mt-5">Create New Expense</h2>
      <form class="#" on:submit|preventDefault={createExpense}>
        <div class="row vertical-gap sm-gap">
          <div class="col-12">
            <label for="expenseAmount">Amount</label>
            <input
              type="text"
              class="form-control"
              id="expenseAmount"
              placeholder="Enter Amount"
              bind:value={details.amount} />
          </div>
          <div class="col-12">
            <label for="expensePurpose">Purpose</label>
            <input
              type="text"
              class="form-control"
              id="expensePurpose"
              placeholder="What is the expense for?"
              bind:value={details.reason} />
          </div>
          <div class="col-12">
            <button type="submit" class="btn btn-brand btn-long">
              <span class="text">Create Expense</span>
              <span class="icon">
                <span
                  data-feather="check-circle"
                  class="rui-icon rui-icon-stroke-1_5" />
              </span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</Layout>
