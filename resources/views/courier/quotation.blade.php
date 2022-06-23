@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Quotation</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Quotation
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Quotation</a>
                            </li>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                              
                                              
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Reference No</th>

                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Shipment Name</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Client Name</th>
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Route</th>
                                               
                                               
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Receiver name</th> 

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Amount</th>
                                                
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($courier))
                                            @foreach ($courier as $row)
                                            <tr class="gradeA even" role="row">
                                               
                                                <td><a href="{{ route('courier_quotation.show', $row->id)}}">{{$row->pacel_number}}</a></li></td>
                                                <td>{{$row->pacel_name}}</td>
                                                <td>{{$row->supplier->name}}</td>
                                                <td>From {{$row->route->from}} to {{$row->route->to}}</td>
                                                
                                                <td>{{$row->receiver_name}}</td>
                                                <td>{{number_format($row->due_amount,2)}} {{$row->currency_code}}</td>
                                                


                                                <td>
                                                    @if($row->status == 0)
                                                    <div class="badge badge-danger badge-shadow">Not Invoiced</div>
                                                    @elseif($row->status == 7)
                                            <div class="badge badge-danger badge-shadow">Cancelled</span>
                                                    @endif
                                                </td>
                                                @if($row->status != 7)
                                        <td>
 <a  class="btn btn-xs btn-outline-info text-uppercase px-2 rounded" title="Edit" onclick="return confirm('Are you sure?')" href="{{ route('courier_quotation.edit', $row->id)}}"><i class="fa fa-edit"></i></a>

 {!! Form::open(['route' => ['courier_quotation.destroy',$row->id], 'method' => 'delete']) !!}
{{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
{{ Form::close() }}

                 <div class="btn-group">
        <button class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown">Change<span class="caret"></span></button>
        <ul class="dropdown-menu animated zoomIn">
         <li class="nav-item"><a  class="nav-link" title="Edit" data-toggle="modal" class="discount"  href="" onclick="model({{ $row->id }},'discount')" value="{{ $row->id}}" data-target="#appFormModal" >Discount Quotation</a></li>
          <li class="nav-item"><a  class="nav-link" title="Convert to Invoice" onclick="return confirm('Are you sure? you want to convert Quotation To Invoice')"  href="{{ route('courier.approve', $row->id)}}">Convert to Invoice</a></li>
          <li class="nav-item"><a  class="nav-link" title="Cancel" onclick="return confirm('Are you sure?')"   href="{{ route('courier.cancel', $row->id)}}">Cancel Quotation</a></li>                                       
                          </ul></div>

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
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                        @if(empty($id))
                                        <h5>Create Quotation</h5>
                                        @else
                                        <h5>Edit Quotation</h5>
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



                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Shipment Name</label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="pacel_name"
                                                            value="{{ isset($data) ? $data->pacel_name : ''}}"
                                                            class="form-control" required >
                                                    </div>
                                                </div>
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
                                                    <label
                                                        class="col-lg-2 col-form-label">Weight (KG)</label>

                                                    <div class="col-lg-4">
                                                        <input type="number" name="weight"
                                                            value="{{ isset($data) ? $data->weight : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Date</label>
                                                    <div class="col-lg-10">
                                                        <input type="date" name="date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->date : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                            </div>

                                       <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Due Date</label>
                                                    <div class="col-lg-10">
                                                        <input type="date" name="due_date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->due_date : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                            </div>

                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Client Name</label>

                                                    <div class="col-lg-10">
                                                    <div class="input-group">
                                         <select class="form-control supplier" name="owner_id" required id="supplier">
                                                <option value="">Select</option>
                                                          @if(!empty($users))
                                                          @foreach($users as $row)
                                                          <option @if(isset($data))
                                                          {{  $data->owner_id == $row->id  ? 'selected' : ''}}
                                                          @endif value="{{ $row->id}}">{{$row->name}}</option>
                                                          @endforeach
                                                          @endif

                                                        </select>
                                                  <div class="input-group-append">
                                                  <button class="btn btn-primary" type="button" data-toggle="modal" onclick="model({{ $row->id }},'supplier')" value="{{ $row->id}}" data-target="#appFormModal"><i class="fa fa-plus-circle"></i></button>
                                                  </div>
                                                 </div>
                                                    </div>
                                                </div>
                                                
                                                   <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Route Name</label>

                                                    <div class="col-lg-10">
                                                    <div class="input-group">
                                                        
                           <select class="form-control route" name="route_id" id="route" required>
                            <option value="">Select</option>
                                                            @if(!empty($route))
                                                            @foreach($route as $row)
                                                            <option value="{{$row->id}}" @if(isset($data))@if($data->
                                                                route_id == $row->id) selected @endif @endif >From
                                                                {{$row->from}} to {{$row->to}}
                                                            </option>

                                                            @endforeach
                                                            @endif
                                                        </select>
                                                  <div class="input-group-append">
                                                  <button class="btn btn-primary" type="button" data-toggle="modal" onclick="model({{ $row->id }},'route')" value="{{ $row->id}}" data-target="#appFormModal"><i class="fa fa-plus-circle"></i></button>
                                                  </div>
                                                 </div>
                                                    </div>
                                                </div>
                             
                                                @if(empty($id))
                                              
                                              
                                                @endif

                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Receiver Name</label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="receiver_name"
                                                            value="{{ isset($data) ? $data->receiver_name : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Receiver Mobile</label>

                                                    <div class="col-lg-10">
                                                        <input type="text" name="mobile"
                                                            value="{{ isset($data) ? $data->mobile : ''}}"
                                                            class="form-control" required placeholder="+255713100200">
                                                    </div>
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

                              <select class="form-control" name="currency_code" id="currency_code" required >
                            <option value="{{ old('currency_code')}}" disabled selected>Choose option</option>
                            @if(isset($currency))
                            @foreach($currency as $row)
                            <option  @if(isset($data)) {{$data->currency_code == $row->code ? 'selected' : 'TZS' }} @endif  value="{{ $row->code }}">{{ $row->name }}</option>
                            @endforeach
                            @endif
                        </select>

                         @else
                       <select class="form-control" name="currency_code" id="currency_code" required >
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
                                             <button type="button" name="add" class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add item</i></button><br>
                        
                                              <br>
    <div class="table-responsive">
<table class="table table-bordered" id="cart">
            <thead>
              <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                 <th>Unit</th>
                <th>Tax</th>
                <th>Total</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                                    

</tbody>
<tfoot>
@if(!empty($id))
   @if(!@empty($items))
    @foreach ($items as $i)
 <tr class="line_items">
<td><select name="item_name[]" class="form-control item_name" required  data-sub_category_id={{$i->order_no}}><option value="">Select Item</option>@foreach($name as $n) <option value="{{ $n->id}}" @if(isset($i))@if($n->id == $i->item_name) selected @endif @endif >{{$n->name}}</option>@endforeach</select></td>
 <td><input type="text" name="quantity[]" class="form-control item_quantity{{$i->order_no}}"  placeholder ="quantity" id ="quantity"  value="{{ isset($i) ? $i->quantity : ''}}" required /></td>
<td><input type="text" name="price[]" class="form-control item_price{{$i->order_no}}" placeholder ="price" required  value="{{ isset($i) ? $i->price : ''}}"/></td>
<td><input type="text" name="unit[]" class="form-control item_unit{{$i->order_no}}" placeholder ="unit" required value="{{ isset($i) ? $i->unit : ''}}"/>
<td><select name="tax_rate[]" class="form-control item_tax'+count{{$i->order_no}}" required ><option value="0">Select Tax Rate</option>
<option value="0" @if(isset($i))@if('0' == $i->tax_rate) selected @endif @endif>No tax</option>
<option value="0.18" @if(isset($i))@if('0.18' == $i->tax_rate) selected @endif @endif>18%</option></select></td>
<input type="hidden" name="total_tax[]" class="form-control item_total_tax{{$i->order_no}}'" placeholder ="total" required value="{{ isset($i) ? $i->total_tax : ''}}" readonly jAutoCalc="{quantity} * {price} * {tax_rate}"   />
<input type="hidden" name="items_id[]" class="form-control item_saved{{$i->order_no}}"   value="{{ isset($i) ? $i->items_id : ''}}" required   />
<td><input type="text" name="total_cost[]" class="form-control item_total{{$i->order_no}}" placeholder ="total" required value="{{ isset($i) ? $i->total_cost : ''}}" readonly jAutoCalc="{quantity} * {price}" /></td>
 <input type="hidden" name="pacel_item_id[]"  class="form-control name_list"  value= "{{ isset($i) ? $i->id : ''}}" />  
<td><button type="button" name="remove" class="btn btn-danger btn-xs rem" value= "{{ isset($i) ? $i->id : ''}}"><i class="fas fa-trash"></i></button></td>
</tr>

@endforeach
 @endif
 @endif

 <tr class="line_items">
<td colspan="4"></td>
<td><span class="bold">Sub Total </span>: </td><td><input type="text" name="subtotal[]" class="form-control item_total" placeholder ="subtotal" required   jAutoCalc="SUM({total_cost})" readonly></td>   
</tr>
 <tr class="line_items">
<td colspan="4"></td>
<td><span class="bold">Tax </span>: </td><td><input type="text" name="tax[]" class="form-control item_total" placeholder ="tax" required   jAutoCalc="SUM({total_tax})" readonly>
</td>   
</tr>
   @if(!@empty($data->discount > 0))
<tr class="line_items">
<td colspan="4"></td>
<td><span class="bold">Discount</span>: </td><td><input type="text" name="discount[]" class="form-control item_discount" placeholder ="total" required  value="{{ isset($data) ? $data->discount : ''}}" readonly></td>   
</tr>
@endif

<tr class="line_items">
<td colspan="4"></td>
  @if(!@empty($data->discount > 0))
<td><span class="bold">Total</span>: </td><td><input type="text" name="amount[]" class="form-control item_total" placeholder ="total" required   jAutoCalc="{subtotal} + {tax} - {discount}" readonly></td>  
 @else
<td><span class="bold">Total</span>: </td><td><input type="text" name="amount[]" class="form-control item_total" placeholder ="total" required   jAutoCalc="{subtotal} + {tax}" readonly></td>  
@endif
</tr>
</tfoot>
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
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

 <!-- discount Modal -->
  <div class="modal inmodal show " id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
    </div>
</div></div>
  </div>


 <!-- route Modal -->
  <div class="modal inmodal show" id="routeModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
<div class="modal-dialog" role="document">
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
</div></div>
  </div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
                extend: 'copy'
            },
            {
                extend: 'csv'
            },
            {
                extend: 'excel',
                title: 'ExampleFile'
            },
            {
                extend: 'pdf',
                title: 'ExampleFile'
            },

            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ]

    });

});
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script>
    $(document).ready(function(){
      
      $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
      });

 $(document).on('change', '.item_name', function(){
        var id = $(this).val();
        var sub_category_id = $(this).data('sub_category_id');
        $.ajax({
            url: '{{url("findCourierPrice")}}',
                    type: "GET",
          data:{id:id},
             dataType: "json",
          success:function(data)
          {
 console.log(data);
                     $('.item_price'+sub_category_id).val(data[0]["price"]);
                      $(".item_unit"+sub_category_id).val(data[0]["unit"]);
                    $(".item_saved"+sub_category_id).val(data[0]["id"]);
          }

        });

});


    });
