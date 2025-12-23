                                              <div class="card-header"> <strong></strong> </div>
                                                
                                            <div class="card-body">
                                                <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                                    <li class="nav-item">
                         <a class="nav-link @if($type == 'details' || $type == 'calls'  || $type == 'meetings'   || $type == 'comments' || $type == 'attachment' || $type == 'tasks' || $type == 'proposal' || $type == 'reminder'  || $type == 'notes' || $type == 'activities') active  @endif" id="home-tab2" data-toggle="tab"
                                                            href="#est-home2" role="tab" aria-controls="home" aria-selected="true">Proposal
                                                            List</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link @if($type == 'edit-proposal') active  @endif" id="profile-tab2"
                                                            data-toggle="tab" href="#est-profile2" role="tab" aria-controls="profile"
                                                            aria-selected="false">New Proposal</a>
                                                    </li>
                                    
                                                </ul>
                                                <br>
                                                <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if($type == 'details' || $type == 'calls'  || $type == 'meetings'   || $type == 'comments' || $type == 'attachment' || $type == 'tasks' || $type == 'proposal' || $type == 'reminder'  || $type == 'notes' || $type == 'activities') active show  @endif " id="est-home2" role="tabpanel"
                                                        aria-labelledby="home-tab2">
                                                        <div class="table-responsive">
                                                            <table class="table datatable-proposal table-striped" style="width:100%">
                                                                <thead>
                                                                    <tr role="row">                                    
                                    
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Ref No</th>
                                                       <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Proposal Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 136.484px;">Expire Date</th>
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

                                                                    @if(!empty($proposal))
                                                                     @foreach ($proposal as $row)
                                                                    <tr class="gradeA even" role="row">
                                                             <td>
                                                    <a class="nav-link" id="profile-tab2"
                                                            href="#" role="tab"
                                                            aria-selected="false">{{$row->reference_no}}</a>
                                                </td>
                                                    <td>{{$row->proposal_date }}  </td>
                                                <td>{{$row->expire_date}}</td>
                                                <td>
                                                    @if($row->status == 0)
                                                    <div class="badge badge-secondary badge-shadow">Draft</div>
                                                    @elseif($row->status == 1)
                                                    <div class="badge badge-primary badge-shadow">Sent</div>
                                                    @elseif($row->status == 2)
                                                    <div class="badge badge-info badge-shadow">Open</div>
                                                    @elseif($row->status == 3)
                                                    <span class="badge badge-warning badge-shadow">Revised</span>
                                                    @elseif($row->status == 4)
                                                    <span class="badge badge-danger badge-shadow">Declined</span>
                                                    @elseif($row->status == 5)
                                                    <span class="badge badge-success badge-shadow">Accepted</span>

                                                    @endif
                                                </td>
                                                <td>
                                        <div class="form-inline">

                                     <a class="list-icons-item text-primary" title="Edit"  href="{{route('edit.lead_details',['type'=>'edit-proposal','type_id'=>$row->id])}}"><i class="icon-pencil7"></i></a>&nbsp
                                  <a class="list-icons-item text-danger" title="Edit"  href="{{route('delete.lead_details',['type'=>'delete-proposal','type_id'=>$row->id])}}" onclick= "return confirm('Are you sure, you want to delete?')"><i class="icon-trash"></i></a>&nbsp&nbsp


                                                   

