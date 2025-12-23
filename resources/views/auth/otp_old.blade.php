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

<style>
	.show_hide_password {
		font-size: 20px;
		color: #a7a7a7;
		position: absolute;
		top: 10px;
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

<body>



    <!-- Main navbar -->
    <div class="navbar navbar-expand-lg navbar-dark bg-indigo navbar-static">
        <div class="navbar-brand ml-2 ml-lg-0">
            <a href="" class="d-inline-block">
 
                <img src="{{url('public/assets/img/logo')}}/{{!empty($settings->picture) ? $settings->picture: ''}}" alt="">{{ !empty($settings->name) ? $settings->name: ''}}
            </a>
            
            
        </div>
    

        <div class="d-flex justify-content-end align-items-center ml-auto">
            <ul class="navbar-nav flex-row">

              
            </ul>
        </div>
    </div>
    <!-- /main navbar -->
	<div class="page-content">
		<!-- Main content -->
		<div class="content-wrapper">
			<div class="content-inner">
				<div class="content d-flex justify-content-center align-items-center">

					<!-- Login form -->
					<form class="login-form" method="POST" action="{{ route('update_user') }}">
						@csrf
						<div class="card mb-0">
							<div class="card-body">
								<div class="text-center mb-3">
									<h5 class="mb-0">Enter OTP number sent to your phone number</h5>
								</div>
								<div class="form-group">
									<input id="email" type="text"
										class="form-control text" name="number" placeholder="Enter Code" tabindex="1" required >
								<p class="form-control-static errors" id="errors" style="text-align:center;color:red;"></p>
								</div>
								<div class="form-group">
								 <button class="btn btn-primary btn-block" type="submit" id="save" style="display:none;">Send</button>
						
								</div>
							</div>
						</div>
				    </div>
				</form>
			</div>
			
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

<script>
 $(document).ready(function() {


        $(document).on('change', '.text', function() {
            var id = $(this).val();
            
            $.ajax({
                url: '{{ url('verify_otp') }}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                   $('.errors').empty();
                        $("#save").hide();
                        if (data != '') {
                            $('.errors').append(data);
                            $("#save").hide();
                        } else {
                          $("#save").show();
                        }


                }

            });

        });


        });
</script>

</html>