<!doctype html>
<html lang="en">

<head>
    <style>
        .circle-green {
            width: 220px;
            height: 220px;
            background-color: transparent;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 5px solid rgba(52, 255, 2, 255);
            box-shadow: 0px 5px 10px 0px rgba(0, 0, 0, 0.5);
        }

        .auth-body-bg {
            background-size: 20%;
        }
    </style>

    <meta charset="utf-8" />
    <title>Login | Promedplanet </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Promedplanet Inventory System" name="promedplanet" />
    <meta content="Promedplanet" name="Aymenelkor" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">
    <!-- Bootstrap Css -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

</head>

<body class="auth-body-bg">
    <div class="bg-overlay"></div>
    <div class="wrapper-page">
        <div class="container-fluid p-0 ">
            <div class="card bg-transparent">
                <div class="card-body">

                    <div class="text-center mt-4">
                        <div class="mb-3 mx-auto" style="max-width: 500px;">
                            <div class="circle-green mx-auto">
                                <a href="javascript:void(0)" class="auth-logo">
                                    <img src="{{ asset('backend/assets/images/logo.png') }}" height="100" class="logo-dark mx-auto" alt="">
                                </a>
                            </div>
                        </div>

                    </div>
                    <h3 class="text-center " style="color: rgb(86,229,43);">PROMED PLANET</h3>
                    <div class="px-3">
                        <form class="form-horizontal mt-3" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control @error('username') is-invalid @enderror" id="username" name="username" type="text" required="" placeholder="Username">
                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control @error('password') is-invalid @enderror" id="password" name="password" type="password" required="" placeholder="Password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3 text-center row mt-3 pt-1">
                                <div class="col-12">
                                    <button class="btn btn-success w-100 waves-effect waves-light" type="submit" style="background-color: rgba(52,255,2,255);">Log In</button>
                                </div>
                            </div>

                            <div class="form-group mb-0 row mt-2">
                                <div class="col-sm-7 mt-3">
                                    <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock" style="color: rgba(52,255,2,255);"></i> <span style="color: rgba(52,255,2,255);"> Forgot your password?</span></a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end -->
                </div>
                <!-- end cardbody -->
            </div>
            <!-- end card -->
        </div>
        <!-- end container -->
    </div>
    <!-- end -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type','info') }}"
        switch (type) {
            case 'info':
                toastr.info(" {{ Session::get('message') }} ");
                break;

            case 'success':
                toastr.success(" {{ Session::get('message') }} ");
                break;

            case 'warning':
                toastr.warning(" {{ Session::get('message') }} ");
                break;

            case 'error':
                toastr.error(" {{ Session::get('message') }} ");
                break;
        }
        @endif
    </script>

</body>

</html>