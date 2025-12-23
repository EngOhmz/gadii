                                              <div class="card-header"> <strong>Expenses</strong> </div>
                                                
                                            <div class="card-body">
                                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                                    <li class="nav-item">
                         <a class="nav-link @if($type == 'credit' || $type == 'details' || $type == 'invoice' || $type == 'comments' || $type == 'attachment' || $type == 'tasks' || $type == 'expenses' || $type == 'estimate' || $type == 'notes' || $type == 'activities' ) active  @endif" id="home-tab2" data-toggle="tab"
                                                            href="#exp-home2" role="tab" aria-controls="home" aria-selected="true">Expenses
                                                            List</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        @if($type == 'edit-expenses')
                                                        <a class="nav-link active" id="profile-tab2"
                                                            data-toggle="tab" href="#exp-profile3" role="tab" aria-controls="profile"
                                                            aria-selected="false">Edit Expenses</a>
                                                            @else
                                                              <a class="nav-link " id="profile-tab2"
                                                            data-toggle="tab" href="#exp-profile2" role="tab" aria-controls="profile"
                                                            aria-selected="false">New Expenses</a>
                                                               @endif
                                                    </li>
                                    
                                                </ul>
                                                <br>
                                                <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if($type == 'credit' || $type == 'details' || $type == 'invoice' || $type == 'comments' || $type == 'attachment' || $type == 'tasks' || $type == 'expenses' || $type == 'estimate' || $type == 'notes' || $type == 'activities' ) active show  @endif " id="exp-home2" role="tabpanel"
                                                        aria-labelledby="home-tab2">
                                                        <div class="table-responsive">
                                                            <table class="table datatable-exp table-striped" style="width:100%">
                                                                <thead>
                                                                    <tr role="row">                                    
                                    
                                                   <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 28.531px;">#</th>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Reference</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Payment Account</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Amount</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @if(!empty($exp))
                                                                     @foreach ($exp as $row)
                                                                    <tr class="gradeA even" role="row">
                                                           <th>{{ $loop->iteration }}</th>
                                                     <td>{{$row->name}}</td>

                                                @php
                                                 $bank=App\Models\AccountCodes::where('id',$row->bank_id)->first();
                                                @endphp
                                                <td>{{$bank->account_name}}</td>                                           
                                                  <td>{{number_format($row->amount,2)}} {{$row->exchange_code}}</td>
                                                   <td>{{$row->date}}</td>
                                                <td>
                                        <div class="form-inline">
 <a  class="nav-link" title="View" data-toggle="modal" class="discount"  href="" onclick="model({{ $row->id }},'view')" value="{{ $row->id}}" data-target="#app2FormModal" >View List</a>
                                                   
