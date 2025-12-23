@extends('layouts.master')

@push('plugin-styles')
 <style>
 .body > .line_items{
     border:1px solid #ddd;
 }
 </style>

@endpush

@section('content')




<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Requisition</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Requisition List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Requisition</a>
                            </li>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                
                                 <!-- Create the drop down filter -->
                                 
                    <div class="category-filter">
                    <label><span>Filter by Status</span> 
                      <select id="categoryFilter" class="form-control m-b">
                        <option value="">Show All</option>
                        <option value="Not Approve">Not Approve</option>
                        <option value="Approved">Approved</option>
                         <option value="Cancelled">Cancelled</option>
                        
                      </select>
                      </label>
                    </div>
    
                                   <table class="table" id="example" class="display">
                                        <thead>
                                            <tr>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 116.484px;">Ref No</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Supplier</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Date</th>
                                                   
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                   style="width: 141.219px;">Amount</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 131.219px;">Location</th>
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
                                            @if(!@empty($purchases))
                                            @foreach ($purchases as $row)
                                            <tr class="gradeA even" role="row">

                                                <td><a href="{{ route('requisition.show',$row->id)}}">{{$row->reference_no}}</a></td>
                                                <td>@if(!empty($row->supplier)){{$row->supplier->name}}@endif</td>
                                                <td>{{Carbon\Carbon::parse($row->purchase_date)->format('d/m/Y') }}</td>
                                                <td>{{number_format($row->due_amount,2)}} {{$row->exchange_code}}</td>

                                                <td>
                                                     @if(!empty($row->location))
                                                    @php    
                                                    $loc=App\Models\Location::where('id', $row->location)->get();   
                                                  @endphp
                                                     @foreach($loc as $l)
                                                    {{$l->name}}
                                                    @endforeach
                                                   @endif
                                                </td>
                                               

                                                <td>
                                                    @if($row->status == 0)
                                                    <div class="badge badge-danger badge-shadow">Not Approve</div>
                                                    @elseif($row->status == 1)
                                                    <div class="badge badge-success badge-shadow">Approved</div>
                                                    @elseif($row->status == 4)
                                                    <span class="badge badge-danger badge-shadow">Cancelled</span>

                                                    @endif
                                                </td>
                                               
                                               
                                                <td>
                                             <div class="form-inline">
                                              @if ($row->status == 0)
                                            <a class="list-icons-item text-primary" title="Edit" onclick="return confirm('Are you sure?')" href="{{ route('requisition.edit', $row->id)}}">
                                            <i class="icon-pencil7"></i></a>&nbsp

                                            {!! Form::open(['route' => ['requisition.destroy',$row->id],
                                            'method' => 'delete']) !!}
                                         {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                            {{ Form::close() }}
                                              @endif
                                              
                                         <div class="dropdown">
                                  <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
                                         <div class="dropdown-menu">
                                           @if ($row->status == 0)
                                <a class="nav-link" id="profile-tab2" href="{{ route('requisition.receive',$row->id)}}">Approve</a>
                                 <a class="nav-link" title="Cancel" onclick="return confirm('Are you sure?')" href="{{ route('requisition.cancel', $row->id)}}">Cancel</a>
                                       @endif 
                                       
                                      
                                <a class="nav-link" id="profile-tab2" href="{{ route('requisition_pdfview',['download'=>'pdf','id'=>$row->id]) }}">Download PDF</a>
                                      
                                  
                                                        </div>
                                </div>

                                                
                                                </div>
                                                
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
                                        <h5>Create Requisition</h5>
                                        @else
                                        <h5>Edit Requisition </h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('requisition.update', $id), 'method' => 'PUT')) }}
                                              
                                                @else
                                                {{ Form::open(['route' => 'requisition.store']) }}
                                                @method('POST')
                                                @endif


                                                <input type="hidden" name="edit_type"
                                                class="form-control name_list"
                                                value="{{$type}}" />
                                                
                                                  @if(empty($type))
                                                 <div class="form-group row">
                                                 <label class="col-lg-2 col-form-label">Supplier Name</label>
                                                        <div class="col-lg-4">
                                                            <div class="input-group mb-3">
                                                                <select
                                                                    class="form-control append-button-single-field supplier_id"
                                                                    name="supplier_id" id="supplier_id" required>
                                                                    <option value="">Select Supplier Name</option>
                                                                    @if (!empty($supplier))
                                                                        @foreach ($supplier as $row)
                                                                            <option
                                                                                @if (isset($data)) {{ $data->supplier_id == $row->id ? 'selected' : '' }} @endif
                                                                                value="{{ $row->id }}">
                                                                                {{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif

                                                                </select>&nbsp

                                                                <button class="btn btn-outline-secondary" type="button"
                                                                    data-toggle="modal" value=""
                                                                    onclick="model('1','supplier')"
                                                                    data-target="#appFormModal" href="appFormModal"><i
                                                                        class="icon-plus-circle2"></i></button>

                                                            </div>
                                                        </div>
                                                        </div>
                                                        
                                                        @endif
                                                
                                                @if(!empty($type))

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Location</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control m-b " name="location" required
                                                        id="location">
                                                        <option value="">Select Location</option>
                                                        @if(!empty($location))
                                                        @foreach($location as $loc)

                                                        <option @if(isset($data))
                                                            {{  $data->location == $loc->id  ? 'selected' : ''}}
                                                            @endif value="{{ $loc->id}}">{{$loc->name}}</option>

                                                        @endforeach
                                                        @endif

                                                    </select>
                                                        
                                                    </div>
                                                    
                                                     <label class="col-lg-2 col-form-label">Supplier Name</label>
                                                        <div class="col-lg-4">
                                                            <div class="input-group mb-3">
                                                                <select
                                                                    class="form-control append-button-single-field supplier_id"
                                                                    name="supplier_id" id="supplier_id" required>
                                                                    <option value="">Select Supplier Name</option>
                                                                    @if (!empty($supplier))
                                                                        @foreach ($supplier as $row)
                                                                            <option
                                                                                @if (isset($data)) {{ $data->supplier_id == $row->id ? 'selected' : '' }} @endif
                                                                                value="{{ $row->id }}">
                                                                                {{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif

                                                                </select>&nbsp

                                                                <button class="btn btn-outline-secondary" type="button"
                                                                    data-toggle="modal" value=""
                                                                    onclick="model('1','supplier')"
                                                                    data-target="#appFormModal" href="appFormModal"><i
                                                                        class="icon-plus-circle2"></i></button>

                                                            </div>
                                                        </div>
                                                   
                                                    </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Purchase Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="purchase_date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ date('Y-m-d')}}"
                                                            class="form-control" required>
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Due Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="due_date"
                                                            placeholder="0 if does not exist"
                                                            value="{{  strftime(date('Y-m-d', strtotime("+10 days")))}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                
                                                
                                                 <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Purchase Agent</label>
                                                        <div class="col-lg-4">
                                                            @if (!empty($data->user_agent))

                                                                <select class="form-control m-b" name="user_agent"
                                                                    id="user_agent" required>
                                                                    <option value="{{ old('user_agent') }}" disabled
                                                                        selected>Select User</option>
                                                                    @if (isset($user))
                                                                        @foreach ($user as $row)
                                                                            <option
                                                                                @if (isset($data)) {{ $data->user_agent == $row->id ? 'selected' : 'TZS' }} @endif
                                                                                value="{{ $row->id }}">
                                                                                {{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            @else
                                                                <select class="form-control m-b" name="user_agent"
                                                                    id="user_agent" required>
                                                                    <option value="{{ old('user_agent') }}" disabled
                                                                        selected>Select User</option>
                                                                    @if (isset($user))
                                                                        @foreach ($user as $row)
                                                                            @if ($row->id == auth()->user()->id)
                                                                                <option value="{{ $row->id }}"
                                                                                    selected>{{ $row->name }}</option>
                                                                            @else
                                                                                <option value="{{ $row->id }}">
                                                                                    {{ $row->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>


                                                            @endif
                                                        </div>
                                                        
                                                        <label class="col-lg-2 col-form-label">Branch</label>
                                                         <div class="form-group col-md-4">
                                                            <select  class="form-control m-b" name="branch_id">
                                                                <option>Select Branch</option>
                                                                @if (!empty($branch))
                                                                    @foreach ($branch as $row)
                                                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>



                                                <br>
                                                 @endif
                                                 
                                                <h4 align="center">Enter Item Details</h4>
                                                <hr>
                                               
                                                
                                               <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Currency</label>
                                                    <div class="col-lg-4">
                                                       @if(!empty($data->exchange_code))

                              <select class="form-control m-b" name="exchange_code" id="currency_code" required >
                            <option value="{{ old('currency_code')}}" disabled selected>Choose option</option>
                            @if(isset($currency))
                            @foreach($currency as $row)
                            <option  @if(isset($data)) {{$data->exchange_code == $row->code ? 'selected' : 'TZS' }} @endif  value="{{ $row->code }}">{{ $row->name }}</option>
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
                                                    <label class="col-lg-2 col-form-label">Exchange Rate</label>
                                                    <div class="col-lg-4">
                                                        <input type="number" name="exchange_rate"
                                                            placeholder="1 if TZSH"
                                                            value="{{ isset($data) ? $data->exchange_rate : '1.00'}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                <hr>
                                                
                                               <button type="button" name="add" class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add Item </i></button><br>
                                                    <br>
                                                    
                                                    <div class=""> <p class="form-control-static save_errors" id="errors" style="text-align:center;color:red;"></p>   </div>
                                                    
                                                   
                                                     <div class="row">
                                                    <div class="table-responsive">
                                                     
                                                     
                                                   
                                                    <div id="cart">
                                                    <div class="row body">
                                                     
                                                    </div></div>
                                                    
                                                    <br>
                                                     <div  id="cart1">
                                                     
                                                     <div class="row body1">
                                                      <div class="table-responsive">
                                                      
                                                     <br><table class="table" id="table1">
                                                     <thead style="display: @if(!empty($items))  @else none @endif ;">
                                                    <tr>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Tax</th>
                                                    <th scope="col">Total Tax</th>
                                                    <th scope="col">Total Cost</th>
                                                     <th scope="col">Action</th>
                                                    </tr>
                                                    </thead>
                                                     <tbody>
                                                     @if (!empty($id))
                                                    @if (!empty($items))
                                                    @foreach ($items as $i)
                                                    
                                                    @php
                                                     $it=App\Models\Inventory::where('id',$i->item_name)->first();
                                                     $t=App\Models\Truck::where('id',$i->truck_id)->first();
    
                                                            $a =  $it->name ; 
                                                            
                                                     if(!empty($t)){
                                                        $b =  $t->truck_name.'-'.$t->reg_no ; 
                                                  }
                                                  else{
                                                   $b =  '' ;     
                                                  }        
                                                            
                                                      if($i->tax_rate == '0'){
                                                          $r='Inclusive';
                                                      }
                                                     else if($i->tax_rate == '0.18'){
                                                          $r='Exclusive';
                                                      }   
                                                    @endphp
                                                    
                                                    <tr class="trlst{{$i->id}}_edit">
                                                      <td>{{$a}}<br>{{$b}}</td>
                                                      <td>{{ isset($i) ? number_format($i->quantity,2) : '' }}</td>
                                                      <td>{{ isset($i) ? number_format($i->price,2) : '' }}</td>
                                                       <td>{{$r}}</td>
                                                        <td>{{ isset($i) ? number_format($i->total_tax,2) : '' }}</td>
                                                      <td>{{ isset($i) ? number_format($i->total_cost,2) : '' }}</td>
                                                      
                                                     
  <td>
<a class="list-icons-item text-info edit1" title="Check" href="javascript:void(0)" data-target="#appFormModal" data-toggle="modal" data-button_id="{{$i->id}}_edit"><i class="icon-pencil7" style="font-size:18px;"></i></a>&nbsp;&nbsp;
<a class="list-icons-item text-danger rem" title="Delete" href="javascript:void(0)" data-button_id="{{$i->id}}_edit" value="{{$i->id}}"><i class="icon-trash" style="font-size:18px;"></i></a>
</td>
                                                    </tr>
                                                     
                                                     
                                                     @endforeach
                                                    @endif
                                                    @endif
                                                      </tbody>
                                                     </table>
                                                     
                                                     @if (!empty($id))
                                                    @if (!empty($items))
                                                    @foreach ($items as $i)
                                                    
                                                    <div class="line_items" id="lst{{$i->id}}_edit">
  <input type="hidden" name="item_name[]" class="form-control item_name" id="name lst{{$i->id}}_edit" value="{{ isset($i) ? $i->item_name : '' }}" required="">
  <input type="hidden" name="quantity[]" class="form-control item_qty" id="qty lst{{$i->id}}_edit" value="{{ isset($i) ? $i->quantity : '' }}" required="">
  <input type="hidden" name="price[]" class="form-control item_price" id="price lst{{$i->id}}_edit" value="{{ isset($i) ? $i->price : '' }}" required="">
  <input type="hidden" name="sub[]" class="form-control item_sub" id="sub lst{{$i->id}}_edit" value="{{ isset($i) ? $i->total_cost - $i->total_tax : '' }}" required="">
  <input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate lst{{$i->id}}_edit" value="{{ isset($i) ? $i->tax_rate : '' }}" required="">
  <input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost lst{{$i->id}}_edit" value="{{ isset($i) ? $i->total_cost : '' }}" required="">
  <input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax lst{{$i->id}}_edit" value="{{ isset($i) ? $i->total_tax : '' }}" required="">
  <input type="hidden" name="unit[]" class="form-control item_unit" id="unit lst{{$i->id}}_edit" value="{{ isset($i) ? $i->unit : '' }}">
  <input type="hidden" name="truck_id[]" class="form-control item_trucklst{{$i->id}}_edit" value="{{$i->truck_id}}">
  <input type="hidden" name="type" class="form-control item_type" id="type lst{{$i->id}}_edit" value="edit">
  <input type="hidden" name="no[]" class="form-control item_type" id="no lst{{$i->id}}_edit" value="{{$i->id}}_edit">
  <input type="hidden" name="saved_items_id[]" class="form-control item_savedlst{{$i->id}}_edit" value="{{$i->id}}">
</div>
                                                     @endforeach
                                                    @endif
                                                    @endif
                                                     
                                                     
                                                     
                                                    </div></div>
                                                    
                                                    <br><br>
                                                     
                                                       <div class="row body2">
                                                     
                                                     <div class="col-lg-1"></div>
                                                    <label class="col-lg-2 col-form-label"><span class="bold">Sub Total (+)</span>:</label>
                                                    <div class="col-lg-6 line-items">
                                                     <input type="text" name="subtotal[]" class="form-control item_total" value="{{ isset($data) ? '' : '0.00' }}"
                                                    required jAutoCalc="SUM({sub})" readonly><br>
                                                        </div> 
                                                         <div class="col-lg-3"></div>
                                                         
                                                   <div class="col-lg-1"></div>
                                                    <label class="col-lg-2 col-form-label"><span class="bold">Tax (+)</span>:</label>
                                                    <div class="col-lg-6 line-items">
                                                   <input type="text" name="tax[]" class="form-control item_total" value="{{ isset($data) ? '' : '0.00' }}"
                                                    required jAutoCalc="SUM({total_tax})" readonly><br>
                                                        </div> 
                                                         <div class="col-lg-3"></div>
                                                         
                                                    <div class="col-lg-1"></div>
                                                    <label class="col-lg-2 col-form-label"><span class="bold">Shipping Cost (+)</span>:</label>
                                                    <div class="col-lg-6 line-items">
                                                    <input type="text" name="shipping_cost[]" min="0" class="form-control item_shipping" required
                                                     value="{{ isset($data) ? $data->shipping_cost : '0.00' }}"><br>
                                                        </div> 
                                                         <div class="col-lg-3"></div>
                                                         
                                                    <div class="col-lg-1"></div>
                                                    <label class="col-lg-2 col-form-label"><span class="bold">Discount (-)</span>:</label>
                                                    <div class="col-lg-6 line-items">
                                                    <input type="text" name="discount[]" min="0" class="form-control item_discount"
                                                     required value="{{ isset($data) ? $data->discount : '0.00' }}"><br>
                                                        </div> 
                                                         <div class="col-lg-3"></div>
                                                         
                                                    <div class="col-lg-1"></div>
                                                    <label class="col-lg-2 col-form-label"><span class="bold">Total</span>:</label>
                                                    <div class="col-lg-6 line-items">
                                                    <input type="text" name="amount[]" class="form-control item_total" value="{{ isset($data) ? '' : '0.00' }}" required
                                                     jAutoCalc="{subtotal} + {tax} + {shipping_cost} - {discount}" readonly><br>
                                                        </div> 
                                                    <div class="col-lg-3"></div>
                                                       
                                                   </div>
                                                     
                                                     
                                                     
                                                    </div>
                                                    
                                                    
                                                    
                                                       
                                                    </div></div>


                                                    <br>
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))

                                                        <a class="btn btn-sm btn-danger float-right m-t-n-xs sv"
                                                            href="{{ route('requisition.index')}}">
                                                            Cancel
                                                        </a>
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs save"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs save"
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
        </div>

    </div>
</section>

   <!-- supplier Modal -->
    <div class="modal fade " data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">

        </div>
    </div>



@endsection

@section('scripts')

 <script>
    $("document").ready(function () {

      $("#example").dataTable({
        "searching": true
      });

      //Get a reference to the new datatable
      var table = $('#example').DataTable();

      //Take the category filter drop down and append it to the datatables_filter div. 
      //You can use this same idea to move the filter anywhere withing the datatable that you want.
      $("#filterTable_filter.dataTables_filter").append($("#categoryFilter"));
      
      //Get the column index for the Category column to be used in the method below ($.fn.dataTable.ext.search.push)
      //This tells datatables what column to filter on when a user selects a value from the dropdown.
      //It's important that the text used here (Category) is the same for used in the header of the column to filter
      var categoryIndex = 0;
      $("#example th").each(function (i) {
        if ($($(this)).html() == "Status") {
          categoryIndex = i; return false;
        }
      });

      //Use the built in datatables API to filter the existing rows by the Category column
      $.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
          var selectedItem = $('#categoryFilter').val()
          var category = data[categoryIndex];
          if (selectedItem === "" || category.includes(selectedItem)) {
            return true;
          }
          return false;
        }
      );

      //Set the change event for the Category Filter dropdown to redraw the datatable each time
      //a user selects a new filter.
      $("#categoryFilter").change(function (e) {
        table.draw();
      });

      table.draw();
    });
  </script>
  
    
     <script type="text/javascript">
        $(document).ready(function() {

            var count = 0;


            function autoCalcSetup() {
                $('div#cart').jAutoCalc('destroy');
                $('div#cart div.line_items').jAutoCalc({
                    keyEventsFire: true,
                    decimalPlaces: 2,
                    emptyAsZero: true,

                });
                $('div#cart').jAutoCalc({
                    decimalPlaces: 2
                });
            }
            autoCalcSetup();

            $('.add').on("click", function(e) {

                count++;
                var html = '';
                html +=
                    '<div class="col-lg-3 line_items" id="td' + count + '"> <br><div><select name="checked_item_name[]" class="form-control m-b item_name" id="item_name' +count + '" data-sub_category_id="' + count +'" required><option value="">Select Item Name</option>@foreach ($name as $n) <option value="{{ $n->id }}">{{ $n->name }} </option>@endforeach</select></div><br><div><select name="checked_truck_id[]" class="form-control m-b truck" id="item_truck' +count + '" data-sub_category_id="' + count +'"><option value="">Select Truck</option>@foreach ($truck as $t) <option value="{{ $t->id }}">{{ $t->truck_name }} - {{ $t->reg_no }}</option>@endforeach</select></div><br></div>';
                html +=
                    '<div class="col-lg-6 line_items" id="td' + count + '"><br>Quantity <input type="number" name="checked_quantity[]"  min="1" class="form-control item_quantity" data-category_id="' +count + '" placeholder ="quantity" id ="quantity'+ count +'" required /><br> Price <input type="text" name="checked_price[]"  class="form-control item_price' + count +'" id="item_price" placeholder ="price"  required  value=""/><br> Tax <select name="checked_tax_rate[]" class="form-control m-b item_tax' + count +'" id="item_tax' + count +'" required ><option value="">Select Tax</option><option value="0">Inclusive</option><option value="0.18">Exclusive</option></select><br><br>Total Cost <input type="text" name="checked_total_cost[]" class="form-control item_total' + count +'" placeholder ="total" required readonly jAutoCalc="{checked_quantity} * {checked_price}" /><br><input type="hidden" name="checked_unit[]" class="form-control item_unit' + count +'" placeholder ="unit" required /><input type="hidden" name="checked_no[]" class="form-control item_check' + count +'" value="' + count +'" placeholder ="total" required /></div>';
                html +='<div class="col-lg-3 line_items text-center" id="td' + count + '"><br><a class="list-icons-item text-info add1" title="Check" href="javascript:void(0)" data-button_id="' + count +'"><i class="icon-check2" style="font-size:30px;font-weight:bold;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger remove" title="Delete" href="javascript:void(0)" data-button_id="' +count + '"><i class="icon-trash" style="font-size:18px;"></i></a><br><div class=""> <p class="form-control-static item_errors'+count+'" id="errors" style="text-align:center;color:red;"></p>   </div></div>';

                 if ( $('#cart > .body .line_items').length < 3 ) {
                $('#cart > .body').append(html);
                autoCalcSetup();
                 }
                 
                  $('.m-b').select2({});
                
                $(document).on('change', '#item_price', function() {
                var id = $(this).val();
                $.ajax({
                url: '{{ url('format_number') }}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                 console.log(data);
                $('.item_price' + count).val(data);
                   
                    }

                });

            });
                          
                              
                             
                       


            });



            $(document).on('click', '.remove', function() {
            var button_id = $(this).data('button_id');
               document.querySelectorAll('#td' + button_id).forEach(el => el.remove());
               
                autoCalcSetup();
            });
            
            
             $(document).on('change', '.item_name', function() {
                var id = $(this).val();
                var sub_category_id = $(this).data('sub_category_id');
                $.ajax({
                    url: '{{url("inventory/findInvPrice")}}',
                    type: "GET",
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        $('.item_price' + sub_category_id).val(numberWithCommas(data[0]["price"]));
                        $(".item_unit" + sub_category_id).val(data[0]["unit"]);
                         autoCalcSetup();
                      

                    }

                });

            });
            
            
        

        });
    </script>
    
    
        <script type="text/javascript">
        $(document).ready(function() {


            function autoCalcSetup1() {
                $('div#cart1').jAutoCalc('destroy');
                $('div#cart1 div.line_items').jAutoCalc({
                    keyEventsFire: true,
                    decimalPlaces: 2,
                    emptyAsZero: true
                });
                $('div#cart1').jAutoCalc({
                    decimalPlaces: 2
                });
            }
            autoCalcSetup1();

           $(document).on('click', '.add1', function() {
               
               var button_id = $(this).data('button_id');
                console.log(button_id);
                
                 $('.item_errors'+ button_id).empty();
                
                var a = $('#item_name'+ button_id + '.item_name').val();
                var b = $('.item_price'+ button_id + '#item_price').val();
                var c = $('#quantity'+ button_id + '.item_quantity').val();
                var d = $('.item_tax'+ button_id).val();
                console.log(c);
                  
                  if( a == '' || c == '' || b == '' || d == ''){
              $('.item_errors'+ button_id).append('Please Fill the Required Fields.');
              event.preventDefault(); 
         }
         
         else{
                
                $.ajax({
                    data: $('#cart > .body').find('input,select,textarea').serialize(),
                    type: 'GET',
                    url: '{{ url('inventory/add_inventory_item') }}',
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                         $('#cart1 > .body1 table thead').show();
                        $('#cart1 > .body1 table tbody').append(response['list']);
                         $('#cart1 > .body1').append(response['list1']);
                         autoCalcSetup1(); 
                         
                         
               document.querySelectorAll('#td' + button_id).forEach(el => el.remove());
                       

                    }
                })

         }    

            });



            $(document).on('click', '.remove1', function() {
            var button_id = $(this).data('button_id');
               document.querySelectorAll('#lst' + button_id).forEach(el => el.remove());
                $(this).closest('tr').remove();
                autoCalcSetup1();
            });
            
            
        
                  $(document).on('click', '.edit1', function() {
                 var button_id = $(this).data('button_id');
                  console.log(button_id);
                $.ajax({
                    data: $('#cart1 > .body1 #lst'+ button_id).find('input,select,textarea').serialize(),
                    type: 'GET',
                    url: '{{ url('inventory/invModal') }}',
                     cache: false,
                async: true,
                success: function(response) {
                    //alert(data);
                     console.log(444);
                    $('#appFormModal > .modal-dialog').html(response);
                     // $('.m-b').select2({ dropdownParent: $('#appFormModal'),});
                },
                error: function(error) {
                     console.log(111);
                    $('#appFormModal').modal('toggle');

                }

               
                });


            });
            
            
            $(document).on('click', '.edit_item', function(e) {
               e.preventDefault();
               var button_id = $(this).data('button_id');
                console.log(button_id);
                
                
                 $('.item2_errors').empty();
                
                var a = $('#item_namelst'+ button_id + '.item_name').val();
                var b = $('.item_pricelst'+ button_id + '#item_price').val();
                var c = $('#quantitylst'+ button_id + '.item_quantity').val();
                 var d = $('.item_taxlst'+ button_id).val();
                console.log(c);
                  
                  if( a == '' || c == '' || b == '' || d == ''){
              $('.item2_errors').append('Please Fill the Required Fields.');
              
              return false; 
              
         }
         
         else{
                
                $.ajax({
                   data: $('.addEditForm').serialize(),
                    type: 'GET',
                    url: '{{ url('inventory/add_inventory_item') }}',
                    dataType: "json",
                    success: function(response) {
                    console.log(response);
                    $('#cart1 > .body1 table tbody').find('.trlst'+button_id).html(response['list']);
                   $('#cart1 > .body1').find('#lst'+button_id).html(response['list1']);
                         autoCalcSetup1(); 
                          $('#appFormModal').modal().hide();
                         
                         
                       

                    }
                })

         }

            });
        
        
             $(document).on('click', '.rem', function() {
            var button_id = $(this).data('button_id');
            var btn_value = $(this).attr("value");
               document.querySelectorAll('#lst' + button_id).forEach(el => el.remove());
                $(this).closest('tr').remove();
                $('#cart1 > .body1').append('<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +btn_value + '"/>');
                autoCalcSetup1();
            });

           

        });
    </script>
    








<script type="text/javascript">
function model(id, type) {

    $.ajax({
        type: 'GET',
        url: '{{url("inventory/invModal")}}',
        data: {
            'id': id,
            'type': type,
        },
        cache: false,
        async: true,
        success: function(data) {
            //alert(data);
            $('#appFormModal > .modal-dialog').html(data);
        },
        error: function(error) {
            $('#appFormModal').modal('toggle');

        }
    });

}

 function saveSupplier(e) {

            $.ajax({
                type: 'GET',
                url: '{{ url('pos/purchases/save_supplier') }}',
                data: $('.addClientForm').serialize(),
                dataType: "json",
                success: function(response) {
                    console.log(response);

                    var id = response.id;
                    var name = response.name;

                    var option = "<option value='" + id + "'  selected>" + name + " </option>";

                    $('#supplier_id').append(option);
                    $('#appFormModal').hide();



                }
            });
        }
</script>


<script>
    $(document).ready(function() {
    
      
         $(document).on('click', '.save', function(event) {
   
         $('.save_errors').empty();
        
          if ( $('#cart1 > .body1 table tbody tr').length == 0 ) {
               event.preventDefault(); 
    $('.save_errors').append('Please Add Items.');
}
         
         else{
            
         
          
         }
        
    });
    
    
    
    });
    </script>
    
    
    

    
    
    <script type="text/javascript">


function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

</script>

@endsection