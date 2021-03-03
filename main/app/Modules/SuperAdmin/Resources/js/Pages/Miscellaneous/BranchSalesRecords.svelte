<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { toCurrency } from "@public-shared/helpers";
  import Modal from "@superadmin-shared/Partials/Modal";
  import Layout from "@superadmin-shared/SuperAdminLayout";

  $: ({ auth } = $page.props);

  export let branchSalesRecords = [];
  let classes = ['primary', 'secondary','brand','info', 'warning', 'info', 'success']
</script>

<style>
  .bg-top{
    background-image: url('/img/bg-400-faded.png');
    padding: 30px 0;
    margin: 0 -30px;
    background-repeat: no-repeat;
    background-size: cover;
    background-color: #fafafa;
    box-shadow: 1px 2px lightgrey;
  }
</style>

<Layout title="Sales Records for  {branchSalesRecords.branch} branch">
  <div class="row vertical-gap bg-top px-5">
    <div class="col-12 d-flex justify-content-around p-0">
      <button data-toggle="modal" data-target="#viewSalesStatistics" class="btn btn-outline-primary">Sales Statistics</button>
      <button data-toggle="modal" data-target="#viewChannelStatistics" class="btn btn-grey-3">Channel Statistics</button>
      <button data-toggle="modal" data-target="#viewSalesRepStatistics" class="btn btn-outline-secondary">Sales Reps Statistics</button>
      <button data-toggle="modal" data-target="#viewOnlineRepStatistics" class="btn btn-outline-dark">Online Reps Statistics</button>
    </div>
  </div>

  <div class="rui-gap-3"></div>

  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="table-responsive-md">
        <!-- svelte-ignore missing-declaration -->
        <table class="rui-datatabl table table-striped" use:initialiseDatatable={{callBackColumn:4}}>
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Model</th>
              <th scope="col">Sales Rep</th>
              <th scope="col">Cost Price</th>
              <th scope="col">Sale Price</th>
              <th scope="col">Channel</th>
              <th scope="col">Confirmer</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th colspan="6" class="font-weight-bold text-right h3">Total:</th>
              <th />
            </tr>
          </tfoot>
          <tbody>
            {#each branchSalesRecords.sales_records as record}
              <tr>
                <th scope="row">{record.id}</th>
                <td>
                  {record.product_model}
                  <span class="d-none">{record.product_supplier}</span>
                  {#if record.is_swap_transaction}
                    <span class="badge badge-danger">SWAP</span>
                  {/if}
                  <br />
                  {record.primary_identifier}
                </td>
                <td>{record.sales_rep} <br /> {record.online_rep}</td>
                <td>{toCurrency(record.cost_price)}</td>
                <td>{toCurrency(record.selling_price)}</td>
                <td>{record.sales_channel}</td>
                <td>
                  {#if record.is_confirmed}
                    {record.sale_confirmer}
                    {#if record.is_payment_complete}
                      <span class="badge badge-success">
                        AMOUNT PAID:
                        {record.total_bank_payments_amount}
                      </span>
                    {:else}
                      <span class="badge badge-danger">
                        AMOUNT PAID:
                        {record.total_bank_payments_amount}
                      </span>
                    {/if}
                    {#if auth.user.isAccountant}
                     <button
                        on:click={() => {
                          productSaleRecordToReplaceProduct = record.id;
                        }}
                        data-toggle="modal"
                        data-target="#replaceSalesRecordProduct"
                        class="btn btn-danger btn-xs btn-sm">
                        Replace Product
                      </button>
                      {/if}
                  {:else if auth.user.isAccountant}
                    <button
                      on:click={() => {
                        productToMarkAsPaid = record.id;
                      }}
                      data-toggle="modal"
                      data-target="#enterProductPaymentDetails"
                      class="btn btn-brand btn-xs btn-sm">
                      Mark Paid
                    </button>
                  {/if}
                  {#if record.is_swap_deal}
                    <InertiaLink
                      type="button"
                      href={route(auth.user.user_type + '.multiaccess.products.swap_deal_details', record.product_uuid)}
                      class="btn btn-primary btn-xs btn-sm text-nowrap">
                      Product Details
                    </InertiaLink>
                  {:else}
                    <InertiaLink
                      type="button"
                      href={route(auth.user.user_type + '.multiaccess.products.view_product_details', record.product_uuid)}
                      class="btn btn-primary btn-xs btn-sm text-nowrap">
                      Product Details
                    </InertiaLink>
                  {/if}
                </td>
              </tr>
            {/each}
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div slot="modals">
    <Modal modalId="viewSalesStatistics" modalTitle="Sales Reps Statistics">
      <ul class="list-group">
        <li class="list-group-item list-group-item-primary">Branch: { branchSalesRecords.branch }</li>
        <li class="list-group-item list-group-item-brand">Sales Count: { branchSalesRecords.total_sales }</li>
        <li class="list-group-item list-group-item-primary">Sales Amount: { toCurrency(branchSalesRecords.total_selling_price) }</li>
        <li class="list-group-item list-group-item-secondary">Confirmed Sales Count: {branchSalesRecords.total_confirmed_sales}</li>
        <li class="list-group-item list-group-item-warning">Confiremed Sales Amount: { toCurrency(branchSalesRecords.total_confirmed_sales_amoumt) }</li>
        <li class="list-group-item list-group-item-success">Total Payments Received: { toCurrency(branchSalesRecords.total_bank_payments) }</li>
        <li class="list-group-item list-group-item-secondary">Total Swap Deals Count: {branchSalesRecords.total_swap_deals}</li>
      </ul>
    </Modal>

    <Modal modalId="viewSalesRepStatistics" modalTitle="Sales Reps Statistics">
      <ul class="list-group">
        {#each Object.entries(branchSalesRecords.sales_rep_statistics) as [repName, statistic], idx}
          <li class="list-group-item list-group-item-{classes[idx]}">{repName}: {statistic} sale</li>
        {/each}
      </ul>
    </Modal>

    <Modal modalId="viewOnlineRepStatistics" modalTitle="Online Reps Statistics">
      <ul class="list-group">
        {#each Object.entries(branchSalesRecords.online_rep_statistics) as [repName, statistic], idx}
          <li class="list-group-item list-group-item-{classes[idx]}">{repName}: {statistic} sale</li>
        {/each}
      </ul>
    </Modal>

    <Modal modalId="viewChannelStatistics" modalTitle="Online Reps Statistics">
      <ul class="list-group">
        {#each Object.entries(branchSalesRecords.channels_statistics) as [channel, statistic], idx}
          <li class="list-group-item list-group-item-{classes[idx]}">{channel}: {statistic} sale</li>
        {/each}
      </ul>
    </Modal>
  </div>

</Layout>
