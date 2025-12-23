@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>New Activity Flow</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                           
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Sales22</a>
                            </li>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                           
                                  
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card sales">
                                    <div class="card-header">
                                        @if(empty($id))
                                        <h5>Create Sales</h5>
                                        @else
                                        <h5>Edit Sales</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

                                            {{ Form::open(['route' => 'add.sales']) }}
                                                @method('POST')
                                                       @csrf


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
                                                
                                          



                                     <br>
                                              <h4 align="center">Enter Item Details</h4>
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
                <th>Weight (KG)</th>
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
                                                            @endif value="{{$trow->id}}">From {{$trow->from}} to {{$trow->to}}</option>

                                                        @endforeach
                                                        @endif

</select></td>
@else
<td><select name="item_name[]" class="form-control m-b item_name" id="name"  required ><option value="">Select Tariff</option></select></td>
@endif
 <td><input type="text" name="quantity[]" class="form-control item_quantity"  placeholder ="weight" id ="quantity"  value="{{ isset($items) ? $items->quantity : ''}}" required /></td>
<td><input type="text" name="price[]" class="form-control item_price" placeholder ="price" required  value="{{ isset($items) ? $items->price : ''}}"/></td>
<td><input type="text" name="unit[]" class="form-control item_unit" placeholder ="unit" required value="{{ isset($items) ? $items->unit : ''}}"/>
<td><select name="tax_rate[]" class="form-control m-b item_tax" required ><option value="0">Select Tax Rate</option>
<option value="0" @if(isset($items))@if('0' == $items->tax_rate) selected @endif @endif>No tax</option>
<option value="0.18" @if(isset($items))@if('0.18' == $items->tax_rate) selected @endif @endif>18%</option></select></td>
<input type="hidden" name="total_tax[]" class="form-control item_total_tax" placeholder ="total" required value="{{ isset($items) ? $items->total_tax : ''}}" readonly jAutoCalc="{quantity} * {price} * {tax_rate}"   />
<td><input type="text" name="total_cost[]" class="form-control item_total" placeholder ="total" required value="{{ isset($items) ? $items->total_cost : ''}}" readonly jAutoCalc="{quantity} * {price}" /></td>
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


   <br>
                                              <h4 align="center">Enter Tracking Details</h4>
                                            <hr>
 <div class="form-group">
                <label class="col-lg-6 col-form-label">Pickup Cost</label>

                <div class="col-lg-12">
                 <input type="number" name="pcosts"   value="" class="form-control" required>
                                          

</div>
            </div>

  <div class="form-group">
                <label class="col-lg-6 col-form-label">Freight Cost</label>

                <div class="col-lg-12">
                 <input type="number" name="lcosts"   value="" class="form-control" >
                                         

</div>
            </div>

  <div class="form-group">
                <label class="col-lg-6 col-form-label">Agents Cost</label>

                <div class="col-lg-12">
                 <input type="number" name="ocosts"   value="" class="form-control" >
                                         

</div>
            </div>

  <div class="form-group">
                <label class="col-lg-6 col-form-label">Delivery Cost</label>

                <div class="col-lg-12">
                 <input type="number" name="dcosts"   value="" class="form-control" >
                                         

</div>
            </div>


 <div class="form-group">
                <label class="col-lg-6 col-form-label">Payment</label>

                <div class="col-lg-12">
                   <select class="form-control m-b" name="bank_id" required>
                                                    <option value="">Select Payment Account</option> 
                                                             @foreach ($bank_accounts as $bank)                                                             
                                                            <option value="{{$bank->id}}" >{{$bank->account_name}}</option>
                                                               @endforeach
                                                              </select>
</div>
            </div>


    
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
                                                            type="submit" id="sales" onclick="saveSales(this)">Save</button>
                                               
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






@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
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
                 

                    $("#name").append('<option value=' + value.id+ '>From ' + value.from + ' to  ' + value.to + '</option>');
                   
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
   

 $(document).on('change', '.method', function(){
var id=$(this).val() ;
console.log(id);
         if($(this).val() == 'Truck Freight') {
          $('.truck').show(); 
           $('.awb').hide(); 
        }else if($(this).val() == 'Air Freight') {
          $('.truck').hide(); 
           $('.awb').show(); 
        }else {
            $('.awb').hide(); 
              $('.truck').hide(); 
        } 

});


    });
</script>

<script type="text/javascript">

    function saveSales(e){
   var form = $('#addSalesForm').serialize();
          $.ajax({
            type: 'GET',
            url: '{{url("courier/addSales")}}',
         data:  $('#addSalesForm').serialize(),                       
                dataType: "json",
             success: function(response) {
                console.log(response);
                         
                               var id = response.id;
                                 $('.sales').hide(); 
                                 $('.pickup').show(); 
                                $('.pid').val(id);
            }
        });
}

 function savePickup(e){
   var form = $('#addPickupForm').serialize();
          $.ajax({
            type: 'GET',
            url: '{{url("courier/addPickup")}}',
         data:  $('#addPickupForm').serialize(),                       
                dataType: "json",
             success: function(response) {
                console.log(response);
                         
                               var id = response.id;
                                 $('.pickup').hide(); 
                                 $('.freight').show(); 
                                $('.fid').val(id);
            }
        });
}

 function saveFreight(e){
   var form = $('#addFreightForm').serialize();
          $.ajax({
            type: 'GET',
            url: '{{url("courier/addFreight")}}',
         data:  $('#addFreightForm').serialize(),                       
                dataType: "json",
             success: function(response) {
                console.log(response);
                         
                               var id = response.id;
                                 $('.freight').hide(); 
                                 $('.comm').show(); 
                                $('.cid').val(id);
            }
        });
}

 function saveComm(e){
   var form = $('#addCommForm').serialize();
          $.ajax({
            type: 'GET',
            url: '{{url("courier/addCommission")}}',
         data:  $('#addCommForm').serialize(),                       
                dataType: "json",
             success: function(response) {
                console.log(response);
                         
                               var id = response.id;
                                 $('.comm').hide(); 
                                 $('.delivery').show(); 
                                $('.did').val(id);
            }
        });
}

 
    </script>


@endsection