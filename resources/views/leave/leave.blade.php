@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Leave</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                         
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Leave
                                    List</a>
                            </li>
                           
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Leave</a>
                            </li>
                           

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                               
                                   <table class="table datatable-basic table-striped" id="table-1">
                                        <thead>
                                            <tr>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 28.484px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Staff Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Leave Category</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Duration</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Status</th>


                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($leave))
                                            @foreach ($leave as $row)
                                            <tr class="gradeA even" role="row">

                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>{{$row->staff->name}}</td>
                                                <td>{{$row->category->leave_category}}</td>

                                                 <td>
                                                    @if($row->leave_type == 'single_day')
                                                        {{ Carbon\Carbon::parse($row->leave_start_date)->format('d/m/Y') }} (1 Day)
                                                    @elseif($row->leave_type == 'multiple_days')
                                                        <?php 
                                                            $start = strtotime($row->leave_start_date);
                                                            $end = strtotime($row->leave_end_date);
                                                
                                                            $days_between = ceil(abs($end - $start) / 86400);
                                                        ?>
                                                        {{ Carbon\Carbon::parse($row->leave_start_date)->format('d/m/Y') }} - {{ Carbon\Carbon::parse($row->leave_end_date)->format('d/m/Y') }} ({{ $days_between }} days)
                                                    @elseif($row->leave_type == 'hours')
                                                        {{ Carbon\Carbon::parse($row->leave_start_date)->format('d/m/Y') }} ({{ $row->hours }} hours {{ \Carbon\Carbon::parse($row->start_hour)->format('g:i A') }} to 
                                                                                                                                                    {{ \Carbon\Carbon::parse($row->end_hour)->format('g:i A') }} )
                                                    @endif
                                                </td>

                                              <td>
                                                    @if($row->application_status == 1)
                                                        <div class="badge badge-info badge-shadow">Pending</div>
                                                    @elseif($row->application_status == 2)
                                                        @if(auth()->user()->can('leave-first-approve'))
                                                            <div class="badge badge-info badge-shadow">First Level Approved (HDO)</div>
                                                        @endif
                                                    @elseif($row->application_status == 3)
                                                        @if(auth()->user()->can('leave-second-approve'))
                                                            <div class="badge badge-info badge-shadow">Second Level Approved (MD)</div>
                                                        @endif
                                                    @elseif($row->application_status == 4)
                                                        @if(auth()->user()->can('leave-third-approve'))
                                                            <div class="badge badge-info badge-shadow">
                                                                @if($row->previous_approval_status >= 2)
                                                                    First Level Approved (HDO),
                                                                @endif
                                                                @if($row->previous_approval_status >= 3)
                                                                    Second Level Approved (MD),
                                                                @endif
                                                                Third Level Approved (Director)
                                                            </div>
                                                        @endif
                                                    @elseif($row->application_status == 5)
                                                        <div class="badge badge-danger badge-shadow">Rejected</div>
                                                    @else
                                                        <div class="badge badge-warning badge-shadow">Unknown Status</div>
                                                    @endif
                                                </td>



                                               
                                                <td>
                                                 <div class="form-inline">
                                                   @if($row->application_status == 1)
                                                <a class="list-icons-item text-primary"
                                                        href="{{ route("leave.edit", $row->id)}}"><i
                                                            class="icon-pencil7"></i>
                                                    </a>
                                        &nbsp
       
                                                    {!! Form::open(['route' => ['leave.destroy',$row->id], 'method' => 'delete']) !!}
                                                    {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}
                                                    @endif

                                                        @if(!empty($row->application_status))
                                                        <div class="dropdown">
                                                            <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown">
                                                                <i class="icon-cog6"></i>
                                                            </a>
                                                            <div class="dropdown-menu">
                                                                @if(auth()->user()->can('leave-first-approve') && $row->application_status == 1)
                                                                    <a class="nav-link" onclick="return confirm('Are you sure you want to approve this leave?')" 
                                                                       href="{{ route('leave.approve', ['id' => $row->id, 'level' => 1]) }}">
                                                                        Approve (First Level)
                                                                    </a>
                                                                @endif
                                                    
                                                                @if(auth()->user()->can('leave-second-approve') && $row->application_status == 2)
                                                                    <a class="nav-link" onclick="return confirm('Are you sure you want to approve this leave?')" 
                                                                       href="{{ route('leave.approve', ['id' => $row->id, 'level' => 2]) }}">
                                                                        Approve (Second Level)
                                                                    </a>
                                                                @endif
                                                    
                                                                @if(auth()->user()->can('leave-third-approve') && $row->application_status == 1 )
                                                                    <a class="nav-link" onclick="return confirm('Are you sure you want to approve this leave?')" 
                                                                       href="{{ route('leave.approve', ['id' => $row->id, 'level' => 3]) }}">
                                                                        Approve (Third Level)
                                                                    </a>
                                                               @elseif(auth()->user()->can('leave-third-approve') && $row->application_status == 3)
                                                                    <a class="nav-link" onclick="return confirm('Are you sure you want to approve this leave?')" 
                                                                       href="{{ route('leave.approve', ['id' => $row->id, 'level' => 3]) }}">
                                                                        Approve (Third Level)
                                                                    </a>
                                                                @elseif(auth()->user()->can('leave-third-approve') && $row->application_status == 2 )
                                                                    <a class="nav-link" onclick="return confirm('Are you sure you want to approve this leave?')" 
                                                                       href="{{ route('leave.approve', ['id' => $row->id, 'level' => 3]) }}">
                                                                        Approve (Third Level)
                                                                    </a>
                                                                @endif
                                                    
                                                                <!-- Reject is visible only if the leave is not approved at any level -->
                                                                @if($row->application_status == 1) <!-- Only show Reject if its pending -->
                                                                    <a class="nav-link" onclick="return confirm('Are you sure you want to reject this leave?')" 
                                                                       href="{{ route('leave.reject', $row->id) }}">
                                                                        Reject
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif


                                                    
                                                   </div>
                                                </td>
                                            </tr>
                                            @endforeach

                                            @endif

                                        </tbody>
                                    </table>
                                   
                                </div>

                            </div>
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                        @if(empty($id))
                                        <h5>Create Leave</h5>
                                        @else
                                        <h5>Edit Leave</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('leave.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'leave.store']) }}
                                                @method('POST')
                                                @endif




                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Staff</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control m-b user" name="staff_id" required
                                                        id="staff_id">
                                                        <option value="">Select</option>
                                                        @if(!empty($staff))
                                                        @foreach($staff as $row)

                                                        <option @if(isset($data))
                                                            {{  $data->staff_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif

                                                    </select>
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Leave Category</label>
                                                    <div class="col-lg-4">
                                                        <div class="input-group mb-3">
                                                    <select class="form-control category append-button-single-field" id="leave" name="leave_category_id" required >
                                                    <option value="">Select Leave Category</option>
                                                    @if(!empty($category))
                                                    @foreach($category as $row)

                                                    <option @if(isset($data))
                                                        {{  $data->leave_category_id == $row->id  ? 'selected' : ''}}
                                                        @endif value="{{ $row->id}}">{{$row->leave_category}}</option>

                                                    @endforeach
                                                    @endif

                                                </select>
                                                &nbsp
                                                
                                                     <button class="btn btn-outline-secondary" type="button"
                                                        data-toggle="modal" value="" href="routeModal"  
                                                        data-target="#routeModal"><i class="icon-plus-circle2"></i></button>
                                                                    
                                                          
                                                        </div>
                                                    </div>
                                                </div>

                                        <div class="form-group row">
                                            <label class="col-lg-2 col-form-label">Leave Type</label>
                                            <div class="col-lg-4">
                                                {{--<input type="radio" name="leave_type" id="leave_type_single_days" value="single_day"  {{(!empty($data))?($data->leave_type =='single_day')?'checked':'':''}} checked="" class="type" >Single day
                                                <input type="radio" name="leave_type" id="leave_type_multiple_days" value="multiple_days" {{(!empty($data))?($data->leave_type =='multiple_days')?'checked':'':''}}  class="type" > Multiple days
                                                <input type="radio" name="leave_type" id="leave_type_hours" value="hours" {{(!empty($data))?($data->leave_type =='hours')?'checked':'':''}}  class="type" > Hours --}}
                                                
                                                <!-- Radio buttons for selecting leave type -->
<input type="radio" name="leave_type" value="single_day" id="leave_type_single_day" class="type" {{ (!empty($data) && $data->leave_type == 'single_day') ? 'checked' : '' }}> Single day
<input type="radio" name="leave_type" value="multiple_days" id="leave_type_multiple_days" class="type" {{ (!empty($data) && $data->leave_type == 'multiple_days') ? 'checked' : '' }}> Multiple days
<input type="radio" name="leave_type" value="hours" id="leave_type_hours" class="type" {{ (!empty($data) && $data->leave_type == 'hours') ? 'checked' : '' }}> Hours

                                            </div>



                                                <label class="col-lg-2 col-form-label">Start Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date"  name="leave_start_date" id="leave_start_date"
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->leave_start_date : ''}}"
                                                            class="form-control start_date" onkeydown="return false" required>
                                                    </div>

                                                   
                                                </div>

                                        @if(!empty($data->leave_end_date))
                                         <div class="form-group row end">
                                                    <label class="col-lg-2 col-form-label">End Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date"  name="leave_end_date" id="leave_end_date"
                                                            placeholder=""
                                                        value="{{ isset($data) ? $data->leave_end_date : ''}}"
                                                            class="form-control end_date" onkeydown="return false">
                                                    </div>
                                            </div>
                                          @else
                                               <div class="form-group row end" style="display:none">
                                                    <label class="col-lg-2 col-form-label">End Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date"  name="leave_end_date" id="leave_end_date"
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->leave_end_date :''}}"
                                                            class="form-control end_date" onkeydown="return false">
                                                    </div>
                                            </div>
                                         @endif
                                         
                                         
                                         <div class=""> <p class="form-control-static errors" id="errors" style="text-align:center;color:red;"></p>   </div>
                                         
                                         
                                         
                                          @if(!empty($data->amount))
                                        <div class="form-group row amount">
                                          @else
                                          <div class="form-group row amount" style="display:none">
                                            @endif
                                        
                                            @if(!empty($data->amount))
                                        
                                            <label class="col-lg-2 col-form-label">Paid Amount</label>
                                            <div class="col-lg-4">
                                              <input type="number" name="amount" min="1" value="{{ isset($data) ? $data->amount : ''}}"
                                                class="form-control paid" id="paid" required>
                                            </div>
                                        
                                            @else
                                        
                                            <label class="col-lg-2 col-form-label">Paid Amount</label>
                                            <div class="col-lg-4">
                                              <input type="number" name="amount" min="1" value="{{ isset($data) ? $data->amount : ''}}"
                                                class="form-control paid" id="paid">
                                            </div>
                                        
                                            @endif
                                         
                                          @if(!empty($data->pay_type))
                                            <label class="col-lg-2 col-form-label">Payment Type</label>
                                            <div class="col-lg-4">
                                              <select class="form-control m-b pay_type" name="pay_type" id="pay_type">
                                                <option value="">Select Payment Type</option>
                                                <option value="Credit" @if (isset($data)) {{ $data->pay_type == 'Credit' ? 'selected' : '' }} @endif>On Credit
                                                </option>
                                                <option value="Cash" @if (isset($data)) {{ $data->pay_type == 'Cash' ? 'selected' : '' }} @endif>On Cash</option>
                                              </select>
                                            </div>
                                            
                                            @else
                                            
                                            <label class="col-lg-2 col-form-label">Payment Type</label>
                                            <div class="col-lg-4">
                                              <select class="form-control m-b pay_type" name="pay_type" id="pay_type">
                                                <option value="">Select Payment Type</option>
                                                <option value="Credit">On Credit</option>
                                                <option value="Cash">On Cash</option>
                                              </select>
                                            </div>
                                            
                                            @endif
                                            </div>
                                         
                                           @if(!empty($data->bank_id))
                                            <div class="form-group row bank">
                                              <label class="col-lg-2 col-form-label">Payment Account</label>
                                              <div class="col-lg-4">
                                                <select class="form-control m-b" name="bank_id" id="bank_id">
                                                  <option value="">Select Payment Account</option>
                                                  @foreach ($bank_accounts as $bank)
                                                  <option value="{{ $bank->id }}" @if (isset($data)) @if ($data->bank_id == $bank->id) selected @endif @endif>{{
                                                    $bank->account_name }}</option>
                                                  @endforeach
                                                </select>
                                              </div>
                                            </div>
                                            @else
                                            <div class="form-group row bank" style="display:none">
                                              <label class="col-lg-2 col-form-label">Payment Account</label>
                                              <div class="col-lg-4">
                                                <select class="form-control m-b" name="bank_id" id="bank_id">
                                                  <option value="">Select Payment Account</option>
                                                  @foreach ($bank_accounts as $bank)
                                                  <option value="{{ $bank->id }}">{{ $bank->account_name }}</option>
                                                  @endforeach
                                                </select>
                                              </div>
                                            </div>
                                            @endif
                                         
       
                        
                        
                                            @if(!empty($data->hours))
                                            <div class="form-group row hour">
                                              <label class="col-lg-2 col-form-label">Hours</label>
                                              <div class="col-lg-4">
                                                <select class="form-control m-b" name="hours" id="hours">
                                                  <option value="">Select</option>
                                                  <option value="1" @if(isset($data)){{ $data->hours == '1' ? 'selected' : ''}} @endif >01</option>
                                                  <option value="2" @if(isset($data)){{ $data->hours == '2' ? 'selected' : ''}} @endif >02</option>
                                                  <option value="3" @if(isset($data)){{ $data->hours == '3' ? 'selected' : ''}} @endif >03</option>
                                                  <option value="4" @if(isset($data)){{ $data->hours == '4' ? 'selected' : ''}} @endif >04</option>
                                                  <option value="5" @if(isset($data)){{ $data->hours == '5' ? 'selected' : ''}} @endif >05</option>
                                                  <option value="6" @if(isset($data)){{ $data->hours == '6' ? 'selected' : ''}} @endif >06</option>
                                                  <option value="7" @if(isset($data)){{ $data->hours == '7' ? 'selected' : ''}} @endif >07</option>
                                                  <option value="8" @if(isset($data)){{ $data->hours == '8' ? 'selected' : ''}} @endif >08</option>
                                                </select>
                                              </div>
                                            </div>
                                            
                                            @else
                                            <div class="form-group row hour" style="display:none">
                                              <label class="col-lg-2 col-form-label">Hours</label>
                                              <div class="col-lg-4">
                                                <select class="form-control m-b" name="hours" id="hours">
                                                  <option value="">Select</option>
                                                  <option value="1">01</option>
                                                  <option value="2">02</option>
                                                  <option value="3">03</option>
                                                  <option value="4">04</option>
                                                  <option value="5">05</option>
                                                  <option value="6">06</option>
                                                  <option value="7">07</option>
                                                  <option value="8">08</option>
                                                </select>
                                              </div>
                                            </div>
                                            @endif
                                            
                                            
                                        <!-- Start Hours and End Hours Fields -->
                                        {{--<div class="form-group row">
                                            <!-- Start Hours -->
                                            <label class="col-lg-2 col-form-label">Start Hours</label>
                                            <div class="col-lg-4">
                                                 <input type="time" class="form-control" name="start_hour" id="start_hour" 
                                                                   value="{{ old('start_hour', isset($data) ? date('H:i', strtotime($data->start_hour)) : '') }}">
                                            </div>
                                        
                                            <!-- End Hours -->
                                            <label class="col-lg-2 col-form-label">End Hours</label>
                                            <div class="col-lg-4">
                                                 <input type="time" class="form-control" name="end_hour" id="end_hour" 
                                                        value="{{ old('end_hour', isset($data) ? date('H:i', strtotime($data->end_hour)) : '') }}">
                                            </div>
                                        </div>--}}
                                        
                                        
                                       <!-- Start Hours and End Hours Fields (initially hidden) -->
                                       
                                        <div class="form-group row" id="start_end_hours_fields" style="display: none; display: flex; justify-content: space-between; align-items: center;">
                                            <div class="col-lg-4" style="flex: 1; margin-right: 10px;">
                                                <label for="start_hour">Start Hours</label>
                                                <input type="time" class="form-control" name="start_hour" id="start_hour" 
                                                    value="{{ old('start_hour', isset($data) ? date('H:i', strtotime($data->start_hour)) : '') }}">
                                            </div>
                                            <div class="col-lg-4" style="flex: 1; margin-right: 10px;">
                                                <label for="end_hour">End Hours</label>
                                                <input type="time" class="form-control" name="end_hour" id="end_hour" 
                                                    value="{{ old('end_hour', isset($data) ? date('H:i', strtotime($data->end_hour)) : '') }}">
                                            </div>
                                        </div>

                                        
                                        
                                        
                                            <div class="form-group row">
                                              <label class="col-lg-2 col-form-label">Reason</label>
                                              <div class="col-lg-4">
                                                <textarea id="present" name="reason" class="form-control" rows="3" data-parsley-id="25" required>{{ isset($data) ? $data->reason : ''}}</textarea>
                                              </div>
                                            </div>

                                            
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit" id="save">Save</button>
                                                       
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
</section>





