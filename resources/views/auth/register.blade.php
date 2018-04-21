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
    <style type="text/css">
        .balon {
            position: relative;
            top:50%;
            margin-top: -80px;
            max-width: 80%;
            height: auto;
        }
        .loginbox {
            position: relative;
            top :100px;
            top:50%;
            margin-top: -170px;
        }
        .fonthead {
            color:white;
            font-size: 20px;
            font-family: Arial;
            font-weight: bold;
        }
        .fontputih{
            color:white;
            font-family: Arial;
        }
        body {
            background-color: #cccccc;
            background-image:url('ads&buzz home image 60 ocp.jpg');/*your background image*/  
            background-repeat:no-repeat;/*we want to have one single image not a repeated one*/  
            background-size:cover;
        }
    </style>

</head>
<body>
    <!--img class="box" src="loginbox.png" align="right"/-->
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img class="balon" src="balon.png" />  
            </div>

            <div class="col-md-5 offset-md-1">
                <div class="card text-white bg-dark loginbox">
                    <div class="card-header fonthead" align="center">REGISTER</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group">
                                <label for="name" class="fontputih">Full Name</label>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="email" class="fontputih">E-mail</label>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

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
                                <label for="password-confirm" class="fontputih">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <div class="form-group">
                                <label class="fontputih"> Privileges </label>
                                <select class="form-control" name="admin">
                                    <option>--Pilih Hak Akses--</option>
                                    <option value="1">Admin</option>
                                    <option value="0">User</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="offset-md-3">
                                    <button type="submit" class="col-md-8 btn btn-primary fonthead"> Daftar </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</body>
</html>