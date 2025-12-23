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
                                    aria-selected="false">New Sales</a>
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

                                                    <div class="col-lg-4">
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
                                               
                <label class="col-lg-2 col-form-label">Payment</label>

                <div class="col-lg-4">
                   <select class="form-control m-b" name="bank_id" required>
                                                    <option value="">Select Payment Account</option> 
                                                             @foreach ($bank_accounts as $bank)                                                             
                                                            <option value="{{$bank->id}}" >{{$bank->account_name}}</option>
                                                               @endforeach
                                                              </select>
</div>
            </div>
                                          



                                     <br>
                                              <h4 align="center">Enter Item Details</h4>
                                            <hr>
                                              
                                        

                                             <button type="button" name="add" class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add item</i></button><br>
               
                                              <br>
    <div class="table-responsive">
<table class="table table-bordered" id="cart">
            <thead>
              <tr>
               <th>Client</th>
                <th class="">Tariff</th>
                <th>Weight (KG)</th>
                <th>Price</th>               
                <th>Tax</th>
                <th class="">Total</th>
                <th>Action</th> 
              </tr>
            </thead>
            <tbody>
               
</tbody>                     
 
<tfoot>

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
</tfoot>
          </table>


   <br><br>
                                              <h4 align="center">Enter Tracking Details</h4>
     <hr>                                      


  <br>
                                              <h4 align="center">Enter Pick Up Costs</h4>                                           
                                             <button type="button" name="add" class="btn btn-success btn-xs padd"><i class="fas fa-plus"> Add Pickup Costs</i></button><br>
               
                                              <br>
    <div class="table-responsive">
<table class="table table-bordered" id="pickup">
            <thead>
              <tr>
               <th>Amount</th>              
                <th>Action</th> 
              </tr>
            </thead>
            <tbody>
               
</tbody>                     
 
<tfoot>
<tr class="line_items">

<td><input type="text"  name="total_p[]" class="form-control item_pcosts" placeholder ="total" required   jAutoCalc="SUM({p_costs})" readonly></td>  <td></td>

</tr>
</tfoot>
          </table>
<hr>


  <br>
                                              <h4 align="center">Enter Freight Costs</h4>                                           
                                             <button type="button" name="add" class="btn btn-success btn-xs ladd"><i class="fas fa-plus"> Add Freight Costs</i></button><br>
               
                                              <br>
    <div class="table-responsive">
<table class="table table-bordered" id="load">
            <thead>
              <tr>
               <th>Amount</th>              
                <th>Action</th> 
              </tr>
            </thead>
            <tbody>
               
</tbody>                     
 
<tfoot>
<tr class="line_items">

<td><input type="text" name="total_l[]"  class="form-control item_total" placeholder ="total" required   jAutoCalc="SUM({l_costs}) " readonly></td>  <td></td>

</tr>
</tfoot>
          </table>
<hr>

  <br>
                                              <h4 align="center">Enter Agents Cost</h4>                                           
                                             <button type="button" name="add" class="btn btn-success btn-xs oadd"><i class="fas fa-plus"> Add Agents Costs</i></button><br>
               
                                              <br>
    <div class="table-responsive">
<table class="table table-bordered" id="off">
            <thead>
              <tr>
               <th>Amount</th>              
                <th>Action</th> 
              </tr>
            </thead>
            <tbody>
               
</tbody>                     
 
<tfoot>
<tr class="line_items">

<td><input type="text"  name="total_o[]" class="form-control item_total" placeholder ="total" required   jAutoCalc="SUM({o_costs}) " readonly></td>  <td></td>

</tr>
</tfoot>
          </table>
<hr>

  <br>
                                              <h4 align="center">Enter Delivery Costs</h4>                                           
                                             <button type="button" name="add" class="btn btn-success btn-xs dadd"><i class="fas fa-plus"> Add Delivery  Costs</i></button><br>
               
                                              <br>
    <div class="table-responsive">
<table class="table table-bordered" id="del">
            <thead>
              <tr>
               <th>Amount</th>              
                <th>Action</th> 
              </tr>
            </thead>
            <tbody>
               
