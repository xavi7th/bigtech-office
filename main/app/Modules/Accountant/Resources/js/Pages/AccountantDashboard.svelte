<script>
    import Layout from "@accountant-shared/AccountantLayout.svelte";

    export let products_in_posession, pending_confirmations, pending_local_products, swap_deals_in_stock, products_with_resellers;
</script>

<Layout title="Accountant Dashboard">
    <!-- svelte-ignore missing-declaration -->
  <div class="rui-swiper" use:initialiseDonutChart>
    <!-- svelte-ignore missing-declaration -->
    <div class="swiper-container"  use:initialiseSwiper={{initialSlide:0, loop:true, grabcursor:true, center:true, slides:'auto', gap:30, speed:400}}>
      <div class="swiper-wrapper">

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h2">{products_in_posession}</div><small class="rui-widget-subtitle">Products in Possession</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="8,5" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h2">{pending_confirmations}</div><small class="rui-widget-subtitle">Pending Confirmations</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="2,5" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h2">{pending_local_products}</div><small class="rui-widget-subtitle">Pending Local Products</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="9,6" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h2">{swap_deals_in_stock}</div><small class="rui-widget-subtitle">Swap Deals Stock</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="5,9" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
            </div>
          </div>
        </div>

        <div class="swiper-slide">
          <div class="rui-widget rui-widget-chart">
            <div class="rui-widget-chart-info">
              <div class="rui-widget-title h2">{products_with_resellers}</div><small class="rui-widget-subtitle">Product with Resellers</small>
            </div>
            <div class="rui-chartjs-container">
              <div class="rui-chartist rui-chartist-donut" data-width="150" data-height="150"
                data-chartist-series="8,2" data-chartist-width="4" data-chartist-gradient="#fe070b;#ed1c24"></div>
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
