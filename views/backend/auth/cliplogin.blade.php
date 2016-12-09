<!DOCTYPE html>
<!--[if IE 8]>
<html class="ie8 no-js" lang="en">
<![endif]-->
<!--[if IE 9]>
<html class="ie9 no-js" lang="en">
<![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
    <!--<![endif]-->
    <!-- start: HEAD -->
    <head>
        <title>Grace Management Login</title>
        <!-- start: META -->
        <meta charset="utf-8" />
        <!--[if IE]>
        <meta http-equiv='X-UA-Compatible' content="IE=edge,IE=9,IE=8,chrome=1" />
        <![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta content="" name="description" />
        <meta content="Phillip Madsen" name="author" />
        <!-- end: META -->
        <!-- start: MAIN CSS -->
        @include('backend.layout.partials.default-styles')
        <!--[if IE 7]>
        <link rel="stylesheet" href="{!! asset('/clip/assets/plugins/font-awesome/css/font-awesome-ie7.min.css') !!}">
        <![endif]-->
        <!-- end: MAIN CSS -->
        <!-- start: CSS REQUIRED FOR THIS PAGE ONLY -->
        <!-- end: CSS REQUIRED FOR THIS PAGE ONLY -->
        <script type="text/javascript" src="{!! asset('/assets/js/jquery/jquery.min.js') !!}"></script>
    </head>
    <body class="login example1">
        <div class="main-login col-sm-4 col-sm-offset-4">
            <div class="logo">GRACE<i class="clip-clip"></i>ADMIN</div>
            <!-- start: LOGIN BOX -->
            <div class="box-login">
                @yield('login-content')
            </div>
            <!-- end: LOGIN BOX -->
            <!-- start: FORGOT BOX -->
            <div class="box-forgot">
                @yield('forgot-content')
            </div>
            <!-- end: FORGOT BOX -->
            <!-- start: REGISTER BOX -->
            <div class="box-register">
                @yield('register-content')
            </div>
            <!-- end: REGISTER BOX -->
            <!-- start: COPYRIGHT -->
            <div class="copyright">
                2016 &copy; GraceAdmin by Phillip Madsen.
            </div>
            <!-- end: COPYRIGHT -->
        </div>
        @include('backend.layout.partials.default-scripts')
        <!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
        <script src="{!! asset('/clip/assets/plugins/jquery-validation/dist/jquery.validate.min.js') !!}"></script>
        <script src="{!! asset('/clip/assets/js/login.js') !!}"></script>
        <!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
        <script>
            jQuery(document).ready(function() {
                Main.init();
                @yield('inline')
                Login.init();
            });

            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
    <!-- end: BODY -->
</html>
