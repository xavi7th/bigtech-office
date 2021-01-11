<script>
  import { page } from "@inertiajs/inertia-svelte";
  import Layout from "@salesrep-shared/SalesRepLayout.svelte";
  import { toCurrency } from "@public-shared/helpers";

  $: ({ auth } = $page.props);
  export let salesStatistics = {}
</script>

<Layout title="SalesRep Dashboard">
  <div class="rui-swiper" data-swiper-initialslide="2" data-swiper-loop="false" data-swiper-grabcursor="true"
      data-swiper-center="true" data-swiper-slides="auto" data-swiper-gap="30" data-swiper-speed="400">
					<div class="swiper-container">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <div class="rui-widget rui-widget-chart">
              <div class="rui-widget-chart-info">
										<div class="rui-widget-title h2">{auth.user.isOnlineRep  ? salesStatistics.today_online_sales_count : salesStatistics.today_walk_in_sales_count}</div><small class="rui-widget-subtitle">Today Sales Count</small>
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
										<div class="rui-widget-title h2">{auth.user.isOnlineRep  ? toCurrency(salesStatistics.today_online_sales_amount) : toCurrency(salesStatistics.today_walk_in_sales_amount)}</div><small class="rui-widget-subtitle">Sales Today</small>
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
										<div class="rui-widget-title h2">{auth.user.isOnlineRep  ? toCurrency(salesStatistics.today_online_sales_bonus_amount) : toCurrency(salesStatistics.today_walk_in_sales_bonus_amount)}</div><small class="rui-widget-subtitle">Bonus Today</small>
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
										<div class="rui-widget-title h1">{auth.user.isOnlineRep  ? toCurrency(salesStatistics.total_online_sales_amount) : toCurrency(salesStatistics.total_walk_in_sales_amount)}</div>
                <small class="rui-widget-subtitle">Total Sales</small>
              </div>
              <div class="rui-widget-total-chart">
                <canvas class="rui-chartjs rui-chartjs-line rui-chartjs-total" data-height="50" data-chartjs-interval="3000" data-chartjs-line-color="#8e9fff"></canvas>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="rui-widget rui-widget-chart">
              <div class="rui-widget-chart-info">
										<div class="rui-widget-title h2">{auth.user.isOnlineRep  ? salesStatistics.monthly_online_sales_count : salesStatistics.monthly_walk_in_sales_count}</div><small class="rui-widget-subtitle">Monthly Sales Count</small>
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
										<div class="rui-widget-title h2">{auth.user.isOnlineRep  ? toCurrency(salesStatistics.monthly_online_sales_amount) : toCurrency(salesStatistics.monthly_walk_in_sales_amount)}</div><small class="rui-widget-subtitle">Monthly Sales</small>
              </div>
              <div class="rui-chartjs-container">
                <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                  data-chartist-series="5,5" data-chartist-width="4" data-chartist-gradient="#8e9fff;#2bb7ef"></div>
              </div>
            </div>
          </div>
          <div class="swiper-slide">
            <div class="rui-widget rui-widget-chart">
              <div class="rui-widget-chart-info">
										<div class="rui-widget-title h2">{auth.user.isOnlineRep  ? toCurrency(salesStatistics.monthly_online_sales_bonus_amount) : toCurrency(salesStatistics.monthly_walk_in_sales_bonus_amount)}</div><small class="rui-widget-subtitle">Monthly Bonus</small>
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
    </div>
</Layout>
