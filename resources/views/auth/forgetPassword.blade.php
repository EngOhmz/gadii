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
    <script src="{{asset('global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->
    
    


<!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{asset('global_assets/css/icons/icomoon/styles.min.css')}}" rel="stylesheet" type="text/css">
 <link rel="stylesheet" href="{{asset('assets/css/select2.min.css')}}">
    <link href="{{asset('assets2/css/datepicker.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.dateTime.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/dataTables.dateTime.min.css')}}">
    <!-- /global stylesheets -->
  
    <link href="{{ asset('assets/login/css/style.css') }}" rel="stylesheet" type="text/css">
     <link rel="stylesheet" href="{{ asset('assets/intl/css/intlTelInput.css') }}">
    
     <!-- Core JS files -->

   <script src="{{ asset('assets/js/all.js') }}"></script>

    <!-- /core JS files -->
    
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

</head>

<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="">
                 <div class="row justify-content-center">
                                 <div class="col-md-6 text-center mb-5">
                					<h2 class="heading-section"><img width="150px" src="{{asset('assets/login/emasuite_logo.png')}}"/></h2>
                				</div>
                            </div>
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-8 text-center mb-5">
                                    <h5>Forgot Password</h5>
                                </div>
                            </div>
                            
                        <form class="login-form" method="POST" action="{{ route('get_otp') }}">
						@csrf

								<div class="text-center mb-3">
								EMASUITE will need to verify your account.<br>Please Enter your Email  or Phone Number.
								</div>
								<div class="form-group">
									<input id="email" type="text"
										class="form-control text" name="email" placeholder="Enter your Email  or Phone Number." tabindex="1" required >
										
										 <p class="form-control-static errors" id="errors" style="text-align:center;color:red;"></p>
								</div>
								<div class="form-group">
								 <button class="btn btn-primary btn-block" type="submit" id="save" style="display:none;">Send</button>
						        
								</div>
								
								<br><br>
								 <span><div class="text-job text-muted"><a class="list-icons-item text-primary" href="{{route('login')}}">  <i class="icon-arrow-left7"></i> Back to Login Page</a></div></span>
							</div>
					
                                
                          
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
   <script>
 $(document).ready(function() {


        $(document).on('change', '.text', function() {
            var id = $(this).val();
            
            $.ajax({
                url: '{{ url('verify_user') }}',
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


</body>

</html>
