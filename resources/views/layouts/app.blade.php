<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Conferentie Site</title>

    <!-- Fonts -->

    <!-- Styles -->
    <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.css">

    <!-- Bootstrap themes -->
    <link rel="stylesheet" href="http://bootswatch.com/paper/bootstrap.min.css">
    {{--<link rel="stylesheet" href="https://bootswatch.com/cyborg/bootstrap.min.css">--}}

    <link rel="stylesheet"
          href="/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css"/>

    <style>
        table.agenda-table > tbody > tr:last-child > td {
            border: none;
        }

        .slot {
            text-align: center;
        }
    </style>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token()]) ?>;
    </script>
</head>
<body>

<form style="display: none;" id="logout-form" action="{{ url('/logout') }}" method="post">
    {{ csrf_field() }}
    <input type="submit" value="Logout">
</form>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="{{Route::current()->uri() == '/' ? 'active' : ''}}">
                    <a href="/">Home <span class="sr-only">(current)</span></a>
                </li>

                <li class="{{Route::current()->uri() == 'agenda' ? 'active' : ''}}">
                    <a href="{{ url('/agenda') }}">Agenda</a>
                </li>

                <li class="{{Route::current()->uri() == 'reservation' ? 'active' : ''}}">
                    <a href="{{ url('/reservation') }}">Reserveren</a>
                </li>

                <li class="{{Route::current()->uri() == 'registration' ? 'active' : ''}}">
                    <a href="{{ url('/registration') }}">Inschrijven</a>
                </li>

                <li>
                    <form action="{{ url('search') }}" class="navbar-form navbar-left">
                        <input type="text" name="q" class="form-control" placeholder="Search">
                    </form>
                </li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                @if(\Auth::check())
                    <li class="{{Route::current()->uri() == 'tags' ? 'active' : ''}}">
                        <a href="{{ url('/tags') }}">Tags</a>
                    </li>
                    <li class="{{Route::current()->uri() == 'ticket-reservations' ? 'active' : ''}}">
                        <a href="{{ url('/ticket-reservations') }}">Reservaties</a>
                    </li>
                    <li class="{{Route::current()->uri() == 'open-registrations' ? 'active' : ''}}">
                        <a href="{{ url('/open-registrations') }}">Registraties</a>
                    </li>
                    <li class="{{Route::current()->uri() == 'conference-email' ? 'active' : ''}}">
                        <a href="{{ url('/conference-email') }}">Email</a>
                    </li>
                    <li>
                        <a href="#" onclick="$('#logout-form').submit();">Logout</a>
                    </li>
                @else
                    <li class="{{Route::current()->uri() == 'login' ? 'active' : ''}}">
                        <a href="{{ url('/login') }}">Login</a></li>
                @endif

            </ul>
        </div>
    </div>
</nav>

<div class="content-wrapper">
    @if (session('message'))
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-{!! session('message_type') !!} alert-dismissible" role="alert"
                         style="margin-bottom: 0; border-radius: 0;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <p>{!! session('message') !!}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @yield('content')
</div>

<!-- Scripts -->
<script src="/bower_components/jquery/dist/jquery.min.js"></script>
<script src="/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<script src="/bower_components/moment/moment.js"></script>
<script src="/bower_components/moment/locale/nl.js"></script>
<script src="/bower_components/eonasdan-bootstrap-datetimepicker/src/js/bootstrap-datetimepicker.js"></script>

@yield('scripts')

</body>
</html>
