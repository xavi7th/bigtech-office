<script>
  import Layout from "@superadmin-shared/SuperAdminLayout.svelte";
  import AdminSwiperStatistics from "@superadmin-shared/Partials/AdminSwiperStatistics.svelte";
  import DailyPaymentBreakdown from "@superadmin-shared/Partials/DailyPaymentBreakdown.svelte";
  import RecentSoldItems from '@superadmin-shared/Partials/RecentSoldItems.svelte';
  import { onMount,  } from 'svelte';
  import DailyExpenses from '@superadmin-shared/Partials/DailyExpenses.svelte';

  export let statistics = {};

  let saveDiv = function(divId, title) {
    html2pdf(document.getElementById(divId), {
      filename: title + '.pdf',
      image: {
        type: 'jpeg',
        quality: 0.98
      },
      // html2canvas: {
      //   scale: 2
      // },
      jsPDF: {
        // unit: 'in',
        format: 'a3',
        // orientation: 'portrait'
      }
    });
  }

  onMount(() => {
      // saveDiv('invoice','My Dashboard Report')
  })
</script>

<svelte:head>
  <script src="/js/html2pdf.js"></script>
</svelte:head>

<style lang="scss">
  .rui-widget.rui-widget-chart:not(.rui-widget-total) .rui-widget-subtitle{
    max-width: 45%;
    word-break: break-word;
    text-align: center;
    line-height: 1;
  }
</style>

<Layout title="Super Admin Dashboard">
  <AdminSwiperStatistics  {statistics} />

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

  <div class="rui-gap-3"></div>
<!--
  <div class="row vertical-gap">
    <div class="col-lg-4">
      <div class="rui-widget rui-widget-actions">
        <div class="rui-widget-head">
          <h4 class="rui-widget-title">Latest Tasks</h4>
          <div class="dropdown dropdown-hover dropdown-triangle dropdown-keep-open ml-auto rui-dropdown-triangle-ready">
            <a class="dropdown-item mnr-8" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,12"><span class="btn btn-custom-round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical rui-icon rui-icon-stroke-1_5"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></span></a>
            <ul class="dropdown-menu dropdown-menu-right">
              <li><a class="dropdown-item" href="#">Export to XLS</a>
              </li>
              <li><a class="dropdown-item" href="#">Export to PDF</a>
              </li>
              <li><a class="dropdown-item" href="#">Export to XML</a>
              </li>
            <span class="dropdown-menu-triangle"></span></ul>
          </div>
        </div>
        <div class="rui-widget-content">
          <ul class="list-group list-group-flush rui-widget-list rui-widget-task-list">
            <li class="list-group-item">
              <div class="rui-task rui-task-success">
                <div class="rui-task-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle rui-icon rui-icon-stroke-1_5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                </div>
                <div class="rui-task-content">
                  <a class="rui-task-title" href="task.html">Cattle whose. There isn't cattle rule said</a>
                  <small class="rui-task-subtitle">#12 opened 4 days ago by <a href="#">Henry</a></small>
                </div>
              </div>
            </li>
            <li class="list-group-item">
              <div class="rui-task rui-task-success">
                <div class="rui-task-icon">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle rui-icon rui-icon-stroke-1_5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                </div>
                <div class="rui-task-content">
                  <a class="rui-task-title" href="task.html">Was living rule Him created a to. Light of itself</a>
                  <small class="rui-task-subtitle">#11 opened 21 days ago by <a href="#">Neil</a></small>
                </div>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-lg-4" id="invoice">
      <div class="rui-widget rui-widget-actions">
        <div class="rui-widget-head">
          <h4 class="rui-widget-title">Latest Uploads</h4>
          <div class="dropdown dropdown-hover dropdown-triangle dropdown-keep-open ml-auto rui-dropdown-triangle-ready">
            <a class="dropdown-item mnr-8" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,12"><span class="btn btn-custom-round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical rui-icon rui-icon-stroke-1_5"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></span></a>
            <ul class="dropdown-menu dropdown-menu-right">
              <li><a class="dropdown-item" href="#">Export to XLS</a>
              </li>
              <li><a class="dropdown-item" href="#">Export to PDF</a>
              </li>
              <li><a class="dropdown-item" href="#">Export to XML</a>
              </li>
            <span class="dropdown-menu-triangle"></span></ul>
          </div>
        </div>
        <div class="rui-widget-content">
          <ul class="list-group list-group-flush rui-widget-list">
            <li class="list-group-item">
              <div class="media media-filled">
                <a href="#" class="media-link"><span class="media-img bg-transparent"><img src="./assets/images/icon-zip.svg" class="icon-file" alt=""></span><span class="media-body"><span class="media-title">Added banner archive<span class="media-time">08:31</span></span> <small class="media-subtitle">Commerce</small></span></a>
              </div>
            </li>
            <li class="list-group-item">
              <div class="media media-filled">
                <a href="#" class="media-link"><span class="media-img bg-transparent"><img src="./assets/images/icon-zip.svg" class="icon-file" alt=""></span><span class="media-body"><span class="media-title">Sensific-1.2.0.zip<span class="media-time">10:24</span></span> <small class="media-subtitle">Template</small></span></a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="rui-widget rui-widget-actions">
        <div class="rui-widget-head">
          <h4 class="rui-widget-title">Activity</h4>
          <div class="dropdown dropdown-hover dropdown-triangle dropdown-keep-open ml-auto rui-dropdown-triangle-ready">
            <a class="dropdown-item mnr-8" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-offset="10,12"><span class="btn btn-custom-round"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical rui-icon rui-icon-stroke-1_5"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg></span></a>
            <ul class="dropdown-menu dropdown-menu-right">
              <li><a class="dropdown-item" href="#">Export to XLS</a>
              </li>
              <li><a class="dropdown-item" href="#">Export to PDF</a>
              </li>
              <li><a class="dropdown-item" href="#">Export to XML</a>
              </li>
            <span class="dropdown-menu-triangle"></span></ul>
          </div>
        </div>
        <div class="rui-widget-content">
          <ul class="list-group list-group-flush rui-widget-list">
            <li class="list-group-item">
              <div class="media media-filled">
                <a href="#" class="media-link active"><span class="media-img">P</span> <span class="media-body"><span class="media-title">[Project] Release Version 1.2.0</span> <small class="media-subtitle">Jul 05, 2019 10:22 — created</small></span></a>
              </div>
            </li>
            <li class="list-group-item">
              <div class="media media-filled">
                <a href="#" class="media-link active"><span class="media-img">H</span> <span class="media-body"><span class="media-title">[Hotfix] Error login page</span> <small class="media-subtitle">Jul 04, 2019 10:38 — created</small></span></a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div> -->


</Layout>
