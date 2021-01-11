<script>
  import { toCurrency } from "@public-shared/helpers";
  import Layout from "@superadmin-shared/SuperAdminLayout";

  export let companyAccount = [],
    date,
    companyAccountTransactions = [];

</script>

<Layout
  title="{companyAccount.account_number || ''} - {companyAccount.bank || ''} {new Date(date).toDateString()} Account Transactions">
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="table-responsive-md">
        <!-- svelte-ignore missing-declaration -->
        <table class="rui-datatabl table table-striped" use:initialiseDatatable>
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              {#if !companyAccount.account_number}
                <th scope="col">Device</th>
              {/if}
              <th scope="col">Device</th>
              <th scope="col">Device Amount</th>
              <th scope="col">Selling Price</th>
              <th scope="col">Amount Paid</th>
              <th scope="col">Time</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th colspan="5" class="font-weight-bold text-right h3">Total:</th>
              <th />
            </tr>
          </tfoot>
          <tbody>
            {#each companyAccountTransactions as record}
              <tr>
                <th scope="row">{record.id}</th>
                {#if !companyAccount.account_number}
                <td>
                  {record.bank} ({record.account_name})
                  <br>
                  {record.account_name}
                  <br />
                </td>
                {/if}
                <td>
                  {record.product}
                  {#if record.is_swap_transaction}
                    <span class="badge badge-danger">SWAP</span>
                  {/if}
                  <br>
                  {record.primary_identifier}
                  <br />
                </td>
                <td>{toCurrency(record.product_price)}</td>
                <td>{toCurrency(record.sale_price)}</td>
                <td>{toCurrency(record.amount_paid)}</td>
                <td>{new Date(record.created_at).toLocaleTimeString()}</td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>
</Layout>
