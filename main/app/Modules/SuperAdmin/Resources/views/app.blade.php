<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  @routes('superadmin')
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0, shrink-to-fit=no">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400%7cOpen+Sans:300,400,600%7cPT+Serif:400i">
  <link rel="icon" type="image/png" href="./assets/images/favicon.png">
  <link href="{{ mix('/css/dashboard-app.css') }}" rel="stylesheet" />
  <link href="{{ mix('/css/superadmin.css') }}" rel="stylesheet" />

</head>

<body data-spy="scroll" data-target=".rui-page-sidebar" data-offset="140" class="rui-no-transition rui-navbar-autohide rui-section-lines">
  @inertia

  <script src="{{ mix('js/dashboard-app-vendor.js') }}" async></script>
  <script src="{{ mix('/js/manifest.js') }}" defer></script>
  <script src="{{ mix('/js/vendor.js') }}" defer></script>
  <script src="{{ mix('js/superadmin.js') }}" defer></script>

</body>

</html>
