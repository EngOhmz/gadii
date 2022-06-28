<!DOCTYPE html>
<html lang="en">
<?php
$settings= App\Models\System::first();
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EMA ERP - by Ujuzinet</title>

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
        type="text/css">
    <link href="asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets2/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="asset('global_assets/js/main/jquery.min.js') }}"></script>
    <script src="asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{asset('assets2/js/app.js') }}"></script>
    <!-- /theme JS files -->

</head>

<body>

    <!-- Main navbar -->
    <div class="navbar navbar-expand-lg navbar-dark bg-indigo navbar-static">
        <div class="navbar-brand ml-2 ml-lg-0">
            <a href="index.html" class="d-inline-block">
 
                <img src="{{url('public/assets/img/logo')}}/{{!empty($settings->picture) ? $settings->picture: ''}}" alt="">            {{ !empty($settings->name) ? $settings->name: ''}}
            </a>
        </div>

        <div class="d-flex justify-content-end align-items-center ml-auto">
            <ul class="navbar-nav flex-row">
                <li class="nav-item">
                    <a href="#" class="navbar-nav-link">
                        <i class="icon-lifebuoy"></i>
                        <span class="d-none d-lg-inline-block ml-2">Support</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="navbar-nav-link">
                        <i class="icon-user-plus"></i>
                        <span class="d-none d-lg-inline-block ml-2">Register</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="navbar-nav-link">
                        <i class="icon-user-lock"></i>
                        <span class="d-none d-lg-inline-block ml-2">Login</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- /main navbar -->


    <!-- Page content -->
    <div class="page-content">

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Inner content -->
            <div class="content-inner">

                <!-- Content area -->
                <div class="content d-flex justify-content-center align-items-center">

                    <!-- Login form -->
                    <form class="login-form" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="text-center mb-3">
         
                                    <h5 class="mb-0">Login</h5>
                                    <span class="d-block text-muted">Enter your credentials below</span>
                                </div>

                                <div class="form-group form-group-feedback form-group-feedback-left">
                                    <input id="email" type="text"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        tabindex="1" required autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <div class="form-control-feedback">
                                        <i class="icon-user text-muted"></i>
                                    </div>
                                </div>

                                <div class="form-group form-group-feedback form-group-feedback-left">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        tabindex="2" required>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <div class="form-control-feedback">
                                        <i class="icon-lock2 text-muted"></i>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Sign in</button>
                                </div>

                                <div class="text-center">
                                    <a href="login_password_recover.html">Forgot password?</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /login form -->

                </div>
                <!-- /content area -->


                <!-- Footer -->
                <div class="navbar navbar-expand-lg navbar-light">
                    <div class="text-center d-lg-none w-100">
                        <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse"
                            data-target="#navbar-footer">
                            <i class="icon-unfold mr-2"></i>
                            Footer
                        </button>
                    </div>

                    <div class="navbar-collapse collapse" id="navbar-footer">
                        <span class="navbar-text">
                            &copy; <?php echo date('Y'); ?> <a href="#">EMA ERP</a> by <a
                                href="https://ema.co.tz/" target="_blank">Ujuzinet  Company Limited</a>
                        </span>

                        <ul class="navbar-nav ml-lg-auto">
                            <li class="nav-item"><a href="https://ema.co.tz/" class="navbar-nav-link"
                                    target="_blank"><i class="icon-lifebuoy mr-2"></i> Support</a></li>
                            <li class="nav-item"><a href="https://ema.co.tz/"
                                    class="navbar-nav-link" target="_blank"><i class="icon-file-text2 mr-2"></i>
                                    Docs</a></li>
                            <li class="nav-item"><a
                                    href="https://ema.co.tz/"
                                    class="navbar-nav-link font-weight-semibold"><span class="text-pink"><i
                                            class="icon-cart2 mr-2"></i> Purchase</span></a></li>
                        </ul>
                    </div>
                </div>
                <!-- /footer -->

            </div>
            <!-- /inner content -->

        </div>
        <!-- /main content -->

    </div>
    <!-- /page content -->

</body>

</html>