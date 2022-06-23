@extends('layouts.master')



@section('content')
<section class="section">
    <div class="section-body">
        @include('layouts.alerts.message')
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit User</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">

                            <a href="{{route('users.index')}}" class="btn btn-secondary btn-xs px-4">
                                <i class="fa fa-arrow-alt-circle-left"></i>
                                Back
                            </a>


                        </ul><br>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                @foreach($user as $users)
            {{ Form::model($users, array('route' => array('users.update', $users->id), 'method' => 'PUT')) }}
            <div class="ibox-content p-0 px-3 pt-2">
                <div class="row">
                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                        <label class="control-label">Full Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="{{$users->name}}">
                    </div>
                 
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">User Name</label>
                        <input type="text" class="form-control" name="email" id="email" value="{{$users->email}}">
                    </div>
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">Address</label>
                         <input type="text" class="form-control" name="address" id="address" value="{{ $users->address}}">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">Phone Number</label>
                        <input type="phone" class="form-control" name="phone" id="phone" value="{{$users->phone}}">
                    </div>
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="">Role </label>
                        <select class="form-control" name="role" >
                            <option value="" disabled selected>Choose option</option>
                            @if(isset($role))
                            @foreach($role as $roles)
                            <option value="@if(isset($users))
                                                            {{ $users->role == $roles->id  ? 'selected' : ''}}
                                                            @endif  {{$roles->id}}">{{$roles->slug}}</option>
                            @endforeach
                            @endif
                        </select>
                    </div>
                </div>

       <div class="row">
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">Department</label>
                        <select  id="department_id" name="department_id" class="form-control department">
                                      <option ="">Select Department</option>
                                      @if(!empty($department))
                                                        @foreach($department as $row)

                                                        <option @if(isset($users))
                                                            {{ $users->department_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                    </div>

 @if(!empty($users->designation_id))
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="">Designation </label>
                        <select id="designation_id" name="designation_id" class="form-control designation">
                                      <option>Select Designation</option>
                           @if(!empty($designation))
                                                        @foreach($designation as $row)

                                                        <option @if(isset($users))
                                                            {{ $users->designation_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                        </select>
                    </div>
             @else
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="">Designation </label>
                        <select id="designation_id" name="designation_id" class="form-control designation">
                                      <option>Select Designation</option>                         
                        </select>
                    </div>
             @endif

                </div>
            </div>
            <div class="ibox-footer">
                <div class="row justify-content-end mr-1">
                    {!! Form::submit('Save', ['class' => 'btn btn-sm btn-info px-5']) !!}
                </div>
            </div>
            {!! Form::close() !!}
            @endforeach
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

<script>
$(document).ready(function() {

    $(document).on('change', '.department', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("findDepartment")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#designation_id").empty();
                $("#designation_id").append('<option value="">Select Designation</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#designation_id").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });






});
</script>
@endsection