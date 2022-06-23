<div class="tab-pane fade @if($type =='basic' || $type =='edit-basic') active show  @endif" id="tab1" role="tabpanel"
    aria-labelledby="tab1">
    <?php $id = 1; ?>
    <div class="card">
        <div class="card-header">
            <h4>Basic Details</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if($type =='basic')active show @endif" id="home-tab2" data-toggle="tab"
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
                <div class="tab-pane fade @if($type =='basic') active show @endif" id="home1" role="tabpanel"
                    aria-labelledby="home-tab2">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <table>
                                <tr>
                                    <td>Emp ID: </td>
                                    <td colspan="1">{{ !empty($basic_details) ? $basic_details->emp_id : ''}}</td>
                                </tr>
                                <tr>
                                    <td>User Name: </td>
                                    <td colspan="1">{{ !empty($basic_details) ? $basic_details->user_name : ''}}</td>
                                </tr>
                                <tr>
                                    <td>Joining Date: </td>
                                    <td colspan="1">{{ !empty($basic_details) ? $basic_details->join_date : ''}}</td>
                                </tr>
                                <tr>
                                    <td>Date Of Birth: </td>
                                    <td colspan="1">{{ !empty($basic_details) ? $basic_details->birth_date : ''}}</td>
                                </tr>
                                <tr>
                                    <td>Father Name: </td>
                                    <td colspan="1">{{ !empty($basic_details) ? $basic_details->father_name : ''}}</td>
                                </tr>
                                <tr>
                                    <td>Email: </td>
                                    <td colspan="1">{{ !empty($basic_details) ? $basic_details->email : ''}}</td>
                                </tr>
                                <tr>
                                    <td>Mobile: </td>
                                    <td colspan="1">{{ !empty($basic_details) ? $basic_details->mobile : ''}}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <table>
                                <tr>
                                    <td>Full Name: </td>
                                    <td colspan="1">{{ !empty($basic_details) ? $basic_details->full_name : ''}}</td>
                                </tr>
                                <tr>
                                    <td>Password: </td>
                                    <td colspan="1">{{ !empty($basic_details) ? $basic_details->password : ''}}</td>
                                </tr>
                                <tr>
                                    <td>Gender: </td>
                                    <td colspan="1">{{ !empty($basic_details) ? $basic_details->gender : ''}}</td>
                                </tr>
                                <tr>
                                    <td>Marital Status: </td>
                                    <td colspan="1">{{ !empty($basic_details) ? $basic_details->marital_status : ''}}</td>
                                </tr>
                                <tr>
                                    <td>Mother Name: </td>
                                    <td colspan="1">{{ !empty($basic_details) ? $basic_details->mother_name : ''}}</td>
                                </tr>
                                <tr>
                                    <td>Phone: </td>
                                    <td colspan="1">{{ !empty($basic_details) ? $basic_details->phone : ''}}</td>
                                </tr>
                                <tr>
                                    <td>National ID/Pasport: </td>
                                    <td colspan="1">{{ !empty($basic_details) ? $basic_details->national_id : ''}}</td>
                                </tr>
                            </table>
                        </div>
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
                                   
                                   
                                    
                                    {{ Form::open(['route' => 'user_details.store']) }}
                                    @method('POST')

                                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                        <input type="hidden" value="basic" name="type">
                            <table>
                                <tr>
                                    <td>Emp ID: </td>
                                    <td colspan="1"><input type="text" value="{{ !empty($basic_details) ? $basic_details->emp_id : ''}}" name="emp_id" ></td>
                                </tr>
                                <tr>
                                    <td>User Name: </td>
                                    <td colspan="1"><input type="text" value="{{ !empty($basic_details) ? $basic_details->user_name : ''}}" name="user_name" ></td>
                                </tr>
                                <tr>
                                    <td>Joining Date: </td>
                                    <td colspan="1"><input type="date" value="{{ !empty($basic_details) ? $basic_details->join_date : ''}}" name="join_date" ></td>
                                </tr>
                                <tr>
                                    <td>Date Of Birth: </td>
                                    <td colspan="1"><input type="date" value="{{ !empty($basic_details) ? $basic_details->birth_date : ''}}" name="birth_date" ></td>
                                </tr>
                                <tr>
                                    <td>Father Name: </td>
                                    <td colspan="1"><input type="text" value="{{ !empty($basic_details) ? $basic_details->father_name : ''}}" name="father_name" ></td>
                                </tr>
                                <tr>
                                    <td>Email: </td>
                                    <td colspan="1"><input type="email" value="{{ !empty($basic_details) ? $basic_details->email : ''}}" name="email" ></td>
                                </tr>
                                <tr>
                                    <td>Mobile: </td>
                                    <td colspan="1"><input type="phone" value="{{ !empty($basic_details) ? $basic_details->mobile : ''}}" name="mobile" ></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <table>
                                <tr>
                                    <td>Full Name: </td>
                                    <td colspan="1"><input type="text" value="{{ !empty($basic_details) ? $basic_details->full_name : ''}}" name="full_name" ></td>
                                </tr>
                              
                                <tr>
                                    <td>Gender: </td>
                                    <td colspan="1"><input type="text" value="{{ !empty($basic_details) ? $basic_details->gender : ''}}" name="gender" ></td>
                                </tr>
                                <tr>
                                    <td>Marital Status: </td>
                                    <td colspan="1"><input type="text" value="{{ !empty($basic_details) ? $basic_details->marital_status : ''}}" name="marital_status" ></td>
                                </tr>
                                <tr>
                                    <td>Mother Name: </td>
                                    <td colspan="1"><input type="text" value="{{ !empty($basic_details) ? $basic_details->mother_name : ''}}" name="mother_name" ></td>
                                </tr>
                                <tr>
                                    <td>Phone: </td>
                                    <td colspan="1"><input type="text" value="{{ !empty($basic_details) ? $basic_details->phone : ''}}" name="phone" ></td>
                                </tr>
                                <tr>
                                    <td>National ID/Pasport: </td>
                                    <td colspan="1"><input type="text" value="{{ !empty($basic_details) ? $basic_details->national_id : ''}}" name="national_id" ></td>
                                </tr>
                            </table>
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