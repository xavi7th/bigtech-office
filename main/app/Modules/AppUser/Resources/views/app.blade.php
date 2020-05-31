<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8" />
	@routes('appuser')
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<link href="{{ mix('/css/dashboard-app.css') }}" rel="stylesheet" />
	<script src="{{ mix('js/dashboard-app-vendor.js') }}" async defer></script>
	<script src="{{ mix('/js/manifest.js') }}" defer></script>
	<script src="{{ mix('/js/vendor.js') }}" defer></script>
	<script src="{{ mix('js/dashboard-app.js') }}" defer></script>
</head>

<body data-spy="scroll" data-target=".rui-page-sidebar" data-offset="140"
	class="rui-no-transition rui-navbar-autohide rui-section-lines">
	@inertia

</body>

</html>
