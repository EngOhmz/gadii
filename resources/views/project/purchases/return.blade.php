<div class="card-header"> <strong></strong> </div>
                                                
                                                <div class="card-body">
                                                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                                        <li class="nav-item">
                             <a class="nav-link @if($type == 'credit' || $type == 'details' || $type == 'calendar' || $type == 'purchase' || $type == 'debit' || $type == 'invoice' || $type == 'comments' || $type == 'attachment' || $type == 'milestone' || $type == 'tasks' || $type == 'expenses' || $type == 'estimate' || $type == 'notes' || $type == 'activities' ) active  @endif" id="home-tab2" data-toggle="tab"
                                                                href="#debit-home2" role="tab" aria-controls="home" aria-selected="true">Debit Note
                                                                List</a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link @if($type == 'edit-debit' || $type == 'debit-good-receive') active  @endif" id="profile-tab2"
                                                                data-toggle="tab" href="#debit-profile2" role="tab" aria-controls="profile"
                                                                aria-selected="false">New Debit Note</a>
                                                        </li>
                                        
                                                    </ul>
                                                    <br>
                                                    <div class="tab-content tab-bordered" id="myTab3Content">
                                    <div class="tab-pane fade @if($type == 'credit' || $type == 'details' || $type == 'calendar' || $type == 'purchase' || $type == 'debit' || $type == 'invoice' || $type == 'comments' || $type == 'attachment' || $type == 'milestone' || $type == 'tasks' || $type == 'expenses' || $type == 'estimate' || $type == 'notes' || $type == 'activities' ) active show  @endif " id="debit-home2" role="tabpanel"
                                                            aria-labelledby="home-tab2">
                                                            <div class="table-responsive">
                                                                <table class="table datatable-dn table-striped" style="width:100%">
                                                                    <thead>
                                                                        <tr role="row">                                    
                                        
                                                        <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 106.484px;">Ref No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 106.484px;">Purchases</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Supplier </th>
      
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Due Amount</th>
                                                      
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 121.219px;">Status</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="CSS grade: activate to sort column ascending"
                                                        style="width: 128.1094px;">Actions</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
    
                                                                        @if(!empty($dn))
                                                                         @foreach ($dn as $row)
                                                                        <tr class="gradeA even" role="row">
                                                                <td>
                                                        <a class="nav-link" id="profile-tab2"
                                                                href="{{ route('debit_note.show',$row->id)}}" role="tab"
                                                                aria-selected="false">{{$row->reference_no}}</a>
                                                    </td>
                                                        
                                                     <td> {{$row->purchase->reference_no }}</td>
                                                <td>
                                                      {{$row->supplier->name }}
                                                </td>
                                                
                                                

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
                                         <a class="list-icons-item text-primary" title="Edit"  href="{{route('edit.project_details',['type'=>'edit-debit','type_id'=>$row->id])}}"><i class="icon-pencil7"></i></a>&nbsp
                                      <a class="list-icons-item text-danger" title="Edit"  href="{{route('delete.project_details',['type'=>'delete-debit','type_id'=>$row->id])}}" onclick= "return confirm('Are you sure, you want to delete?')"><i class="icon-trash"></i></a>&nbsp
    @endif          
                                                                                      <div class="dropdown">
                                                        <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
                                                        <div class="dropdown-menu">
                                                                       @if($row->status == 0)
                                                                <a class="nav-link" id="profile-tab2"  href="{{route('edit.project_details',['type'=>'debit-good-receive','type_id'=>$row->id])}}">Approve Debit Note</a>
                                                                                             @endif
                                                                                        <a class="nav-link" id="profile-tab2" href="{{ route('debit_note_pdfview',['download'=>'pdf','id'=>$row->id]) }}"
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
                                                        <div class="tab-pane fade  @if($type == 'edit-debit' || $type == 'debit-good-receive') active show @endif" id="debit-profile2"
                                                            role="tabpanel" aria-labelledby="profile-tab2">
                                        <br>
                                                            <div class="card">
                                                                <div class="card-header">
                                                                  @if($type == 'edit-debit' || $type == 'debit-good-receive')
                                            <h5>Edit Debit Note</h5>
                                            @else
                                            <h5>Add New Debit Note</h5>
                                            @endif
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">
                                                                        <div class="col-sm-12 ">
                                                                          @if($type == 'edit-debit' || $type == 'debit-good-receive')
    
                                                                           {!! Form::open(array('route' => 'update.project_details',"enctype"=>"multipart/form-data")) !!}
                                                                             <input type="hidden" name="id" value="{{ $type_id}}">
                                                                            @else
                                                                            {!! Form::open(array('route' => 'save.project_details',"enctype"=>"multipart/form-data")) !!}                                                                                                                             
                                                                            @method('POST')
                                                                            @endif                                                                     
                                                                            
    
                                                                         <input type="hidden" name="project_id" value="{{ $id}}" class="form-control dn-project">
                                                                              <input type="hidden" name="type" value="debit">
    
                                                                   <input type="hidden" name="receive"  value="{{ isset($receive) ? $receive : ''}}" >
    
                                                                            <div class="form-group row">
    
                                                                               <label class="col-lg-2 col-form-label">Supplier Name <span class="text-danger">*</span></label>
                                                        <div class="col-lg-4">
                                                          
                                                                <select class="form-control m-b dn-client" name="supplier_id" required
                                                                    id="dn-supplier_id">
                                                                    <option value="">Select Supplier Name</option>
                                                                    @if(!empty($supplier))
                                                                    @foreach($supplier as $row)
    
                                                                    <option @if(isset($edit_data))
                                                                        {{  $edit_data->supplier_id == $row->id  ? 'selected' : ''}}
                                                                        @endif value="{{ $row->id}}">{{$row->name}}</option>
    
                                                                    @endforeach
                                                                    @endif
    
                                                                </select>
                                                                </div>
    
                                                                <label class="col-lg-2 col-form-label">Purchases<span class="text-danger">*</span></label>
                                                                               <div class="col-lg-4">
                                                                                   <select class="form-control m-b dn-invoice" name="purchase_id" required
                                                                    id="dn-invoice_id">
                                                                    <option value="">Select Purchases</option>
                                                                  
    
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
    
    
     <div class="dn-data" id="dn-data">
    
                                           </div>
                                                                         
                                        
                                                                      
                                                                            {!! Form::close() !!}
                                                                        </div>
                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                        
                                                    </div>
                                                </div>
                                                                
                                                
    
    
                                                
                    