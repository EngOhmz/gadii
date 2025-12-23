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
                                    <table class="table table-striped dataTables-example" id="table-4">
                                        <thead>
                                            <tr>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Date</th>                                             
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 106.484px;">Reference No</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Shipment Name</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 146.484px;">Client Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Destination</th> 

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Amount</th>
                                                
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 81.219px;">Status</th>
                                 <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 198.1094px;">Actions</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($pacel))
                                            @foreach ($pacel as $row)
                                            <tr class="gradeA even" role="row">
                                              <td>{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}</td>
                                                <td><a href="{{ route('pacel_quotation.show', $row->id)}}">{{$row->confirmation_number}}</a></li></td>
                                                <td>{{$row->pacel_name}}</td>
                                                <td>{{$row->supplier->name}}</td>
                                              
                                                
                                                <td>
                                                <ol>
                                                  @php
                                                $result = App\Models\Pacel\PacelItem::all()->where('pacel_id',$row->id);
                                                 @endphp
                                                @foreach($result as $row2)
                                                @php
                                                $destination = App\Models\Route::find($row2->item_name);
                                                if(!empty($destination)){
                                                    $to = $destination->to;
                                                }
                                                @endphp
                                               <li> {{isset($to)? $to : ""}} </li>
                                               
                                                @endforeach  
                                                <ol>
                                                </td>
                                                <td>{{number_format($row->amount,2)}} {{$row->currency_code}}</td>
                                                


                                                <td>
                                                    @if($row->status == 0 && $row->collected == 0)
                                                    <div class="badge badge-danger badge-shadow">Not Approved</div>                                                   
                                              @elseif($row->collected == 1)
                                            <div class="badge badge-success badge-shadow">Approved</div>
                                                  @elseif($row->status == 7 &&$row->collected == 0)
                                            <div class="badge badge-danger badge-shadow">Cancelled</div>
                                                    @endif
                                                </td>
                                             
                                   @if($row->collected == 0 && $row->status == 0)
                                            <td>
