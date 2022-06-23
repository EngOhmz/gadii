@extends('layouts.master')

@section('content')

  <section class="section">
    <div class="section-body">
      <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
          <!-- alert -->
          @if(Session::get('messagev'))
          <div class="alert alert-success alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>×</span>
              </button>
              {{Session::get('messagev')}}
            </div>
          </div>
          @endif
          @if(Session::get('messager')))
          <div class="alert alert-danger alert-dismissible show fade">
            <div class="alert-body">
              <button class="close" data-dismiss="alert">
                <span>×</span>
              </button>
              {{Session::get('messager')}}
            </div>
          </div>
           @endif

          <!-- end of alert -->
          <div class="card">
            <div class="card-header">
              <h4>Farmer Management</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 col-sm-12 col-lg-2 col-xl-2 col-md-2">
                  <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                     <li class="nav-item">
                      <a class="nav-link  active" id="profile-tab4" data-toggle="tab" href="#profile4" role="tab" aria-controls="profile" aria-selected="true">Manage Farmer</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="home-tab4" data-toggle="tab" href="#home4" role="tab" aria-controls="home" aria-selected="false">Register </a>
                    </li>
                   
                    <li class="nav-item">
                      <a class="nav-link" id="contact-tab4" data-toggle="tab" href="#contact4" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
                    </li>
                  </ul>
                </div>
                
                <div class="col-12 col-sm-12 col-lg-10 col-xl-10 col-md-10">
                  <div class="tab-content no-padding" id="myTab2Content">
                    <div class="tab-pane fade" id="home4" role="tabpanel" aria-labelledby="home-tab4">
                      <div class="card">
                        <div class="card-header">
                          <h4></h4>
                        </div>
                        <div class="card-body p-0">
                    {!! Form::open(['action'=>'MemberController@store','class'=>'form-group', 'method'=>'post']) !!}
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-6 col-lg-6">
                        {{Form::label('FirstName')}}
                        {{Form::text('firstname','',['class'=>'form-control','placeholder'=>''])}}
                        @error('firstname')
                            <div class="text-danger">{{$message }}</div>
                             @enderror
                    </div>
                            <div class="col-md-6">
                           {{Form::label('LastName')}}
                           {{Form::text('lastname','kulwa',['class'=>'form-control','placeholder'=>''])}}
                            @error('lastname')
                            <div class="text-danger">{{$message }}</div>
                             @enderror
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                        {{Form::label('select region')}}
                        {{Form::select('region',['L' => 'Large', 'S' => 'Small'],'S',['class'=>'form-control','placeholder'=>''])}}
                       
                    </div>
                            <div class="col-md-6">
                           {{Form::label('true name')}}
                           {{form::text('price','',['class'=>'form-control','placeholder'=>'1000'])}}
                            @error('price')
                            <div class="text-danger">{{$message }}</div>
                             @enderror
                    </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            {{form::submit('submit',['class'=>'btn btn-success form-control'])}}
                            @error('price')
                            <div class="text-danger">{{$message }}</div>
                             @enderror
                        </div>
                    </div>
                    {!! Form::close() !!}
                    


                    


                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
    </div>
  </section>
@endsection