
<!DOCTYPE html>
<html>

<head lang="en">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>@yield('title') | Hand Free</title>

  <base href="{{ asset('') }}">
  <link href="img/icons/icon-144x144.png" rel="icon" type="image/png">
  <link href="img/icons/icon-144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
  <link href="img/icons/icon-128x128.png" rel="apple-touch-icon" type="image/png" sizes="128x128">

  <link href="img/icons/icon-144x144.png" rel="shortcut icon">

  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="assets/vendors/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/vendors/select2/dist/css/select2.min.css">
  <link rel="stylesheet" type="text/css" href="assets/vendors/bootstrap-sweetalert/dist/sweetalert.css">

  <link rel="stylesheet" type="text/css" href="assets/common/css/source/main.css">
  <link rel="stylesheet" type="text/css" href="css/app.css">
  <link rel="stylesheet" type="text/css" href="css/hf-style.css">

  <!-- Vendors Scripts -->
  <script src="assets/vendors/jquery/jquery.min.js"></script>
  <script src="assets/vendors/tether/dist/js/tether.min.js"></script>
  <script src="assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="assets/vendors/bootstrap-show-password/bootstrap-show-password.min.js"></script>
  <script src="assets/vendors/select2/dist/js/select2.full.min.js"></script>
  <script src="assets/vendors/html5-form-validation/dist/jquery.validation.min.js"></script>
  <script src="assets/vendors/bootstrap-sweetalert/dist/sweetalert.min.js"></script>
  <script src="assets/vendors/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js"></script>

  <!-- Clean UI Scripts -->
  <script src="assets/common/js/common.js"></script>
  <script src="assets/common/js/demo.temp.js"></script>
  <style type="text/css">
    .single-page-block-inner {
      margin-top: 0px;
    }

    @media only screen and (min-width: 540px) {
      .single-page-block-inner {
        margin-top: 100px;
      }
    }

  </style>

  <!-- Page Scripts -->
  @stack('stylesheets')
  <!-- End Page Scripts -->
</head>

<body class="theme-default single-page">
  @yield('content')
</body>

</html>
