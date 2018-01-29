<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="icon" type="image/png" href="../assets/img/log.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Sekretariat</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/paper-kit.css?v=2.0.1') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/demo.css') }}" rel="stylesheet">

    <!--     Fonts and icons     -->
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,300,700' rel='stylesheet' type='text/css'>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet">

</head>
<body>
    <nav class="navbar navbar-toggleable-md fixed-top navbar-transparent" color-on-scroll="300">
        <div class="container">
            <div class="navbar-translate">
                <button class="navbar-toggler navbar-toggler-right navbar-burger" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-bar"></span>
                    <span class="navbar-toggler-bar"></span>
                    <span class="navbar-toggler-bar"></span>
                </button>
                <a class="navbar-brand" href="http://inka.co.id" target="_blank">
                    <img border="0" alt="" src="../assets/img/cropped-logo3.png" width="50%" height="50%">
                </a>
            </div>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        @if (Auth::check())
                            {{-- <a href="{{ url('/home') }}" class="nav-link"><i class="nc-icon nc-bank"></i> Home</a> --}}
                            <a href="{{ url('/home') }}" class="btn btn-purple btn-round">Home</a>
                        @else
                            {{-- <a href="{{ url('/login') }}" class="nav-link"><i class="nc-icon nc-circle-10"></i> Login</a> --}}
                            <a href="{{ url('/login') }}" class="btn btn-purple btn-round">Login</a>
                            {{-- <a href="{{ url('/register') }}">Register</a> --}}
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </nav>

        <div class="page-header" data-parallax="true" style="background-image: url('../assets/img/laptop-computer-pxhere.com(convert).jpg');">
            <div class="filter"></div>
            <div class="container">
                <div class="motto text-center">
                    <h1 style="font-size: 60pt; font-weight: bold;">Sekretariat</h1>
                    <h3>PT Industri Kereta Api (Persero)</h3>
                    <!-- <br />
                    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="btn btn-outline-neutral btn-round"><i class="fa fa-play"></i>Watch video</a>
                    <button type="button" class="btn btn-outline-neutral btn-round">Download</button> -->
                </div>
            </div>
        </div>
</body>

<!-- Core JS Files -->
<script src="{{ asset('assets/js/jquery-3.2.1.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/jquery-ui-1.12.1.custom.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/tether.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>

<!--  Paper Kit Initialization snd functons -->
<script src="{{ asset('assets/js/paper-kit.js?v=2.0.1') }}"></script>

</html>