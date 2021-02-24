<script>
  import { page } from "@inertiajs/inertia-svelte";
  import Layout from "@salesrep-shared/SalesRepLayout.svelte";
  import { toCurrency } from "@public-shared/helpers";

  $: ({ auth } = $page.props);
  export let salesStatistics = {}
</script>

<Layout title="SalesRep Dashboard">
  <!-- svelte-ignore missing-declaration -->
  <div class="rui-swiper" use:initialiseDonutChart>
      <!-- svelte-ignore missing-declaration -->
    <div class="swiper-container"  use:initialiseSwiper={{initialSlide:0, loop:true, grabcursor:true, center:false, slides:'auto', gap:30, speed:400}}>

      <div class="swiper-wrapper">

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h2">{auth.user.isOnlineSalesRep  ? salesStatistics.today_online_sales_count : salesStatistics.today_walk_in_sales_count}</div><small class="rui-widget-subtitle">Today Sales Count</small>
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
              <div class="rui-widget-title h2">{auth.user.isOnlineSalesRep  ? toCurrency(salesStatistics.today_online_sales_bonus_amount) : toCurrency(salesStatistics.today_walk_in_sales_bonus_amount)}</div><small class="rui-widget-subtitle">Bonus Today</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="2,8" data-chartist-width="4" data-chartist-gradient="#8e9fff;#2bb7ef"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h2">{auth.user.isOnlineSalesRep  ? salesStatistics.monthly_online_sales_count : salesStatistics.monthly_walk_in_sales_count}</div><small class="rui-widget-subtitle">Monthly Sales Count</small>
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
              <div class="rui-widget-title h2">{auth.user.isOnlineSalesRep  ? toCurrency(salesStatistics.monthly_online_sales_bonus_amount) : toCurrency(salesStatistics.monthly_walk_in_sales_bonus_amount)}</div><small class="rui-widget-subtitle">Monthly Bonus</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="5,5" data-chartist-width="4" data-chartist-gradient="#8e9fff;#2bb7ef"></div>
            </div>
          </div>
        </div>

      </div>

    </div>
    <div class="swiper-button-next">
      <span data-feather="chevron-right" class="rui-icon rui-icon-stroke-1_5"></span>
    </div>
    <div class="swiper-button-prev"><span data-feather="chevron-left" class="rui-icon rui-icon-stroke-1_5"></span>
    </div>
    <div class="swiper-scrollbar"></div>
  </div>
</Layout>
