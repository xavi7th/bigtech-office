<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { toCurrency } from "@public-shared/helpers";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import MarkAsPaidModal from "@usershared/MarkAsPaidModal.svelte";

  $: ({ auth } = $page.props);

  export let salesRecords = [],
    date,
    companyAccounts = [];
  let productToMarkAsPaid;
</script>

<Layout title="Sales Records | {date}">
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
            {#each salesRecords as record}
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
    <MarkAsPaidModal {companyAccounts} {productToMarkAsPaid} />
  </div>
</Layout>
