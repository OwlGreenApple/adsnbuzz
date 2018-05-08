<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
     <!-- Link Icon -->
    <link rel='shortcut icon' type='image/png' href="{{ asset('icon.png') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('selectize/selectize.css') }}" rel="stylesheet">
    <link href="{{ asset('css/user_home.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-1.12.4.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('selectize/selectize.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    
   
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    @guest
                    @else
                        @if (Auth::user()->admin == 0) 
                            <!-- Left Side Of Navbar -->
                            <ul class="navbar-nav mr-auto">
                                <!-- Authentication Admin login redirect menu admin -->
                                <li>Rp. <?php echo number_format(Auth::user()->deposit) ?></li>

                            </ul>

                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                                <!-- Authentication Links -->
                                <li>
                                    <a class="nav-brand" href="{{ url('/') }}">
                                        <img src="{{ asset('logo.png') }}" style="position:relative; max-width: 60%; margin-bottom: 10px;">
                                    </a>     
                                </li>
                            </ul>
                        @else 
                            <!-- Left Side Of Navbar -->
                            <ul class="navbar-nav mr-auto">
                                <!-- Authentication Admin login redirect menu admin -->
                                <li><a href="{{ url('/confirm-admin') }}">Confirm Payment</a></li>
                                <li><a href="{{ url('/report') }}">Reports</a></li>
                                <li><a href="{{ url('/coupon') }}">Coupon</a></li>
                            </ul>

                            <!-- Right Side Of Navbar -->
                            <ul class="navbar-nav ml-auto">
                                <!-- Authentication Links -->
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        @endif
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @endguest
                </div>
        </nav>
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>
