<script>
  import { InertiaLink, page } from "@inertiajs/inertia-svelte";
  import { toCurrency } from '@public-shared/helpers';

  export let statistics;
</script>


<style lang="scss">

  .rui-widget.rui-widget-chart .rui-widget-title{
    margin-top: 10px !important;
  }

  .rui-widget.rui-widget-chart:not(.rui-widget-total) .rui-widget-subtitle{
    max-width: 45%;
    word-break: break-word;
    text-align: center;
    line-height: 1;
  }
</style>

 <!-- svelte-ignore missing-declaration -->
 <div class="rui-swiper" use:initialiseDonutChart>
    <!-- svelte-ignore missing-declaration -->
    <div class="swiper-container" use:initialiseSwiper={{initialSlide:0, loop:true, grabcursor:true, center:false, slides:'auto', gap:30, speed:400}}>
      <div class="swiper-wrapper">

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h4">{statistics.total_daily_sale_count}</div><small class="rui-widget-subtitle">Daily Sales Count</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="5,2" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h4">{statistics.total_daily_confirmed_sale_count}</div><small class="rui-widget-subtitle">Confirmed Sales Count</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="5,2" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h4">{toCurrency(statistics.total_daily_confirmed_sale_amount)}</div><small class="rui-widget-subtitle">Confirmed Sales Amount</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="5,2" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h4">{statistics.total_daily_unconfirmed_sale_count}</div><small class="rui-widget-subtitle">Pending Sales Count</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="5,2" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h4">{toCurrency(statistics.total_daily_unconfirmed_sale_amount)}</div><small class="rui-widget-subtitle">Pending Sales Amount</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="5,2" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h4">{toCurrency(statistics.total_daily_sales_proposed_selling_price)}</div><small class="rui-widget-subtitle">Proposed Selling Price</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="5,2" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h4">{toCurrency(statistics.total_daily_profit)}</div><small class="rui-widget-subtitle">Profit Today</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="5,2" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide rui-swiper-slide-total">
          <div class="rui-widget rui-widget-chart rui-widget-total">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h1">{toCurrency(statistics.total_daily_sales_selling_price)}</div>
              <small class="rui-widget-subtitle">Total Daily Sales</small>
            </div>
            <div class="rui-widget-total-chart">
              <canvas use:initialiseLineChart={{data: statistics.live_account_payments}} class="rui-chartjs rui-chartjs-line rui-chartjs-total" data-height="100" data-chartjs-interval="3000" data-chartjs-line-color="#fe070b">
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h4">{toCurrency(statistics.total_daily_sales_stock)}</div><small class="rui-widget-subtitle">Stock Sales Today</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="8,1" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h4">{toCurrency(statistics.total_daily_sales_local_suppliers)}</div><small class="rui-widget-subtitle">Supplier Sales Today</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="8,1" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h4">{toCurrency(statistics.total_daily_repairs_cost)}</div><small class="rui-widget-subtitle">Repairs Cost Today</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="8,1" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h4">{statistics.total_swap_deals_count}</div><small class="rui-widget-subtitle">Swap Deals Count</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="8,1" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h4">{toCurrency(statistics.total_swap_deals_value)}</div><small class="rui-widget-subtitle">Swap Deals Today</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="8,1" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h4">{statistics.total_local_purchases_count}</div><small class="rui-widget-subtitle">Local Supplies Today</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="8,1" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h4">{toCurrency(statistics.balance_after_expenses)}</div><small class="rui-widget-subtitle">Cash After Expenses</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="8,1" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h4">{toCurrency(statistics.total_monthly_expenses)}</div><small class="rui-widget-subtitle">Monthly Expenses</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="5,5" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h4">{toCurrency(statistics.total_monthly_repairs_cost)}</div><small class="rui-widget-subtitle">Monthly Repairs</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="5,5" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h4">{statistics.total_monthly_sale_count}</div><small class="rui-widget-subtitle">Monthly Sale Count</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="5,5" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>


        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h4">{toCurrency(statistics.total_monthly_sale_profit)}</div><small class="rui-widget-subtitle">Monthly Sale Profit</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="5,5" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
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
