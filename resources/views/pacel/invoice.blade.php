@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Invoice</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Invoice
                                    List</a>
                            </li>

                       @if(!empty($id))
                              <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Edit Invoice
                                   </a>
                            </li>
                      @endif

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
                                                    style="width: 126.484px;">Reference No</th>
                                                 
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Client Name</th>
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Amount</th>
                                                
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
                                            @if(!@empty($pacel))
                                            @foreach ($pacel as $row)
                                            <tr class="gradeA even" role="row">
                                                 <td>{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}</td>
                                                <td><a href="{{ route('invoice.details', $row->id)}}">{{$row->confirmation_number}}</a></td>
                                                <td>{{$row->supplier->name}}</td>
                                               
                                                <td>{{number_format($row->due_amount,2)}} {{$row->currency_code}}</td>
                                                


                                                <td>
                                                    @if($row->status == 0)
                                                    <div class="badge badge-primary badge-shadow">Invoiced</div>
                                                    @elseif($row->status == 1)
                                                    <div class="badge badge-info badge-shadow">Partially Paid</div>
                                                    @elseif($row->status == 2)
                                                    <div class="badge badge-success badge-shadow">Paid Invoice</div>
                                                    @endif
                                                </td>

                                                  <td>
                                                     
                                                <div class="form-inline">
                                                @if($row->status == 0 )
                                      <a  class="list-icons-item text-primary" title="Edit" onclick="return confirm('Are you sure?')" href="{{ route('edit.invoice', $row->id)}}"><i  class="icon-pencil7"></i></a>&nbsp
                                               @endif
                                               
                                                @if($row->status != 2 )
                                      
                                              <div class="dropdown">
                                  <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
    <div class="dropdown-menu">
                                            <a class="nav-link" 
                                            href="{{ route('pacel.pay',$row->id)}}" 
                                            aria-selected="false">Make
                                            Payments</a>
                                               </div>     </div>
                 
                                        @endif
                                           </div>
                                                
                                                </td>
                                               
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
                                        <h5>Create Invoice</h5>
                                        @else
                                        <h5>Edit Invoice</h5>
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

                                                <input type="hidden" name="type"  value="invoice"   class="form-control" required>

                                                 <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Currency</label>
                                                    <div class="col-lg-4">
                                 @if(!empty($data->currency_code))

                              <select class="form-control m-b" name="currency_code" id="currency_code"  required disabled>
                            <option value="{{ old('currency_code')}}" disabled selected>Choose option</option>
                            @if(isset($currency))
                            @foreach($currency as $row)
                            <option  @if(isset($data)) {{$data->currency_code == $row->code ? 'selected' : 'TZS' }} @endif  value="{{ $row->code }}">{{ $row->name }}</option>
                            @endforeach
                            @endif
                        </select>

                         @else
                       <select class="form-control m-b" name="currency_code" id="currency_code" required disabled>
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
                                               
                                          
                      

                                              <br> <br>
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
              </tr>
            </thead>
            <tbody>
                                    

</tbody>
<tfoot>
@if(!empty($id))
   @if(!@empty($items))
    @foreach ($items as $i)
 <tr class="line_items">
<td><select name="item_name[]" class="form-control m-b item_name" required  data-sub_category_id={{$i->order_no}} ><option value="">Select Item</option>@foreach($route as $n) <option value="{{ $n->id}}" @if(isset($i))@if($n->id == $i->item_name) selected @endif @endif >{{$n->from}} - {{$n->to}} </option>@endforeach</select></td>
 <td><input type="text" name="quantity[]" class="form-control item_quantity{{$i->order_no}}"  placeholder ="quantity" id ="quantity"  value="{{ isset($i) ? $i->quantity : ''}}" required/></td>
<td><input type="text" name="price[]" class="form-control item_price{{$i->order_no}}" placeholder ="price" required  value="{{ isset($i) ? $i->price : ''}}" /></td>
<td><select name="charge[]" class="form-control m-b item_charge'+count{{$i->order_no}}" required >
<option value="0">Select Charge</option>
<option value="1" @if(isset($i))@if('Flat' == $i->charge_type) selected @endif @endif>Flat</option>
<option value="{{$i->distance}}" @if(isset($i))@if('Distance' == $i->charge_type) selected @endif @endif  name="one">Distance per ton</option>
</td>
<td><select name="tax_rate[]" class="form-control m-b item_tax'+count{{$i->order_no}}" required >
<option value="0">Select Tax </option>
<option value="0" @if(isset($i))@if($i->tax_rate) selected @endif @endif>No tax</option>
<option value="0.18" @if(isset($i))@if('0.18' == $i->tax_rate) selected @endif @endif>18%</option></select>
</td>



<input type="hidden" name="total_tax[]" class="form-control item_total_tax{{$i->order_no}}'" placeholder ="total" required value="{{ isset($i) ? $i->total_tax : ''}}" readonly jAutoCalc="{quantity} * {price} * {charge} * {tax_rate}"   />
<input type="hidden" name="items_id[]" class="form-control item_saved{{$i->order_no}}"   value="{{ isset($i) ? $i->items_id : ''}}" required   />
<input type="hidden"  name="distance[]" class="form-control item_distance{{$i->order_no}}"  required   value="{{ isset($i) ? $i->distance : ''}}" />
<td><input type="text" name="total_cost[]" class="form-control item_total{{$i->order_no}}" placeholder ="total" required value="{{ isset($i) ? $i->total_cost : ''}}" readonly jAutoCalc="{quantity} * {price} * {charge} " /></td>
 <input type="hidden" name="pacel_item_id[]"  class="form-control name_list"  value= "{{ isset($i) ? $i->id : ''}}" />  
</tr>

@endforeach
 @endif
 @endif

 <tr class="line_items">
<td colspan="4"></td>
<td><span class="bold">Sub Total </span>: </td><td><input type="text" name="subtotal[]" class="form-control total" placeholder ="subtotal" required   jAutoCalc="SUM({total_cost})" readonly>
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
                                                                
                                                                href="{{ route('pacel.invoice')}}">
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
 


 

       

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.dataTables-example').DataTable({
        pageLength: 10,
        responsive: true,
             order: [[0, 'desc']],
 
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
      


 $(document).on('change', '.item_name', function(){
        var id = $(this).val();
        var sub_category_id = $(this).data('sub_category_id');

        $.ajax({
            url: '{{url("findPacelPrice")}}',
                    type: "GET",
          data:{id:id},
             dataType: "json",
          success:function(data)
          {
 console.log(data);
       

                     $('.item_distance'+sub_category_id).val(data[0]["distance"]);
                 $('.item_charge'+sub_category_id).find('option[name="one"]').val(data[0]["distance"]);
   
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


<script type="text/javascript">
    function model(id,type) {

        $.ajax({
            type: 'GET',
            url: '{{url("pacelModal")}}',
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

</script>

@endsection