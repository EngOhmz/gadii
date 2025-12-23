@extends('layouts.master')

@push('plugin-styles')
 <style>
.show_hide_password,.show_hide_password2 {
   
    position: absolute;
    top: 45px;
    right: 15px;
    float: right;
    cursor: pointer;
}
.icon-hide:before {
    content: "\ecae";
}

.icon-show:before {
    content: "\ecab";
}

</style>

@endpush


@section('content')
<section class="section">
    <div class="section-body">
        @include('layouts.alerts.message')
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                 <div class="card-header header-elements-sm-inline">
								<h4 class="card-title"> Add User</h4>
								<div class="header-elements">
								   
                             
                     <a href="{{route('users.index')}}" class="btn btn-secondary btn-xs px-4">
                                <i class="fa fa-arrow-alt-circle-left"></i>
                                Back
                            </a>
									
				                	</div>
			                	
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
                        <label class="control-label">Full Name</label>
                        <input type="text" class="form-control" name="name" id="nname" value="{{ old('name')}}">
                        @error('name')
                        <p class="text-danger">. {{$message}}</p>
                        @enderror
                    </div>

                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">Joining Date</label>
                        <input required type="month"  value="{{ old('joining_date')}}"   class="form-control monthyear" name="joining_date" data-format="yyyy/mm/dd">
                    </div>
</div>


                <div class="row">
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">Username/Email</label>
                        <input type="text" class="form-control" name="email" id="email" value="{{ old('email')}}" required>
                        @error('email')
                        <p class="text-danger">. {{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">Address</label>
                        <input type="text" class="form-control" name="address" id="address" value="{{ old('address')}}">
                     
                        @error('address')
                        <p class="text-danger">. {{$message}}</p>
                        @enderror
                    </div>
                </div>
                 
                <div class="row">
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">Phone Number</label><br>
                        <input type="tel" class="form-control" name="phone_number" id="phone" value="{{ old('phone')}}">
                        <span id="valid-msg" class="hide"></span>
                        <span id="error-msg" class="hide"></span>
                        
                        @error('phone')
                        <p class="text-danger">. {{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="">Role </label>
                        <select class="form-control m-b" name="role">
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
                        <label class="control-label">Department</label>
                        <select  id="department_id" name="department_id" class="form-control m-b department">
                                      <option value="">Select Department</option>
                                      @if(!empty($department))
                                                        @foreach($department as $row)

                                                        <option value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                    </div>


                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="">Designation </label>
                        <select id="designation_id" name="designation_id" class="form-control m-b designation">
                                      <option value="">Select Designation</option>                         
                        </select>
                    </div>
            
                </div>


                <div class="row">
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                          <span class="icon-hide show_hide_password"></span>
                        @error('password')
                        <p class="text-danger">. {{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group col-lg-6 col-md-12 col-sm-12">
                        <label class="control-label">Confirm Password</label>
                        <input type="password" class="form-control" name="comfirmpassword" id="comfirmpassword">
                          <span class="icon-hide show_hide_password2"></span>
                    </div>
                </div>
            </div>
            <div class="ibox-footer">
                <div class="row justify-content-end mr-1">
                    {!! Form::submit('Save', ['class' => 'btn btn-sm btn-info px-5','id' => 'save']) !!}
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

<script>
$(document).ready(function() {

    $(document).on('change', '.department', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("access_control/findDepartment")}}',
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

<script>
var input = document.querySelector("#phone"),
    errorMsg = document.querySelector("#error-msg"),
    validMsg = document.querySelector("#valid-msg");

// Error messages based on the code returned from getValidationError
var errorMap = [ "Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];



// Initialise plugin
var intl = window.intlTelInput(input, {
    separateDialCode: true,
    initialCountry: "auto",
    hiddenInput: "phone",
    geoIpLookup: function(success, failure) {
        $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
            var countryCode = (resp && resp.country) ? resp.country : "";
            success(countryCode);
        });
    },
    
    
    utilsScript: '{{url("assets/intl/js/utils.js")}}'
});

var reset = function() {
    input.classList.remove("error");
    errorMsg.innerHTML = "";
    errorMsg.classList.add("hide");
    validMsg.classList.add("hide");
};

// Validate on blur event
input.addEventListener('blur', function() {
    reset();
     $("#save").attr("disabled", false);
    if(input.value.trim()){
        if(intl.isValidNumber()){
            validMsg.classList.remove("hide");
        }else{
            input.classList.add("error");
            var errorCode = intl.getValidationError();
            errorMsg.innerHTML = errorMap[errorCode];
            errorMsg.classList.remove("hide");
             $("#save").attr("disabled", true);
        }
    }
});

// Reset on keyup/change event
input.addEventListener('change', reset);
input.addEventListener('keyup', reset);




</script>

    <script>
        $(document).ready(function() {
            $('.show_hide_password').click(function() {
                var passwordField = $('#password');
                var passwordFieldType = passwordField.attr('type');
                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).removeClass('icon-hide');
                    $(this).addClass('icon-show');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).removeClass('icon-show');
                    $(this).addClass('icon-hide');
                }
            });
            
            $('.show_hide_password2').click(function() {
                var passwordField = $('#comfirmpassword');
                var passwordFieldType = passwordField.attr('type');
                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).removeClass('icon-hide');
                    $(this).addClass('icon-show');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).removeClass('icon-show');
                    $(this).addClass('icon-hide');
                }
            });
            
            
        });
    </script>




@endsection