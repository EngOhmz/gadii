                                              <div class="card-header"> <strong></strong> </div>
                                                
                                            <div class="card-body">
                                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                                    <li class="nav-item">
                         <a class="nav-link @if($type == 'credit' || $type == 'details' || $type == 'calendar' || $type == 'purchase' || $type == 'debit' || $type == 'invoice' || $type == 'comments' || $type == 'attachment' || $type == 'milestone' || $type == 'tasks' || $type == 'expenses' || $type == 'estimate' || $type == 'notes' || $type == 'activities' ) active  @endif" id="home-tab2" data-toggle="tab"
                                                            href="#credit-home2" role="tab" aria-controls="home" aria-selected="true">Credit Note
                                                            List</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link @if($type == 'edit-credit' || $type == 'credit-good-receive') active  @endif" id="profile-tab2"
                                                            data-toggle="tab" href="#credit-profile2" role="tab" aria-controls="profile"
                                                            aria-selected="false">New Credit Note</a>
                                                    </li>
                                    
                                                </ul>
                                                <br>
                                                <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if($type == 'credit' || $type == 'details' || $type == 'calendar' || $type == 'purchase' || $type == 'debit' || $type == 'invoice' || $type == 'comments' || $type == 'attachment' || $type == 'milestone' || $type == 'tasks' || $type == 'expenses' || $type == 'estimate' || $type == 'notes' || $type == 'activities' ) active show  @endif " id="credit-home2" role="tabpanel"
                                                        aria-labelledby="home-tab2">
                                                        <div class="table-responsive">
                                                            <table class="table datatable-credit table-striped" style="width:100%">
                                                                <thead>
                                                                    <tr role="row">                                    
                                    
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Ref No</th>
                                                  <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Invoice No</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Client Name</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 136.484px;">Return Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 161.219px;">Due Amount</th>
                                                  
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 168.1094px;">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @if(!empty($crd))
                                                                     @foreach ($crd as $row)
                                                                    <tr class="gradeA even" role="row">
                                                            <td>
                                                    <a class="nav-link" id="profile-tab2"
                                                            href="{{ route('credit_note.show',$row->id)}}" role="tab"
                                                            aria-selected="false">{{$row->reference_no}}</a>
                                                </td>
                                                     <td> {{$row->invoice->reference_no }}</td>
                                                <td>
                                                      {{$row->client->name }}
                                                </td>
                                                
                                                <td>{{$row->return_date}}</td>

                                                <td>{{number_format($row->due_amount,2)}} {{$row->exchange_code}}</td>
                                                <td>
                                                    @if($row->status == 0)
                                                    <div class="badge badge-danger badge-shadow">Not Approved</div>
                                                    @elseif($row->status == 1)
                                                    <div class="badge badge-success badge-shadow">Approved</div>
                                                    @elseif($row->status == 2)
                                                    <div class="badge badge-info badge-shadow">Partially Paid</div>
                                                    @elseif($row->status == 3)
                                                    <span class="badge badge-success badge-shadow">Fully Paid</span>
                                                    @elseif($row->status == 4)
                                                    <span class="badge badge-danger badge-shadow">Cancelled</span>

                                                    @endif
                                                </td>
                                                <td>
                                        <div class="form-inline">
                                              @if($row->status == 0)
                                     <a class="list-icons-item text-primary" title="Edit"  href="{{route('edit.project_details',['type'=>'edit-credit','type_id'=>$row->id])}}"><i class="icon-pencil7"></i></a>&nbsp
                                  <a class="list-icons-item text-danger" title="Edit"  href="{{route('delete.project_details',['type'=>'delete-credit','type_id'=>$row->id])}}" onclick= "return confirm('Are you sure, you want to delete?')"><i class="icon-trash"></i></a>&nbsp
