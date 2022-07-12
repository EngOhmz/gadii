@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container mt-5">
        <div class="row">
           
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
                                    <label for="company_name">{{__('company.company_name')}}==</label>
                                    <input id="company_name" type="text" class="form-control" name="company_name"
                                        autofocus>
                                    @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="address">{{__('company.location')}}</label>
                                    <input id="address" type="text" class="form-control" name="address">
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
                                    <label for="company_name">{{__('company.company_name')}}</label>
                                    <input id="company_name" type="text" class="form-control" name="company_name"
                                        autofocus>
                                    @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="address">{{__('company.location')}}</label>
                                    <input id="address" type="text" class="form-control" name="address">
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
                        <form method="POST" action="{{ route('users_details.store') }}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-6">
                                    <label for="company_name">{{__('company.company_name')}}</label>
                                    <input id="company_name" type="text" class="form-control" name="company_name"
                                        autofocus>
                                    @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="address">{{__('company.location')}}</label>
                                    <input id="address" type="text" class="form-control" name="address">
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
                                        autofocus>
                                    @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group col-6">
                                    <label for="address">{{__('company.location')}}</label>
                                    <input id="address" type="text" class="form-control" name="address">
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



        </div>
    </div>
</div>
@endsection