</script>


    
    <script type="text/javascript">
        
          $(document).ready(function(){

      
      var count = 0;


            function autoCalcSetup() {
                $('table#cart').jAutoCalc('destroy');
                $('table#cart tr.line_items').jAutoCalc({keyEventsFire: true, decimalPlaces: 2, emptyAsZero: true});
                $('table#cart').jAutoCalc({decimalPlaces: 2});
            }
            autoCalcSetup();

    $('.add').on("click", function(e) {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html += '<td><select name="item_name[]" class="form-control item_name" required  data-sub_category_id="'+count+'"><option value="">Select Item</option>@foreach($name as $n) <option value="{{ $n->id}}">{{$n->name}}</option>@endforeach</select></td>';
        html += '<td><input type="text" name="quantity[]" class="form-control item_quantity" data-category_id="'+count+'"placeholder ="quantity" id ="quantity" required /></td>';
       html += '<td><input type="text" name="price[]" class="form-control item_price'+count+'" placeholder ="price" required  value=""/></td>';
       html += '<td><input type="text" name="unit[]" class="form-control item_unit'+count+'" placeholder ="unit" required /></td>';
       html += '<td><select name="tax_rate[]" class="form-control item_tax'+count+'" required ><option value="0">Select Tax Rate</option><option value="0">No tax</option><option value="0.18">18%</option></select></td>';
 html += '<input type="hidden" name="total_tax[]" class="form-control item_total_tax'+count+'" placeholder ="total" required readonly jAutoCalc="{quantity} * {price} * {tax_rate}"   />';
 html += '<input type="hidden" name="items_id[]" class="form-control item_saved'+count+'"  required   />';
       html += '<td><input type="text" name="total_cost[]" class="form-control item_total'+count+'" placeholder ="total" required readonly jAutoCalc="{quantity} * {price}" /></td>';
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fas fa-trash"></i></button></td>';

        $('tbody').append(html);
autoCalcSetup();
      });

  $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
autoCalcSetup();
      });
      

 $(document).on('click', '.rem', function(){  
      var btn_value = $(this).attr("value");   
               $(this).closest('tr').remove();  
            $('tfoot').append('<input type="hidden" name="removed_id[]"  class="form-control name_list" value="'+btn_value+'"/>');  
         autoCalcSetup();
           });  

        });
        


    </script>