@endif          
                                                                                  <div class="dropdown">
							                		<a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
													<div class="dropdown-menu">
                                                                   @if($row->status == 0)
                                                            <a class="nav-link" id="profile-tab2"  href="{{route('edit.project_details',['type'=>'credit-good-receive','type_id'=>$row->id])}}">Approve Credit Note</a>
                                                                                         @endif
                                                                                    <a class="nav-link" id="profile-tab2" href="{{ route('credit_note_pdfview',['download'=>'pdf','id'=>$row->id]) }}"
                                            role="tab"  aria-selected="false">Download PDF</a>
                                                               													</div>
					                			</div>
                                                   
                                                                                   

</div>
                                                </td>
                                                                    </tr>
                                                                
                                    
                                                                                @endforeach
                                    
                                                                                @endif
                                    
                                                                            </tbody>
                                                                     
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade  @if($type == 'edit-credit' || $type == 'credit-good-receive') active show @endif" id="credit-profile2"
                                                        role="tabpanel" aria-labelledby="profile-tab2">
                                    <br>
                                                        <div class="card">
                                                            <div class="card-header">
                                                              @if($type == 'edit-credit' || $type == 'credit-good-receive')
                                        <h5>Edit Credit Note</h5>
                                        @else
                                        <h5>Add New Credit Note</h5>
                                        @endif
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12 ">
                                                                      @if($type == 'edit-credit' || $type == 'credit-good-receive')

                                                                       {!! Form::open(array('route' => 'update.project_details',"enctype"=>"multipart/form-data")) !!}
                                                                         <input type="hidden" name="id" value="{{ $type_id}}">
                                                                        @else
                                                                        {!! Form::open(array('route' => 'save.project_details',"enctype"=>"multipart/form-data")) !!}                                                                                                                             
                                                                        @method('POST')
                                                                        @endif                                                                     
                                                                        

                                                                     <input type="hidden" name="project_id" value="{{ $id}}" class="form-control crd-project">
                                                                          <input type="hidden" name="type" value="credit">

                                                               <input type="hidden" name="receive"  value="{{ isset($receive) ? $receive : ''}}" >

                                                                        <div class="form-group row">

                                                                           <label class="col-lg-2 col-form-label">Client Name <span class="text-danger">*</span></label>
                                                    <div class="col-lg-4">
                                                      
                                                            <select class="form-control m-b crd-client" name="client_id" required
                                                                id="crd-client_id">
                                                                <option value="">Select Client Name</option>
                                                                @if(!empty($client))
                                                                @foreach($client as $row)

                                                                <option @if(isset($edit_data))
                                                                    {{  $edit_data->client_id == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                                @endforeach
                                                                @endif

                                                            </select>
                                                            </div>

                                                                            <label class="col-lg-2 col-form-label">Invoice <span class="text-danger">*</span></label>
                                                                           <div class="col-lg-4">
                                                                               <select class="form-control m-b crd-invoice" name="invoice_id" required
                                                                id="crd-invoice_id">
                                                                <option value="">Select Invoice</option>
                                                              

                                                            </select>
                                                             
                                                                            </div>
                                                                        </div>


                                                                       
                                                                        <div class="form-group row">
                                                                            <label class="col-lg-2 col-form-label">Return Date  <span class="text-danger">*</span></label>                                                                                                        
                                                                            <div class="col-lg-4">
                                                                             <input type="date" name="return_date" required  placeholder=""  value="{{ isset($edit_data) ? $edit_data->return_date : date('Y-m-d')}}"   class="form-control">                                                         
                                                                            </div>
                                                                         <label class="col-lg-2 col-form-label">End Date<span class="text-danger">*</span></label>                                                                                                        
                                                                            <div class="col-lg-4">
                                                                             <input type="date" name="due_date" required  placeholder=""  value="{{ isset($edit_data) ? $edit_data->due_date : strftime(date('Y-m-d', strtotime("+10 days")))}}"   class="form-control">                                                         
                                                                            </div>
                        
                                                                       
                                                                    </div>


 <div class="crd-data" id="crd-data">

                                       </div>
                                                                     
                                    
                                                                  
                                                                        {!! Form::close() !!}
                                                                    </div>
                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                    
                                                </div>
                                            </div>
												            
											


											
				