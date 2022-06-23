<!DOCTYPE html>
<html lang="en">

  @include('layouts.header')

  <body>
    <div class="loader"></div>
    <div id="app">
      <div class="main-wrapper main-wrapper-1">
      
        @include('layouts.top')

      @include('layouts.aside')
      
       <!-- Main Content -->
      <div class="main-content">
         @include('layouts.alerts.message')
        @yield('content')
        
        @include('layouts.setting')
       
      </div>
      @include('layouts.footer')
    </div>
</div>
@include('layouts.script')
@yield('scripts')
</body>


<!-- index.html  21 Nov 2019 03:47:04 GMT -->
</html>