</div>
                                                </td>
                                                                    </tr>
                                                                
                                    
                                                                                @endforeach
                                    
                                                                                @endif
                                    
                                                                            </tbody>
                                                                     
                                                            </table>
                                                        </div>
                                                    </div>
                                                  
                                                            @if($type == 'edit-expenses')

                                                               <div class="tab-pane fade  @if($type == 'edit-expenses') active show @endif" id="exp-profile2"
                                                        role="tabpanel" aria-labelledby="profile-tab2">
                                    <br>
                                                        <div class="card">
                                                            <div class="card-header">
                                                              @if($type == 'edit-expenses')
                                        <h5>Edit Expenses</h5>
                                        @else
                                        <h5>Add New Expenses</h5>
                                        @endif
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12 ">
                                                                      @if($type == 'edit-expenses')

                                                                       {!! Form::open(array('route' => 'update.project_details',"enctype"=>"multipart/form-data")) !!}
                                                                         <input type="hidden" name="id" value="{{ $type_id}}">
                                                                        @else
                                                                        {!! Form::open(array('route' => 'save.project_details',"enctype"=>"multipart/form-data")) !!}                                                                                                                             
                                                                        @method('POST')
                                                                        @endif                                                                     
                                                                        

                                                                     <input type="hidden" name="project_id" value="{{ $id}}">
                                                                          <input type="hidden" name="type" value="expenses">

                                                                       

                                                <div class="form-group row">
                           <label class="col-lg-2 col-form-label">Reference  <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="name" 
                                                            value="{{ isset($edit_data) ? $edit_data->name : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                
                                                 <div class="form-group row">
                           <label class="col-lg-2 col-form-label">Reference2</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="ref" 
                                                            value="{{ isset($edit_data) ? $edit_data->ref : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                               <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Amount  <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="number" name="amount" required
                                                            placeholder=""
                                                            value="{{ isset($edit_data) ? $edit_data->amount : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                  <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Date  <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="date" required
                                                            placeholder=""
                                                           value="{{ isset($edit_data) ? $edit_data->date : date('Y-m-d')}}" 
                                                            class="form-control">
                                                    </div>
                                                </div>
                                               
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Expense Account  <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                <select class="m-b account_id" id="account_id" name="account_id" required>
                                                    <option value="">Select Expense Account</option> 
                                                            @if(!empty($chart_of_accounts))                                                   
                                                            @foreach ($chart_of_accounts as $chart)                                                             
                                                            <option value="{{$chart->id}}" @if(isset($edit_data))@if($edit_data->account_id == $chart->id) selected @endif @endif >{{$chart->account_name}}</option>
                                                               @endforeach
                                                                  @endif
                                                             </select>
                                                    </div>
                                                </div>

                                                

                                                   <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Payment Account  <span class="text-danger">*</span></label>
                                                    <div class="col-lg-8">
                                                       <select class="m-b" id="bank_id" name="bank_id" required>
                                                    <option value="">Select Payment Account</option> 
                                                          @if(!empty($bank_accounts))  
                                                          @foreach ($bank_accounts as $bank)                                                             
                                                            <option value="{{$bank->id}}" @if(isset($edit_data))@if($edit_data->bank_id == $bank->id) selected @endif @endif >{{$bank->account_name}}</option>
                                                               @endforeach
                                                                 @endif
                                                              </select>
                                                    </div>
                                                </div>
                                               
                                                  <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Notes</label>
                                                    <div class="col-lg-8">
                                                        <textarea name="notes"
                                                            placeholder=""
                                                            class="form-control" rows="2">{{isset($edit_data) ? $edit_data->notes : '' }}</textarea>
                                                    </div>
                                                </div>
                                                                     
                                    
                                                                    <div class="form-group row">
                                                                        <div class="col-lg-offset-2 col-lg-12">
                                                                            @if($type == 'edit-expenses')
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

                                                               @else
                                                    <div class="tab-pane fade" id="exp-profile2"
                                                        role="tabpanel" aria-labelledby="profile-tab2">
                                    <br>
                                                        <div class="card">
                                                            <div class="card-header">
                                                              @if($type == 'edit-expenses')
                                        <h5>Edit Expenses</h5>
                                        @else
                                        <h5>Add New Expenses</h5>
                                        @endif
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12 ">
                                                                      @if($type == 'edit-expenses')

                                                                       {!! Form::open(array('route' => 'update.project_details',"enctype"=>"multipart/form-data")) !!}
                                                                         <input type="hidden" name="id" value="{{ $type_id}}">
                                                                        @else
                                                                        {!! Form::open(array('route' => 'save.project_details',"enctype"=>"multipart/form-data")) !!}                                                                                                                             
                                                                        @method('POST')
                                                                        @endif                                                                     
                                                                        

                                                                     <input type="hidden" name="project_id" value="{{ $id}}">
                                                                          <input type="hidden" name="type" value="expenses">

                                                                        <div class="form-group row">

                                                                            <label class="col-lg-2 col-form-label">Reference <span class="text-danger">*</span></label>
                                                                           <div class="col-lg-4">
                                                                               <input type="text" name="name" 
                                                            value="{{ isset($edit_data) ? $edit_data->name : ''}}"
                                                            class="form-control" required>
                                                             
                                                                            </div>

                                                                    <label class="col-lg-2 col-form-label">Reference2 </label>
                                                                           <div class="col-lg-4">
                                                                               <input type="text" name="ref" 
                                                            value="{{ isset($edit_data) ? $edit_data->ref : ''}}"
                                                            class="form-control">
                                                                        </div>
                                                                            </div>

                                                                       
                                                                        <div class="form-group row">
                                                                            <label class="col-lg-2 col-form-label"> Date  <span class="text-danger">*</span></label>                                                                                                        
                                                                            <div class="col-lg-4">
                                                                             <input type="date" name="date" required  placeholder=""  value="{{ isset($edit_data) ? $edit_data->date : date('Y-m-d')}}"   class="form-control">                                                         
                                                                            </div>
                                                                         <label class="col-lg-2 col-form-label">Payment Account<span class="text-danger">*</span></label>                                                                                                        
                                                                            <div class="col-lg-4">
                                                                              <select class="form-control m-b " id="bank2_id" name="bank_id" required>
                                                    <option value="">Select Payment Account</option> 
                                                          @foreach ($bank_accounts as $bank)                                                             
                                                            <option value="{{$bank->id}}" @if(isset($edit_data))@if($edit_data->bank_id == $bank->id) selected @endif @endif >{{$bank->account_name}}</option>
                                                               @endforeach
                                                              </select>
                                                                            </div>
                        
                                                                       
                                                                    </div>


                                                       <br>
                                               
                                               
                                               
                                          <hr>
                                                <button type="button" name="add" class="btn btn-success btn-xs exp_add"><i
                                                        class="fas fa-plus"> Add item</i></button><br>
                                                <br>
                                                <div class="table-responsive">
                                                <table class="table table-bordered" id="exp_cart">
                                                    <thead>
                                                        <tr>
                                                            <th>Expense Account</th>
                <th>Amount</th>
                <th>Notes</th>                
                <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                    </tbody>
                                                    
                                                </table>
                                            </div>


                                 
                                                                     
                                    
                                                                    <div class="form-group row">
                                                                        <div class="col-lg-offset-2 col-lg-12">
                                                                            @if($type == 'edit-expenses')
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
                                                     @endif
                                    
                                                </div>
                                            </div>
												            
											


											
				