</tbody>                     
 
<tfoot>
<tr class="line_items">

<td><input type="text"  name="total_d[]" class="form-control item_total" placeholder ="total" required   jAutoCalc="SUM({d_costs}) " readonly></td>  <td></td>

</tr>
</tfoot>
          </table>
<hr>


 



    
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
           var sub_category_id = $(this).data('sub_category_id');
        $.ajax({
            url: '{{url("courier/findTariff")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#name"+ sub_category_id).empty();
                $("#name"+ sub_category_id).append('<option value="">Select </option>');
                $.each(response,function(key, value)
                {
                 

                    $("#name"+ sub_category_id).append('<option value=' + value.id+ '>' + value.from + ' - ' + value.to + '</option>');
                   
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
     var sub_category_id = $(this).data('sub_category_id');
        $.ajax({
            url: '{{url("courier/findCourierPrice")}}',
                    type: "GET",
          data:{id:id},
             dataType: "json",
          success:function(data)
          {
 console.log(data);
                     $('.item_price' + sub_category_id).val(data[0]["price"]);
          }

        });

});


    });
</script>

<script type="text/javascript">
$(document).ready(function() {


    var count = 0;


    function autoCalcSetup() {
        $('table#cart').jAutoCalc('destroy');
        $('table#cart tr.line_items').jAutoCalc({
            keyEventsFire: true,
            decimalPlaces: 2,
            emptyAsZero: true
        });
        $('table#cart').jAutoCalc({
            decimalPlaces: 2
        });
    }
    autoCalcSetup();
    
    $('.add').on("click", function(e) {

        count++;
        var html = '';
        html += '<tr class="line_items">';
         html +=
            '<td><select class=" form-control m-b supplier " name="owner_id[]"  id="supplier' + count +
            '" data-sub_category_id="' +count +'" required ><option value="">Select</option>@foreach($users as $row) <option value="{{ $row->id}}">{{$row->name}}</option>@endforeach</select></td>';
        html +=
            '<td><select name="item_name[]" class="form-control m-b item_name" required  data-sub_category_id="' +count + '"  id="name' + count + '"><option value="">Select </option></select></td>';
        html +=
            '<td><input type="number" name="quantity[]" class="form-control item_quantity" data-category_id="' +
            count + '"placeholder ="quantity" id ="quantity" required /></td>';
        html += '<td><input type="text" name="price[]" class="form-control item_price' + count +
            '" placeholder ="price" required  value=""/></td>';
        html += '<td><select name="tax_rate[]" class="form-control m-b item_tax' + count +
            '" required ><option value="0">Select</option><option value="0">No tax</option><option value="0.18">18%</option></select></td>';
        html += '<input type="hidden" name="total_tax[]" class="form-control item_total_tax' + count +
            '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price} * {tax_rate}"   />';
       
        html += '<td><input type="text" name="total_cost[]" class="form-control item_total' + count +
            '" placeholder ="total" required readonly jAutoCalc="{quantity} * {price}" /></td>';
        html +=
            '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

        $('#cart > tbody').append(html);
        autoCalcSetup();
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
    });



    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
        autoCalcSetup();
    });



});
</script>
    


<script type="text/javascript">
$(document).ready(function() {
    var count = 0;

    function autoCalcSetup() {
        $('table#pickup').jAutoCalc('destroy');
        $('table#pickup tr.line_items').jAutoCalc({
            keyEventsFire: true,
            decimalPlaces: 2,
            emptyAsZero: true
        });
        $('table#pickup').jAutoCalc({
            decimalPlaces: 2
        });
    }
    autoCalcSetup();
    
    $('.padd').on("click", function(e) {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html +=  '<td><input type="text" name="pcosts[]" class="form-control item_pc" data-category_id="' +count + '"placeholder ="pickup_cost" id ="pickup_cost" required /></td>';
         html +=  '<input type="hidden" name="p_costs[]" class="form-control item_pc" data-category_id="' +count + '"placeholder ="pickup_cost" id ="pickup_cost"  jAutoCalc="{pcosts} * 1" required />';
        html +='<td><button type="button" name="remove" class="btn btn-danger btn-xs premove"><i class="icon-trash"></i></button></td></tr>';

        $('#pickup> tbody').append(html);
        autoCalcSetup();
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
    });



    $(document).on('click', '.premove', function() {
        $(this).closest('tr').remove();
        autoCalcSetup();
    });


});
</script>
    
  <script type="text/javascript">
