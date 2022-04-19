
<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Time Track</title>

    <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ url('assets/css/animate.css') }}" rel="stylesheet">
    <link href="{{ url('assets/css/style.css') }}" rel="stylesheet">

</head>

<body class="gray-bg d-flex align-items-center">

    <div class="middle-box text-center loginscreen animated fadeInDown" style="padding-top: 0;">
            <div>
                <h3 style="font-size: 40px;">Login</h3>
            </div>
            @if($errors->has('error'))
                <p class="text-danger">{{ $errors->first('error') }}</p>
            @endif
            <form class="m-t" role="form" action="{{ route('login') }}" method="post">
                @csrf
                <div class="form-group">
                    <input type="text" autocomplete="off" id="username" name="username" class="form-control" placeholder="User Name">
                    @if($errors->has('username'))
                        <p class="text-danger">{{ $errors->first('username') }}</p>
                    @endif
                </div>
                <div class="form-group">
                    <input type="password" autocomplete="off" id="password" name="password" class="form-control" placeholder="Password">
                    @if($errors->has('password'))
                        <p class="text-danger">{{ $errors->first('password') }}</p>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">Login</button>
            </form>
    </div>

    <!-- Mainly scripts -->
    <script src="{{ url('assets/js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ url('assets/js/popper.min.js') }}"></script>
    <script src="{{ url('assets/js/bootstrap.js') }}"></script>
</body>

</html>