<!-- route Modal -->
<div class="modal fade" id="routeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Leave Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
  <form id="addRouteForm" class="addRouteForm" method="post" action="javascript:void(0)">
            @csrf
                <div class="modal-body">
                    <p><strong>Make sure you enter valid information</strong> .</p>

                   

                    <div class="form-group row"><label class="col-lg-2 col-form-label">Leave Category</label>

                        <div class="col-lg-10">
                            <input type="text" name="leave_category" id="category" class="form-control category" required>
                        </div>
                    </div>
                    
                     <div class="form-group row"><label class="col-lg-2 col-form-label">Number of Days</label>

                        <div class="col-lg-10">
                            <input type="number" name="days" id="days" class="form-control days" required>
                        </div>
                    </div>
                    
                     <div class="form-group row"><label class="col-lg-2 col-form-label">Limit Days</label>

                        <div class="col-lg-10">
                          <select class="form-control limitation m-b" name="limitation"  id="limitation" required>
                            <option value="">Select</option>
                           <option value="Yes">Yes</option>
                            <option value="No" >No</option>
                        </select>
                        </div>
                    </div>
                    
                     <div class="form-group row"><label class="col-lg-2 col-form-label">Paid Leave</label>

                        <div class="col-lg-10">
                          <select class="form-control m-b paid" name="paid"  id="paid" required>
                            <option value="">Select</option>
                           <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                        </div>
                    </div>
                    
                    
                    
                    

                </div>
                <div class="modal-footer bg-whitesmoke br">
                 <button class="btn btn-primary route"  type="submit" id="save"><i class="icon-checkmark3 font-size-base mr-1"></i>Save</button>
                <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
                </div>

                 </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>

