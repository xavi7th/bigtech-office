<script>
  import { page, InertiaLink } from "@inertiajs/inertia-svelte";
  import { toCurrency } from "@public-assets/js/bootstrap";
  import Layout from "@superadmin-shared/SuperAdminLayout";


  export let paymentRecords = [];

  $: ({ app } = $page);
</script>

<style>
  .rui-timeline {
    width: 100%;
  }
</style>

<Layout title="Payment Records">
  <div class="container-fluid">
    <div class="row vertical-gap">
      <div class="rui-timeline rui-timeline-right-lg mt-30">
        <div class="rui-timeline-line" />

        {#each Object.entries(paymentRecords) as [date, records], idx}
          <div
            class="rui-timeline-item"
            class:rui-timeline-item-swap={!!(idx % 2)}>
            <div class="rui-timeline-icon">
              <span data-feather="clock" class="rui-icon rui-icon-stroke-1_5" />
            </div>
            <div class="rui-timeline-content p-0 border-0">
              <div class="list-group">
                {#each Object.entries(records) as [bank, amount], i}
                  <span
                    v-for="(interest, savings_type) in interest_summary"
                    class="list-group-item list-group-item-action d-flex justify-content-between"
                    class:list-group-item-brand={!!(i % 2)}
                    class:list-group-item-success={!(i % 2)}>
                    <b class="text-capitalize mr-15">{bank}</b>
                    {toCurrency(amount)}
                    <InertiaLink
                      href="{route('superadmin.miscellaneous.bank_payment_records', [bank, date])}"
                      class="btn btn-dark mr-0 ml-auto btn-xs">
                      Details
                    </InertiaLink>
                  </span>
                {/each}
              </div>
            </div>
            <div class="rui-timeline-date">{date}</div>
          </div>
        {/each}
      </div>
    </div>
    <div class="rui-gap-3" />
  </div>
</Layout>
