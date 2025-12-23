 <div class="card-header"> <strong>Attachment</strong> </div>
                                                
                                            <div class="card-body">
                                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                                    <li class="nav-item">
                         <a class="nav-link @if($type == 'details' || $type == 'comments' || $type == 'attachment' || $type == 'tasks' || $type == 'notes' || $type == 'activities' ) active  @endif" id="home-tab2" data-toggle="tab"
                                                            href="#home2" role="tab" aria-controls="home" aria-selected="true">Attachment
                                                            List</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link @if($type == 'edit-attachment') active  @endif" id="profile-tab2"
                                                            data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                                            aria-selected="false">New Attachment</a>
                                                    </li>
                                    
                                                </ul>
                                                <br>
                                                <div class="tab-content tab-bordered" id="myTab3Content">
                                                    <div class="tab-pane fade @if($type == 'details'|| $type == 'comments' || $type == 'attachment' || $type == 'tasks' || $type == 'notes' || $type == 'activities' ) active show  @endif " id="home2" role="tabpanel"
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
                                                    style="width: 106.484px;">Title</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Attachment</th>
                                                   
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @if(!@empty($attach))
                                            @foreach ($attach as $row)
                                                                    <tr class="gradeA even" role="row">
                                                           <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->title}}</td>
                                               <td><a href="#" class="nav-link"  data-toggle="modal" data-target="#appFormModal"  data-id="{{ $row->id }}" data-type="view"  onclick="model({{ $row->id }},'view')">View Attachment</a></td>
                                                <td>
                                        <div class="form-inline">

                                     <a class="list-icons-item text-primary" title="Edit"  href="{{route('edit.task_details',['type'=>'edit-attachment','type_id'=>$row->id])}}"><i class="icon-pencil7"></i></a>&nbsp
                                  <a class="list-icons-item text-danger" title="Edit"  href="{{route('delete.task_details',['type'=>'delete-attachment','type_id'=>$row->id])}}" onclick= "return confirm('Are you sure, you want to delete?')"><i class="icon-trash"></i></a>&nbsp
                                                   
                                  
</div>
                                                </td>
                                                                    </tr>
                                                                
                                    
                                                                                @endforeach
                                    
                                                                                @endif
                                    
                                                                            </tbody>
                                                                     
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade  @if($type == 'edit-attachment') active show @endif" id="profile2"
                                                        role="tabpanel" aria-labelledby="profile-tab2">
                                    <br>
                                                        <div class="card">
                                                            <div class="card-header">
                                                              @if($type == 'edit-attachment')
                                        <h5>Edit Attachment</h5>
                                        @else
                                        <h5>Add New Attachment</h5>
                                        @endif
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12 ">
                                                                      @if($type == 'edit-attachment')

                                                                       {!! Form::open(array('route' => 'update.task_details',"enctype"=>"multipart/form-data")) !!}
                                                                         <input type="hidden" name="id" value="{{ $type_id}}">
                                                                        @else
                                                                        {!! Form::open(array('route' => 'save.task_details',"enctype"=>"multipart/form-data")) !!}                                                                                                                             
                                                                        @method('POST')
                                                                        @endif                                                                     
                                                                        

                                                                     <input type="hidden" name="task_id" value="{{ $id}}">
                                                                          <input type="hidden" name="type" value="attachment">

                                                                        <div class="form-group row">
                                                                            <label class="col-lg-2 col-form-label">Title <span class="text-danger">*</span></label>
                                                                            <div class="col-lg-4">
                                                                                <input type="text" name="title"
                                                                                    value="{{ isset($edit_data) ? $edit_data->title : ''}}"
                                                                                    class="form-control" required>
                                                                            </div>
                                                                        

                                                                            <label class="col-lg-2 col-form-label">Description </label>
                                                                           <div class="col-lg-4">
                                                                              <textarea name="description" 
                                                                    class="form-control" >@if(isset($edit_data)){{ $edit_data->description}} @endif</textarea>
                                                                            </div>
                                                                        </div>
                                                                       
                                                                        <div class="form-group row">
                                                                            <label
                                                                                class="col-lg-2 col-form-label">Attachment  <span class="text-danger">*</span></label>
                        
                                                                            <div class="col-lg-10">

                                                     
                                                                                <input type="file" class="file-input" data-show-upload="false" name="attachment"  value="{{ isset($edit_data) ? $edit_data->attachment : ''}}">
                                                                            </div>
                                                                       
                        
                                                                       
                                                                    </div>
                                                                     
                                    
                                                                    <div class="form-group row">
                                                                        <div class="col-lg-offset-2 col-lg-12">
                                                                            @if($type == 'edit-attachment')
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
                                   