@endsection

@section('scripts')

<script>
    $(document).ready(function(){
   

 $(document).on('change', '.paid', function(){
var id=$(this).val() ;
console.log(id);
         if($(this).val() == 'Yes') {
          $('.amount_field').show(); 
           $("#amount").empty();
        $("#amount").prop('required',true);
        }
   else  {
            $('.amount_field').hide(); 
             $("#amount").empty();
             $("#amount").val(0);
           $("#amount").prop('required',false);
        } 
});






    });
</script>


<script>
    $(document).ready(function(){
   

 $(document).on('change', '.type', function(){
var id=$(this).val() ;
console.log(id);
         if($(this).val() == 'multiple_days') {
          $('.end').show(); 
           $("#leave_end_date").val('');
           $("#leave_end_date").prop('required',true);
            $('.hour').hide();
        } else if($(this).val() == 'hours') {
            $('.hour').show(); 
           $('.end').hide();
        } 
   else  {
            $('.hour').hide(); 
           $('.end').hide();
            $("#leave_end_date").val('');
            $("#leave_end_date").prop('required',false);
        } 
});


$('.route').click(function (event){
event.preventDefault();
       var leave_category= $('.category').val();
       var days= $('.days').val();
           $.ajax({
            type: "POST",
            url: '{{url("leave/addCategory")}}',
            data: $('.addRouteForm').serialize(),
            dataType: "json",
            success: function(response) {
                console.log(response);
          // do whatever you want with a successful response
                        var id = response.id;
                        var arrival_point = response.leave_category;

                        var option = "<option value='"+id+"'  selected>"+arrival_point+"</option>"; 
                      
                             $('#leave').append(option);
                             $('#routeModal').hide();
                             $('.modal-backdrop').remove();
        }
      });
    });




    });
