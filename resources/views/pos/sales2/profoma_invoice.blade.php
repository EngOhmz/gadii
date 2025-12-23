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
                            <h4>Profoma Invoice </h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                        aria-selected="true">Invoice
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Invoice</a>
                                </li>

                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table datatable-basic table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 106.484px;">Ref</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 186.484px;">Client Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 136.484px;">Invoice Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 161.219px;">Invoice Amount</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Location</th>
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
                                                @if (!@empty($invoices))
                                                    @foreach ($invoices as $row)
                                                        <tr class="gradeA even" role="row">

                                                            <td>
                                                            <a href="{{ route('profoma_invoice.show', $row->id) }}">{{ $row->reference_no }}</a>
                                                            </td>
                                                            <td>
                                                                {{ $row->client->name }}
                                                            </td>

                                                            <td>{{Carbon\Carbon::parse($row->invoice_date)->format('d/m/Y') }}</td>

                                                            <td>{{ number_format($row->due_amount, 2) }}
                                                                {{ $row->exchange_code }}</td>
                                                            <td>
                                                                @if (!empty($row->store->name))
                                                                    {{ $row->store->name }}
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($row->status == 0)
                                                                    <div class="badge badge-danger badge-shadow">Not
                                                                        Approved</div>
                                                                @elseif($row->status == 1)
                                                                    <div class="badge badge-warning badge-shadow">Not Paid
                                                                    </div>
                                                                @elseif($row->status == 2)
                                                                    <div class="badge badge-info badge-shadow">Partially
                                                                        Paid</div>
                                                                @elseif($row->status == 3)
                                                                    <span class="badge badge-success badge-shadow">Fully
                                                                        Paid</span>
                                                                @elseif($row->status == 4)
                                                                    <span
                                                                        class="badge badge-danger badge-shadow">Cancelled</span>
                                                                @endif
                                                            </td>

                                                            @if ($row->status != 4 && $row->status != 3)
                                                                <td>
                                                                    <div class="form-inline">
                                                                        @if ($row->good_receive == 0)
                                                                            <a class="list-icons-item text-primary"
                                                                                title="Edit"
                                                                                onclick="return confirm('Are you sure?')"
                                                                                href="{{ route('profoma_invoice.edit', $row->id) }}"><i
                                                                                    class="icon-pencil7"></i></a>&nbsp
                                                                        @endif

                                                                        {!! Form::open(['route' => ['profoma_invoice.destroy', $row->id], 'method' => 'delete']) !!}
                                                                        {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                                        {{ Form::close() }}

                                                                        &nbsp

                                                                        <div class="dropdown">
                                                                            <a href="#"
                                                                                class="list-icons-item dropdown-toggle text-teal"
                                                                                data-toggle="dropdown"><i
                                                                                    class="icon-cog6"></i></a>
                                                                            <div class="dropdown-menu">
                                                                                @if ($row->invoice_status == 0)
                                                                                    <a class="nav-link"
                                                                                        onclick="return confirm('Are you sure?')"
                                                                                        href="{{ route('invoice.convert_to_invoice', $row->id) }}"
                                                                                        title=""> Convert To Invoice
                                                                                    </a>
                                                                                @endif
                                                                                @if ($row->status != 0 && $row->status != 4 && $row->status != 3 && $row->good_receive == 0)
                                                                                    <a class="nav-link" id="profile-tab2"
                                                                                        href="{{ route('invoice.receive', $row->id) }}"
                                                                                        role="tab"
                                                                                        aria-selected="false">Good
                                                                                        Receive</a>
                                                                                @endif
                                                                                @if ($row->status != 0 && $row->status != 4 && $row->status != 3 && $row->good_receive == 1)
                                                                                    <a class="nav-link" id="profile-tab2"
                                                                                        href="{{ route('invoice.pay', $row->id) }}"
                                                                                        role="tab"
                                                                                        aria-selected="false">Make
                                                                                        Payments</a>
                                                                                @endif
                                                                                @if ($row->good_receive == 0)
                                                                                    <a class="nav-link" title="Cancel"
                                                                                        onclick="return confirm('Are you sure?')"
                                                                                        href="{{ route('invoice.cancel', $row->id) }}">Cancel
                                                                                        Invoice</a>
                                                                                @endif
                                                                                
                                                                                <a class="nav-link" id="profile-tab2"
                                                                                        href="{{ route('pos_profoma_pdfview',['download'=>'pdf','id'=>$row->id]) }}"
                                                                                        role="tab"
                                                                                        aria-selected="false">Download PDF</a>

                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                </td>
                                                            @else
                                                                <td></td>
                                                            @endif
                                                        </tr>
                                                    @endforeach

                                                @endif

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade @if (!empty($id)) active show @endif"
                                    id="profile2" role="tabpanel" aria-labelledby="profile-tab2">

                                    <div class="card">
                                        <div class="card-header">
                                            @if (empty($id))
                                                <h5>Create Invoice</h5>
                                            @else
                                                <h5>Edit Invoice</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if (isset($id))
                                                        {{ Form::model($id, ['route' => ['profoma_invoice.update', $id], 'method' => 'PUT']) }}
                                                    @else
                                                        {{ Form::open(['route' => 'profoma_invoice.store']) }}
                                                        @method('POST')
                                                    @endif


                                                    <input type="hidden" name="edit_type" class="form-control name_type"
                                                        value="{{ $type }}" />

                                                    <div class="form-group row">

                                                        <label class="col-lg-2 col-form-label">Client Name</label>
                                                        <div class="col-lg-4">
                                                            <div class="input-group mb-3">
                                                                <select
                                                                    class="form-control append-button-single-field client_id"
                                                                    name="client_id" id="client_id" required>
                                                                    <option value="">Select Client Name</option>
                                                                    @if (!empty($client))
                                                                        @foreach ($client as $row)
                                                                            <option
                                                                                @if (isset($data)) {{ $data->client_id == $row->id ? 'selected' : '' }} @endif
                                                                                value="{{ $row->id }}">
                                                                                {{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif

                                                                </select>&nbsp

                                                                <button class="btn btn-outline-secondary" type="button"
                                                                    data-toggle="modal" value=""
                                                                    onclick="model('1','client')"
                                                                    data-target="#appFormModal" href="app2FormModal"><i
                                                                        class="icon-plus-circle2"></i></button>
                                                            </div>
                                                        </div>
                                                        <label class="col-lg-2 col-form-label">Location</label>
                                                        <div class="col-lg-4">
                                                            <select class="form-control m-b location" name="location"
                                                                required id="location">
                                                                <option value="">Select Location</option>
                                                                @if (!empty($location))
                                                                    @foreach ($location as $loc)
                                                                        <option
                                                                            @if (isset($data)) {{ $data->location == $loc->id ? 'selected' : '' }} @endif
                                                                            value="{{ $loc->id }}">
                                                                            {{ $loc->name }}</option>
                                                                    @endforeach
                                                                @endif

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Invoice Date</label>
                                                        <div class="col-lg-4">
                                                            <input type="date" name="invoice_date"
                                                                placeholder="0 if does not exist"
                                                                value="{{ isset($data) ? $data->invoice_date : date('Y-m-d') }}"
                                                                class="form-control">
                                                        </div>
                                                        <label class="col-lg-2 col-form-label">Due Date</label>
                                                        <div class="col-lg-4">
                                                            <input type="date" name="due_date"
                                                                placeholder="0 if does not exist"
                                                                value="{{ isset($data) ? $data->due_date : strftime(date('Y-m-d', strtotime('+10 days'))) }}"
                                                                class="form-control">
                                                        </div>
                                                    </div>


                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Sales Agent</label>
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
                                                            <select class="form-control m-b" name="branch_id">
                                                                <option>Select Branch</option>
                                                                @if (!empty($branch))
                                                                    @foreach ($branch as $row)
                                                                        <option value="{{ $row->id }}">
                                                                            {{ $row->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                     <div class="form-group row">
                                                     <label class="col-lg-2 col-form-label">Notes</label>

                                                        <div class="col-lg-10">
                                                    <textarea name="notes" class="form-control" rows="4">{{ isset($data) ? $data->notes : '' }}</textarea>
                                                        </div>
                                                    </div>




                                                    <br>
                                                    <h4 align="center">Enter Item Details</h4>
                                                    <hr>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Currency</label>
                                                        <div class="col-lg-4">
                                                            @if (!empty($data->exchange_code))

                                                                <select class="form-control m-b" name="exchange_code"
                                                                    id="currency_code" required>
                                                                    <option value="{{ old('currency_code') }}" disabled
                                                                        selected>Choose option</option>
                                                                    @if (isset($currency))
                                                                        @foreach ($currency as $row)
                                                                            <option
                                                                                @if (isset($data)) {{ $data->exchange_code == $row->code ? 'selected' : 'TZS' }} @endif
                                                                                value="{{ $row->code }}">
                                                                                {{ $row->name }}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                            @else
                                                                <select class="form-control m-b" name="exchange_code"
                                                                    id="currency_code" required>
                                                                    <option value="{{ old('currency_code') }}" disabled>
                                                                        Choose option</option>
                                                                    @if (isset($currency))
                                                                        @foreach ($currency as $row)
                                                                            @if ($row->code == 'TZS')
                                                                                <option value="{{ $row->code }}"
                                                                                    selected>{{ $row->name }}</option>
                                                                            @else
                                                                                <option value="{{ $row->code }}">
                                                                                    {{ $row->name }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                </select>


                                                            @endif
                                                        </div>
                                                        <label class="col-lg-2 col-form-label">Exchange Rate</label>
                                                        <div class="col-lg-4">
                                                            <input type="number" name="exchange_rate" step="0.0001"
                                                                placeholder="1 if TZSH"
                                                                value="{{ isset($data) ? $data->exchange_rate : '1.0000' }}"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                     <div class=""> <p class="form-control-static item_errors" id="errors" style="text-align:center;color:red;"></p>   </div>
                                                    <button type="button" name="add"
                                                        class="btn btn-success btn-xs add"><i class="fas fa-plus"></i> Add
                                                            item</button><br>
                                                    <br>
                         
                                             <div class="table-responsive">

<div class="cart" id="cart">

<div class="row body">


</div>
</div>



<br>

<div class="cart1" id="cart1">
<div class="row body1">
 <div class="table-responsive">
            <br><table class="table" id="table1">
                                                     <thead style="display: @if(!empty($items))  @else none @endif ;">
                                                    <tr>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Total Cost</th>
                                                    <th scope="col">Total Tax</th>
                                                     <th scope="col">Action</th>
                                                    </tr>
                                                    </thead>
                                                     <tbody>
              @if (!empty($id))
                                                    @if (!empty($items))
                                                    @foreach ($items as $i)
                                                    
                                                    @php
                                                     $it=App\Models\POS\Items::where('id',$i->item_name)->first();
                                                        $c = App\Models\POS\Color::find($it->color);
                                                        $s = App\Models\POS\Size::find($it->size);
                                                                
                                                       if(!empty($c) && empty($s)){
                                                         $a = $it->name .' - '.$c->name;  
                                                       }
                                                          
                                                      elseif(empty($c) && !empty($s)){
                                                         $a =  $it->name .' - '.$s->name;   
                                                       } 
                                                       
                                                       elseif(!empty($c) && !empty($s)){
                                                       $a =  $it->name .' - '.$c->name . ' - '.$s->name;
                                                       } 
                                                       
                                                       else{
                                                            $a =  $it->name ; 
                                                       }
                                                    @endphp
                                                    
                                                    <tr class="trlst{{$i->id}}_edit">
                                                      <td>{{$a}}</td>
                                                      <td>{{ isset($i) ? number_format($i->quantity,2) : '' }}
                                                      <div class=""> <span class="form-control-static errorslst{{$i->id}}_edit" id="errors" style="text-align:center;color:red;"></span></div></td>
                                                      <td>{{ isset($i) ? number_format($i->price,2) : '' }}</td>
                                                      <td>{{ isset($i) ? number_format($i->total_cost,2) : '' }}</td>
                                                      <td>{{ isset($i) ? number_format($i->total_tax,2) : '' }}</td>
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

</div>

@if (!empty($id))
                                                    @if (!empty($items))
                                                    @foreach ($items as $i)
                                                    
                                                    <div class="line_items" id="lst{{$i->id}}_edit">
  <input type="hidden" name="item_name[]" class="form-control item_name" id="name lst{{$i->id}}_edit" value="{{ isset($i) ? $i->item_name : '' }}" required="">
  <input type="hidden" name="description[]" class="form-control item_desc" id="desc lst{{$i->id}}_edit" value="{{ isset($i) ? $i->description : '' }}">
  <input type="hidden" name="quantity[]" class="form-control item_quantity" id="qty lst{{$i->id}}_edit" data-category_id="lst{{$i->id}}_edit" value="{{ isset($i) ? $i->quantity : '' }}" required="">
  <input type="hidden" name="price[]" class="form-control item_price" id="price lst{{$i->id}}_edit" value="{{ isset($i) ? $i->price : '' }}" required="">
  <input type="hidden" name="tax_rate[]" class="form-control item_rate" id="rate lst{{$i->id}}_edit" value="{{ isset($i) ? $i->tax_rate : '' }}" required="">
  <input type="hidden" name="total_cost[]" class="form-control item_cost" id="cost lst{{$i->id}}_edit" value="{{ isset($i) ? $i->total_cost : '' }}" required="">
  <input type="hidden" name="total_tax[]" class="form-control item_tax" id="tax lst{{$i->id}}_edit" value="{{ isset($i) ? $i->total_tax : '' }}" required="">
  <input type="hidden" name="unit[]" class="form-control item_unit" id="unit lst{{$i->id}}_edit" value="{{ isset($i) ? $i->unit : '' }}">
  <input type="hidden" name="type" class="form-control item_type" id="type lst{{$i->id}}_edit" value="edit">
  <input type="hidden" name="no[]" class="form-control item_type" id="no lst{{$i->id}}_edit" value="{{$i->id}}_edit">
  <input type="hidden" name="saved_items_id[]" class="form-control item_savedlst{{$i->id}}_edit" value="{{$i->id}}">
  <input type="hidden" id="item_id" class="form-control item_idlst{{$i->id}}_edit" value="{{ isset($i) ? $i->item_name : '' }}">
</div>
                                                     @endforeach
                                                    @endif
                                                    @endif

                                                 

</div>
       
     <br> <br>
<div class="row">



<div class="col-lg-1"></div><label class="col-lg-3 col-form-label"> Sub Total (+):</label>
<div class="col-lg-6 line_items">
<input type="text" name="subtotal[]" class="form-control item_total" value="{{ isset($data) ? '' : '0.00' }}" required="" jautocalc="SUM({total_cost})" readonly=""> <br>
</div><div class="col-lg-2"></div>

<div class="col-lg-1"></div><label class="col-lg-3 col-form-label">Tax (+):</label>
<div class="col-lg-6 line_items">
<input type="text" name="tax[]" class="form-control item_total" value="{{ isset($data) ? '' : '0.00' }}" required="" jautocalc="SUM({total_tax})" readonly=""> <br>
</div><div class="col-lg-2"></div>

<div class="col-lg-1"></div><label class="col-lg-3 col-form-label"> Shipping Cost (+):</label>
<div class="col-lg-6 line_items">
<input type="number" name="shipping_cost[]" class="form-control item_shipping" required="" value="{{ isset($data) ? $data->shipping_cost : '0.00' }}"> <br> 
</div><div class="col-lg-2"></div>

<div class="col-lg-1"></div><label class="col-lg-3 col-form-label">  Discount (-)</label>
<div class="col-lg-6 line_items">
<input type="number" name="discount[]" class="form-control item_discount" required="" value="{{ isset($data) ? $data->discount : '0.00' }}"><br>  
</div><div class="col-lg-2"></div>

<div class="col-lg-1"></div><label class="col-lg-3 col-form-label"> Total Before Adjustment:</label>
<div class="col-lg-6 line_items">
<input type="text" name="before[]" class="form-control item_total" value="{{ isset($data) ? '' : '0.00' }}" required="" jautocalc="{subtotal} + {tax} + {shipping_cost} - {discount}" readonly="readonly" ><br> 
</div><div class="col-lg-2"></div>

<div class="col-lg-1"></div><label class="col-lg-3 col-form-label"> Adjustment:</label>
<div class="col-lg-6 line_items">
<input type="number" name="adjustment[]" step="0.01" class="form-control item_total" value="{{ isset($data) ? $data->adjustment : '0.00' }}" ><br> 
</div><div class="col-lg-2"></div>

<div class="col-lg-1"></div><label class="col-lg-3 col-form-label"> Total:</label>
<div class="col-lg-6 line_items">
<input type="text" name="amount[]" class="form-control item_total" value="{{ isset($data) ? '' : '0.00' }}" required="" jautocalc="{before} + {adjustment}" readonly="readonly" ><br> 
</div><div class="col-lg-2"></div>

</div>


</div>





</div>



                                                    <br>
                                                    <div class="form-group row">
                                                        <div class="col-lg-offset-2 col-lg-12">
                                                            @if (!@empty($id))

                                                                <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                                    href="{{ route('profoma_invoice.index') }}">
                                                                    cancel
                                                                </a>
                                                                <button class="btn btn-sm btn-primary float-right m-t-n-xs save"
                                                                   
                                                                    type="submit" id="save">Update</button>
                                                            @else
                                                                <button class="btn btn-sm btn-primary float-right m-t-n-xs save"
                                                                    type="submit" id="save">Save</button>
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
    <div class="modal fade" data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">

        </div>
    </div>


@endsection

@section('scripts')
    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            order: [
                [2, 'desc']
            ],
            "columnDefs": [{
                "orderable": false,
                "targets": [3]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            },

        });
    </script>
   <script>
    
    $(document).ready(function() {
       

        
         $(document).on('change', '.location', function() {
 $(".item_quantity").change();

});

        $(document).on('change', '.item_quantity', function() {
            var id = $(this).val();
              var type = $('.name_type').val();
            var sub_category_id = $(this).data('category_id');
            var item = $('.item_id' + sub_category_id).val();
            var location = $('.location').val();

            console.log(location);
            $.ajax({
                 url: '{{ url('pos/sales/findInvQuantity') }}',
                type: "GET",
                data: {
                    id: id,
                    item: item,
                    location: location,
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                      if (type == 'receive') {
                    $('.errors' + sub_category_id).empty();
                    $("#save").attr("disabled", false);
                      $(".add_edit_form").attr("disabled", false);
                    if (data != '') {
                        $('.errors' + sub_category_id).append(data);
                        $("#save").attr("disabled", true);
                         $(".add_edit_form").attr("disabled", true);
                    } else {

                    }
                      }  

                }

            });

        });



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
                emptyAsZero: true
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
                '<div class="col-lg-3 line_items" id="td'+count + '"><br><div class="input-group mb-3"><select name="checked_item_name[]" class="form-control m-b item_name"  id="item_name' +
                count + '" data-sub_category_id="' + count +'" required><option value="">Select Item Name</option>@foreach ($name as $n) <option value="{{ $n->id }}">{{ $n->name }} @if(!empty($n->color)) - {{$n->c->name}} @endif   @if(!empty($n->size)) - {{$n->s->name}} @endif</option>@endforeach</select></div><br><textarea name="checked_description[]"  class="form-control desc' + count +'" placeholder="Description"  ></textarea><br></div>';
            html +='<div class="col-lg-6 line_items" id="td'+count + '"><br>Quantity <input type="number" name="checked_quantity[]" class="form-control item_quantity" min="0.01" step="0.01" data-category_id="' +count +'"placeholder ="quantity" id ="quantity" required /><div class=""> <p class="form-control-static errors' +count + '" id="errors" style="text-align:center;color:red;"></p> </div><br>Price <input type="text" name="checked_price[]" class="form-control item_price' + count +'" placeholder ="price" id="price td'+count + '" required  value=""/><br>Total Cost <input type="text" name="checked_total_cost[]" class="form-control item_total' +
                count + '" placeholder ="total" id="total td'+count + '" required readonly jAutoCalc="{checked_quantity} * {checked_price}" /><br>Tax <input type="text" name="checked_total_tax[]" class="form-control item_total_tax' +
                count +'" placeholder ="tax" id="tax_rate td'+count + '" required readonly jAutoCalc="{checked_quantity} * {checked_price} * {checked_tax_rate}"   readonly/><br>';
                 html += '<input type="hidden" name="checked_no[]" class="form-control item_no' + count +'" id="no td'+count + '" value="' + count +'" required />';
            html += '<input type="hidden" name="checked_unit[]" class="form-control item_unit' + count +'" id="unit td'+count + '" placeholder ="unit" required />';
            html += '<input type="hidden" name="checked_tax_rate[]" class="form-control item_tax' + count +'" placeholder ="total" id="tax td'+count + '"required />';
            html += '<input type="hidden" id="item_id"  class="form-control item_id' + count +'" value="" /></div>';
            html +='<div class="col-lg-3 text-center line_items" id="td'+count + '"><br><a class="list-icons-item text-info add1" title="Check" href="javascript:void(0)" data-save_id="' +count + '"><i class="icon-check2" style="font-size:30px;font-weight:bold;"></i></a>&nbsp&nbsp<a class="list-icons-item text-danger remove" title="Delete" href="javascript:void(0)" data-button_id="' +count + '"><i class="icon-trash" style="font-size:18px;"></i></a><br><div class=""> <p class="form-control-static body_errors' +count + '" id="errors" style="text-align:center;color:red;"></p></div></div>';


          
            if ( $('#cart > .body div').length == 0 ) {
            $('#cart > .body').append(html);
            autoCalcSetup();
            
              }

            /*
             * Multiple drop down select
             */
            $('.m-b').select2({});


       
        
        
         $(document).on('change', '.item_price'+ count, function() {
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
        
         $(document).on('change', '.item_name', function() {
            var id = $(this).val();
            var sub_category_id = $(this).data('sub_category_id');
            $.ajax({
                url: '{{ url('pos/sales/findInvPrice') }}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('.item_price' + sub_category_id).val(numberWithCommas(data[0]["sales_price"]));
                    $(".item_unit" + sub_category_id).val(data[0]["unit"]);
                    $(".item_tax" + sub_category_id).val(data[0]["tax_rate"]);
                    $(".desc" + sub_category_id).val(data[0]["description"]);
                    $('.item_id' + sub_category_id).val(id);
                      autoCalcSetup();
                }

            });

        });
        

      


        $(document).on('click', '.remove', function() {
            var button_id = $(this).data('button_id');
            var contentToRemove = document.querySelectorAll('#td' + button_id);
            $(contentToRemove).remove(); 
            autoCalcSetup();
        });

    });
</script>


<script type="text/javascript">
    $(document).ready(function() {


     
        function autoCalcSetup1() {
            $('div#cart1').jAutoCalc('destroy');
            $('div#cart1.div.line_items').jAutoCalc({
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
            console.log(1);
            
            
            
        var button_id = $(this).data('save_id');
        $('.body_errors'+ button_id).empty();
        //$('.body').find('select, textarea, input').serialize();
        
        var b=$('#td' + button_id).find('.item_name').val();
        var c=$('div#td' + button_id +'.col-lg-6.line_items').find('.item_quantity').val();
        var d=$('.item_price' + button_id).val();
        
         
        
        if( b == '' || c == '' || d == '' ){
           $('.body_errors'+ button_id).append('Please Fill Required Fields.');
        
     }
     
     else{
        
        
         $.ajax({
                type: 'GET',
                 url: '{{ url('pos/sales/add_inv_item') }}',
               data: $('#cart > .body').find('select, textarea, input').serialize(),
                cache: false,
                async: true,
                success: function(data) {
                    console.log(data);
                    
          
             $('#cart1 > .body1 table thead').show();
             $('#cart1 > .body1 table tbody').append(data['list']);
               $('#cart1 > .body1').append(data['list1']);
              autoCalcSetup1();
 
                },
              


            });
            
            
            var contentToRemove = document.querySelectorAll('#td' + button_id);
            $(contentToRemove).remove(); 
            
     }
     

        });



        $(document).on('click', '.remove1', function() {
            var button_id = $(this).data('button_id');
            var contentToRemove = document.querySelectorAll('#lst' + button_id);
            $(contentToRemove).remove(); 
             $(this).closest('tr').remove();
             $(".item_quantity").change();
            autoCalcSetup1();
        });
        
        
          $(document).on('click', '.rem', function() {
            var button_id = $(this).data('button_id');
            var btn_value = $(this).attr("value");
            var contentToRemove = document.querySelectorAll('#lst' + button_id);
            $(contentToRemove).remove(); 
             $(this).closest('tr').remove();
              $('#cart1 > .body1').append('<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +btn_value + '"/>');
              $(".item_quantity").change();
            autoCalcSetup1();
        });



  $(document).on('click', '.edit1', function() {
            var button_id = $(this).data('button_id');
            
            console.log(button_id);
            $.ajax({
                type: 'GET',
                 url: '{{ url('pos/sales/invModal') }}',
                 data: $('#cart1 > .body1 #lst'+button_id).find('select, textarea, input').serialize(),
                cache: false,
                async: true,
                success: function(data) {
                    //alert(data);

                    $('#appFormModal > .modal-dialog').html(data);
                      $('.m-b').select2({ dropdownParent: $('#appFormModal'),});
                },
                error: function(error) {
                    $('#appFormModal').modal('toggle');

                }


            });
           
            
        });
        
        
            $(document).on('click', '.add_edit_form', function(e) {
            e.preventDefault();
           
            var sub = $(this).data('button_id');
            console.log(sub);
            
            $.ajax({
                data: $('.addEditForm').serialize(),
                type: 'GET',
                 url: '{{ url('pos/sales/add_inv_item') }}',
                dataType: "json",
                success: function(data) {
                    console.log(data);
                  
                  $('#cart1 > .body1 table tbody').find('.trlst'+sub).html(data['list']);
                  $('#cart1 > .body1').find('#lst'+sub).html(data['list1']);
                    $(".item_quantity").change();
              autoCalcSetup1();
           

                }
            })
        });



    });
</script>

<script type="text/javascript">
    function model(id, type) {


        $.ajax({
            type: 'GET',
             url: '{{ url('pos/sales/invModal') }}',
            data: {
                'id': id,
                'type': type,
            },
            cache: false,
            async: true,
            success: function(data) {
                //alert(data);
                $('#appFormModal > .modal-dialog').html(data);
                  $('.m-b').select2({ dropdownParent: $('#appFormModal'),});
                
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');

            }
        });

    }


</script>

<script type="text/javascript">
    

    function saveClient(e) {

        $.ajax({
            type: 'GET',
            url: '{{ url('pos/sales/save_client') }}',
            data: $('.addClientForm').serialize(),
            dataType: "json",
            success: function(response) {
                console.log(response);

                var id = response.id;
                var name = response.name;

                var option = "<option value='" + id + "'  selected>" + name + " </option>";

                $('#client_id').append(option);
                $('#appFormModal').hide();



            }
        });
    }
</script>

<script>
    $(document).ready(function() {
      $(".item_quantity").trigger('change');
      
         $(document).on('click', '.save', function(event) {
   
         $('.item_errors').empty();

          if ( $('#cart1 > .body1 .line_items').length == 0 ) {
               event.preventDefault(); 
    $('.item_errors').append('Please Add Items.');
}
         
         else{
            
         
          
         }
        
    });
    
    
    
    });
    </script>
    
    
  
    </script>
    
    
    <script type="text/javascript">


function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

</script>
@endsection
