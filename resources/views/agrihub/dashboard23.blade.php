@extends('layouts.master24')

@section('content')

<section class="section">
<div class="section-body">
  <div class="row">
  
  <div class="col-12 col-md-12 col-lg-12">
  
  <div class="card">
            <div class="card-header">
              <h4>Please Enter Your Company Details</h4>
            </div>
            <div class="card-body">
  
  <!-- Login form -->
                      <form method="POST" action="{{ route('users_details.store') }}" enctype="multipart/form-data">
                            @csrf
                                 <p> <span class="required"> * - Required Fields </span> </p>
                              <br>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="company_name">{{__('company.company_name')}} <span class="required"> * </span></label>
                                    <input id="company_name" type="text" class="form-control" name="company_name"
                                        autofocus required>
                                    @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="address">{{__('company.location')}} <span class="required"> * </span></label>
                                    <input id="address" type="text" class="form-control" name="address" required>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                
                            </div>
                            <div class="row">
                             <div class="form-group col-6">
                                    <label for="email">{{__('company.company_email')}}</label>
                                    <input id="email" type="email" class="form-control" name="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                           <div class="form-group col-6">
                                    <label for="email">{{__('Phone Number')}} <span class="required"> * </span></label>
                                    <input id="text" type="text" class="form-control" name="phone" required>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                               
                               
                            </div>
                            <div class="row">
                              <div class="form-group col-6">
                                    <label for="email">Company {{__('company.tin')}}</label>
                                    <input id="tin" type="text" class="form-control" name="tin">
                                    @error('tin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="password" class="d-block">Company VRN</label>
                                    <input id="vat" type="text" class="form-control" name="vat">
                                    @error('vat')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="password2" class="d-block">{{__('company.logo')}}</label>
                                    <input id="logo" type="file" class="form-control" name="picture" onchange="loadBigFile(event)">
                                      @error('picture')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                            
                                    <img id="big_output" width="100">
                                </div>
                                <div class="form-group col-6">
                                    <label for="password2" class="d-block">Default Currency <span class="required"> * </span></label>
                                     <select class="form-control m-b" id="currency" name="currency" required>
                                                    <option value="">Select Currency</option>  
                                                      
                                                      @foreach($currency as $cur)
                                                      <option value="{{$cur->code}}">{{$cur->name}}</option>
                                                       @endforeach
                                                      
                                                        </select>

                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    {{__('company.save')}}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
         
            @can('isWarehouse1')
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>{{__('company.title')}}</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users_details.store') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="company_name">{{__('company.company_name')}}<span class="required"> * </span></label>
                                    <input id="company_name" type="text" class="form-control" name="company_name"
                                        autofocus required>
                                    @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="address">{{__('company.location')}} <span class="required"> * </span></label>
                                    <input id="address" type="text" class="form-control" name="address" required>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="email">{{__('company.company_email')}}</label>
                                    <input id="email" type="email" class="form-control" name="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="email">{{__('company.tin')}}</label>
                                    <input id="tin" type="text" class="form-control" name="tin">
                                    @error('tin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="password" class="d-block">{{__('company.website')}}</label>
                                    <input id="password" type="text" class="form-control pwstrength"
                                        data-indicator="pwindicator" name="website">
                                    @error('website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <div id="pwindicator" class="pwindicator">
                                        <div class="bar"></div>
                                        <div class="label"></div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="password2" class="d-block">{{__('company.logo')}}</label>
                                    <input id="logo" type="file" class="form-control" name="files">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    {{__('company.save')}}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            @endcan
            @can('isFarmer1')
            <script type="text/javascript">
            window.location = "{{ url('home') }}";
            </script>
            @endcan
            @can('isCooperate')
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>{{__('company.title')}}</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users_details.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="company_name">{{__('company.company_name')}}<span class="required"> * </span></label>
                                    <input id="company_name" type="text" class="form-control" name="company_name"
                                        autofocus required>
                                    @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="address">{{__('company.location')}}<span class="required"> * </span></label>
                                    <input id="address" type="text" class="form-control" name="address" required>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="email">{{__('company.company_email')}}</label>
                                    <input id="email" type="email" class="form-control" name="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="email">{{__('company.tin')}}</label>
                                    <input id="tin" type="text" class="form-control" name="tin">
                                    @error('tin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="password" class="d-block">{{__('company.website')}}</label>
                                    <input id="password" type="text" class="form-control pwstrength"
                                        data-indicator="pwindicator" name="website">
                                    @error('website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <div id="pwindicator" class="pwindicator">
                                        <div class="bar"></div>
                                        <div class="label"></div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="password2" class="d-block">{{__('company.logo')}}</label>
                                    <input id="logo" type="file" class="form-control" name="picture">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    {{__('company.save')}}
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            @endcan
            @can('isAgronomy1')
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>{{__('company.title')}}</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('users_details.store') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="company_name">{{__('company.company_name')}}</label>
                                    <input id="company_name" type="text" class="form-control" name="company_name"
                                        autofocus required>
                                    @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="address">{{__('company.location')}}<span class="required"> * </span></label>
                                    <input id="address" type="text" class="form-control" name="address" required>
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="email">{{__('company.company_email')}}</label>
                                    <input id="email" type="email" class="form-control" name="email">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="email">{{__('company.tin')}}</label>
                                    <input id="tin" type="text" class="form-control" name="tin">
                                    @error('tin')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="password" class="d-block">{{__('company.website')}}</label>
                                    <input id="password" type="text" class="form-control pwstrength"
                                        data-indicator="pwindicator" name="website">
                                    @error('website')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <div id="pwindicator" class="pwindicator">
                                        <div class="bar"></div>
                                        <div class="label"></div>
                                    </div>
                                </div>
                                <div class="form-group col-6">
                                    <label for="password2" class="d-block">{{__('company.logo')}}</label>
                                    <input id="logo" type="file" class="form-control" name="files">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    {{__('company.save')}}
                                </button>
                            </div>
                   </form>
                    </div>

                </div>
            </div>
            @endcan
                    <!-- /login form -->
  
  
  
  
  </div>
   </div>

    </div>
    
    </div>

    </div>

</section>  

<script src="{{url('assets/js/jquery.bootstrap-growl.min.js')}}"></script>
   <script src="{{ asset('assets/amcharts/amcharts.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/amcharts/serial.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/amcharts/pie.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/amcharts/themes/light.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('assets/amcharts/plugins/export/export.min.js') }}"
            type="text/javascript"></script>
            
            
                <script>
  var loadBigFile=function(event){
    var output=document.getElementById('big_output');
    output.src=URL.createObjectURL(event.target.files[0]);
  };
</script>

@endsection
  
  