</script>


  <script>
        $(document).ready(function() {
            
       $(document).on('change', '.category', function() {  
              var id = $(this).val();
              
               $.ajax({
                    url: '{{ url('leave/findPaid') }}',
                    type: "GET",
                    data: {
                        id: id,
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        
                      $("#paid").val('');
                    
                        
                        if (data != '') {
                    $('.amount').show();
                    $("#paid").prop('required',true);
                     $("#pay_type").prop('required',true);
                        } else {
                         $('.amount').hide();
                          $('.bank').hide();
                    $("#paid").prop('required',false);
                     $("#pay_type").prop('required',false);
                     $("#bank_id").prop('required',false);
                        }


                    }

                });

            
            
            
       });         

            $(document).on('change', '.pay_type', function() {
                var id = $(this).val();
                console.log(id);


                if (id == 'Cash') {
                    $('.bank').show();
                    $("#bank_id").prop('required',true);

                } else {
                    $('.bank').hide();
                     $("#bank_id").prop('required',false);

                }

            });
            



        });
    </script>



  
 <script>
$(document).ready(function() {
    
    $(document).on('change', '.end_date', function() {
     $(".start_date").change();

    });
    
    $(document).on('change', '.category', function() {
     $(".start_date").change();

    });
    
    $(document).on('change', '.start_date', function() {
        var id = $(this).val();
        var category= $('.category').val();
         var date= $('.end_date').val();
          var user = $('.user').val();
          console.log(id);
        $.ajax({
            url: '{{url("leave/findDays")}}',
            type: "GET",
            data: {
                id: id,
                category: category,
                 date:date,
                  user:user,
            },
            dataType: "json",
            success: function(data) {
                console.log(data);
                
         
               $('.errors').empty();
               $("#save").attr("disabled", false);
                if (data != '') {
                    $('.errors').append(data);
                    $("#save").attr("disabled", true);
                } else {

                }
                          
               
            }

        });

    });
    

    


    
   
   
   
}); 
    </script>
    

