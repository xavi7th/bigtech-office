<script>
  import { toCurrency } from '@public-shared/helpers';
  import Layout from "@superadmin-shared/SuperAdminLayout.svelte";
  import { onMount,  } from 'svelte';
	import { InertiaLink, page } from '@inertiajs/inertia-svelte'

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
  #breakdown-section{
    .card-text{
      font-size: 0.7em;
    }

    .card-title{
      text-align: center;
    }

    .card-img-top{
      max-height: 200px;
      object-fit: cover;
      object-position: center;
      box-shadow: 0px 1px 5px 0px #ddd;
    }
  }
</style>

<Layout title="Super Admin Dashboard">
  <!-- svelte-ignore missing-declaration -->
  <div class="rui-swiper" use:initialiseDonutChart use:initialiseLineChart>
    <!-- svelte-ignore missing-declaration -->
    <div class="swiper-container" use:initialiseSwiper={{initialSlide:0, loop:true, grabcursor:true, center:false, slides:'auto', gap:30, speed:400}}>
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h2">25%</div><small class="rui-widget-subtitle">Bounce Rate</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="5,2" data-chartist-width="4" data-chartist-gradient="#8e9fff;#2bb7ef"></div>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h2">-12%</div><small class="rui-widget-subtitle">Sales Today</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="2,8" data-chartist-width="4" data-chartist-gradient="#8e9fff;#2bb7ef"></div>
            </div>
          </div>
        </div>
        <div class="swiper-slide rui-swiper-slide-total">
          <div class="rui-widget rui-widget-chart rui-widget-total">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h1">$1371.24</div>
              <small class="rui-widget-subtitle">Total Income</small>
            </div>
            <div class="rui-widget-total-chart">
              <canvas class="rui-chartjs rui-chartjs-line rui-chartjs-total" data-height="50" data-chartjs-interval="3000" data-chartjs-line-color="#8e9fff"></canvas>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h2">+14%</div><small class="rui-widget-subtitle">Users Today</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="8,1" data-chartist-width="4" data-chartist-gradient="#8e9fff;#2bb7ef"></div>
            </div>
          </div>
        </div>
        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h2">+10%</div><small class="rui-widget-subtitle">Session</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="5,5" data-chartist-width="4" data-chartist-gradient="#8e9fff;#2bb7ef"></div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="swiper-button-prev">
      <span data-feather="chevron-left" class="rui-icon rui-icon-stroke-1_5"></span>
    </div>
    <div class="swiper-button-next">
      <span data-feather="chevron-right" class="rui-icon rui-icon-stroke-1_5"></span>
    </div>
    <div class="swiper-scrollbar"></div>

  </div>
  <div class="rui-gap-2"></div>

  <div class="row vertical-gap" id="breakdown-section">
    <div class="col-lg-4">
      <div class="card">
          <img src="/img/breeakdown.jpg" class="card-img-top" alt="">
          <div class="card-body">
              <h5 class="card-title h2">Daily Payments Breakdown</h5>
              <p class="card-text">Breakdown of financial transactions confirmed by the accountant in realtime.</p>
          </div>
          <ul class="list-group list-group-flush">
             {#each  Object.entries(statistics.payments_breakdown) as [bank, amount]}
                <li class="list-group-item d-flex justify-content-between"><strong class="text-capitalize">{bank}: </strong> <h4 class="my-0 mr-15">{toCurrency(amount)}</h4></li>
              {/each}
          </ul>
      </div>
    </div>
     <div class="col-lg-4">
      <div class="card">
          <img src="/img/sold.png" class="card-img-top" alt="">
          <div class="card-body">
              <h5 class="card-title h2">Last 5 sold items</h5>
              <p class="card-text">This lists the latest sales records along with the sales rep that handled the sales.</p>
          </div>
          <ul class="list-group list-group-flush">
               {#each  statistics.most_recent_sales as record}
                <li class="list-group-item">
                  <h4 class="my-0 text-capitalize">
                    <InertiaLink href={route($page.props.auth.user.user_type + '.multiaccess.products.view_product_details', record.uuid)} >{record.desc}</InertiaLink> sold by {record.sales_rep}
                  </h4>
                </li>
              {/each}
          </ul>
          <div class="card-body">
              <div class="mnt-5 mnb-5">
                  <a href="#" class="card-link">Card link</a>
                  <a href="#" class="card-link">Another link</a>
              </div>
          </div>
      </div>
    </div>
    <div class="col-lg-4" id="invoice">
      <div class="card">
          <img src="/img/expenses.jpg" class="card-img-top" alt="">
          <div class="card-body">
              <h5 class="card-title h2">Daily Expenes</h5>
              <p class="card-text">List of expenses and monies spent in the office today.</p>
          </div>
          <ul class="list-group list-group-flush">
              {#each  Object.entries(statistics.daily_expenses_list) as [expense_details, amount]}
                <li class="list-group-item d-flex justify-content-between"><strong class="text-capitalize">{expense_details}: </strong> <h4 class="my-0 mr-15">{toCurrency(amount)}</h4></li>
              {/each}
          </ul>
      </div>
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
