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
    <script src="asset('global_assets/js/main/jquery.min.js') }}"></script>
    <script src="asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ asset('assets2/js/app.js') }}"></script>
    <!-- /theme JS files -->

    <!-- Global stylesheets -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
    <link href="{{ asset('global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
   
    <link href="{{ asset('assets2/css/datepicker.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.dateTime.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dataTables.dateTime.min.css') }}">
        <link href="{{ asset('assets/login/css/style.css') }}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}">
    <!-- Core JS files -->

    <script src="{{ asset('global_assets/js/main/jquery.min.js') }}"></script>
    <script src="{{ asset('global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/all.js') }}"></script>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>


    <style>
        .card {
            box-shadow: 0px 4px 8px 0px #BDBDBD;
        }

        .owl-nav .owl-prev,
        .owl-nav .owl-next {
            position: absolute;
            top: 15%;
            left: -3%;
            transform: translate(0, -50%);
        }

        .owl-nav .owl-next {
            left: auto;
            right: -3%;
        }

        .owl-carousel .owl-nav button.owl-next,
        .owl-carousel .owl-nav button.owl-prev {
            background: 0 0;
            color: #1E88E5 !important;
            border: none;
            padding: 5px 20px !important;
            font: inherit;
            font-size: 50px !important;

        }

        .owl-carousel .owl-nav button.owl-next:hover,
        .owl-carousel .owl-nav button.owl-prev:hover {
            color: #0D47A1 !important;
            background-color: transparent !important;
        }

        .owl-dots {
            display: none;
        }

        button:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            outline-width: 0;
        }

        .item {
            display: none;
        }

        .next {
            display: block !important;
            position: relative;
            transform: scale(0.8);
            transition-duration: 0.3s;
            opacity: 0.6;
        }

        .prev {
            display: block !important;
            position: relative;
            transform: scale(0.8);
            transition-duration: 0.3s;
            opacity: 0.6;
        }

        .item.show {
            display: block;
            transition-duration: 0.4s;
        }

        @media screen and (max-width: 999px) {

            .next,
            .prev {
                transform: scale(1);
                opacity: 1;
            }

            .item {
                display: block !important;
            }
        }
    </style>



</head>

<body>

@php

// Create the function, so you can use it
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
@endphp

     <section class="vh-100 gradient-custom">

    <!-- Page content -->

    
        <div class="page-content">
        
                    <div class="row justify-content-center">
                                 <div class="col-md-6 text-center mb-5"><br>
                					<h2 class="heading-section"><img width="150px" src="{{asset('assets/login/emasuite_logo.png')}}"/></h2>
                				</div>
                            </div>

            <!-- Main content -->
            <div class="content-wrapper">
            

            

                <!-- Inner content -->
                <div class="content-inner">

                    <!-- Content area -->
                    <div class="content d-flex justify-content-center align-items-center">

                        <div class="container-fluid px-3 px-sm-5 my-5 text-center">
                            <h4 class="mb-5 font-weight-bold">Roles & Features</h4>
                            <div class="owl-carousel owl-theme">
                            
                            {{-- If the user is on a mobile device, redirect them--}}
                                @if(isMobile())
                                
                                <div class="item first prev">
                                    <div class="card border-0 py-4 px-4">
                                    <h6 class="mb-3 mt-2">{{ $first->slug }}</h6>
                                        <p>{!! $first->notes !!}</p>
                                        
                                        
                                    </div>
                                </div>
                                  @foreach ($role as $rl)
                                <div class="item show">
                                    <div class="card border-0 py-3 px-4">
                                        <h6 class="mb-3 mt-2">{{ $rl->slug }}</h6>
                                            <p>{!! $rl->notes !!}</p>
                                        
                                    </div>
                                </div>
                                  @endforeach
                               
                                    <div class="item next">
                                        <div class="card border-0 py-3 px-4">

                                        <h6 class="mb-3 mt-2">{{ $last->slug }}</h6>
                                        <p>{!! $last->notes !!}</p>
                                           
                                        </div>
                                    </div>
                               
                                <div class="item last">
                                    <div class="card border-0 py-3 px-4">
                                    <h6 class="mb-3 mt-2">{{ $prev->slug }}</h6>
                                        <p>{!! $prev->notes !!}</p>
                                       
                                    </div>
                                
                                
                                @else
                            
                                <div class="item first prev">
                                    <div class="card border-0 py-4 px-4">
                                        <h6 class="mb-3 mt-2">{{ $prev->slug }}</h6>
                                        <p>{!! $prev->notes !!}</p>
                                    </div>
                                </div>
                                <div class="item show">
                                    <div class="card border-0 py-3 px-4">

                                        <h6 class="mb-3 mt-2">{{ $first->slug }}</h6>
                                        <p>{!! $first->notes !!}</p>
                                    </div>
                                </div>

                                @foreach ($role as $rl)
                                    <div class="item next">
                                        <div class="card border-0 py-3 px-4">

                                            <h6 class="mb-3 mt-2">{{ $rl->slug }}</h6>
                                            <p>{!! $rl->notes !!}</p>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="item last">
                                    <div class="card border-0 py-3 px-4">

                                        <h6 class="mb-3 mt-2">{{ $last->slug }}</h6>
                                        <p>{!! $last->notes !!}</p>
                                    </div>
                                    
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /content area -->


       

                </div>
                <!-- /inner content -->

            </div>
            <!-- /main content -->
        </div>
    </div>
    <!-- /page content -->
</section>

    <script>
        $(document).ready(function() {

            $('.owl-carousel').owlCarousel({
                mouseDrag: false,
                loop: true,
                margin: 2,
                nav: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 3
                    }
                }
            });

            $('.owl-prev').click(function() {
                $active = $('.owl-item .item.show');
                $('.owl-item .item.show').removeClass('show');
                $('.owl-item .item').removeClass('next');
                $('.owl-item .item').removeClass('prev');
                $active.addClass('next');
                if ($active.is('.first')) {
                    $('.owl-item .last').addClass('show');
                    $('.first').addClass('next');
                    $('.owl-item .last').parent().prev().children('.item').addClass('prev');
                } else {
                    $active.parent().prev().children('.item').addClass('show');
                    if ($active.parent().prev().children('.item').is('.first')) {
                        $('.owl-item .last').addClass('prev');
                    } else {
                        $('.owl-item .show').parent().prev().children('.item').addClass('prev');
                    }
                }
            });

            $('.owl-next').click(function() {
                $active = $('.owl-item .item.show');
                $('.owl-item .item.show').removeClass('show');
                $('.owl-item .item').removeClass('next');
                $('.owl-item .item').removeClass('prev');
                $active.addClass('prev');
                if ($active.is('.last')) {
                    $('.owl-item .first').addClass('show');
                    $('.owl-item .first').parent().next().children('.item').addClass('prev');
                } else {
                    $active.parent().next().children('.item').addClass('show');
                    if ($active.parent().next().children('.item').is('.last')) {
                        $('.owl-item .first').addClass('next');
                    } else {
                        $('.owl-item .show').parent().next().children('.item').addClass('next');
                    }
                }
            });

        });
    </script>

</body>

</html>
