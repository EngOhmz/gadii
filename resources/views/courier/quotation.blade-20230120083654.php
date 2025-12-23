@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Request Pickup</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id) && empty($id2)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Pickup
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Pickup - Automatic  Based</a>
                            </li>

@if(auth()->user()->client_id == null)
  <li class="nav-item">
                                <a class="nav-link @if(!empty($id2)) active show @endif" id="profile-tab3"
                                    data-toggle="tab" href="#profile3" role="tab" aria-controls="profile"
                                    aria-selected="false">New Pickup - Formula Based</a>
                            </li>
@endif
                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id) && empty($id2)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr>                                              
                                              
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 90.484px;">Reference</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 150.484px;">Client Name</th>
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 186.219px;">Tariff</th>
                                                      
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Date</th> 

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Amount</th>
                                                
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 50.219px;">Status</th>
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 50.219px;">Cargo Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 150.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($courier))
                                            @foreach ($courier as $row)
                                            <tr class="gradeA even" role="row">
                                               
                                                <td><a href="{{ route('courier_quotation.show', $row->id)}}">{{$row->confirmation_number}}</a></li></td>
                                                
                                                <td>{{$row->supplier->name}}</td>
                                                <td> {{$row->route->zone_name}} - {{$row->route->weight}} KG</td>                                                
                                                <td>{{Carbon\Carbon::parse($row->date)->format('M d, Y')}}</td>
                                                <td>{{number_format($row->due_amount,2)}} {{$row->currency_code}}</td>
                                                

                                                  @if(auth()->user()->client_id == null)
                                                <td>                              
                                                        @if($row->status == 0 && $row->good_receive == 0)
                                                    <div class="badge badge-danger badge-shadow">Waiting For Approval</div>
                                                    @elseif($row->good_receive == 1)
                                                    <div class="badge badge-success badge-shadow">Approved</div>
                                                    @elseif($row->status == 7 &&$row->good_receive == 0)
                                                    <div class="badge badge-danger badge-shadow">Cancelled</div>
                                                    @endif                                                 
                                               </td>
                                           @endif

                                       <!--Client Actions -->
                                 @can('view-management_report')
                               @if(auth()->user()->client_id != null)
                                      <td>
                                    
                                                          @if($row->approval_1 == '' && $row->good_receive == 0)
                                                    <div class="badge badge-danger badge-shadow">Waiting For First Approval</div>
                                                         @elseif($row->approval_1 != '' && $row->approval_2 == '' && $row->good_receive == 0)
                                                    <div class="badge badge-danger badge-shadow">Waiting For Second Approval</div>
                                                   @elseif($row->approval_1 != '' && $row->approval_2 != '' && $row->good_receive == 0)
                                                    <div class="badge badge-danger badge-shadow">Waiting For Final Approval</div>
                                                    @elseif($row->good_receive == 1)
                                                    <div class="badge badge-success badge-shadow">Approved</div>
                                                    @elseif($row->status == 7 &&$row->good_receive == 0)
                                                    <div class="badge badge-danger badge-shadow">Cancelled</div>
                                                    @endif   

                                     </td>
                                                   @endif
                                                     @endcan


                                         <?php
                                       $key=App\Models\Courier\CourierActivity::where('module_id',$row->id)->orderBy('id', 'desc')->first();
                                          ?>
                                      @if(!empty($key))
                                  <td>
                                        @if($key->activity =='Confirm Pickup')
                                          Package Picked Up
                                         @elseif($key->activity =='Confirm Freight')
                                            Package Freighted
                                          @elseif($key->activity =='Confirm Commission')
                                            Package Commissioned
                                           @elseif($key->activity =='Confirm Delivery')
                                              Package Delivered      
                                                    @endif
                                         </td> 

                                                 @else
                                                     <td></td>
                                                    @endif


                                             @if(auth()->user()->client_id == null)
                                               
                                                 <td>
                                               
                                        <div class="form-inline">
  @if($row->by_client == 'No' && $row->good_receive == 0)

 @if($row->tariff_type == 'Automatic')
 <a class="list-icons-item text-primary" title="Edit" onclick="return confirm('Are you sure?')" href="{{ route('courier_quotation.edit', $row->id)}}"> <i class="icon-pencil7"></i></a>&nbsp
