                                                             <div class="card-header"> <strong></strong> </div>
                                                
                                            <div class="card-body">
                                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                                    <li class="nav-item">
                         <a class="nav-link @if($type == 'credit' || $type == 'details' || $type == 'calendar' || $type == 'purchase' || $type == 'debit' || $type == 'invoice' || $type == 'comments' || $type == 'attachment' || $type == 'milestone' || $type == 'tasks' || $type == 'expenses' || $type == 'estimate' || $type == 'notes' || $type == 'activities' )  active  @endif" id="home-tab2" data-toggle="tab"
                                                            href="#notes-home2" role="tab" aria-controls="home" aria-selected="true">Notes
                                                            List</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link @if($type == 'edit-notes') active  @endif" id="profile-tab2"
                                                            data-toggle="tab" href="#notes-profile2" role="tab" aria-controls="profile"
                                                            aria-selected="false">New Notes</a>
                                                    </li>
                                    
                                                </ul>
                                                <br>
                                                <div class="tab-content tab-bordered" id="myTab3Content">
                                                    <div class="tab-pane fade @if($type == 'credit' || $type == 'details' || $type == 'calendar' || $type == 'purchase' || $type == 'debit' || $type == 'invoice' || $type == 'comments' || $type == 'attachment' || $type == 'milestone' || $type == 'tasks' || $type == 'expenses' || $type == 'estimate' || $type == 'notes' || $type == 'activities' )  active show  @endif " id="notes-home2" role="tabpanel"
                                                        aria-labelledby="home-tab2">
                                                        <div class="table-responsive">
                                                            <table class="table datatable-attach table-striped" style="width:100%">
                                                                <thead>
                                                                    <tr role="row">                                    
                                    
                                                       <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 28.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Notes</th>
                                                   
                                                   
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @if(!empty($notes))
                                            @foreach ($notes as $row)
                                                                    <tr class="gradeA even" role="row">
                                                           <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->notes}}</td>
                                              
                                                <td>
                                        <div class="form-inline">

                                     <a class="list-icons-item text-primary" title="Edit"  href="{{route('edit.project_details',['type'=>'edit-notes','type_id'=>$row->id])}}"><i class="icon-pencil7"></i></a>&nbsp
                                  <a class="list-icons-item text-danger" title="Edit"  href="{{route('delete.project_details',['type'=>'delete-notes','type_id'=>$row->id])}}" onclick= "return confirm('Are you sure, you want to delete?')"><i class="icon-trash"></i></a>&nbsp
                                                   
                                  
</div>
                                                </td>
                                                                    </tr>
                                                                
                                    
                                                                                @endforeach
                                    
                                                                                @endif
                                    
                                                                            </tbody>
                                                                     
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade  @if($type == 'edit-notes') active show @endif" id="notes-profile2"
                                                        role="tabpanel" aria-labelledby="profile-tab2">
												                      
                                                        <div class="card">
                                                            <div class="card-header">
                                                              @if($type == 'edit-notes')
                                        <h5>Edit Notes</h5>
                                        @else
                                        <h5>Add New Notes</h5>
                                        @endif
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12 ">
                                                                      @if($type == 'edit-notes')

                                                                       {!! Form::open(array('route' => 'update.project_details',"enctype"=>"multipart/form-data")) !!}
                                                                         <input type="hidden" name="id" value="{{ $type_id}}">
                                                                        @else
                                                                        {!! Form::open(array('route' => 'save.project_details',"enctype"=>"multipart/form-data")) !!}                                                                                                                             
                                                                        @method('POST')
                                                                        @endif                                                                     
                                                                        

                                                                     <input type="hidden" name="project_id" value="{{ $id}}">
                                                                          <input type="hidden" name="type" value="notes">

                                                                        <div class="form-group row">
                                                                           

                                                                            <label class="col-lg-2 col-form-label">Notes  <span class="text-danger">*</span></label>
                                                                           <div class="col-lg-8">
                                                                              <textarea name="notes" 
                                                                    class="form-control" required>@if(isset($edit_data)){{ $edit_data->notes}} @endif</textarea>
                                                                            </div>
                                                                        </div>
                                                                       
 
                                                                    <div class="form-group row">
                                                                        <div class="col-lg-offset-2 col-lg-12">
                                                                            @if($type == 'edit-notes')
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