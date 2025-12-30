<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="index, follow">
	<meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$title??''}}</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="{{web_resource_url('assets/img/favicon.ico')}}">
	<link rel="apple-touch-icon" href="{{web_resource_url('assets/img/favicon.ico')}}">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{web_resource_url('assets/admin/css/bootstrap.min.css')}}">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/fontawesome/css/fontawesome.min.css')}}">
	<link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/fontawesome/css/all.min.css')}}">

	<!-- Feather CSS -->
	<link rel="stylesheet" href="{{web_resource_url('assets/admin/css/feather.css')}}">

	<!-- Daterangepikcer CSS -->
	<link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/daterangepicker/daterangepicker.css')}}">

	<!-- Iconsax CSS -->
	<link rel="stylesheet" href="{{web_resource_url('assets/admin/css/iconsax.css')}}">

	<!-- Main CSS -->
	<link rel="stylesheet" href="{{web_resource_url('assets/admin/css/style.css')}}">

	<!-- jQuery -->
	<script src="{{web_resource_url('assets/admin/js/jquery-3.7.1.min.js')}}" type="text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="{{web_resource_url('assets/admin/js/bootstrap.bundle.min.js')}}" type="text/javascript"></script>

	<!-- Sticky Sidebar JS -->
	<script src="{{web_resource_url('assets/admin/plugins/theia-sticky-sidebar/ResizeSensor.js')}}" type="text/javascript"></script>
	<script src="{{web_resource_url('assets/admin/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js')}}" type="text/javascript"></script>

	<!-- Custom JS -->
	<script src="{{web_resource_url('assets/admin/js/script.js')}}" type="text/javascript"></script>

    <script type="text/javascript" src="{{web_resource_url('assets/admin/js/lodash.js') }}"></script>
    <script src="{{web_resource_url('assets/admin/plugins/wait-me/waitMe.min.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{web_resource_url('assets/admin/plugins/wait-me/waitMe.min.css')}}">
    <link href="{{web_resource_url('assets/admin/plugins/toastr/toastr.min.css')}}" rel="stylesheet"/>
    <script src="{{web_resource_url('assets/admin/plugins/toastr/toastr.min.js')}}"></script>
    <script type="text/javascript" src="{{web_resource_url('assets/admin/js/utils.js') }}"></script>
</head>