@else
 <a class="list-icons-item text-primary" title="Edit" onclick="return confirm('Are you sure?')" href="{{ route('courier.formula', $row->id)}}"> <i class="icon-pencil7"></i></a>&nbsp
@endif

 {!! Form::open(['route' => ['courier_quotation.destroy',$row->id], 'method' => 'delete']) !!}
{{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
{{ Form::close() }}
&nbsp
 @endif
                                                                                                                <div class="dropdown">
                                                    <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>

                                                    <div class="dropdown-menu">
                                @if($row->good_receive == 0)
                   <a   href="#" class="nav-link" title="Collect" data-toggle="modal"  onclick="model({{ $row->id }},'assign')" value="{{ $row->id}}" data-target="#appFormModal">Approve Pickup</a>  
                          @endif
                      @if($row->by_client == 'No' && $row->good_receive == 0)                                                                                                             
                  <a  class="nav-link" title="Cancel" onclick="return confirm('Are you sure?')"   href="{{ route('courier.cancel', $row->id)}}">Cancel Pickup</a>
                        @endif  
              <a class="nav-link" id="profile-tab2" href="{{ route('courier_pdfview',['download'=>'pdf','id'=>$row->id]) }}"  role="tab"  aria-selected="false">Download PDF</a>

                                           
             </div>
                                                </div>
 </div>
                                                 

                                                    </td>
                                                   @endif


<!--Client Actions -->
                                 @can('view-management_report')
                               @if(auth()->user()->client_id != null)

                                           <td>
                                               
                                        <div class="form-inline">
  @if($row->approval_2 == ''  && $row->good_receive == 0)
 <a class="list-icons-item text-primary" title="Edit" onclick="return confirm('Are you sure?')" href="{{ route('courier_quotation.edit', $row->id)}}"> <i class="icon-pencil7"></i></a>&nbsp

 {!! Form::open(['route' => ['courier_quotation.destroy',$row->id], 'method' => 'delete']) !!}
{{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
{{ Form::close() }}
&nbsp
@endif
                                                                                         <div class="dropdown">
                                                    <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>

                                                    <div class="dropdown-menu">


                             @if($row->approval_1 == '' && $row->good_receive == 0)
                         <a  class="nav-link"  title="Collect" onclick="return confirm('Are you sure? you want to approve')" href="{{ route('courier.first_approval', $row->id)}}">First Approval</a>
                           @elseif($row->approval_1 != '' && $row->approval_2 == '')
                            <a  class="nav-link"  title="Collect" onclick="return confirm('Are you sure? you want to approve')" href="{{ route('courier.second_approval', $row->id)}}">Second Approval</a>
                          @endif

                                     @if($row->approval_2 == ''  && $row->good_receive == 0)
                           
                              <a  class="nav-link" title="Cancel" onclick="return confirm('Are you sure?')"   href="{{ route('courier.cancel', $row->id)}}">Cancel Pickup</a>                                                                                                                                  
                                @endif

                                 
                              <a class="nav-link" id="profile-tab2" href="{{ route('courier_pdfview',['download'=>'pdf','id'=>$row->id]) }}"  role="tab"  aria-selected="false">Download PDF</a>      


                                                    </div>
                                                </div>
 </div>

                                                </td>
                                                   @endif
                                                     @endcan
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
                                        <h5>Create Pickup</h5>
                                        @else
                                        <h5>Edit Pickup</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('courier_quotation.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'courier_quotation.store']) }}
                                                @method('POST')
                                                @endif



                                              <!--
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Number of Docs</label>
                                                    <div class="col-lg-4">
                                                        <input type="number" name="docs"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->docs : ''}}"
                                                            class="form-control">
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Number of Cargo</label>
                                                    <div class="col-lg-4">
                                                        <input type="number" name="non_docs"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->non_docs : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">

                                                    <label class="col-lg-2 col-form-label">Number of Bags If
                                                        apply</label>
                                                    <div class="col-lg-4">
                                                        <input type="number" name="bags"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->bags : ''}}"
                                                            class="form-control">
                                                    </div>
-->
                                                               <div class="form-group row">
                                                     <label class="col-lg-2 col-form-label">Date</label>

                                                    <div class="col-lg-6">
                                                        <input type="date" name="date"
                                                            placeholder="0 if does not exist"
                                                            value="<?php
                                                      if (!empty($data)) {
                                                      echo $data->date;
                                                               } else {
                                     echo date('Y-m-d');
                                                      }
                                                 ?>"
                                                            class="form-control" required>
                                                    </div>
                                                </div>


                                             
                                           
                                      @if(auth()->user()->client_id == null)
                                  
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Client Name</label>

                                                    <div class="col-lg-10">
                                                  
                                         <select class=" form-control m-b supplier " name="owner_id" required id="supplier">
                                                <option value="">Select</option>
                                                          @if(!empty($users))
                                                          @foreach($users as $row)
                                                          <option @if(isset($data))
                                                          {{  $data->owner_id == $row->id  ? 'selected' : ''}}
                                                          @endif value="{{ $row->id}}">{{$row->name}}</option>
                                                          @endforeach
                                                          @endif

                                                        </select>
 
                                                    </div>
                                                </div>
                                               @endif

                                            @can('view-management_report')
                                      @if(auth()->user()->client_id != null)
                                                
                                 <input type="hidden" name="owner_id" class="form-control"  required value="{{ auth()->user()->client_id}}" readonly   />
                                 <input type="hidden" name=" by_client" class="form-control"  required value="Yes" readonly   />
                                    
                             @endif
                                        @endcan

                           @if(auth()->user()->client_id == null)
                                                
                                 <input type="hidden" name=" by_client" class="form-control"  required value="No" readonly   />
                                    
                             @endif

            <input type="hidden" name="tariff_type" class="form-control"  required value="Automatic" readonly   />

                                          <div class="form-group row">
                                      <label class="col-lg-2 col-form-label" for="inputState">Departure Region</label>
                                   <div class="col-lg-4">
                                
                                    <select  class="form-control m-b from_region" name="from_region_id" required  id="from_region">
                                      <option ="">Select Departure Region</option>
                                      @if(!empty($region))
                                                        @foreach($region as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->from_region_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>

                     @if(!empty($data))
                   
                                    <label for="inputState"  class="col-lg-2 col-form-label">Departure District</label>
                                 <div class="col-lg-4">
                                    <select id="from_district_id" name="from_district_id" class="form-control m-b from_district">
                                      <option>Select Departure District</option>
                                    @if(!empty($from_district))
                                                        @foreach($from_district as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->from_district_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>
                 @else
           
                                    <label for="inputState"  class="col-lg-2 col-form-label">Departure District</label>
                                 <div class="col-lg-4">
                                      <select id="from_district_id" name="from_district_id" class="form-control m-b from_district">
                                      <option selected="">Select Departure District</option>
                                    
                                    </select>
                                  </div>
  @endif
                            
                             </div>


         
                                          <div class="form-group row">
                                      <label class="col-lg-2 col-form-label" for="inputState">Arrival Region</label>
                                   <div class="col-lg-4">
                                    <select  id="to_region_id" name="to_region_id" class="form-control m-b to_region" required>
                                      <option ="">Select Arrival Region</option>
                                      @if(!empty($region))
                                                        @foreach($region as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->to_region_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>

                     @if(!empty($data))
                    
                                    <label for="inputState"  class="col-lg-2 col-form-label">Arrival District</label>
                                 <div class="col-lg-4">
                                    <select id="to_district_id" name="to_district_id" class="form-control m-b to_district">
                                      <option>Select Arrival District</option>
                                    @if(!empty($to_district))
                                                        @foreach($to_district as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->to_district_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>
                 @else
             <label for="inputState"  class="col-lg-2 col-form-label">Arrival District</label>
                                 <div class="col-lg-4">
                                    <select id="to_district_id" name="to_district_id" class="form-control m-b to_district">
                                      <option selected="">Select Arrival District</option>
                                    
                                    </select>
                                  </div>
  @endif
                            
            

                             </div> 


                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Instructions</label>

                                                    <div class="col-lg-10">
                                                        <textarea name="instructions" class="form-control">{{ isset($data) ? $data->instructions : ''}}</textarea>

                                                    </div>
                                                </div>



                                     <br>
                                              <h4 align="center">Enter Item Details</h4>
                                            <hr>
                                                 <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Currency</label>
                                                    <div class="col-lg-4">
                                 @if(!empty($data->currency_code))

                              <select class="form-control m-b" name="currency_code" id="currency_code" required >
                            <option value="{{ old('currency_code')}}" disabled selected>Choose option</option>
                            @if(isset($currency))
                            @foreach($currency as $row)
                            <option  @if(isset($data)) {{$data->currency_code == $row->code ? 'selected' : 'TZS' }} @endif  value="{{ $row->code }}">{{ $row->name }}</option>
                            @endforeach
                            @endif
                        </select>

                         @else
                       <select class="form-control m-b" name="currency_code" id="currency_code" required >
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
<!--
                                             <button type="button" name="add" class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add item</i></button><br>
    -->                    
                                              <br>
    <div class="table-responsive">
<table class="table table-bordered" id="cart">
            <thead>
              <tr>
                <th class="col-sm-3">Tariff</th>
                <th>Price</th>
                 <th>Unit</th>
                <th>Tax</th>
                <th class="col-sm-2">Total</th>
              
              </tr>
            </thead>
            <tbody>
                                    
 <tr class="line_items">
   @if(!empty($items))
<td><select name="item_name[]" class="form-control m-b item_name" id="name"  required ><option value="">Select Tariff</option>
  @if(!empty($tariff))
                                                        @foreach($tariff as $trow)

                                                        <option @if(isset($items))
                                                            {{ $items->item_name== $trow->id  ? 'selected' : ''}}
                                                            @endif value="{{$trow->id}}"> {{$trow->zonal->name}} - {{$trow->weight}} KG</option>

                                                        @endforeach
                                                        @endif

</select></td>
@else
 @can('view-management_report')
@if(auth()->user()->client_id != null)
<?php 
   $tariff= App\Models\Tariff::where('client_id',auth()->user()->client_id)->where('type','Automatic')->get();
?>
<td><select name="item_name[]" class="form-control m-b item_name" id="name"  required ><option value="">Select Tariff</option>
  @if(!empty($tariff))
                                                        @foreach($tariff as $trow)

                                                        <option value="{{$trow->id}}">{{$trow->zonal->name}} - {{$trow->weight}} KG</option>

                                                        @endforeach
                                                        @endif

</select></td>
@endif
@endcan

@if(auth()->user()->client_id == null)
<td><select name="item_name[]" class="form-control m-b item_name" id="name"  required ><option value="">Select Tariff</option></select></td>
@endif

@endif
<input type="hidden" name="quantity[]" class="form-control item_quantity"  placeholder ="weight" id ="quantity"  value="{{ isset($items) ? $items->quantity : ''}}" required />
<td><input type="text" name="price[]" class="form-control item_price" placeholder ="price" required  value="{{ isset($items) ? $items->price : ''}}"/></td>
<td><input type="text" name="unit[]" class="form-control item_unit" placeholder ="unit" required value="{{ isset($items) ? $items->unit : ''}}"/>
<td><select name="tax_rate[]" class="form-control m-b item_tax" required ><option value="0">Select Tax Rate</option>
<option value="0" @if(isset($items))@if('0' == $items->tax_rate) selected @endif @endif>No tax</option>
<option value="0.18" @if(isset($items))@if('0.18' == $items->tax_rate) selected @endif @endif>18%</option></select></td>
<input type="hidden" name="total_tax[]" class="form-control item_total_tax" placeholder ="total" required value="{{ isset($items) ? $items->total_tax : ''}}" readonly jAutoCalc="1 * {price} * {tax_rate}"   />
<td><input type="text" name="total_cost[]" class="form-control item_total" placeholder ="total" required value="{{ isset($items) ? $items->total_cost : ''}}" readonly jAutoCalc="1 * {price}" /></td>
</tr>



 <tr class="line_items">
<td colspan="3"></td>
<td><span class="bold">Sub Total </span>: </td><td><input type="text" name="subtotal[]" class="form-control item_total" placeholder ="subtotal" required   jAutoCalc="SUM({total_cost})" readonly></td>   
</tr>
 <tr class="line_items">
<td colspan="3"></td>
<td><span class="bold">Tax </span>: </td><td><input type="text" name="tax[]" class="form-control item_total" placeholder ="tax" required   jAutoCalc="SUM({total_tax})" readonly>
</td>   
</tr>


<tr class="line_items">
<td colspan="3"></td>

<td><span class="bold">Total</span>: </td><td><input type="text" name="amount[]" class="form-control item_total" placeholder ="total" required   jAutoCalc="{subtotal} + {tax}" readonly></td>  

</tr>
</tbody>
          </table>


    
                                                <br><div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                       
                                                              <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                                
                                                                href="{{ route('courier_quotation.index')}}">
                                                                 cancel
                                                            </a>
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



   <div class="tab-pane fade @if(!empty($id2)) active show @endif" id="profile3" role="tabpanel"
                                aria-labelledby="profile-tab3">

                                <div class="card">
                                    <div class="card-header">
                                        @if(empty($id2))
                                        <h5>Create Pickup</h5>
                                        @else
                                        <h5>Edit Pickup</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id2))
                                                {{ Form::model($id2, array('route' => array('courier_quotation.update', $id2), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'courier_quotation.store']) }}
                                                @method('POST')
                                                @endif



                                              <!--
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Number of Docs</label>
                                                    <div class="col-lg-4">
                                                        <input type="number" name="docs"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data2) ? $data2->docs : ''}}"
                                                            class="form-control">
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Number of Cargo</label>
                                                    <div class="col-lg-4">
                                                        <input type="number" name="non_docs"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data2) ? $data2->non_docs : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="form-group row">

                                                    <label class="col-lg-2 col-form-label">Number of Bags If
                                                        apply</label>
                                                    <div class="col-lg-4">
                                                        <input type="number" name="bags"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data2) ? $data2->bags : ''}}"
                                                            class="form-control">
                                                    </div>
