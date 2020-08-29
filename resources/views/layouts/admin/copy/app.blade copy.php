<!-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{url('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{url('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('adminlte/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{url('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    @section('css')
    @show
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @include('layouts.admin.header')

        @yield('sidebar')
        

        <div class="content-wrapper">
            @yield('content')
        </div>
        @include('layouts.admin.footer')
    </div>

    <script src="{{url('adminlte/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{url('adminlte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{url('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{url('adminlte/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
    <script src="{{url('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <script src="{{url('adminlte/dist/js/adminlte.js')}}"></script>
    @section('js')
    @show
    <script>
        $(document).ready(function() {
            console.log('aa');
        });
    </script>
</body>

</html> -->

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{url('adminlte2/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('adminlte2/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{url('adminlte2/bower_components/Ionicons/css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{url('adminlte2/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{url('adminlte2/dist/css/skins/_all-skins.min.css')}}">
    <link rel="stylesheet" href="{{url('adminlte2/bower_components/morris.js/morris.css')}}">
    <link rel="stylesheet" href="{{url('adminlte2/bower_components/jvectormap/jquery-jvectormap.css')}}">
    <link rel="stylesheet" href="{{url('adminlte2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
    <link rel="stylesheet" href="{{url('adminlte2/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{url('adminlte2/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini fixed">
<div class="wrapper">

    @include('layouts.admin.header')
    @yield('sidebar')

    <div class="content-wrapper">
        @yield('content')
    </div>

    @include('layouts.admin.footer')
</div>

<script src="{{url('adminlte2/bower_components/jquery/dist/jquery.min.js')}}"></script>
<script src="{{url('adminlte2/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<script src="{{url('adminlte2/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{url('adminlte2/bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{url('adminlte2/bower_components/morris.js/morris.min.js')}}"></script>
<script src="{{url('adminlte2/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<script src="{{url('adminlte2/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{url('adminlte2/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<script src="{{url('adminlte2/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
<script src="{{url('adminlte2/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{url('adminlte2/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{url('adminlte2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{url('adminlte2/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<script src="{{url('adminlte2/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{url('adminlte2/bower_components/fastclick/lib/fastclick.js')}}"></script>
<script src="{{url('adminlte2/dist/js/adminlte.min.js')}}"></script>
<script src="{{url('adminlte2/dist/js/pages/dashboard.js')}}"></script>
<script src="{{url('adminlte2/dist/js/demo.js')}}"></script>
</body>
</html>