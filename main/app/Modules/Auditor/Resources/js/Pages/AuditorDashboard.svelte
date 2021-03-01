<script>
  import Layout from "@auditor-shared/AuditorLayout";
  import AdminSwiperStatistics from '@superadmin-shared/partials/AdminSwiperStatistics.svelte';
  import DailyExpenses from '@superadmin-shared/Partials/DailyExpenses.svelte';
  import DailyPaymentBreakdown from '@superadmin-shared/partials/DailyPaymentBreakdown.svelte';
  import RecentSoldItems from '@superadmin-shared/Partials/RecentSoldItems.svelte';

  export let statistics = {};

</script>

<Layout title="Auditor Dashboard">
  <AdminSwiperStatistics {statistics}/>

  <div class="row vertical-gap" id="breakdown-section">
    <div class="col-lg-4">
      <DailyPaymentBreakdown payments_breakdown={statistics.payments_breakdown}/>
    </div>
    <div class="col-lg-4">
      <RecentSoldItems most_recent_sales={statistics.most_recent_sales}/>
    </div>
    <div class="col-lg-4" id="invoice">
      <DailyExpenses daily_expenses_list={statistics.daily_expenses_list} />
    </div>
  </div>
</Layout>