<script type="text/javascript">
    function model(id,type) {

        $.ajax({
            type: 'GET',
            url: '{{url("courierModal")}}',
            data: {
                'id': id,
                'type':type,
            },
            cache: false,
            async: true,
            success: function(data) {
                //alert(data);
                $('.modal-dialog').html(data);
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');

            }
        });

    }
    
    function calculateDiscount() {

      $('#discount').on('input',function() {
    var price= parseInt($('#discount').val());
    var qty = parseFloat($('#old').val());
console.log(price);
    $('#total').val((qty -price ? qty - price : 0).toFixed(2));
});

    }


    function saveClient(e){
  
     
     var name = $('#name').val();
     var phone = $('#phone').val();
     var email = $('#email').val();
     var address = $('#address').val();
   var TIN= $('#TIN').val();

     
          $.ajax({
            type: 'GET',
            url: '{{url("addCourierSupplier")}}',
             data: {
                 'name':name,
                 'phone':phone,
                 'email':email,
                 'address':address,
                  'TIN':TIN,
             },
                dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var name = response.name;

                             var option = "<option value='"+id+"'  selected>"+name+" </option>"; 

                             $('#supplier').append(option);
                              $('#appFormModal').hide();
                   
                               
               
            }
        });
}


    function saveRoute(e){
     
     
     var to = $('#to').val();
     var distance = $('#distance').val();
     var from = $('#from').val();

     
          $.ajax({
            type: 'GET',
            url: '{{url("addRoute")}}',
             data: {
                 'to':to,
                 'distance':distance,
                 'from':from,
             },
          dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var arrival_point = response.from;
                              var destination_point = response.to;

                             var option = "<option value='"+id+"'  selected>From "+arrival_point+" to "+destination_point+"</option>"; 

                             $('#route').append(option);
                              $('#appFormModal').hide();
                   
                               
               
            }
          
        });
}
    </script>

@endsection