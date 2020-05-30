<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	@routes('public')
	<meta name="format-detection" content="telephone=yes">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<link rel="icon" type="image/png" href="images/favicon.png">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,700i">
	<link href="{{ mix('/css/app.css') }}" rel="stylesheet" />

	<title>{{config('app.name')}}</title>

</head>

<body>
	@inertia

	<script src="{{ mix('/js/public-vendor.js') }}" async></script>
	<script src="{{ mix('/js/manifest.js') }}" defer></script>
	<script src="{{ mix('/js/vendor.js') }}" defer></script>
	<script src="{{ mix('/js/app.js') }}" defer></script>

</body>

</html>
