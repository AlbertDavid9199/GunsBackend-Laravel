<?php

use App\Helpers\Helper;

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

    <META HTTP-EQUIV="Pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="Cache-Control" CONTENT="no-store, no-cache, must-revalidate">
    <META HTTP-EQUIV="Pragma-directive" CONTENT="no-cache">
    <META HTTP-EQUIV="Cache-Directive" CONTENT="no-cache">
    <META http-equiv="Expires" content="0">

    <title>@yield('title')</title>
	<link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="/assets/plugins/css/responsive.css">
	<link rel="stylesheet" href="/assets/plugins/font-awesome/css/font-awesome.css">
	<link rel="stylesheet" href="/assets/plugins/dataTables/css/dataTables.bootstrap.css">
    <link rel="stylesheet" href="/assets/plugins/dataTables/css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="/assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css">
	<link rel="stylesheet" href="/assets/plugins/bootstrap-datepicker/css/buttons.dataTables.min.css">
    @yield('view_css_link')
	<link rel="stylesheet" href="/assets/css/app.css">

    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
	<script type="text/javascript" src="/assets/plugins/bootstrap/js/bootstrap.js"></script>
	<script type="text/javascript" src="/assets/plugins/js/modernizr.js"></script>
	<script type="text/javascript" src="/assets/plugins/js/respond.js"></script>
	<script type="text/javascript" src="/assets/plugins/dataTables/js/jquery.dataTables.js"></script>
	<script type="text/javascript" src="/assets/plugins/dataTables/js/dataTables.bootstrap.js"></script>

    <script type="text/javascript" src="/assets/plugins/dataTables/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/dataTables/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/dataTables/js/jszip.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/dataTables/js/pdfmake.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/dataTables/js/vfs_fonts.js"></script>
    <script type="text/javascript" src="/assets/plugins/dataTables/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="/assets/plugins/dataTables/js/buttons.print.min.js"></script>


	<script type="text/javascript" src="/assets/plugins/jquery.mask/js/jquery.mask.js"></script>
	<script type="text/javascript" src="/assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.js"></script>
	<script type="text/javascript" src="/assets/plugins/bootstrap-checkbox/js/bootstrap-checkbox.js"></script>
	<script type="text/javascript" src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="/assets/plugins/js/typehead.js"></script>
	<script type="text/javascript" src="/assets/plugins/js/date.js"></script>
    @yield('view_js_link')
	<script type="text/javascript" src="/assets/js/app.js"></script>

    <style>
        @yield("view_css")
    </style>

</head>
<body>
    <div id="loader" class="loader">
        <span class="fa fa-circle-o-notch fa-spin"></span>
    </div>
    <!-- Main Article -->
    <article class="mam-ma clearfix">
        <h1 class="mam-mah">
        @yield('header')
        </h1>
        @yield('subheader')
        <div class="mam-content">
        @yield('content')
        </div>
    </article> <!-- // Main Article -->
	<script language="JavaScript">
        $('#ajaxMessage').hide();
        $( document ).ajaxStart(function() {
            $('#loader').show();

        });
        $( document ).ajaxComplete(function() {
            $('#loader').hide();
        });


        $(document).ready(function() {
            $(document).ready(function() {
                $('#dataList_filter').addClass('pull-right');

            });
        });


	</script>
    @yield('view_script')
	@yield('view_script_ext')

</body>
</html>

