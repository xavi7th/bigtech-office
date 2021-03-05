<script>
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import { page } from "@inertiajs/inertia-svelte";
  import { Inertia } from "@inertiajs/inertia";
  import { toCurrency } from '@public-shared/helpers';

  $: ({ auth } = $page.props);

  let details = {};
  export let resellerWithTransactions = [];

  let createResellerTransaction = () => {
    BlockToast.fire({
      text: "Creating transaction ..."
    });

    Inertia.post(route(auth.user.user_type + ".resellers.finances.create", resellerWithTransactions.business_name), details, {
      preserveState: true,
      preserveScroll: true,
      only: ["flash", "errors", "resellerWithTransactions"],
      onSuccess: () =>{
          details = {};
      }
    })
  };

</script>

<Layout title="Reseller Ledger">
  <div class="row vertical-gap">
    {#if auth.user.isSuperAdmin }
      <div class="col-lg-3 col-xl-4">
        <form class="#" on:submit|preventDefault={createResellerTransaction}>

          <div class="row vertical-gap sm-gap">

            <div class="col-12">
              <label for="amount">Amount</label>
              <input
                type="number"
                id="amount"
                class="form-control"
                placeholder="Amount"
                bind:value={details.amount} />
            </div>


            <div class="col-12">
              <label for="purpose">Purpose</label>
              <input
                type="text"
                id="purpose"
                class="form-control"
                placeholder="Purpose"
                bind:value={details.purpose} />
            </div>

            <div class="col-12">
              <label for="trans_type">Transaction Type</label>
              <div class="input-group">
                <select
                  class="custom-select"
                  bind:value={details.trans_type}>
                  <option value={null} selected>Select</option>
                  <option value='debit'>Debit</option>
                  <option value='credit'>Credit</option>
                </select>
              </div>
            </div>

            <div class="col-12">
              <button
                type="submit"
                class="btn btn-success btn-long">
                <span class="text">Create</span>
              </button>
            </div>
          </div>
        </form>
      </div>
    {/if}
    <div class="col-lg-9 col-xl-8">
      <div class="table-responsive">
        <!-- svelte-ignore missing-declaration -->
        <table class="table table-bordered" use:initialiseDatatable={{callBackColumn:1}}>
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Amount</th>
              <th scope="col">Purpose</th>
              <th scope="col">Recorder</th>
              <th scope="col">Date</th>
            </tr>
          </thead>
           <tfoot>
            <tr>
              <th colspan="5" class="font-weight-bold text-right h3">Total:</th>
            </tr>
          </tfoot>
          <tbody>
            {#each resellerWithTransactions.reseller_transactions as trans}
              <tr>
                <td>{trans.id}</td>
                <td class={trans.amount<0 ? 'text-danger' : 'text-dark'}>{toCurrency(trans.amount)}</td>
                <td>{trans.purpose}</td>
                <td>{trans.recorder.full_name}</td>
                <td>{new Date(trans.created_at).toDateString()}</td>
              </tr>
            {:else}
              <tr>
                <td colspan="5" class="text-center">NONE AVAILABLE</td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>

</Layout>
