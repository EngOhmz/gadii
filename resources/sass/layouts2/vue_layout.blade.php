<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<?php
$settings= App\Models\System::first();
?>
  <title>{{ !empty($settings->name) ? $settings->name: ''}}</title>
  <link rel="stylesheet" href="{{ mix('css/app.css') }}" />
  
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('assets/css/app.min.css')}}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/components.css')}}">
  <link rel="stylesheet" href="{{asset('assets/bundles/prism/prism.css')}}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
  <link rel='shortcut icon' type='image/x-icon' href="{{url('public/assets/img/logo')}}/{{$settings->picture}}" />

  <link rel="stylesheet" href="{{asset('assets/bundles/datatables/datatables.min.css')}}">
  
  

  
  <link rel="stylesheet" href="{{asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
  
   {{-- <link href="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.0.0-rc.4/dist/js/tom-select.complete.min.js"></script> --}}
    @laravelPWA
        <meta name="viewport" content="width=device-width, initial-scale=1">

       
    </head>
    <body class="antialiased">
      <div id="app">
        <div class="loader"></div>
        <div id="teleport-target"></div>
        
          <div class="main-wrapper main-wrapper-1">
          
            @include('layouts.top')
    
          @include('layouts.aside')
          
           <!-- Main Content -->
          <div class="main-content">
            {{-- @include('layouts.alerts.message') --}}
            @yield('content')
            @include('layouts.setting')
          </div>
          @include('layouts.footer')
        </div>
    </div>
    </body>
    <script  src="{{ mix('js/app.js') }}" defer></script>
    @include('layouts.script')
    @yield('scripts')
</html>