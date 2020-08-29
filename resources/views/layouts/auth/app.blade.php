<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>{{ config('app.name') }}</title>
    
    <link rel="shortcut icon" href="{{asset('assets/img/favicon.ico')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{url('')}}">
    <link rel="stylesheet" href="{{url('adminlte2/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('adminlte2/bower_components/font-awesome/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{url('adminlte2/bower_components/Ionicons/css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{url('adminlte2/dist/css/AdminLTE.min.css')}}">
    <link rel="stylesheet" href="{{url('adminlte2/plugins/iCheck/square/blue.css')}}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="#">
          <img src="{{url('assets/img/logo.png')}}" alt="" width="120px">
        </a>
      </div>
      @yield('content')
    </div>

    <script src="{{url('adminlte2/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{url('adminlte2/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{url('adminlte2/plugins/iCheck/icheck.min.js')}}"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%'
        });
      });
    </script>
  </body>
</html>
