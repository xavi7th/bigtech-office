<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	@routes(['salesrep','auth', 'public', 'multiaccess'])
	<script src="{{ mix('js/dashboard-app-vendor.js') }}"></script>
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0, shrink-to-fit=no">
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400%7cOpen+Sans:300,400,600%7cPT+Serif:400i">
	<link rel="icon" type="image/png" href="/img/favicon.png">
</head>

<body>
	@inertia

	<script src="{{ mix('/js/manifest.js') }}" defer async></script>
	<script src="{{ mix('/js/vendor.js') }}" defer async></script>
	<script src="{{ mix('js/salesrep.js') }}" defer></script>
  <link rel="stylesheet" href="{{ mix('css/dashboard-app.css') }}">
  <link rel="stylesheet" href="{{ mix('css/sales-reps-app.css') }}">

</body>

</html>
