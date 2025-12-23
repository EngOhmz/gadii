
                                            <div class="card-header"> <strong>Meetings</strong> </div>
                                                
                                            <div class="card-body">
                                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link @if($type == 'calls' || $type == 'details' || $type == 'meetings' || $type == 'comments' || $type == 'attachment' || $type == 'tasks' || $type == 'proposal' || $type == 'reminder' || $type == 'notes' || $type == 'activities' ) active  @endif" id="home-tab2" data-toggle="tab"
                                                            href="#meet-home2" role="tab" aria-controls="home" aria-selected="true">Meeting
                                                            List</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link @if($type == 'edit-meetings') active  @endif" id="profile-tab2"
                                                            data-toggle="tab" href="#meet-profile2" role="tab" aria-controls="profile"
                                                            aria-selected="false">New Meetings</a>
                                                    </li>
                                    
                                                </ul>
                                                <br>
                                                <div class="tab-content tab-bordered" id="myTab3Content">
                                                    <div class="tab-pane fade @if($type == 'calls' || $type == 'details' || $type == 'meetings' || $type == 'comments' || $type == 'attachment' || $type == 'tasks' || $type == 'proposal' || $type == 'reminder' || $type == 'notes' || $type == 'activities' ) active show @endif " id="meet-home2" role="tabpanel"
                                                        aria-labelledby="home-tab2">
                                                        <div class="table-responsive">
                                                            <table class="table datatable-meetings table-striped" style="width:100%">
                                                                <thead>
                                                                    <tr role="row">                                    
                                    
                                                       <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 28.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 106.484px;">Subject</th>
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Start Time</th>
                                                   <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">End Time</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Responsible</th>
                                                   
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @if(!@empty($meetings))
                                            @foreach ($meetings as $row)
                                                                    <tr class="gradeA even" role="row">
                                                           <th>{{ $loop->iteration }}</th>
                                                  <td>{{$row->meeting_subject}}</td>
                                                <td>{{Carbon\Carbon::parse($row->start_date)->format('d/m/Y')}} at {{$row->start_time}}</td>
                                                <td>{{Carbon\Carbon::parse($row->end_date)->format('d/m/Y')}} at {{$row->end_time}}</td>
                                                <td> {{$row->assign->name}} </td>

                                                <td>
                                        <div class="form-inline">

                              <a class="list-icons-item text-primary" title="Edit"  href="{{route('edit.lead_details',['type'=>'edit-meetings','type_id'=>$row->id])}}"><i class="icon-pencil7"></i></a>&nbsp
                            <a class="list-icons-item text-danger" title="Edit"  href="{{route('delete.lead_details',['type'=>'delete-meetings','type_id'=>$row->id])}}" onclick= "return confirm('Are you sure, you want to delete?')"><i class="icon-trash"></i></a>&nbsp
                                                   


                                  
