<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import Layout from "@superadmin-shared/SuperAdminLayout";
  import MarkAsPaidModal from "@usershared/MarkAsPaidModal.svelte";
  import route from "ziggy";

  $: ({ app } = $page);

  export let salesRecords = [],
    date,
    companyAccounts = [];
  let productToMarkAsPaid;
</script>

<Layout title="Sales Records | {date}">
  <div class="row vertical-gap">
    <div class="col-lg-12 col-xl-12">
      <div class="table-responsive-md">
        <table class="rui-datatable table table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Model</th>
              <th scope="col">Product ID</th>
              <th scope="col">Sales Rep</th>
              <th scope="col">Ideal Price</th>
              <th scope="col">Sale Price</th>
              <th scope="col">Channel</th>
              <th scope="col">Confirmer</th>
            </tr>
          </thead>
          <tbody>
            {#each salesRecords as record}
              <tr>
                <th scope="row">{record.id}</th>
                <td>
                  {record.product_model}
                  {#if record.is_swap_deal}
                    <span class="badge badge-danger">SWAP</span>
                  {/if}
                </td>
                <td>{record.primary_identifier}</td>
                <td>
                  {record.sales_rep}
                  <br />
                  {record.online_rep}
                </td>
                <td>{record.proposed_selling_price}</td>
                <td>{record.selling_price}</td>
                <td>{record.sales_channel}</td>
                <td>
                  {#if record.is_confirmed}
                    {record.sale_confirmer}
                    {#if record.is_payment_complete}
                      <span class="badge badge-success">
                        AMOUNT PAID: {record.total_bank_payments_amount}
                      </span>
                    {:else}
                      <span class="badge badge-danger">
                        AMOUNT PAID: {record.total_bank_payments_amount}
                      </span>
                    {/if}
                  {:else}
                    <button
                      on:click={() => {
                        productToMarkAsPaid = record.product_uuid;
                      }}
                      data-toggle="modal"
                      data-target="#enterProductPaymentDetails"
                      class="btn btn-brand btn-xs btn-sm">
                      Mark Paid
                    </button>
                  {/if}
                  &nbsp;
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