<div class="form-inline">
 <a  class="list-icons-item text-primary" title="Edit" onclick="return confirm('Are you sure?')" href="{{ route('pacel_quotation.edit', $row->id)}}"><i  class="icon-pencil7"></i></a>&nbsp

 {!! Form::open(['route' => ['pacel_quotation.destroy',$row->id], 'method' => 'delete']) !!}
{{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}&nbsp

 <div class="dropdown">
                                  <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
    <div class="dropdown-menu">
          <a  class="nav-link" title="Collect" onclick="return confirm('Are you sure? you want to transport package')"  href="{{ route('pacel.approve', $row->id)}}">Approve Quotation</a>      
        <a  class="nav-link" title="Cancel" onclick="return confirm('Are you sure?')"   href="{{ route('pacel.cancel', $row->id)}}">Cancel Quotation</a>                                       
                          </ul>
</div>
                  

                                                       </div>
                                </div>
                              </td>

                                       @else
                                        <td>{{-- <a  class="list-icons-item text-danger" title="Delete" onclick="return confirm('Are you sure?')" href="{{ route('pacel.disable', $row->id)}}"><i class="icon-trash"></i></a> --}}</td>
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
                                                {{ Form::model($id, array('route' => array('pacel_quotation.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'pacel_quotation.store']) }}
                                                @method('POST')
                                                @endif

                                   <input type="hidden" name="type"   value=""    class="form-control" required>

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
                                                            class="form-control weight" required>
                                                    </div>
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Date</label>
                                                    <div class="col-lg-10">
                                                        <input type="date" name="date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->date : date('Y-m-d')}}"
                                                            class="form-control" required>
                                                    </div>
                                            </div>

                                       <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Due Date</label>
                                                    <div class="col-lg-10">
                                                        <input type="date" name="due_date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->due_date : strftime(date('Y-m-d', strtotime("+10 days")))}}"
                                                            class="form-control" required>
                                                    </div>
                                            </div>

                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Client Name</label>

                                                    <div class="col-lg-8">
                                         <select class="form-control m-b supplier" name="owner_id" required id="supplier">
                                                <option value="">Select Client</option>
                                                          @if(!empty($users))
                                                          @foreach($users as $row)
                                                          <option @if(isset($data))
                                                          {{  $data->owner_id == $row->id  ? 'selected' : ''}}
                                                          @endif value="{{ $row->id}}">{{$row->name}}</option>
                                                          @endforeach
                                                          @endif

                                                         </select>
                                                          </div>
<?php $a=1;?>
                                                 <div class="col-lg-2">
                                                     <div class="input-group-append">
                                                  <button class="btn btn-primary" type="button" data-toggle="modal" onclick="model({{ $a }},'supplier')" value="{{ $a}}" data-target="#appFormModal"><i class="icon-plus-circle2"></i></button>
                                                 
                                                
                                                    </div>
                                                </div>
                                                
                                                </div>
                                                
                                                   
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
                                                     @php $def=App\Models\System::where('added_by',auth()->user()->added_by)->first(); @endphp
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

                           @if($row->code ==  $def->currency)
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
                                             <button type="button" name="add" class="btn btn-success btn-xs add"><i class="icon-plus-circle2"></i> Add item</button><br>
                        
                                              <br>
    <div class="table-responsive">
<table class="table table-bordered" id="cart">
            <thead>
              <tr>
                <th>Route Name</th>
                <th>Quantity</th>
                <th >Price</th>
             <th>Charge Type</th>
                <th>Tax</th>
                <th >Total</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            @if(!empty($id))
   @if(!@empty($items))
    @foreach ($items as $i)
 <tr class="line_items">
<td><select name="item_name[]" class="form-control m-b item_name" required  data-sub_category_id="{{$i->order_no}}_edit"><option value="">Select Item</option>@foreach($route as $n) <option value="{{ $n->id}}" @if(isset($i))@if($n->id == $i->item_name) selected @endif @endif >{{$n->from}} - {{$n->to}} </option>@endforeach</select></td>
 <td><input type="text" name="quantity[]" class="form-control item_quantity{{$i->order_no}}_edit"  placeholder ="quantity" id ="quantity"  value="{{ isset($i) ? $i->quantity : ''}}" required /></td>
<td><input type="text" name="price[]" class="form-control item_price{{$i->order_no}}_edit" placeholder ="price" required  value="{{ isset($i) ? $i->price : ''}}" /></td>
<td><select name="charge[]" class="form-control m-b item_charge{{$i->order_no}}_edit" required >
<option value="0">Select Charge</option>
<option value="1" @if(isset($i))@if('Flat' == $i->charge_type) selected @endif @endif>Flat</option>
<option value="{{$i->distance}}"  name="one" @if(isset($i))@if('Distance' == $i->charge_type) selected @endif @endif>Distance per ton</option>
<option value="{{ $data->weight }}" name="two" @if(isset($i))@if('Rate' == $i->charge_type)  selected @endif @endif>Rate per weight</option></select>
</td>
<td><select name="tax_rate[]" class="form-control m-b item_tax{{$i->order_no}}_edit" required >
<option value="0">Select Tax </option>
<option value="0" @if(isset($i))@if($i->tax_rate) selected @endif @endif>No tax</option>
<option value="0.18" @if(isset($i))@if('0.18' == $i->tax_rate) selected @endif @endif>18%</option></select>
</td>
<input type="hidden" name="total_tax[]" class="form-control item_total_tax{{$i->order_no}}_edit" placeholder ="total" required value="{{ isset($i) ? $i->total_tax : ''}}" readonly jAutoCalc="{quantity} * {price} * {charge} * {tax_rate}"   />
<input type="hidden" name="items_id[]" class="form-control item_saved{{$i->order_no}}_edit"   value="{{ isset($i) ? $i->items_id : ''}}" required   />
<input type="hidden"  name="distance[]" class="form-control item_distance{{$i->order_no}}_edit"  required   value="{{ isset($i) ? $i->distance : ''}}" />
<td><input type="text" name="total_cost[]" class="form-control item_total{{$i->order_no}}_edit" placeholder ="total" required value="{{ isset($i) ? $i->total_cost : ''}}" readonly jAutoCalc="{quantity} * {price} * {charge} " /></td>
 <input type="hidden" name="pacel_item_id[]"  class="form-control name_list"  value= "{{ isset($i) ? $i->id : ''}}" />  
<td><button type="button" name="remove" class="btn btn-danger btn-xs rem" value= "{{ isset($i) ? $i->id : ''}}"><i class="icon-trash"></i></button></td>
</tr>

@endforeach
 @endif
 @endif                        

</tbody>
<tfoot>


 <tr class="line_items">
<td colspan="4"></td>
<td><span class="bold">Sub Total </span>: </td><td><input type="text" name="subtotal[]" class="form-control total_amount" placeholder ="subtotal" required   jAutoCalc="SUM({total_cost})" readonly>
</td>   
</tr>
 <tr class="line_items">
<td colspan="4"></td>
<td><span class="bold">Tax </span>: </td><td><input type="text" name="tax[]" class="form-control tax_total" placeholder ="tax" required   jAutoCalc="SUM({total_tax})" readonly>

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
<td><span class="bold">Total</span>: </td><td><input type="text" name="amount[]" class="form-control t_total" placeholder ="total" required   jAutoCalc="{subtotal} + {tax}" readonly>

</td>  
@endif
</tr>
</tfoot>
          </table>


    
                                                <br><div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                       
                                                              <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                                
                                                                href="{{ route('pacel_quotation.index')}}">
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
  <div class="modal fade " id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
    </div>
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
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>


    </div>
</div>
  </div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.dataTables-example').DataTable({
        pageLength: 10,
        responsive: true,
        ordering:false,
      
       
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


<script>
    $(document).ready(function(){
      
      $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
      });
      
       
 $(document).on('change', '.item_name', function(){
        var id = $(this).val();
        var sub_category_id = $(this).data('sub_category_id');
        var weight=$('.weight').val();
        $.ajax({
            url: '{{url("pacel/findPacelPrice")}}',
                    type: "GET",
          data:{id:id},
             dataType: "json",
          success:function(data)
          {
 console.log(data);
  console.log(weight);
                     $('.item_distance'+sub_category_id).val(data[0]["distance"]);
                 $('.item_charge'+sub_category_id).find('option[name="one"]').val(data[0]["distance"]);
                 $('.item_charge'+sub_category_id).find('option[name="two"]').val(weight);      
          }

        });


});

$(document).on('change', '.item_tax_rate', function(){
  var sub_category_id = $(this).data('sub_category_id');;      
console.log(sub_category_id);

var data=$(this).val();
   $('.item_tax'+sub_category_id).val(data); 

}) 

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
        html += '<td><select name="item_name[]" class="form-control m-b item_name" required  data-sub_category_id="'+count+'"><option value="">Select Item</option>@foreach($route as $n) <option value="{{ $n->id}}"> {{$n->from}} - {{$n->to}} </option>@endforeach</select></td>';
        html += '<td><input type="text" name="quantity[]" class="form-control item_quantity" data-category_id="'+count+'" placeholder ="quantity" id ="quantity" required /></td>';
       html += '<td><input type="text" name="price[]" class="form-control item_price'+count+'" placeholder ="price" required  value=""/></td>';
    html += '<td class="charge"><select name="charge[]" class="form-control m-b item_charge'+count+'" required   data-sub_category_id="'+count+'" ><option value="0">Select Charge </option><option value="1">Flat</option><option value="" name="one">Distance per ton</option><option value="" name="two">Rate per weight</option></select></td>';
       html += '<td><select name="tax_rate[]" class="form-control m-b item_tax'+count+'" required ><option value="0">Select Tax </option><option value="0">No tax</option><option value="0.18">18%</option></select></td>';
 html += '<input type="hidden" name="tax_rate[]" class="form-control item_tax'+count+'"  value="0" required   />';
 html += '<input type="hidden" name="items_id[]" class="form-control item_saved'+count+'"  required   />';
 html += '<input type="hidden"  name="distance[]" class="form-control item_distance'+count+'"  required  value="" />';
 html += '<input type="hidden" name="total_tax[]" class="form-control item_total_tax'+count+'" placeholder ="total" required readonly jAutoCalc="{quantity} * {price} * {charge} * {tax_rate}"   />';
       html += '<td class="total"><input type="text" name="total_cost[]" id="cost" class="form-control item_total'+count+'" placeholder ="total"  jAutoCalc="{quantity} * {price}  * {charge}" required readonly  />';           
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

        $('#cart > tbody').append(html);
autoCalcSetup();
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });

      });




  $(document).on('click', '.remove', function(){
        $(this).closest('tr').remove();
autoCalcSetup();
      });
      

 $(document).on('click', '.rem', function(){  
      var btn_value = $(this).attr("value");   
               $(this).closest('tr').remove();  
            $('#cart > tfoot').append('<input type="hidden" name="removed_id[]"  class="form-control name_list" value="'+btn_value+'"/>');  
         autoCalcSetup();
           });  

        });
        


    </script>

<script>
     $(document).ready(function(){
     

  $(document).on('change', '.weight', function() {
     $(".item_name").change();
       $(".item_quantity").change();
       $('.charge').find('select').change();
       $('.total').find('#cost').change();

    });



    });
</script>

<script type="text/javascript">
    function model(id,type) {

        $.ajax({
            type: 'GET',
            url: '{{url("pacel/pacelModal")}}',
            data: {
                'id': id,
                'type':type,
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
    
    function calculateDiscount() {

      $('#discount').on('input',function() {
    var price= parseInt($('#discount').val());
    var qty = parseFloat($('#old').val());
console.log(price);
    $('#total').val((qty -price ? qty - price : 0).toFixed(2));
});

    }


    function saveClient(e){
  
          $.ajax({
            type: 'GET',
                url: '{{ url('pos/sales/save_client') }}',
                data: $('.addClientForm').serialize(),
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