</div>
                                                </td>
                                                                    </tr>
                                                                                                    
                                                                                @endforeach
                                                                                @endif
                                    
                                                                            </tbody>
                                                                     
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade  @if($type == 'edit-proposal') active show @endif" id="est-profile2"
                                                        role="tabpanel" aria-labelledby="profile-tab2">
                                    <br>
                                                        <div class="card">
                                                            <div class="card-header">
                                                              @if($type == 'edit-proposal')
                                        <h5>Edit Proposal</h5>
                                        @else
                                        <h5>Add New Proposal</h5>
                                        @endif
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-sm-12 ">
                                                                      @if($type == 'edit-proposal')

                                                                       {!! Form::open(array('route' => 'update.lead_details',"enctype"=>"multipart/form-data")) !!}
                                                                         <input type="hidden" name="id" value="{{ $type_id}}">
                                                                        @else
                                                                        {!! Form::open(array('route' => 'save.lead_details',"enctype"=>"multipart/form-data")) !!}                                                                                                                             
                                                                        @method('POST')
                                                                        @endif                                                                     
                                                                        

                                                                     <input type="hidden" name="leads_id" value="{{ $id}}">
                                                                          <input type="hidden" name="type" value="proposal">
                                                                          
                                                                          @php $lead_name = App\Models\Leads\Leads::find($id)->lead_name; @endphp

                                                                        <div class="form-group row">
                                                                              <label class="col-lg-2 col-form-label">Realted To <span class="text-danger">*</span></label>
                                                    <div class="col-lg-4">
                                                            <select class="form-control m-b" name="related">
                                                                <option selected>Leads</option>
                                                            </select>
                                                            </div>
                                                            
                                                            

                                                       <label class="col-lg-2 col-form-label">Selected Leads<span class="text-danger">*</span></label>
                                                                           <div class="col-lg-4">
                                                                               <select class="form-control m-b est_location">
                                                        <option selected>{{$lead_name}}</option>

                                                    </select>
                                                             
                                                                            </div>
                                                                        </div>


                                                                       
                                                                        <div class="form-group row">
                                                                            <label class="col-lg-2 col-form-label">Proposal Date  <span class="text-danger">*</span></label>                                                                                                        
                                                                            <div class="col-lg-4">
                                                                             <input type="date" name="proposal_date" required  placeholder=""  value="{{ isset($edit_data) ? $edit_data->proposal_date : date('Y-m-d')}}"   class="form-control">                                                         
                                                                            </div>
                                                                         <label class="col-lg-2 col-form-label">Expire Date<span class="text-danger">*</span></label>                                                                                                        
                                                                            <div class="col-lg-4">
                                                                             <input type="date" name="expire_date" required  placeholder=""  value="{{ isset($edit_data) ? $edit_data->expire_date : strftime(date('Y-m-d', strtotime("+10 days")))}}"   class="form-control">                                                         
                                                                            </div>
                        
                                                                       
                                                                    </div>
                                                                    
                                                                    <div class="form-group row">
                                                                            <label class="col-lg-2 col-form-label">Discount Type  <span class="text-danger">*</span></label>                                                                                                        
                                                                            <div class="col-lg-4">
                                                                             
                                                                             <select class="m-b" id="discount" name="discount" required>  
                                                                                <option value="">Select Discount Type</option>                                                                                                                                                                     
                                                                                <option value="No Discount" @if(isset($edit_data))@if($edit_data->task_status == 'No Discount') selected @endif @endif >No Discount</option>                                                            
                                                                                 <option value="Before Tax" @if(isset($edit_data))@if($edit_data->task_status == 'Before Tax') selected @endif @endif >Before Tax</option>                                                             
                                                                                    <option value="After Tax" @if(isset($edit_data))@if($edit_data->task_status == 'After Tax') selected @endif @endif >After Tax</option>
                                                                                  
                                                                              </select>
                                                              
                                                              
                                                                            </div>
                                                                         <label class="col-lg-2 col-form-label">Status <span class="text-danger">*</span></label>                                                                                                        
                                                                            <div class="col-lg-4">
                                                                             <select class="m-b" id="status" name="status" required>  
                                                                                <option value="">Select Status</option>                                                                                                                                                                     
                                                                                <option value="0" @if(isset($edit_data))@if($edit_data->status == '0') selected @endif @endif >Draft</option>                                                            
                                                                                 <option value="1" @if(isset($edit_data))@if($edit_data->status == '1') selected @endif @endif >Sent</option>                                                             
                                                                                    <option value="2" @if(isset($edit_data))@if($edit_data->status == '2') selected @endif @endif >Open</option>
                                                                                  <option value="3" @if(isset($edit_data))@if($edit_data->status == '3') selected @endif @endif >Revised</option>                                                            
                                                                                   <option value="4" @if(isset($edit_data))@if($edit_data->status == '4') selected @endif @endif >Declined</option> 
                                                                                   <option value="5" @if(isset($edit_data))@if($edit_data->status == '5') selected @endif @endif >Accepted</option> 
                                                                                  </select>
                                                                           
                                                                            </div>
                        
                                                                       
                                                                    </div>
                                                                    
                                                <div class="form-group row">
                                                 <label class="col-lg-2 col-form-label">Notes</label>
                                                    <div class="col-lg-8">
                                                    <textarea class="form-control" name="notes">{{ isset($edit_data) ? $edit_data->notes : ''}}</textarea>
                                                      
                                                    </div>
                                                </div>
                                                                    
