<script>
    import { page, InertiaLink } from "@inertiajs/inertia-svelte";
    import { Inertia } from "@inertiajs/inertia";
    import Layout from "@salesrep-shared/SalesRepLayout.svelte";
    import FlashMessage from "@usershared/FlashMessage";

import { onMount, tick } from "svelte";
import { toCurrency } from "@public-assets/js/bootstrap";

    $: ({ flash, auth } = $page);
    export let salesStatistics = {}

    onMount(async () => {
      await tick();

      var mySwiper = new Swiper('.swiper-container')

      // 		// Chart
			// jQuery('.rui-chartjs')
			// 	.each(function() {
			// 		const $this = jQuery(this);
			// 		const ctx = $this[0].getContext('2d');

			// 		$this.attr('height', parseInt($this.attr('data-height'), 10));

			// 		// Line Realtime
			// 		if ($this.hasClass('rui-chartjs-line')) {
			// 			const dataInterval = parseInt($this.attr('data-chartjs-interval'), 10);
			// 			const dataBorderColor = $this.attr('data-chartjs-line-color');
			// 			const conf = {};

			// 			const gradient = ctx.createLinearGradient(0, 0, 0, 90);
			// 			gradient.addColorStop(0, Chart.helpers.color(dataBorderColor)
			// 				.alpha(0.1)
			// 				.rgbString());
			// 			gradient.addColorStop(1, Chart.helpers.color(dataBorderColor)
			// 				.alpha(0)
			// 				.rgbString());

			// 			const rand = () => Array.from({
			// 				length: 40
			// 			}, () => Math.floor(Math.random() * (100 - 40) + 40));

			// 			function addData(chart, data) {
			// 				chart.data.datasets.forEach((dataset) => {
			// 					let data = dataset.data;
			// 					const first = data.shift();
			// 					data.push(first);
			// 					dataset.data = data;
			// 				});

			// 				chart.update();
			// 			}

			// 			conf.type = 'line';
			// 			conf.data = {
			// 				labels: rand(),
			// 				datasets: [{
			// 					backgroundColor: gradient,
			// 					borderColor: dataBorderColor,
			// 					borderWidth: 2,
			// 					pointHitRadius: 5,
			// 					pointBorderWidth: 0,
			// 					pointBackgroundColor: 'transparent',
			// 					pointBorderColor: 'transparent',
			// 					pointHoverBorderWidth: 0,
			// 					pointHoverBackgroundColor: dataBorderColor,
			// 					data: rand(),
      //                       }],
			// 			};
			// 			conf.options = {
			// 				tooltips: {
			// 					mode: 'index',
			// 					intersect: false,
			// 					backgroundColor: '#393f49',
			// 					bodyFontSize: 11,
			// 					bodyFontColor: '#d7d9e0',
			// 					bodyFontFamily: '"Open Sans", sans-serif',
			// 					xPadding: 10,
			// 					yPadding: 10,
			// 					displayColors: false,
			// 					caretPadding: 5,
			// 					cornerRadius: 4,
			// 					callbacks: {
			// 						title: () => {
			// 							return;
			// 						},
			// 						label: (t) => {
			// 							if ($this.hasClass('rui-chartjs-memory')) {
			// 								return [`In use ${t.value}%`, `${t.value * 100} MB`];
			// 							}
			// 							if ($this.hasClass('rui-chartjs-disc')) {
			// 								return [`Read ${Math.round((t.value / 80) * 100) / 100} MB/s`,
			// 									`Write ${Math.round((t.value / 90) * 100) / 100} MB/s`];
			// 							}
			// 							if ($this.hasClass('rui-chartjs-cpu')) {
			// 								return [`Utilization ${t.value}%`, `Processes ${parseInt((t.value / 10), 10)}`];
			// 							}
			// 							if ($this.hasClass('rui-chartjs-total')) {
			// 								return `$${t.value}`;
			// 							}
			// 						}
			// 					},
			// 				},
			// 				legend: {
			// 					display: false,
			// 				},
			// 				maintainAspectRatio: true,
			// 				spanGaps: false,
			// 				plugins: {
			// 					filler: {
			// 						propagate: false,
			// 					},
			// 				},
			// 				scales: {
			// 					xAxes: [{
			// 						display: false
      //                           }],
			// 					yAxes: [{
			// 						display: false,
			// 						ticks: {
			// 							beginAtZero: true,
			// 						},
      //                           }],
			// 				},
			// 			};
			// 			const myChart = new Chart(ctx, conf);
			// 			setInterval(() => addData(myChart), dataInterval);
			// 		}
			// 	});

			// // Doughnut
			// jQuery('.rui-chartist')
			// 	.each(function() {
			// 		const $this = jQuery(this);
			// 		let dataSeries = $this.attr('data-chartist-series');
			// 		const dataWidth = $this.attr('data-width');
			// 		const dataHeight = $this.attr('data-height');
			// 		const dataGradient = $this.attr('data-chartist-gradient');
			// 		const dataBorderWidth = parseInt($this.attr('data-chartist-width'), 10);
			// 		const data = {};
			// 		const conf = {};

			// 		// Data
			// 		if (dataSeries) {
			// 			dataSeries = dataSeries.split(',');
			// 			let dataSeriesNum = [];
			// 			for (let i = 0; i < dataSeries.length; i++) {
			// 				dataSeriesNum.push(parseInt(dataSeries[i], 10));
			// 			}
			// 			data.series = dataSeriesNum;
			// 		}

			// 		// Conf
			// 		conf.donut = true;
			// 		conf.showLabel = false;

			// 		if (dataBorderWidth) {
			// 			conf.donutWidth = dataBorderWidth;
			// 		}
			// 		if (dataWidth) {
			// 			conf.width = dataWidth;
			// 		}
			// 		if (dataHeight) {
			// 			conf.height = dataHeight;
			// 		}

			// 		const chart = new Chartist.Pie($this[0], data, conf);

			// 		// Create gradient
			// 		chart.on('created', function(ctx) {
			// 			const defs = ctx.svg.elem('defs');
			// 			defs.elem('linearGradient', {
			// 					id: 'gradient',
			// 					x1: 0,
			// 					y1: 1,
			// 					x2: 0,
			// 					y2: 0
			// 				})
			// 				.elem('stop', {
			// 					offset: 0,
			// 					'stop-color': dataGradient.split(';')[0]
			// 				})
			// 				.parent()
			// 				.elem('stop', {
			// 					offset: 1,
			// 					'stop-color': dataGradient.split(';')[1]
			// 				});
			// 		});
			// 	});




    })

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