-->
                                                               <div class="form-group row">
                                                     <label class="col-lg-2 col-form-label">Date</label>

                                                    <div class="col-lg-6">
                                                        <input type="date" name="date"
                                                            placeholder="0 if does not exist"
                                                            value="<?php
                                                      if (!empty($data2)) {
                                                      echo $data2->date;
                                                               } else {
                                     echo date('Y-m-d');
                                                      }
                                                 ?>"
                                                            class="form-control" required>
                                                    </div>
                                                </div>


                                             
                                           
                                      @if(auth()->user()->client_id == null)
                                  
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Client Name</label>

                                                    <div class="col-lg-10">
                                                  
                                         <select class=" form-control m-b supplier2 " name="owner_id" required id="supplier2">
                                                <option value="">Select</option>
                                                          @if(!empty($users))
                                                          @foreach($users as $row)
                                                          <option @if(isset($data2))
                                                          {{  $data2->owner_id == $row->id  ? 'selected' : ''}}
                                                          @endif value="{{ $row->id}}">{{$row->name}}</option>
                                                          @endforeach
                                                          @endif

                                                        </select>
 
                                                    </div>
                                                </div>
                                               @endif

                                            @can('view-management_report')
                                      @if(auth()->user()->client_id != null)
                                                
                                 <input type="hidden" name="owner_id" class="form-control"  required value="{{ auth()->user()->client_id}}" readonly   />
                                 <input type="hidden" name=" by_client" class="form-control"  required value="Yes" readonly   />
                                    
                             @endif
                                        @endcan

                           @if(auth()->user()->client_id == null)
                                                
                                 <input type="hidden" name=" by_client" class="form-control"  required value="No" readonly   />
                                    
                             @endif

                                            <input type="hidden" name="tariff_type" class="form-control"  required value="Formula" readonly   />

                                          <div class="form-group row">
                                      <label class="col-lg-2 col-form-label" for="inputState">Departure Region</label>
                                   <div class="col-lg-4">
                                
                                    <select  class="form-control m-b from_region2" name="from_region_id" required  id="from_region2">
                                      <option ="">Select Departure Region</option>
                                      @if(!empty($region))
                                                        @foreach($region as $row)

                                                        <option @if(isset($data2))
                                                            {{ $data2->from_region_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>

                     @if(!empty($data2))
                   
                                    <label for="inputState"  class="col-lg-2 col-form-label">Departure District</label>
                                 <div class="col-lg-4">
                                    <select id="from_district_id2" name="from_district_id" class="form-control m-b from_district2">
                                      <option>Select Departure District</option>
                                    @if(!empty($from_district))
                                                        @foreach($from_district as $row)

                                                        <option @if(isset($data2))
                                                            {{ $data2->from_district_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>
                 @else
           
                                    <label for="inputState"  class="col-lg-2 col-form-label">Departure District</label>
                                 <div class="col-lg-4">
                                     <select id="from_district_id2" name="from_district_id" class="form-control m-b from_district2">
                                      <option selected="">Select Departure District</option>
                                    
                                    </select>
                                  </div>
  @endif
                            
                             </div>


         
                                          <div class="form-group row">
                                      <label class="col-lg-2 col-form-label" for="inputState">Arrival Region</label>
                                   <div class="col-lg-4">
                                    <select  id="to_region_id2" name="to_region_id" class="form-control m-b to_region2" required>
                                      <option ="">Select Arrival Region</option>
                                      @if(!empty($region))
                                                        @foreach($region as $row)

                                                        <option @if(isset($data2))
                                                            {{ $data2->to_region_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>

                     @if(!empty($data2))
                    
                                    <label for="inputState"  class="col-lg-2 col-form-label">Arrival District</label>
                                 <div class="col-lg-4">
                                     <select  id="to_region_id2" name="to_region_id" class="form-control m-b to_region2" required>
                                      <option>Select Arrival District</option>
                                    @if(!empty($to_district))
                                                        @foreach($to_district as $row)

                                                        <option @if(isset($data2))
                                                            {{ $data2->to_district_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>
                 @else
             <label for="inputState"  class="col-lg-2 col-form-label">Arrival District</label>
                                 <div class="col-lg-4">
                                    <select id="to_district_id2" name="to_district_id" class="form-control m-b to_district2">
                                      <option selected="">Select Arrival District</option>
                                    
                                    </select>
                                  </div>
  @endif
                            
            

                             </div> 


                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Instructions</label>

                                                    <div class="col-lg-10">
                                                        <textarea name="instructions" class="form-control">{{ isset($data2) ? $data2->instructions : ''}}</textarea>

                                                    </div>
                                                </div>



                                     <br>
                                              <h4 align="center">Enter Item Details</h4>
                                            <hr>
                                                 <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Currency</label>
                                                    <div class="col-lg-4">
                                 @if(!empty($data2->currency_code))

                              <select class="form-control m-b" name="currency_code" id="currency_code" required >
                            <option value="{{ old('currency_code')}}" disabled selected>Choose option</option>
                            @if(isset($currency))
                            @foreach($currency as $row)
                            <option  @if(isset($data2)) {{$data2->currency_code == $row->code ? 'selected' : 'TZS' }} @endif  value="{{ $row->code }}">{{ $row->name }}</option>
                            @endforeach
                            @endif
                        </select>

                         @else
                       <select class="form-control m-b" name="currency_code" id="currency_code" required >
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
                                                            value="{{ isset($data2) ? $data2->exchange_rate : '1.00'}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>
                                                <hr>
<!--
                                             <button type="button" name="add" class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add item</i></button><br>
    -->                    
                                              <br>
    <div class="table-responsive">
<table class="table table-bordered" id="cart">
            <thead>
              <tr>
                <th class="col-sm-3">Tariff</th>
                <th>Price</th>
              <th>Description</th>
                 <th>Unit</th>
                <th>Tax</th>
                <th class="col-sm-2">Total</th>
              
              </tr>
            </thead>
            <tbody>
                                    
 <tr class="line_items">
   @if(!empty($items))
<td><select name="item_name[]" class="form-control m-b item_name2" id="name2"  required ><option value="">Select Tariff</option>
  @if(!empty($tariff))
                                                        @foreach($tariff as $trow)

                                                        <option @if(isset($items))
                                                            {{ $items->item_name== $trow->id  ? 'selected' : ''}}
                                                            @endif value="{{$trow->id}}"> {{$trow->zonal->name}} - {{$trow->weight}} KG</option>

                                                        @endforeach
                                                        @endif

</select></td>
@else
 @can('view-management_report')
@if(auth()->user()->client_id != null)
<?php 
   $tariff= App\Models\Tariff::where('client_id',auth()->user()->client_id)->where('type','Formula')->get();
?>
<td><select name="item_name[]" class="form-control m-b item_name2" id="name2"  required ><option value="">Select Tariff</option>
  @if(!empty($tariff))
                                                        @foreach($tariff as $trow)

                                                        <option value="{{$trow->id}}">{{$trow->zonal->name}} - {{$trow->weight}} KG</option>

                                                        @endforeach
                                                        @endif

</select></td>
@endif
@endcan

@if(auth()->user()->client_id == null)
<td><select name="item_name[]" class="form-control m-b item_name2" id="name2"  required ><option value="">Select Tariff</option></select></td>
@endif

@endif
<input type="hidden" name="quantity[]" class="form-control item_quantity2"  placeholder ="weight" id ="quantity2"  value="{{ isset($items) ? $items->quantity : ''}}" required />
<td><input type="text" name="price[]" class="form-control item_price2" placeholder ="price" required  value="{{ isset($items) ? $items->price : ''}}"/></td>
<td><textarea name="description[]" class="form-control item_desc2"  required>{{ isset($items) ? $items->description : ''}}</textarea>
<td><input type="text" name="unit[]" class="form-control item_unit2" placeholder ="unit" required value="{{ isset($items) ? $items->unit : ''}}"/>
<td><select name="tax_rate[]" class="form-control m-b item_tax2" required ><option value="0">Select Tax Rate</option>
<option value="0" @if(isset($items))@if('0' == $items->tax_rate) selected @endif @endif>No tax</option>
<option value="0.18" @if(isset($items))@if('0.18' == $items->tax_rate) selected @endif @endif>18%</option></select></td>
<input type="hidden" name="total_tax[]" class="form-control item_total_tax2" placeholder ="total" required value="{{ isset($items) ? $items->total_tax : ''}}" readonly jAutoCalc=" 1 * {price} * {tax_rate}"   />
<td><input type="text" name="total_cost[]" class="form-control item_total2" placeholder ="total" required value="{{ isset($items) ? $items->total_cost : ''}}" readonly jAutoCalc="1 * {price}" /></td>
</tr>



 <tr class="line_items">
<td colspan="4"></td>
<td><span class="bold">Sub Total </span>: </td><td><input type="text" name="subtotal[]" class="form-control item_total" placeholder ="subtotal" required   jAutoCalc="SUM({total_cost})" readonly></td>   
</tr>
 <tr class="line_items">
<td colspan="4"></td>
<td><span class="bold">Tax </span>: </td><td><input type="text" name="tax[]" class="form-control item_total" placeholder ="tax" required   jAutoCalc="SUM({total_tax})" readonly>
</td>   
</tr>


<tr class="line_items">
<td colspan="4"></td>

<td><span class="bold">Total</span>: </td><td><input type="text" name="amount[]" class="form-control item_total" placeholder ="total" required   jAutoCalc="{subtotal} + {tax}" readonly></td>  

</tr>
</tbody>
          </table>


    
                                                <br><div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id2))
                                                       
                                                              <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                                
                                                                href="{{ route('courier_quotation.index')}}">
                                                                 cancel
                                                            </a>
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
                </div>
            </div>
        </div>

    </div>
</section>

 <!-- discount Modal -->
  <div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
    </div>
</div>


 <!-- route Modal -->
  <div class="modal fade" id="routeModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Add Discount</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <p><strong>Make sure you enter valid information</strong> .</p>

       <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">from</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="arrival_point"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">To</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="destination_point"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Distance</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="distance"
                                                                class="form-control">
                                                        </div>
                                                    </div>

        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>


 
    </div>
</div>
  </div>

@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
            order: [[4, 'desc']],
            "columnDefs": [
                {"orderable": false, "targets": [3]}
            ],
           dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
               search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
             paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            },
        
        });
    </script>

<script>
$(document).ready(function() {

    $(document).on('change', '.from_region', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("fuel/findFromRegion")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#from_district_id").empty();
                $("#from_district_id").append('<option value="">Select Departure District</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#from_district_id").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });

});
</script>


<script>
$(document).ready(function() {

    $(document).on('change', '.to_region', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("fuel/findToRegion")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#to_district_id").empty();
                $("#to_district_id").append('<option value="">Select Arrival District</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#to_district_id").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });

});
</script>

<script>
$(document).ready(function() {

    $(document).on('change', '.supplier', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("courier/findTariff")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#name").empty();
                $("#name").append('<option value="">Select Tariff</option>');
                $.each(response,function(key, value)
                {


                    $("#name").append('<option value=' + value.id+ '>' + value.zone_name + ' -  ' + value.weight + ' KG</option>');
                   
                });                      
               
            }

        });

    });

});
</script>

<script>
    $(document).ready(function(){
      

 $(document).on('change', '.item_name', function(){
        var id = $(this).val();
        $.ajax({
            url: '{{url("courier/findCourierPrice")}}',
                    type: "GET",
          data:{id:id},
             dataType: "json",
          success:function(data)
          {
 console.log(data);
                     $('.item_price').val(data[0]["price"]);
                  $('.item_quantity').val(data[0]["weight"]);
          }

        });

});


    });
</script>


<script>
$(document).ready(function() {

    $(document).on('change', '.from_region2', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("fuel/findFromRegion")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#from_district_id2").empty();
                $("#from_district_id2").append('<option value="">Select Departure District</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#from_district_id2").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });

});
</script>


<script>
$(document).ready(function() {

    $(document).on('change', '.to_region2', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("fuel/findToRegion")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#to_district_id2").empty();
                $("#to_district_id2").append('<option value="">Select Arrival District</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#to_district_id2").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });

});
</script>

<script>
$(document).ready(function() {

    $(document).on('change', '.supplier2', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("courier/findTariff2")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#name2").empty();
                $("#name2").append('<option value="">Select Tariff</option>');
                $.each(response,function(key, value)
                {


                    $("#name2").append('<option value=' + value.id+ '>' + value.zone_name + ' -  ' + value.weight + ' KG</option>');
                   
                });                      
               
            }

        });

    });

});
</script>

<script>
    $(document).ready(function(){
      

 $(document).on('change', '.item_name2', function(){
        var id = $(this).val();
        $.ajax({
            url: '{{url("courier/findCourierPrice")}}',
                    type: "GET",
          data:{id:id},
             dataType: "json",
          success:function(data)
          {
 console.log(data);
                  $('.item_quantity2').val(data[0]["weight"]);
          }

        });

});


    });
</script>

    
    <script type="text/javascript">
        
          $(document).ready(function(){

     

            function autoCalcSetup() {
                $('table#cart').jAutoCalc('destroy');
                $('table#cart tr.line_items').jAutoCalc({keyEventsFire: true, decimalPlaces: 2, emptyAsZero: true});
                $('table#cart').jAutoCalc({decimalPlaces: 2});
            }
            autoCalcSetup();

   

        });
        


    </script>




<script>
 $(document).ready(function(){
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });

  });
</script>

@endsection