@if(!empty($edit_data))
<?php
$list=explode(",", $edit_data->assigned_to);
?>
@endif
                                                   <div class="form-group row">
                                                 <label class="col-lg-2 col-form-label">Assigned To</label>
                                                    <div class="col-lg-8">
                                                     @if(!empty($users))
                                                      <input type="checkbox" name="select_all"  id="example-select-all"> Select All <br>
                                            @foreach ($users as $row)
                                    <input name="trans_id[]" type="checkbox"  class="checks" value="{{$row->id}}" @if(!empty($edit_data)) <?php if(in_array("$row->id",$list)){echo "checked";}?> @endif> {{$row->name}} &nbsp;
                                            @endforeach
                                                   @endif
                                                      
                                                    </div>
                                                </div>


                                                       <br>
                                                <h4 align="center">Enter Item Details</h4>
                                                <hr>
                                               <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Currency</label>
                                                    <div class="col-lg-4">
                                                       @if(!empty($edit_data->exchange_code))

                              <select class="form-control m-b" name="exchange_code" id="currency_code" required >
                            <option value="{{ old('currency_code')}}" disabled selected>Choose option</option>
                            @if(isset($currency))
                            @foreach($currency as $row)
                            <option  @if(isset($edit_data)) {{$edit_data->exchange_code == $row->code ? 'selected' : 'TZS' }} @endif  value="{{ $row->code }}">{{ $row->name }}</option>
                            @endforeach
                            @endif
                        </select>

                         @else
                       <select class="form-control m-b" name="exchange_code" id="currency_code" required >
                            <option value="{{ old('currency_code')}}" disabled >Choose option</option>
                            @if(isset($currency))
                            @foreach($currency as $row)

                           @if($row->code == 'TZS')
                            <option value="{{ $row->code }}" selected>{{ $row->name }}</option>
                           @else
                          <option value="{{ $row->code }}" >{{ $row->name }}</option>
                           @endif

                            @endforeach
                            @endif
                        </select>


                     @endif
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Tags</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="tags"
                                                            placeholder="Tag"
                                                            value="{{ isset($edit_data) ? $edit_data->tags : ''}}"
                                                            class="form-control" >
                                                    </div>
                                                </div>


                                          <hr>
                                                <button type="button" name="add" class="btn btn-success btn-xs est_add"><i
                                                        class="fas fa-plus"> Add item</i></button><br>
                                                <br>
                                                <div class="table-responsive">
                                                <table class="table table-bordered" id="est_cart">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Quantity</th>
                                                            <th>Price</th>
                                                           
                                                            <th>Tax</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                    </tbody>
                                                    <tfoot>
                                                        @if(!empty($type_id))
                                                        @if(!empty($items))
                                                        @foreach ($items as $i)
                                                        <tr class="line_items">
                                                            <td><select name="item_name[]"
                                                                    class="form-control  m-b est_item_name" required
                                                                    data-sub_category_id={{$i->order_no}}>
                                                                    <option value="">Select Item</option>
                                                                       @if(!empty($name))
                                                                     @foreach ($name as $n)
                                                                
                                                                     <option value="{{ $n->id}}"
                                                                        @if(isset($i))@if($n->id == $i->item_name)
                                                                        selected @endif @endif >{{$n->name}}</option>
                                                                    @endforeach
                                                                           @endif
                                                                </select></td>
                                                            <td><input type="number" name="quantity[]"
                                                                   class="form-control est_item_quantity" data-category_id="{{$i->order_no}}"
                                                                    placeholder="quantity" id="quantity"
                                                                    value="{{ isset($i) ? $i->quantity : ''}}"
                                                                    required /><div class=""> <p class="form-control-static est_errors{{$i->order_no}}" id="errors" style="text-align:center;color:red;"></p>   </div></td>
                                                            <td><input type="text" name="price[]"
                                                                    class="form-control est_item_price{{$i->order_no}}"
                                                                    placeholder="price" required
                                                                    value="{{ isset($i) ? $i->price : ''}}" /></td>
                                                           <input type="hidden" name="unit[]"
                                                                    class="form-control est_item_unit{{$i->order_no}}"
                                                                    placeholder="unit" required
                                                                    value="{{ isset($i) ? $i->unit : ''}}" />
                                                            <td><select name="tax_rate[]"
                                                                    class="form-control  m-b item_tax'+count{{$i->order_no}}"
                                                                    required>
                                                                    <option value="0">Select Tax Rate</option>
                                                                    <option value="0" @if(isset($i))@if('0'==$i->
                                                                        tax_rate) selected @endif @endif>No tax</option>
                                                                    <option value="0.18" @if(isset($i))@if('0.18'==$i->
                                                                        tax_rate) selected @endif @endif>18%</option>
                                                                </select></td>
                                                            <input type="hidden" name="total_tax[]"
                                                                class="form-control item_total_tax{{$i->order_no}}'"
                                                                placeholder="total" required
                                                                value="{{ isset($i) ? $i->total_tax : ''}}" readonly
                                                                jAutoCalc="{quantity} * {price} * {tax_rate}" />
                                                            <input type="hidden" name="saved_items_id[]"
                                                                class="form-control item_saved{{$i->order_no}}"
                                                                value="{{ isset($i) ? $i->id : ''}}"
                                                                required />
                                                            <td><input type="text" name="total_cost[]"
                                                                    class="form-control item_total{{$i->order_no}}"
                                                                    placeholder="total" required
                                                                    value="{{ isset($i) ? $i->total_cost : ''}}"
                                                                    readonly jAutoCalc="{quantity} * {price}" /></td>
                                                               <input type="hidden" id="item_id"  class="form-control est_item_id{{$i->order_no}}" value="{{$i->items_id}}" />
                                                            <input type="hidden" name="items_id[]"
                                                                class="form-control name_list"
                                                                value="{{ isset($i) ? $i->id : ''}}" />
                                                            <td><button type="button" name="remove"
                                                                    class="btn btn-danger btn-xs est-rem"
                                                                    value="{{ isset($i) ? $i->id : ''}}"><i class="icon-trash"></i></button></td>
                                                        </tr>

                                                        @endforeach
                                                        @endif
                                                        @endif

                                                        <tr class="line_items">
                                                            <td colspan="3"></td>
                                                            <td><span class="bold">Sub Total </span>: </td>
                                                            <td><input type="text" name="subtotal[]"
                                                                    class="form-control item_total"
                                                                    placeholder="subtotal" required
                                                                    jAutoCalc="SUM({total_cost})" readonly></td>
                                                        </tr>
                                                        <tr class="line_items">
                                                            <td colspan="3"></td>
                                                            <td><span class="bold">Tax </span>: </td>
                                                            <td><input type="text" name="tax[]"
                                                                    class="form-control item_total" placeholder="tax"
                                                                    required jAutoCalc="SUM({total_tax})" readonly>
                                                            </td>
                                                        </tr>
                                                        
                                                        <tr class="line_items">
                                                            <td colspan="3"></td>
                                                            <td><span class="bold">Total</span>: </td>
                                                            <td><input type="text" name="amount[]"
                                                                    class="form-control item_total" placeholder="total"
                                                                    required jAutoCalc="{subtotal} + {tax}" readonly>
                                                            </td>
                                                          
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>


                                 
                                                                     
                                    
                                                                    <div class="form-group row">
                                                                        <div class="col-lg-offset-2 col-lg-12">
                                                                            @if($type == 'edit-proposal')
                                                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                                data-toggle="modal" data-target="#myModal"
                                                                                type="submit" id="est_save">Update</button>
                                                                            @else
                                                                            <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                                type="submit" id="est_save">Save</button>
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
												            
											


											
				