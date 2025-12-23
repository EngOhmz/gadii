<!doctype html>
<html lang="en">
<?php
$settings= App\Models\System::first();
?>
<head>
    <title>GAD Industries ERP. </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
     <link href="{{ asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="css/style.css">
    <link href="{{ asset('assets/login/css/style.css') }}" rel="stylesheet" type="text/css">
    
    <script src="{{ asset('global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    
     <style>
.show_hide_password {
   
   
    position: absolute;
    top: 50px;
    right: 13px;
    float: right;
    cursor: pointer;
}
.icon-hide:before {
    content: "\ecae";
}

.icon-show:before {
    content: "\ecab";
}

</style>

</head>

<body>
    <section class="ftco-section">
        <div class="container">
            @if (!empty(Session::get('error')))
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


                <div class="bootstrap-growl alert alert-danger "
                    style="position:absolute;margin:0px;z-index:9999; top:20px;width:250px;right:20px">

                    <a class="close" data-dismiss="alert" href="#">&times;</a>
                    {{ Session::get('error') }}
                </div>
            @endif
            <script>
                $(".alert").delay(6000).slideUp(200, function() {
                    $(this).alert(close);
                });
            </script>
            <div class="row justify-content-center">
                 <div class="col-md-6 text-center mb-5">
					{{-- <h2 class="heading-section"><img width="150px" src="{{asset('assets/login/emasuite_logo.png')}}"/></h2> --}}
				</div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="text-wrap p-4 p-lg-5 text-center d-flex align-items-center order-md-last">
                            <div class="text w-100">
                                <h2>Welcome to GAD ERP</h2>
                                {{-- <p>Dont have an account?<a style="color:white" href="{{route('register')}}">    Create One</p>
                                <a href="{{route('register')}}" class="btn btn-white btn-outline-white">Sign Up</a> --}}
                            </div>
                        </div>
                        <div class="login-wrap p-4 p-lg-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h2 class="heading-section">Sign In</h2>
                                </div>
                                <div class="w-100">
                                    <p class="social-media d-flex justify-content-end">
                                        <a href="#"
                                            class="social-icon d-flex align-items-center justify-content-center"><span
                                                class="fa fa-facebook"></span></a>
                                        <a href="#"
                                            class="social-icon d-flex align-items-center justify-content-center"><span
                                                class="fa fa-twitter"></span></a>
                                        <a href="#"
                                            class="social-icon d-flex align-items-center justify-content-center"><span
                                                class="fa fa-instagram"></span></a>
                                    </p>
                                </div>
                            </div>
                            <form class="login-form" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group mb-3">
                                    <label class="label" for="name">Username</label>
                                    <input id="email" type="text" placeholder="Enter your email or phone number"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        tabindex="1" required autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label" for="password">Password</label>
                                    <input id="password" type="password" placeholder="Enter your password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        tabindex="2" required>
                                    <span class="icon-hide show_hide_password"></span>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control  submit px-3" 
                                    style="
                                    background: linear-gradient(135deg, #0d6efd 0%, #0d6efd 100%);
                                    background: -o-linear-gradient(315deg, #f75959 0%, #C9E0EE 100%);
                                    color:#fff"
                                    
                                    >Sign in</button>
                                </div>
                                <div class="form-group d-md-flex">
                                    <div class="w-50 text-left">
                                        {{--<label class="checkbox-wrap checkbox-primary mb-0">Remember Me
                                            <input type="checkbox" checked>
                                            <span class="checkmark"></span>
                                        </label>--}}
                                    </div>
                                    <div class="w-50 text-md-right">
                                        <a href="{{ url('forgetPassword') }}">Forgot password?</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('assets/login/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/login/js/popper.js') }}"></script>
    <script src="{{ asset('assets/login/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/login/js/main.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.show_hide_password').click(function() {
                var passwordField = $('#password');
                var passwordFieldType = passwordField.attr('type');
                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).removeClass('icon-hide');
                    $(this).addClass('icon-show');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).removeClass('icon-show');
                    $(this).addClass('icon-hide');
                }
            });
        });
    </script>

</body>

</html>
