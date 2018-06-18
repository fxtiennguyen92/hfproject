<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Hand Free | @yield('title')</title>

	<link href="{{ env('CDN_HOST') }}/img/icon/icon-144x144.png" rel="shortcut icon">
	<link href="{{ env('CDN_HOST') }}/img/icon/icon-144x144.png" rel="apple-touch-icon" type="image/png" sizes="144x144">
	<link href="{{ env('CDN_HOST') }}/img/icon/icon-128x128.png" rel="apple-touch-icon" type="image/png" sizes="128x128">
	
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<base href="{{ asset('') }}">

	<!-- Vendors Styles -->
	<!-- v1.0.0 -->
	<link rel="stylesheet" type="text/css" href="assets/vendors/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/jscrollpane/style/jquery.jscrollpane.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/ladda/dist/ladda-themeless.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/select2/dist/css/select2.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/fullcalendar/dist/fullcalendar.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/cleanhtmlaudioplayer/src/player.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/cleanhtmlvideoplayer/src/player.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/bootstrap-sweetalert/dist/sweetalert.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/summernote/dist/summernote.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/owl.carousel/dist/assets/owl.carousel.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/ionrangeslider/css/ion.rangeSlider.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/datatables/media/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/c3/c3.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/chartist/dist/chartist.min.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/barrating/bars-reversed.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/barrating/fontawesome-stars.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/barrating/fontawesome-stars-o.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/slick/slick.css">
	<!-- v1.4.0 -->
	<link rel="stylesheet" type="text/css" href="assets/vendors/nprogress/nprogress.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/jquery-steps/demo/css/jquery.steps.css">
	<!-- v1.4.2 -->
	<link rel="stylesheet" type="text/css" href="assets/vendors/bootstrap-select/dist/css/bootstrap-select.min.css">
	<!-- v1.7.0 -->
	<link rel="stylesheet" type="text/css" href="assets/vendors/dropify/dist/css/dropify.min.css">

	<!-- More -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/vendors/number/number.css">

	<!-- Clean UI Styles -->
	<link rel="stylesheet" type="text/css" href="assets/common/css/source/main.css">
	<link rel="stylesheet" type="text/css" href="css/app.css">
	
	<link rel="stylesheet" type="text/css" href="css/hf-style.css">

	<!-- Vendors Scripts -->
	<!-- v1.0.0 -->
	<script src="assets/vendors/jquery/jquery.min.js"></script>
	<script src="assets/vendors/tether/dist/js/tether.min.js"></script>
	<script src="assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
	<script src="assets/vendors/jquery-mousewheel/jquery.mousewheel.min.js"></script>
	<script src="assets/vendors/jscrollpane/script/jquery.jscrollpane.min.js"></script>
	<script src="assets/vendors/spin.js/spin.js"></script>
	<script src="assets/vendors/ladda/dist/ladda.min.js"></script>
	<script src="assets/vendors/select2/dist/js/select2.full.min.js"></script>
	<script src="assets/vendors/html5-form-validation/dist/jquery.validation.min.js"></script>
	<script src="assets/vendors/jquery-typeahead/dist/jquery.typeahead.min.js"></script>
	<script src="assets/vendors/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
	<script src="assets/vendors/autosize/dist/autosize.min.js"></script>
	<script src="assets/vendors/bootstrap-show-password/bootstrap-show-password.min.js"></script>
	<script src="assets/vendors/moment/min/moment.min.js"></script>
	<script src="assets/vendors/moment/locale/vi.js"></script>
	<script src="assets/vendors/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<script src="assets/vendors/fullcalendar/dist/fullcalendar.min.js"></script>
	<script src="assets/vendors/cleanhtmlaudioplayer/src/jquery.cleanaudioplayer.js"></script>
	<script src="assets/vendors/cleanhtmlvideoplayer/src/jquery.cleanvideoplayer.js"></script>
	<script src="assets/vendors/bootstrap-sweetalert/dist/sweetalert.min.js"></script>
	<script src="assets/vendors/remarkable-bootstrap-notify/dist/bootstrap-notify.min.js"></script>
	<script src="assets/vendors/summernote/dist/summernote.min.js"></script>
	<script src="assets/vendors/owl.carousel/dist/owl.carousel.min.js"></script>
	<script src="assets/vendors/ionrangeslider/js/ion.rangeSlider.min.js"></script>
	<script src="assets/vendors/nestable/jquery.nestable.js"></script>
	<script src="assets/vendors/datatables/media/js/jquery.dataTables.min.js"></script>
	<script src="assets/vendors/datatables/media/js/dataTables.bootstrap4.min.js"></script>
	<script src="assets/vendors/datatables-fixedcolumns/js/dataTables.fixedColumns.js"></script>
	<script src="assets/vendors/datatables-responsive/js/dataTables.responsive.js"></script>
	<script src="assets/vendors/editable-table/mindmup-editabletable.js"></script>
	<script src="assets/vendors/d3/d3.min.js"></script>
	<script src="assets/vendors/c3/c3.min.js"></script>
	<script src="assets/vendors/chartist/dist/chartist.min.js"></script>
	<script src="assets/vendors/peity/jquery.peity.min.js"></script>
	<script src="assets/vendors/barrating/jquery.barrating.min.js"></script>
	<!-- v1.0.1 -->
	<script src="assets/vendors/chartist-plugin-tooltip/dist/chartist-plugin-tooltip.min.js"></script>
	<!-- v1.1.1 -->
	<script src="assets/vendors/gsap/src/minified/TweenMax.min.js"></script>
	<script src="assets/vendors/hackertyper/hackertyper.js"></script>
	<script src="assets/vendors/jquery-countTo/jquery.countTo.js"></script>
	<!-- v1.4.0 -->
	<script src="assets/vendors/nprogress/nprogress.js"></script>
	<script src="assets/vendors/jquery-steps/build/jquery.steps.min.js"></script>
	<!-- v1.4.2 -->
	<script src="assets/vendors/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="assets/vendors/chart.js/src/Chart.bundle.min.js"></script>
	<!-- v1.7.0 -->
	<script src="assets/vendors/dropify/dist/js/dropify.min.js"></script>

	<!-- More -->
	<script src="assets/vendors/number/number.js"></script>
	<script src="assets/vendors/number/accounting.js"></script>
	<script src="assets/vendors/slick/slick.min.js"></script>
	
	<!-- Clean UI Scripts -->
	<script src="assets/common/js/common.js"></script>
	<script src="js/hf-script.js"></script>
	
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-106495939-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag() { dataLayer.push(arguments); }
		gtag('js', new Date());
	
		gtag('config', 'UA-106495939-1');
	</script>
	
	<!-- Page Scripts -->
	@stack('stylesheets')
	<!-- End Page Scripts -->
</head>

<body class="theme-default single-page">
	@if (auth()->check() && auth()->user()->role >= 80)
		@include('template.mng.nav')
	@else
		@include('template.nav')
	@endif
	
	@include('template.header-top-bar')
	@yield('content')
</body>

</html>