<script>
    
    $(document).ready(function() { //DISABLED PAST DATES IN APPOINTMENT DATE
  var dateToday =new Date(new Date().getFullYear(), 0, 1);;
  var month = dateToday.getMonth() + 1;
  var day = dateToday.getDate();
  var year = dateToday.getFullYear();

  if (month < 10)
    month = '0' + month.toString();
  if (day < 10)
    day = '0' + day.toString();

  var minDate = year + '-' + month + '-' + day;
  
   var dateToday2 =new Date(new Date().getFullYear(), 11, 31);
  var month2 = dateToday2.getMonth() + 1;
  var day2 = dateToday2.getDate();
  var year2 = dateToday2.getFullYear();

  if (month2 < 10)
    month2 = '0' + month2.toString();
  if (day2 < 10)
    day2 = '0' + day2.toString();

  var maxDate = year2 + '-' + month2 + '-' + day2;
  

  $('#leave_start_date').attr('min', minDate);
   $('#leave_end_date').attr('min', minDate);
    //$('#leave_start_date').attr('max', maxDate);


});
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to toggle visibility of hours fields
        function toggleHoursFields() {
            const hoursRadio = document.getElementById('leave_type_hours');
            const hoursFields = document.getElementById('start_end_hours_fields');
            if (hoursRadio.checked) {
                hoursFields.style.display = 'flex';
            } else {
                hoursFields.style.display = 'none';
            }
        }
    
        // Initial check to set visibility based on current selection
        toggleHoursFields();
    
        // Event listeners for changes in leave type selection
        document.getElementById('leave_type_single_day').addEventListener('change', toggleHoursFields);
        document.getElementById('leave_type_multiple_days').addEventListener('change', toggleHoursFields);
        document.getElementById('leave_type_hours').addEventListener('change', toggleHoursFields);
});

</script>



@endsection