<!DOCTYPE html>
<html lang="en">
<?php
$settings = App\Models\System::first();
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>EMASUITE by Ujuzinet</title>



    <!-- Core JS files -->
    <script src="{{ asset('global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->




    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/select2.min.css') }}">
    <link href="{{ asset('assets2/css/datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.dateTime.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.dateTime.min.css') }}">
    <!-- /global stylesheets -->

    <link href="{{ asset('assets/login/css/style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/intl/css/intlTelInput.css') }}">

    <!-- Core JS files -->

    <script src="{{ asset('assets/js/all.js') }}"></script>

    <!-- /core JS files -->

    <style>
        #error-msg {
            color: #EA4335;
        }

        #valid-msg {
            color: #34A853;
        }

        .show_hide_password,
        .show_hide_password2 {

            position: absolute;
            top: 52px;
            right: 28px;
            float: right;
            cursor: pointer;
        }

        .icon-hide:before {
            content: "\ecae";
        }

        .icon-show:before {
            content: "\ecab";
        }

        .required {
            color: red;
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
                            <h2 class="heading-section"><img width="150px"
                                    src="{{ asset('assets/login/emasuite_logo.png') }}" /></h2>
                        </div>
                    </div>
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-6 text-center mb-5">
                                    <h2 class="heading-section">Register</h2>
                                </div>
                            </div>
                            <form class="register-form" method="POST" action="{{ route('register') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-4">

                                        <div class="form-outline">
                                            <label for="name">Company Name <span class="required"> * </span></label>
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" name="name" autofocus required>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4">

                                        <div class="form-outline">
                                            <label for="address">Address <span class="required"> * </span></label>
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
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4 d-flex align-items-center">

                                        <div class="form-outline datepicker w-100">
                                            <label for="email">Email <span class="required"> * </span></label>
                                            <input id="email" type="email"
                                                class="form-control emailfind @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" name="email" required>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div class="form-group col-12 row">
                                                <div align="center">
                                                    <p class="form-control-static errors2" id="errors"
                                                        style="text-align:center;color:red;"></p>

                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6 mb-4 pb-2">

                                        <div class="form-outline"><br>
                                            <label for="phone">Phone <span class="required"> * </span></label>
                                            <input id="phone" type="phone"
                                                class="form-control phonefind @error('phone') is-invalid @enderror"
                                                value="{{ old('phone') }}" name="phone_number" required>

                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            <div class="form-group col-12 row">
                                                <div align="center">
                                                    <p class="form-control-static errors23" id="errors"
                                                        style="text-align:center;color:red;"></p>

                                                    <span id="valid-msg" class="hide"></span>
                                                    <span id="error-msg" class="hide"></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>


                                <div class="row">


                                    <div class="col-md-6 mb-4 pb-2">

                                        <div class="form-outline" <label for="phone">Company TIN</label>
                                            <input id="tin" type="text" class="form-control"
                                                name="tin">
                                            @error('tin')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4 pb-2">

                                        <div class="form-outline">
                                            <label for="vat">Company VRN</label>
                                            <input id="vat" type="text" class="form-control"
                                                name="vat">
                                            @error('tin')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>
                                    </div>

                                </div>


                                <div class="row">

                                    <div class="col-md-6 mb-4 pb-2">
                                        <div class="form-outline">
                                            <label for="phone">Company Logo </label>
                                            <input id="logo" type="file" class="form-control" name="picture"
                                                onchange="loadBigFile(event)">

                                            @error('picture')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                            <img id="big_output" width="100">

                                        </div>

                                    </div>

                                    <div class="col-md-6 mb-4 pb-2">

                                        <?php
                                        $currency = App\Models\Currency::all();
                                        ?>

                                        <div class="form-outline datepicker w-100">
                                            <label for="email">Default Currency <span class="required"> *
                                                </span></label>
                                            <select class="form-control m-b" id="currency" name="currency" required>
                                                <option value="">Select Currency</option>

                                                @foreach ($currency as $cur)
                                                    <option value="{{ $cur->code }}">{{ $cur->name }}</option>
                                                @endforeach

                                            </select>
                                            @error('currency')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror


                                        </div>

                                    </div>



                                </div>





                                <div class="row">
                                    <div class="col-md-6 mb-4 pb-2">

                                        <div class="form-outline">
                                            <label for="password" class="d-block">Password <span class="required"> *
                                                </span></label>
                                            <input id="password" type="password"
                                                class="form-control pwstrength @error('password') is-invalid @enderror"
                                                data-indicator=" pwindicator" name="password" required>
                                            <span class="icon-hide show_hide_password"></span>
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

                                    </div>
                                    <div class="col-md-6 mb-4 pb-2">

                                        <label for="password2" class="d-block">Confirm Password <span
                                                class="required"> * </span></label>
                                        <input id="password2" type="password" class="form-control"
                                            value="{{ old('password_confirmation') }}" name="password_confirmation"
                                            required>
                                        <span class="icon-hide show_hide_password2"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4 pb-2">
                                        <div class="form-outline">
                                            <label for="reference_no">Affiliate Number</label>
                                            <input id="reference_no" type="text" class="form-control" name="reference_no">
                                            @error('reference_no')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4 pb-2">

                                        <div class="form-outline">
                                            <label for="address">Register As <span class="required"> *
                                                </span></label>
                                            <?php
                                            $roles = App\Models\Role::where('status', 1)->orderBy('slug', 'asc')->get();
                                            ?>

                                            <select
                                                class="form-control m-b register @error('register_as') is-invalid @enderror"
                                                name="register_as" id="register_as" required>
                                                <option value="">Select</option>
                                                @foreach ($roles as $row)
                                                    <option value="{{ $row->id }}">{{ $row->slug }}</option>
                                                @endforeach
                                            </select>

                                            <small><a href="{{ url('view_features') }}" target="_blank"
                                                    style="color:#5D94E5;font-size:15px">View System
                                                    Features</a></small>&nbsp&nbsp&nbsp&nbsp

                                            @error('register_as')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror

                                        </div>

                                    </div>
                                </div>




                                <div class="row ">
                                    <div class="col-md-8 mb-4 pb-2">
                                        <div class="form-outline">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="agree" class="custom-control-input"
                                                    required id="agree" required>
                                                <label class="custom-control-label" for="agree">I agree with the
                                                    terms
                                                    and
                                                    conditions</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>





                                <div class="row" style="margin:0 auto;">
                                    <div class="col-md-12 mb-8 pb-4">
                                        <div class="form-outline">
                                            <button type="submit" class="btn btn-success btn-lg btn-block save"
                                                id="saveProduce">
                                                Register
                                            </button>


                                            <span>
                                                <div class="text-job text-muted"> Already Registered? <a
                                                        href="{{ route('login') }}">Login</a>
                                                </div>
                                            </span>

                                        </div>
                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('assets/intl/js/intlTelInput.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            /*
             * Multiple drop down select
             */
            $('.m-b').select2({
                theme: "classic"
            });



        });
    </script>




    <script>
        $(document).ready(function() {

            $(document).on('change', '.phonefind', function() {
                var id = $(this).val();

                console.log(id);
                $.ajax({
                    url: '{{ url('register/phonefind') }}',
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
                    url: '{{ url('register/emailfind') }}',
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

    <script>
        var input = document.querySelector("#phone"),
            errorMsg = document.querySelector("#error-msg"),
            validMsg = document.querySelector("#valid-msg");

        // Error messages based on the code returned from getValidationError
        var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];



        // Initialise plugin
        var intl = window.intlTelInput(input, {
            separateDialCode: true,
            initialCountry: "auto",
            hiddenInput: "phone",
            geoIpLookup: function(success, failure) {
                $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    success(countryCode);
                });
            },


            utilsScript: '{{ url('assets/intl/js/utils.js') }}'
        });

        var reset = function() {
            input.classList.remove("error");
            errorMsg.innerHTML = "";
            errorMsg.classList.add("hide");
            validMsg.classList.add("hide");
        };

        // Validate on blur event
        input.addEventListener('blur', function() {
            reset();
            $('.save').attr("disabled", false);
            if (input.value.trim()) {
                if (intl.isValidNumber()) {
                    validMsg.classList.remove("hide");
                } else {
                    input.classList.add("error");
                    var errorCode = intl.getValidationError();
                    errorMsg.innerHTML = errorMap[errorCode];
                    errorMsg.classList.remove("hide");
                    console.log(23);
                    $('.save').attr("disabled", true);
                }
            }
        });

        // Reset on keyup/change event
        input.addEventListener('change', reset);
        input.addEventListener('keyup', reset);
    </script>

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

            $('.show_hide_password2').click(function() {
                var passwordField = $('#password2');
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

    <script>
        var loadBigFile = function(event) {
            var output = document.getElementById('big_output');
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>


</body>

</html>

