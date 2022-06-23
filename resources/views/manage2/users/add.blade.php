@extends('layouts.master')



@section('contents')
<section class="section">
    <div class="section-body">
        @include('layouts.alerts.message')
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Add User</h4>
                    </div>
                    <div class="card-body">

                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                {{ Form::open(['route' => 'users.store']) }}
            @method('POST')
            <div class="ibox-content p-0 px-3 pt-2">
                <div class="row">
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">First Name</label>
                        <input type="text" class="form-control" name="fname" id="fnname" value="{{ old('fname')}}">
                        @error('fname')
                        <p class="text-danger">. {{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">Last Name</label>
                        <input type="text" class="form-control" name="lname" id="lame" value="{{ old('lname')}}">
                        @error('lname')
                        <p class="text-danger">. {{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ old('email')}}">
                        @error('email')
                        <p class="text-danger">. {{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">Address</label>

                        <select class="form-control" name="address" required>
                            <option value="{{ old('address')}}" disabled selected>Choose option</option>
                            @foreach($region as $row)
                            <option value="{{ $row->name }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                        @error('address')
                        <p class="text-danger">. {{$message}}</p>
                        @enderror
                    </div>
                </div>
                 
                <div class="row">
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">Phone Number</label>
                        <input type="phone" class="form-control" name="phone" id="phone" value="{{ old('phone')}}">
                        @error('phone')
                        <p class="text-danger">. {{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="">Role </label>
                        <select class="form-control" name="role">
                            <option value="" disabled selected>Choose option</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->slug }}</option>
                            @endforeach
                        </select>
                        @error('role')
                        <p class="text-danger">. {{$message}}</p>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                        @error('password')
                        <p class="text-danger">. {{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">Comfirm Password</label>
                        <input type="password" class="form-control" name="comfirmpassword" id="comfirmpassword">
                    </div>
                </div>
            </div>
            <div class="ibox-footer">
                <div class="row justify-content-end mr-1">
                    {!! Form::submit('Save', ['class' => 'btn btn-sm btn-info px-5']) !!}
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
</section>


@endsection

@section('scripts')
<script>
$(document).on('click', '.edit_user_btn', function() {
    var id = $(this).data('id');
    var name = $(this).data('name');
    var slug = $(this).data('slug');
    var module = $(this).data('module');
    $('#id').val(id);
    $('#p-name_').val(name);
    $('#p-slug_').val(slug);
    $('#p-module_').val(module);
    $('#editPermissionModal').modal('show');
});
</script>
@endsection