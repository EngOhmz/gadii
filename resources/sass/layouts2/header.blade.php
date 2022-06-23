<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
<?php
$settings= App\Models\System::first();
?>
  <title>{{ !empty($settings->name) ? $settings->name: ''}}</title>
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('assets/css/app.min.css')}}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/components.css')}}">
  <link rel="stylesheet" href="{{asset('assets/bundles/prism/prism.css')}}">
  <link rel="stylesheet" href="{{asset('assets/bundles/select2/dist/css/select2.min.css')}}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
  <link rel='shortcut icon' type='image/x-icon' href="{{url('public/assets/img/logo')}}/{{$settings->picture}}" />

  <link rel="stylesheet" href="{{asset('assets/bundles/datatables/datatables.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/bundles/jquery-selectric/selectric.css')}}">
  
  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.css') }}">

  
  <link rel="stylesheet" href="{{asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/css/tom-select.css" rel="stylesheet">

  <link rel="stylesheet" href="{{asset('assets/css/dataTables.dateTime.css')}}">
<link rel="stylesheet" href="{{asset('assets/css/dataTables.dateTime.min.css')}}">

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/js/tom-select.complete.min.js"></script>
    @laravelPWA
</head>