</div>
                                                </td>
                                                                    </tr>
                                                                
                                    
                                                                                @endforeach
                                    
                                                                                @endif
                                    
                                                                            </tbody>
                                                                     
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade  @if($type == 'edit-meetings') active show @endif" id="meet-profile2"
                                                        role="tabpanel" aria-labelledby="profile-tab2">
                                    <br>
                                                        <div class="card">
                                                            <div class="card-header">
                                                              @if($type == 'edit-meetings')
                                        <h5>Edit Meetings</h5>
                                        @else
                                        <h5>Add New Meetings</h5>
                                        @endif
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12 ">
                                                                      @if($type == 'edit-meetings')
                                                                        {{ Form::open(['route' => 'update.lead_details']) }}
                                                                         <input type="hidden" name="id" value="{{ $type_id}}">
                                                                        @else
                                                                        {{ Form::open(['route' => 'save.lead_details']) }}
                                                                        @method('POST')
                                                                        @endif
                                                                     

                                                                     <input type="hidden" name="leads_id" value="{{ $id}}">
                                                                          <input type="hidden" name="type" value="meetings">

                                                                        <div class="form-group row">
                                                                            <label class="col-lg-2 col-form-label">Subject<span class="text-danger">*</span></label>
                                                                            <div class="col-lg-4">
                                                                                <input type="text" name="meeting_subject" 
                                                                                    value="{{ isset($edit_data) ? $edit_data->meeting_subject : ''}}"
                                                                                    class="form-control" required>
                                                                            </div>
                                                                        

                                                                            <label class="col-lg-2 col-form-label">Description </label>
                                                                           <div class="col-lg-4">
                                                                              <textarea name="description" 
                                                                    class="form-control" >@if(isset($edit_data)){{ $edit_data->description }} @endif</textarea>
                                                                            </div>
                                                                        </div>
                                                                       

                                                                        <div class="form-group row">
                                                                            <label class="col-lg-2 col-form-label">Start Date <span class="text-danger">*</span></label>
                                                                            <div class="col-lg-4">
                                                                                <input type="date" name="start_date" 
                                                                                    value="{{ isset($edit_data) ? $edit_data->start_date : ''}}"
                                                                                    class="form-control" required>
                                                                            </div>
                                                                        

                                                                            <label class="col-lg-2 col-form-label">Start Time <span class="text-danger">*</span></label>
                                                                           <div class="col-lg-4">
                                                                               <input type="text" name="start_time" 
                                                                                    value="{{ isset($edit_data) ? $edit_data->start_time : ''}}"
                                                                                    class="form-control"  id="timepicker1"  required>
                                                                            </div>
                                                                        </div>

                                                                         <div class="form-group row">
                                                                            <label class="col-lg-2 col-form-label">End Date <span class="text-danger">*</span></label>
                                                                            <div class="col-lg-4">
                                                                                <input type="date" name="end_date" 
                                                                                    value="{{ isset($edit_data) ? $edit_data->end_date : ''}}"
                                                                                    class="form-control" required>
                                                                            </div>
                                                                        

                                                                            <label class="col-lg-2 col-form-label">End Time <span class="text-danger">*</span></label>
                                                                           <div class="col-lg-4">
                                                                               <input type="text" name="end_time" 
                                                                                    value="{{ isset($edit_data) ? $edit_data->end_time : ''}}"
                                                                                    class="form-control "  id="timepicker2" required>
                                                                            </div>
                                                                        </div>
                                                                       
                                                                        <div class="form-group row">
                                                                            <label
                                                                                class="col-lg-2 col-form-label">Responsible <span class="text-danger">*</span></label>
                        
                                                                            <div class="col-lg-4">
                                                                                <select class="form-control m-b" name="user_id" required  id="user">                                                                               
                                                                        <option value="">Select </option>
                                                                        @if(!empty($staff))
                                                                        @foreach($staff as $row)
                        
                                                                        <option @if(isset($edit_data))
                                                                            {{$edit_data->user_id == $row->id  ? 'selected' : ''}}
                                                                            @endif value="{{ $row->id}}">{{$row->name}}</option>
                        
                                                                        @endforeach
                                                                        @endif
                        
                                                                    </select>
                                                                            </div>
                                                                       
                        
                                                                        <label
                                                                            class="col-lg-2 col-form-label">Location <span class="text-danger">*</span></label>
                        
                                                                        <div class="col-lg-4">
                                                                          <input type="text" name="location" 
                                                                                    value="{{ isset($edit_data) ? $edit_data->location : ''}}"
                                                                                    class="form-control" required>
                                                                        </div>
                                                                    </div>


                                                      <br>
                                            <h4 align="center">Enter Meeting Attendees</h4>
                                            <hr>
                                            
                                            
                                            <button type="button" name="add" class="btn btn-success btn-xs add"><i
                                                    class="fas fa-plus"> Add item</i></button><br>
                                            <br>
                                            <div class="table-responsive">
                                            <table class="table table-bordered" id="cart">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                </tbody>
                                                <tfoot>
                                                    @if(!empty($edit_data))
                                                    @if(!empty($edit_items))
                                                    @foreach ($edit_items as $ei)
                                                    <tr class="line_items">
                                                        
                                                      
                                        <td>
                                             <select class="form-control m-b" name=" attendee[]" required  id=" attendee">                                                                               
                                                                        <option value="">Select </option>
                                                                        @if(!empty($staff))
                                                                        @foreach($staff as $row)                        
                                                                        <option @if(isset($ei))
                                                                            {{$ei->user_id == $row->id  ? 'selected' : ''}}
                                                                            @endif value="{{ $row->id}}">{{$row->name}}</option>                        
                                                                        @endforeach
                                                                       @endif                        
                                                                    </select>
                                         
                                            </td>

                                                                <input type="hidden" name="saved_id[]"
                                                                class="form-control item_saved"
                                                                value="{{ isset($ei) ? $ei->id : ''}}"
                                                                required />
                                                        <td><button type="button" name="remove"
                                                                class="btn btn-danger btn-xs rem"
                                                                value="{{ isset($ei) ? $ei->id : ''}}"><i
                                                                    class="icon-trash"></i></button></td>
                                                    </tr>

                                                    @endforeach
                                                    @endif
                                                    @endif

                                                </tfoot>    
                                            </table>
                                        </div>


                                            <br>
                                                                     
                                    
                                                                    <div class="form-group row">
                                                                        <div class="col-lg-offset-2 col-lg-12">
                                                                            @if($type == 'edit-calls')
                                                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                                data-toggle="modal" data-target="#myModal"
                                                                                type="submit">Update</button>
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