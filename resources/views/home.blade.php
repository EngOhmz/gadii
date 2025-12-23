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

<style>
.required{
color:red;
}

</style>
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
<!--
                <li class="nav-item">
                    <a href="#" class="navbar-nav-link">
                        <i class="icon-lifebuoy"></i>
                        <span class="d-none d-lg-inline-block ml-2">Support</span>
                    </a>
                </li>
   <li class="nav-item">
                    <a href="#" class="navbar-nav-link">
                        <i class="icon-user-lock"></i>
                        <span class="d-none d-lg-inline-block ml-2">Register</span>
                    </a>
                </li>
-->
                <li class="nav-item">
                    <a  href="{{route('login')}}" class="navbar-nav-link">
                        <i class="icon-user-plus"></i>
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
                      <form method="POST" action="{{ route('users_details.store') }}" enctype="multipart/form-data">
                            @csrf
                                 <p> <span class="required"> * - Required Fields </span> </p>
                              <br>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="company_name">{{__('company.company_name')}} <span class="required"> * </span></label>
                                    <input id="company_name" type="text" class="form-control" name="company_name"
                                        autofocus required>
                                    @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="address">{{__('company.location')}} <span class="required"> * </span></label>
                                    <input id="address" type="text" class="form-control" name="address" required>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                            </div>
                            <div class="row">
                           <div class="form-group col-6">
                                    <label for="email">{{__('Phone Number')}} <span class="required"> * </span></label>
                                    <input id="text" type="text" class="form-control" name="phone" required>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="email">{{__('company.company_email')}}</label>
                                    <input id="email" type="email" class="form-control" name="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                               
                            </div>
                            <div class="row">
                              <div class="form-group col-6">
                                    <label for="email">{{__('company.tin')}}</label>
                                    <input id="tin" type="text" class="form-control" name="tin">
                                    @error('tin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="password" class="d-block">{{__('company.website')}}</label>
                                    <input id="password" type="text" class="form-control pwstrength"
                                        data-indicator="pwindicator" name="website">
                                    @error('website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <div id="pwindicator" class="pwindicator">
                                        <div class="bar"></div>
                                        <div class="label"></div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="password2" class="d-block">{{__('company.logo')}}</label>
                                    <input id="logo" type="file" class="form-control" name="picture">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    {{__('company.save')}}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
         
            @can('isWarehouse1')
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>{{__('company.title')}}</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users_details.store') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="company_name">{{__('company.company_name')}}<span class="required"> * </span></label>
                                    <input id="company_name" type="text" class="form-control" name="company_name"
                                        autofocus required>
                                    @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="address">{{__('company.location')}} <span class="required"> * </span></label>
                                    <input id="address" type="text" class="form-control" name="address" required>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="email">{{__('company.company_email')}}</label>
                                    <input id="email" type="email" class="form-control" name="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="email">{{__('company.tin')}}</label>
                                    <input id="tin" type="text" class="form-control" name="tin">
                                    @error('tin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="password" class="d-block">{{__('company.website')}}</label>
                                    <input id="password" type="text" class="form-control pwstrength"
                                        data-indicator="pwindicator" name="website">
                                    @error('website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <div id="pwindicator" class="pwindicator">
                                        <div class="bar"></div>
                                        <div class="label"></div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="password2" class="d-block">{{__('company.logo')}}</label>
                                    <input id="logo" type="file" class="form-control" name="files">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    {{__('company.save')}}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            @endcan
            @can('isFarmer1')
            <script type="text/javascript">
            window.location = "{{ url('home') }}";
            </script>
            @endcan
            @can('isCooperate')
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>{{__('company.title')}}</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users_details.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="company_name">{{__('company.company_name')}}<span class="required"> * </span></label>
                                    <input id="company_name" type="text" class="form-control" name="company_name"
                                        autofocus required>
                                    @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="address">{{__('company.location')}}<span class="required"> * </span></label>
                                    <input id="address" type="text" class="form-control" name="address" required>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="email">{{__('company.company_email')}}</label>
                                    <input id="email" type="email" class="form-control" name="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="email">{{__('company.tin')}}</label>
                                    <input id="tin" type="text" class="form-control" name="tin">
                                    @error('tin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="password" class="d-block">{{__('company.website')}}</label>
                                    <input id="password" type="text" class="form-control pwstrength"
                                        data-indicator="pwindicator" name="website">
                                    @error('website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <div id="pwindicator" class="pwindicator">
                                        <div class="bar"></div>
                                        <div class="label"></div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="password2" class="d-block">{{__('company.logo')}}</label>
                                    <input id="logo" type="file" class="form-control" name="picture">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    {{__('company.save')}}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            @endcan
            @can('isAgronomy1')
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>{{__('company.title')}}</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users_details.store') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="company_name">{{__('company.company_name')}}</label>
                                    <input id="company_name" type="text" class="form-control" name="company_name"
                                        autofocus required>
                                    @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="address">{{__('company.location')}}<span class="required"> * </span></label>
                                    <input id="address" type="text" class="form-control" name="address" required>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="email">{{__('company.company_email')}}</label>
                                    <input id="email" type="email" class="form-control" name="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="email">{{__('company.tin')}}</label>
                                    <input id="tin" type="text" class="form-control" name="tin">
                                    @error('tin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="password" class="d-block">{{__('company.website')}}</label>
                                    <input id="password" type="text" class="form-control pwstrength"
                                        data-indicator="pwindicator" name="website">
                                    @error('website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <div id="pwindicator" class="pwindicator">
                                        <div class="bar"></div>
                                        <div class="label"></div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="password2" class="d-block">{{__('company.logo')}}</label>
                                    <input id="logo" type="file" class="form-control" name="files">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    {{__('company.save')}}
                                </button>
                            </div>
                   </form>
                    </div>

                </div>
            </div>
            @endcan
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