$(document).ready(function() {
    var count = 0;

    function autoCalcSetup() {
        $('table#load').jAutoCalc('destroy');
        $('table#load tr.line_items').jAutoCalc({
            keyEventsFire: true,
            decimalPlaces: 2,
            emptyAsZero: true
        });
        $('table#load').jAutoCalc({
            decimalPlaces: 2
        });
    }
    autoCalcSetup();
    
    $('.ladd').on("click", function(e) {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html +=  '<td><input type="text" name="lcosts[]" class="form-control item_lc" data-category_id="' +count + '"placeholder ="freight_cost" id ="freight_cost" required /></td>';
         html +=  '<input type="hidden" name="l_costs[]" class="form-control item_pc" data-category_id="' +count + '"placeholder ="freight_cost" id ="freight_cost"  jAutoCalc="{lcosts} * 1" required />';
        html +='<td><button type="button" name="remove" class="btn btn-danger btn-xs lremove"><i class="icon-trash"></i></button></td></tr>';

        $('#load > tbody').append(html);
        autoCalcSetup();
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
    });



    $(document).on('click', '.lremove', function() {
        $(this).closest('tr').remove();
        autoCalcSetup();
    });


});
</script>

<script type="text/javascript">
$(document).ready(function() {
    var count = 0;

    function autoCalcSetup() {
        $('table#off').jAutoCalc('destroy');
        $('table#off tr.line_items').jAutoCalc({
            keyEventsFire: true,
            decimalPlaces: 2,
            emptyAsZero: true
        });
        $('table#off').jAutoCalc({
            decimalPlaces: 2
        });
    }
    autoCalcSetup();
    
    $('.oadd').on("click", function(e) {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html +=  '<td><input type="text" name="ocosts[]" class="form-control item_oc" data-category_id="' +count + '"placeholder ="agents_cost" id ="agents_cost" required /></td>';
         html +=  '<input type="hidden" name="o_costs[]" class="form-control item_oc" data-category_id="' +count + '"placeholder ="agents_cost" id ="agents_cost"  jAutoCalc="{ocosts} * 1" required />';
        html +='<td><button type="button" name="remove" class="btn btn-danger btn-xs oremove"><i class="icon-trash"></i></button></td></tr>';

        $('#off > tbody').append(html);
        autoCalcSetup();
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
    });



    $(document).on('click', '.oremove', function() {
        $(this).closest('tr').remove();
        autoCalcSetup();
    });


});
</script>

<script type="text/javascript">
$(document).ready(function() {
    var count = 0;

    function autoCalcSetup() {
        $('table#del').jAutoCalc('destroy');
        $('table#del tr.line_items').jAutoCalc({
            keyEventsFire: true,
            decimalPlaces: 2,
            emptyAsZero: true
        });
        $('table#del').jAutoCalc({
            decimalPlaces: 2
        });
    }
    autoCalcSetup();
    
    $('.dadd').on("click", function(e) {

        count++;
        var html = '';
        html += '<tr class="line_items">';
        html +=  '<td><input type="text" name="dcosts[]" class="form-control item_dc" data-category_id="' +count + '"placeholder ="delivery_cost" id ="delivery_cost" required /></td>';
         html +=  '<input type="hidden" name="d_costs[]" class="form-control item_dc" data-category_id="' +count + '" placeholder ="delivery_cost" id ="delivery_cost"  jAutoCalc="{dcosts} * 1" required />';
        html +='<td><button type="button" name="remove" class="btn btn-danger btn-xs dremove"><i class="icon-trash"></i></button></td></tr>';

        $('#del > tbody').append(html);
        autoCalcSetup();
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
    });



    $(document).on('click', '.dremove', function() {
        $(this).closest('tr').remove();
        autoCalcSetup();
    });


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