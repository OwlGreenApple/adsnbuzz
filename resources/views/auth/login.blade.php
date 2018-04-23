<!DOCTYPE html>
<html>
<head>
    <title>Halaman Login</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <!-- Link Icon -->
    <link rel='shortcut icon' type='image/png' href='icon.png'>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/loginregis.css') }}" rel="stylesheet">

</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img class="balon" src="balon.png" />  
            </div>

            <div class="col-md-6">
                <div class="card bg-dark loginbox">
                    <div class="card-header fonthead" align="center">LOGIN</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group">
                                <label for="email" class="fontputih">E-mail</label>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password" class="fontputih">Password</label>
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <a href="{{ route('password.request') }}" class="fontputih">
                                    Forgot Password?
                                </a>
                            </div>

                            <div class="form-group">
                                <div align="center">
                                    <button type="submit" class="col-md-6 btn btn-primary fonthead"> Masuk </button>
                                </div>
                            </div>

                            <div class="form-group" align="center">
                                 <p class="fontputih">or <a href="{{ route('register') }}" class="fontreg">Register Now</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</body>
</html>