@extends('layouts.main2')

@section('contents')
<div class="container">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-8">
                <?php
                    $settings= App\Models\System::first();
                    //$settings= App\Models\System::first()->where('added_by',auth()->user()->user_id);
                 ?>
               
               
            
                   <!-- <div class="card-body">
                        <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators2" data-slide-to="0" class=""></li>
                                <li data-target="#carouselExampleIndicators2" data-slide-to="1" class=""></li>
                                <li data-target="#carouselExampleIndicators2" data-slide-to="2" class="active"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="{{url('assets/img/blog/img04.jpg') }}"
                                        alt="First slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>Heading</h5>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua.</p>
                                    </div>
                                </div>
                                <div class="carousel-item">
                                    <img class="d-block w-100" src="{{url('assets/img/blog/img07.jpg') }}"
                                        alt="Second slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>Heading</h5>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua.</p>
                                    </div>
                                </div>
                                <div class="carousel-item active">
                                    <img class="d-block w-100" src="{{url('assets/img/blog/img06.jpg') }}"
                                        alt="Third slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>Heading</h5>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                            tempor incididunt ut labore et dolore magna aliqua.</p>
                                    </div>
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators2" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators2" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>!-->

           <!-- </div>!-->

            
              <!--  <div class="card">
                    <div class="card-header">
                        <h4>{{ !empty($settings->name) ? $settings->name: ''}}</h4>
                    </div>!-->
            
              <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-4 col-xl-8 offset-xl-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>{{ !empty($settings->name) ? $settings->name: ''}} Login</h4>
                    </div>
           
            <!--<div class="col-12 col-sm-8  col-md-6  col-lg-4">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Login</h4> 
              </div>!-->
              <div class="card-body">
              <form method="POST" action="{{ route('login') }}">
                @csrf
                  <div class="form-group">
                    <label for="email">User Name</label>
                    <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" tabindex="1" required autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                      <div class="float-right">
                        <a href="auth-forgot-password.html" class="text-small">
                          Forgot Password?
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" tabindex="2" required>
                    @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                  </div>
                  <!--
                          <div class="form-group ">
                                    <label for="address">Select Company</label>
                                    <?php
                                       $roles = App\Models\Role::all();
                                    ?>

                                    <select class="form-control @error('register_as') is-invalid @enderror"
                                        name="login_as" id="login_as">
                                          <option value="">Select Company</option>
                                        @foreach($roles as $row)
                                        @if(($row->id == 35))
                                            <option value="{{$row->id}}">
                                                {{ $row->slug }}
                                            </option>
                                            @endif
                                            @endforeach
                                    </select>
                                    @error('register_as')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                -->
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Login
                    </button>
                  </div>
                </form>
                <div class="text-center mt-4 mb-3">
                  <div class="text-job text-muted"> Don't have an account? <a href="{{route('register')}}">Create One</a></div>
                </div>
               
              </div>  
            </div>
            
            </div>
        </div>
    </div>
</div>
@endsection