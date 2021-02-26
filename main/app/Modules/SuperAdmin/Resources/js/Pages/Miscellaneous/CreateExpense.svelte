<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";

  $: ({ auth } = $page.props);

  export let dailyExpenses = [];
  let details = {};

  let createDailyExpense = () => {
    BlockToast.fire({
      text: "Creating daily expense ..."
    });

    Inertia.post(
      route("accountant.miscellaneous.create_daily_expense"),
      details,
      {
        preserveState: true,
        preserveScroll: true,
        only: ["flash", "errors", "dailyExpenses"],
        onSuccess: () =>{
          details = {};
        }
      }
    )
  };

  // let updateDailyExpense = () => {
  //   BlockToast.fire({
  //     text: "Updating daily expense ..."
  //   });

  //   Inertia.put(
  //     route("superadmin.miscellaneous.edit_daily_expense", details.id),
  //     details,
  //     {
  //       preserveState: true,
  //       preserveScroll: true,
  //       only: ["flash", "errors", "dailyExpenses"],
  //       onSuccess: () => {
  //          details = {};
  //       }
  //     }
  //   )
  // };

  // let deleteDailyExpense = id => {
    // swalPreconfirm
    //   .fire({
    //     text:
    //           "This daily expense will be permanently deleted and products can no longer be created under it",
    //     confirmButtonText: "Yes, carry on!",
    //     preConfirm: () => {
    //           return Inertia.delete(
    //             route("superadmin.miscellaneous.delete_daily_expense", id),
    //             {
    //               preserveState: true,
    //               preserveScroll: true,
    //               only: ["flash", "errors", "dailyExpenses"]
    //             }
    //           )
    //         }
    //   })
  // };
</script>

<Layout title="Manage Daily Expenses">
  <div class="row vertical-gap">
    {#if auth.user.isAccountant}
      <div class="col-lg-4 col-xl-4">
        <form class="#" on:submit|preventDefault={createDailyExpense}>

          <div class="row vertical-gap sm-gap">
            <div class="col-12">
              <label for="name">Enter New Daily Amount</label>
              <input
                type="text"
                class="form-control"
                placeholder="Amount"
                bind:value={details.amount} />
            </div>
            <div class="col-12">
              <label for="name">Enter Expense Purpose</label>
              <input
                type="text"
                class="form-control"
                placeholder="Purpose of Expense"
                bind:value={details.purpose} />
            </div>

            <div class="col-12">
              <button
                type="submit"
                class="btn btn-success btn-long"
                disabled={!details.amount || !details.purpose}>
                <span class="text">Create</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    {/if}
    <div class="col-lg-8 col-xl-8">
      <div class="d-flex align-items-center justify-content-between mb-25">
        <h2 class="mnb-2" id="formBase">Today's Expenses</h2>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Amount</th>
              <th scope="col">Purpose</th>
              <!-- <th scope="col">Action</th> -->
            </tr>
          </thead>
          <tbody>
            {#each dailyExpenses as dailyExpense, idx}
              <tr>
                <td>{idx + 1}</td>
                <td>{dailyExpense.amount}</td>
                <td>{dailyExpense.purpose}</td>
                <!-- <td class="d-flex justify-content-between align-content-center">
                  <button
                    type="button"
                    class="btn btn-danger btn-xs"
                    on:click={() => {
                      deleteDailyExpense(dailyExpense.id);
                    }}>
                    DELETE
                  </button>
                  <button
                    type="button"
                    class="btn btn-warning btn-xs"
                    data-toggle="modal"
                    data-target="#updateDailyExpense"
                    on:click={() => {
                      dailyExpenseName = dailyExpense.speed;
                      dailyExpenseId = dailyExpense.id;
                    }}>
                    EDIT
                  </button>
                </td> -->
              </tr>
            {:else}
              <tr>
                <td colspan="5" class="text-center">
                  No Expense Recorded For Today.
                </td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- <div slot="modals">
    <Modal modalId="updateDailyExpense" modalTitle="Update Daily Expense">

      <FlashMessage />

      <div class="row vertical-gap sm-gap">
        <div class="col-12">
          <label for="name">Change Amount</label>
          <input
            type="text"
            class="form-control"
            placeholder="Daily Expense Amount"
            bind:value={details.amount} />
        </div>
        <div class="col-12">
          <label for="name">Change Purpose</label>
          <input
            type="text"
            class="form-control"
            placeholder="Daily Expense Purpose"
            bind:value={details.purpose} />
        </div>

      </div>
      <button
        on:click={updateDailyExpense}
        slot="footer-buttons"
        class="btn btn-success btn-long">
        <span class="text">Update</span>
      </button>

    </Modal>
  </div> -->
</Layout>
