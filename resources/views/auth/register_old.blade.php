<!DOCTYPE html>
<html lang="en">
<?php
$settings= App\Models\System::first();
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EMASUITE by Ujuzinet</title>

    <!-- Core JS files -->
    <script src="asset('global_assets/js/main/jquery.min.js') }}"></script>
    <script src="asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{asset('assets2/js/app.js') }}"></script>
    <!-- /theme JS files -->

<!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{asset('global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets2/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('assets2/css/datepicker.min.css')}}" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="{{asset('assets/css/dataTables.dateTime.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/dataTables.dateTime.min.css')}}">
    <!-- /global stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
    <!-- Core JS files -->
  
<script src="{{asset('global_assets/js/main/jquery.min.js')}}"></script>
	<script src="{{asset('global_assets/js/main/bootstrap.bundle.min.js')}}"></script>

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
              <li class="nav-item">
                    <a  href="{{route('tracking')}}" class="navbar-nav-link">
                        <i class="icon-package"></i>
                        <span class="d-none d-lg-inline-block ml-2">Courier Tracking</span>
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
                    <form class="register-form" method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="card mb-0">
                            <div class="card-body">
                                <div class="text-center mb-3">
         
                                    <h5 class="mb-0">Register</h5>
                                    <span class="d-block text-muted">Enter your credentials below</span>
                                </div>

                                <div class="row">
                                <div class="form-group col-6">
                                    <label for="name">Full Name</label>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" name="name" autofocus required>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="address">Address</label>
                                    <input id="address" type="text"
                                        class="form-control @error('address') is-invalid @enderror"
                                        value="{{ old('address') }}" name="address" required>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label for="email">Email</label>
                                    <input id="email" type="email"
                                        class="form-control emailfind @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}" name="email" required>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-12 row"> <div align="center"> <p class="form-control-static errors2" id="errors" style="text-align:center;color:red;"></p> </div>  </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="phone">Phone</label>
                                    <input id="phone" type="phone"
                                        class="form-control phonefind @error('phone') is-invalid @enderror"
                                        value="{{ old('phone') }}" name="phone" required>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <div class="form-group col-12 row"> <div align="center"> <p class="form-control-static errors23" id="errors" style="text-align:center;color:red;"></p> </div>  </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="address">Register As</label>
                                    <?php
                                       $roles = App\Models\Role::where('status',1)->orderBy('slug','asc')->get();
                                    ?>

                                    <select class="form-control m-b @error('register_as') is-invalid @enderror" name="register_as" id="register_as" required>
                                         <option value="">Select</option>
                                        @foreach($roles as $row)
                                        
                                            <option value="{{$row->id}}">
                                                {{ $row->slug }}
                                            </option>
                                            
                                            @endforeach
                                    </select>
                                    @error('register_as')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    
                                    <small><a href="{{ url('view_features') }}" target="_blank">View System Features</a></small>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="password" class="d-block">Password</label>
                                    <input id="password" type="password"
                                        class="form-control pwstrength @error('password') is-invalid @enderror""
                                        data-indicator=" pwindicator" name="password" required>
                                    @error('password')
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
                                    <label for="password2" class="d-block">Password Confirmation</label>
                                    <input id="password2" type="password" class="form-control"
                                        value="{{ old('password_confirmation') }}" name="password_confirmation" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="agree" class="custom-control-input" required
                                        id="agree" required>
                                    <label class="custom-control-label" for="agree">I agree with the terms and
                                        conditions</label>
                                </div>
                            </div>

                                <div class="form-group">
                                 <button   type="submit" class="btn btn-primary btn-lg btn-block"  id="saveProduce">
                                    Register
                                </button>
                                </div>

                             <div class="mb-4 text-muted text-center">
                        Already Registered? <a href="{{route('login')}}">Login</a>
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
                            &copy; <?php echo date('Y'); ?> <a href="#">EMASUITE</a> by <a
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

  <script src="{{asset('assets/js/select2.min.js')}}"></script>
   
    <script>
        $(document).ready(function(){
            /*
                         * Multiple drop down select
                         */
            $('.m-b').select2({ width: '100%', });



        });
    </script>
    
    <script>
    $(document).ready(function() {
    
       $(document).on('change', '.phonefind', function() {
            var id = $(this).val();

    console.log(id);
            $.ajax({
                url: '{{url("register/phonefind")}}',
                type: "GET",
                data: {
                    id: id,
                },
                dataType: "json",
                success: function(data) {
                  console.log(data);
                 $('.errors23').empty();
                $("#saveProduce").attr("disabled", false);
                 if (data != '') {
                $('.errors23').append(data);
               $("#saveProduce").attr("disabled", true);
    } else {
      
    }
                
           
                }
    
            });
    
        });
    
    
    
    });
    </script>
    
    
    <script>
    $(document).ready(function() {
    
       $(document).on('change', '.emailfind', function() {
            var id = $(this).val();

    console.log(id);
            $.ajax({
                url: '{{url("register/emailfind")}}',
                type: "GET",
                data: {
                    id: id,
                },
                dataType: "json",
                success: function(data) {
                  console.log(data);
                 $('.errors2').empty();
                $("#saveProduce").attr("disabled", false);
                 if (data != '') {
                $('.errors2').append(data);
               $("#saveProduce").attr("disabled", true);
    } else {
      
    }
                
           
                }
    
            });
    
        });
    
    
    
    });
    </script>

</body>

</html>