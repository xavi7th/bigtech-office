<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	@routes(['superadmin', 'multiaccess'])
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0, shrink-to-fit=no">
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400%7cOpen+Sans:300,400,600%7cPT+Serif:400i">
	<link rel="icon" type="image/png" href="/img/favicon.png">
</head>

<body>


	<style lang="scss">
		*,
		::after,
		::before {
			box-sizing: border-box;
		}

		#page-loader {
			background: rgba(203, 7, 11, 0.4);
			overflow: hidden;
			position: fixed;
			top: 0;
			bottom: 0;
			left: 0;
			right: 0;
			z-index: 9999;
		}

		#page-loader h4 {
			position: absolute;
			top: calc(50% + 100px);
			left: calc(50% + 20px);
			margin: 0;
			font-weight: 200;
			opacity: 0.5;
			font-family: fantasy;
			color: #fff;
			transform: translateX(-50%);
			font-size: 25px;
		}

		#loader {
			/* Uncomment this to make it run! */
			animation: loader 10s linear infinite;
			position: absolute;
			top: calc(50% - 20px);
			left: calc(50% - 20px);
		}

		#box {
			width: 200px;
			height: 150px;
			background: transparent;
			position: absolute;
			top: 0;
			left: 0;
			border-radius: 3px;
			background-image: url(/img/the-bigtech-logo.png);
			background-size: contain;
			background-repeat: no-repeat;
		}

		#shadow {
			width: 70px;
			height: 5px;
			background: #000;
			opacity: 0.1;
			position: absolute;
			top: 95px;
			left: 60px;
			border-radius: 50%;
			animation: shadow 0.5s linear infinite;
		}

		@keyframes loader {
			0% {
				left: -100px;
			}

			100% {
				left: 110%;
			}
		}

		@keyframes animate {
			0% {
				transform: rotate(0deg);
			}

			25% {
				transform: translateY(9px);
			}

			50% {
				transform: translateY(18px) scale(1, 0.9);
			}

			75% {
				transform: translateY(9px);
			}

			100% {
				transform: translateY(0) rotate(360deg);
			}
		}

		@keyframes shadow {
			50% {
				transform: scale(1.2, 1);
			}
		}

	</style>

	<div id="page-loader">
		<div id="loader">
			<div id="shadow"></div>
			<div id="box"></div>
		</div>
		<h4>loading...</h4>
	</div>


	@inertia

	<script src="{{ mix('js/dashboard-app-vendor.js') }}"></script>
	<script src="{{ mix('/js/manifest.js') }}" defer async></script>
	<script src="{{ mix('/js/vendor.js') }}" defer async></script>
	<script src="{{ mix('js/superadmin.js') }}" defer></script>
	<link rel="stylesheet" href="{{ mix('css/dashboard-app.css') }}">
	<link rel="stylesheet" href="{{ mix('css/superadmin-app.css') }}">

</body>

</html>
