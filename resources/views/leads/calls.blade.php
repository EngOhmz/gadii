                                              <div class="card-header"> <strong>Calls</strong> </div>
                                                
                                            <div class="card-body">
                                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                                    <li class="nav-item">
                         <a class="nav-link @if($type == 'calls' || $type == 'details' || $type == 'meetings' || $type == 'comments' || $type == 'attachment' || $type == 'tasks' || $type == 'proposal' || $type == 'reminder' || $type == 'notes' || $type == 'activities' ) active  @endif" id="home-tab2" data-toggle="tab"
                                                            href="#home2" role="tab" aria-controls="home" aria-selected="true">Call
                                                            List</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link @if($type == 'edit-calls') active  @endif" id="profile-tab2"
                                                            data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                                            aria-selected="false">New Calls</a>
                                                    </li>
                                    
                                                </ul>
                                                <br>
                                                <div class="tab-content tab-bordered" id="myTab3Content">
                                                    <div class="tab-pane fade @if($type == 'calls' || $type == 'details' || $type == 'meetings' || $type == 'comments' || $type == 'attachment' || $type == 'tasks' || $type == 'proposal' || $type == 'reminder' || $type == 'notes' || $type == 'activities' ) active show  @endif " id="home2" role="tabpanel"
                                                        aria-labelledby="home-tab2">
                                                        <div class="table-responsive">
                                                            <table class="table datatable-call table-striped" style="width:100%">
                                                                <thead>
                                                                    <tr role="row">                                    
                                    
                                                       <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 28.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 106.484px;">Date</th>
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Call Summary</th>
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

                                                                    @if(!@empty($calls))
                                            @foreach ($calls as $row)
                                                                    <tr class="gradeA even" role="row">
                                                           <th>{{ $loop->iteration }}</th>
                                                <td>{{Carbon\Carbon::parse($row->date)->format('M d, Y')}}</td>
                                                <td>{{$row->call_summary}}</td>
                                                <td> {{$row->assign->name}} </td>

                                                <td>
                                        <div class="form-inline">

                                     <a class="list-icons-item text-primary" title="Edit"  href="{{route('edit.lead_details',['type'=>'edit-calls','type_id'=>$row->id])}}"><i class="icon-pencil7"></i></a>&nbsp
                                  <a class="list-icons-item text-danger" title="Edit"  href="{{route('delete.lead_details',['type'=>'delete-calls','type_id'=>$row->id])}}" onclick= "return confirm('Are you sure, you want to delete?')"><i class="icon-trash"></i></a>&nbsp
                                                   


                                  
</div>
                                                </td>
                                                                    </tr>
                                                                
                                    
                                                                                @endforeach
                                    
                                                                                @endif
                                    
                                                                            </tbody>
                                                                     
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade  @if($type == 'edit-calls') active show @endif" id="profile2"
                                                        role="tabpanel" aria-labelledby="profile-tab2">
                                    <br>
                                                        <div class="card">
                                                            <div class="card-header">
                                                              @if($type == 'edit-calls')
                                        <h5>Edit Calls</h5>
                                        @else
                                        <h5>Add New Calls</h5>
                                        @endif
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12 ">
                                                                      @if($type == 'edit-calls')
                                                                        {{ Form::open(['route' => 'update.lead_details']) }}
                                                                         <input type="hidden" name="id" value="{{ $type_id}}">
                                                                        @else
                                                                        {{ Form::open(['route' => 'save.lead_details']) }}
                                                                        @method('POST')
                                                                        @endif
                                                                     

                                                                     <input type="hidden" name="leads_id" value="{{ $id}}">
                                                                          <input type="hidden" name="type" value="calls">

                                                                        <div class="form-group row">
                                                                            <label class="col-lg-2 col-form-label">Date <span class="text-danger">*</span></label>
                                                                            <div class="col-lg-4">
                                                                                <input type="date" name="date"
                                                                                    placeholder="0 if does not exist"
                                                                                    value="{{ isset($edit_data) ? $edit_data->date : ''}}"
                                                                                    class="form-control" required>
                                                                            </div>
                                                                        

                                                                            <label class="col-lg-2 col-form-label">Call Summary <span class="text-danger">*</span></label>
                                                                           <div class="col-lg-4">
                                                                              <textarea name="call_summary" 
                                                                    class="form-control" required>@if(isset($edit_data)){{ $edit_data->call_summary }} @endif</textarea>
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
                                                                            class="col-lg-2 col-form-label">Contact with</label>
                        
                                                                        <div class="col-lg-4">
                                                                           <select class="form-control m-b" name="client_id"  id="client">                                                                               
                                                                        <option value="">Select </option>
                                                                        @if(!empty($client))
                                                                        @foreach($client as $row)
                        
                                                                        <option @if(isset($edit_data))
                                                                            {{$edit_data->client_id == $row->id  ? 'selected' : ''}}
                                                                            @endif value="{{ $row->id}}">{{$row->name}}</option>
                        
                                                                        @endforeach
                                                                        @endif
                        
                                                                    </select>
                                                                        </div>
                                                                    </div>
                                                                     
                                    
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
                                    