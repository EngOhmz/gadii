@extends('errors.layouts')

@section('title') Not Found @endsection

@section('message')

<!-- Content area -->
<div class="content d-flex justify-content-center align-items-center">

    <!-- Container -->
    <div class="flex-fill">

        <!-- Error title -->
        <div class="text-center mb-4">
            <img src="{{ url('error_bg.svg') }}" class="img-fluid mb-3" height="230" alt="">
            <h1 class="display-3 fw-semibold lh-1 mb-3">404</h1>
            <h6 class="w-md-25 mx-md-auto">Oops, an error has occurred. <br> Page Not Found.</h6>
        </div>
        <!-- /error title -->


        <!-- Error content -->
        <div class="text-center">
            <a href="/" class="btn btn-primary">
                <i class="ph-house me-2"></i>
                Return to Home Page
            </a>
        </div>
        <!-- /error wrapper -->

    </div>
    <!-- /container -->

</div>
<!-- /content area -->

@endsection
