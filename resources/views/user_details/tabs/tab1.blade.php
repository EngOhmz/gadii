<div class="tab-pane fade @if($type =='basic' || $type =='edit-basic') active show  @endif" id="tab1" role="tabpanel"
    aria-labelledby="tab1">
    <?php $id = 1; ?>
<div class="row">
                        <div class="col-lg-12 col-md-12">
    <div class="card">
        <div class="card-header">
            <h4>Basic Details</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if($type =='basic' || $type =='bank'  || $type =='salary' || $type =='notification')active show @endif" id="home-tab2" data-toggle="tab"
                        href="#home1" role="tab" aria-controls="home" aria-selected="true">Details
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if($type =='edit-basic') active show @endif" id="profile-tab2"
                        data-toggle="tab" href="#profile1" role="tab" aria-controls="profile" aria-selected="false">Edit
                        Details</a>
                </li>

            </ul>
            <div class="tab-content tab-bordered" id="myTab3Content">
                <div class="tab-pane fade @if($type =='basic' || $type =='bank'  || $type =='salary' || $type =='notification') active show @endif" id="home1" role="tabpanel"
                    aria-labelledby="home-tab2">
                    
                     <div class="table-responsive">
                                        <table class="table datatable-basic table-striped">
                                       
                                        <tbody>
                                           
                                          
                                          
                             <tr>
                       <td>Employee ID: </td><td>{{ !empty($basic_details) ? $basic_details->emp_id : ''}}</td>
<td>Date Of Birth: </td> <td >{{ !empty($basic_details) ? $basic_details->birth_date : ''}}</td>                                   
</tr>


                <tr>
                                    <td>Gender: </td><td >{{ !empty($basic_details) ? $basic_details->gender : ''}}</td>                                                                    
                                    <td>Marital Status: </td>  <td >{{ !empty($basic_details) ? $basic_details->marital_status : ''}}</td>                                  
                                </tr>
               
                                <tr>
                                    <td>Father Name: </td><td >{{ !empty($basic_details) ? $basic_details->father_name : ''}}</td>
                                    <td>Mother Name: </td><td>{{ !empty($basic_details) ? $basic_details->mother_name : ''}}</td>
                                </tr>
                                
                        
                             
                                <tr>
                                    <td>National ID/Passport: </td><td >{{ !empty($basic_details) ? $basic_details->national_id : ''}}</td>
                                    
                                </tr>

                                        </tbody>

                                    </table>
                        </div>
                    </div>
                
                <div class="tab-pane fade @if($type =='edit-basic') active show @endif" id="profile1"
                    role="tabpanel" aria-labelledby="profile-tab2">

                    <div class="card">
                        <div class="card-header">
                           
                            <h5>Edit Details</h5>
                         
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 ">
                                   
                                   
                                    
                                    {{ Form::open(['route' => 'details.store']) }}
                                    @method('POST')

                                  
                        <input type="hidden" value="basic" name="type">
                         <input type="hidden" value="{{$user_id}}" name="user_id">

                              <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Employee ID</label>
                                                    <div class="col-lg-4">
                                                      <input type="text" class="form-control" value="{{ !empty($basic_details) ? $basic_details->emp_id : ''}}" name="emp_id" >
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Date Of Birth</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" class="form-control" value="{{ !empty($basic_details) ? $basic_details->birth_date : ''}}" name="birth_date" required>
                                                    </div>
                                                </div>


                                     <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Gender</label>
                                                    <div class="col-lg-4">
                                                       <select class="form-control m-b" name="gender" required    id="gender">                                                           
                                                                <option value="">Select Gender</option>
                                                                <option @if(isset($basic_details))  {{ $basic_details->gender == 'Male'  ? 'selected' : ''}}    @endif value="Male">Male</option>
                                                              <option @if(isset($basic_details))  {{ $basic_details->gender == 'Female'  ? 'selected' : ''}}    @endif value="Female">Female</option>
                                                          </select>
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Marital Status</label>
                                                    <div class="col-lg-4">
                                                       <select class="form-control m-b" name="marital_status" required    id="marital_status">                                                           
                                                                <option value="">Select Marital Status</option>
                                                                    <option @if(isset($basic_details))  {{ $basic_details->marital_status == 'Single'  ? 'selected' : ''}}    @endif value="Single">Single</option>
                                                                <option @if(isset($basic_details))  {{ $basic_details->marital_status == 'Married'  ? 'selected' : ''}}    @endif value="Married">Married</option>
                                                              <option @if(isset($basic_details))  {{ $basic_details->marital_status == 'Divorced'  ? 'selected' : ''}}    @endif value="Divorced">Divorced</option>
                                                             <option @if(isset($basic_details))  {{ $basic_details->marital_status == 'Widowed'  ? 'selected' : ''}}    @endif value="Married">Married</option>
                                                             
                                                          </select>
                                                    </div>
                                                </div>


                                       <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Father's Name</label>
                                                    <div class="col-lg-4">
                                                      <input type="text" class="form-control"  value="{{ !empty($basic_details) ? $basic_details->father_name : ''}}" name="father_name" >
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Mother's Name</label>
                                                    <div class="col-lg-4">
                                                       <input type="text"  class="form-control" value="{{ !empty($basic_details) ? $basic_details->mother_name : ''}}" name="mother_name" >
                                                    </div>
                                                </div>


                                            <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">National ID/Passport</label>
                                                    <div class="col-lg-4">
                                                     <input type="text"  class="form-control" value="{{ !empty($basic_details) ? $basic_details->national_id : ''}}" name="national_id" required>
                                                    </div>
                                                   
                                                </div>

                        
                              
                         
                                
                     

                                    <div class="form-group row">
                                        <div class="col-lg-offset-2 col-lg-12">
                                            @if($type =='edit-preparation')
                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                data-toggle="modal" data-target="#myModal" type="submit">Update</button>
                                            @else
                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                type="submit">Save</button>
                                            @endif
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
 </div>
</div>
</div>