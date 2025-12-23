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
                                <a class="nav-link  active show" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">Edit Invoice</a>
                            </li>
                       @endif

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr>
                                              
                                              
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 116.484px;">Reference No</th>
                                                      <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 156.484px;">Client Name</th>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Amount</th>
                                                
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 91.219px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($courier))
                                            @foreach ($courier as $row)
                                            <tr class="gradeA even" role="row">
                                               
                                                <td><a href="{{ route('courier.details', $row->id)}}">{{$row->confirmation_number}}</a></td>
                                                <td>{{$row->supplier->name}}</td>                                             
                                                <td>{{number_format($row->due_amount,2)}} {{$row->currency_code}}</td>
                                                


                                                <td>
                                                  @if($row->status == 0 && $row->approve == 0 )
                                                    <div class="badge badge-warning badge-shadow">Waiting For Approval</div>
                                                    @elseif($row->status == 0 && $row->approve == 1 )
                                                    <div class="badge badge-primary badge-shadow">Invoiced</div>
                                                    @elseif($row->status == 1)
                                                    <div class="badge badge-info badge-shadow">Partially Paid</div>
                                                    @elseif($row->status == 2)
                                                    <div class="badge badge-success badge-shadow">Paid Invoice</div>
                                                    @endif
                                                </td>
                                                 <td>
                                                     <div class="form-inline">
  
                                                                                                                <div class="dropdown">
                                                    <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>

                                                    <div class="dropdown-menu">
                                       @if($row->approve == 1)

                                                @if($row->status == 0 || $row->status == 1)                                        
                                            <a class="nav-link"   href="{{ route('courier.pay',$row->id)}}" aria-selected="false"> Make Payments</a>
                                        @endif

                                                @else
                                        <a  class="nav-link" title="Receive" onclick="return confirm('Are you sure?')"   href="{{ route('courier_edit.invoice', $row->id)}}">Edit</a>  
                                    <a  href="#" class="nav-link" title="View" data-toggle="modal"  onclick="model({{ $row->id }},'reverse')" value="{{ $row->id}}" data-target="#appFormModal">Reverse</a>  
                                                 @can('approve-invoice') 
                                               <a  class="nav-link" title="Receive" onclick="return confirm('Are you sure?')"   href="{{ route('courier.approve', $row->id)}}">Approve</a>  
                                                    @endcan
                          @endif

                     <a class="nav-link" href="{{ route('courier_invoice_pdfview',['download'=>'pdf','id'=>$row->id]) }}"  title="" > Download PDF </a>  
                                           
             </div>
                                                </div>
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
                                      
                                        <h5>Edit Invoice</h5>
                                       
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                              
                                                {{ Form::open(['route' => 'courier_save.invoice']) }}
                                                @method('POST')
                                               

                                         <input type="hidden" name="id"
                                                class="form-control list"
                                                value="{{ isset($data) ? $id : ''}}" />

                                     <input type="hidden" name="receive"
                                                class="form-control list"
                                                value="{{ isset($receive) ? $receive : ''}}" />

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
                                                  
                                         <select class=" form-control m-b supplier " name="owner_id"  id="supplier" disabled>
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


<div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Description</label>

                                                    <div class="col-lg-10">
                                                  
                                         <textarea name="description" class="form-control">{{ isset($data) ? $data->description : ''}}</textarea>
 
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
           <th>Type</th>
                <th class="col-sm-3">Tariff</th>
                <th>Price</th>
                <th>Tax</th>
                <th class="col-sm-2">Total</th>
              
              </tr>
            </thead>
            <tbody>
 @if(!empty($items))
@foreach($items as $i)                                   
 <tr class="line_items">

<td><select id="type{{$i->id}}" name="tariff_type[]" class="form-control m-b type"  data-sub_category_id="{{$i->id}}" required><option ="">Select Type</option> 
<option value="Automatic" @if(isset($i))@if('Automatic' == $i->tariff_type) selected @endif @endif>Automatic</option>
<option value="Formula"  @if(isset($i))@if('Formula' == $i->tariff_type) selected @endif @endif>Formula</option> 
<option value="Manual"  @if(isset($i))@if('Manual' == $i->tariff_type) selected @endif @endif>Manual</option> 
</select>
</td> 
                                    
<td>
<div class="auto" id="auto{{$i->id}}" style="display:{{ $i->tariff_type != 'Manual' ? 'block' : 'none'}};">
<select name="{{$i->tariff_type != 'Manual' ? 'item_name[]' : ''}} " class="form-control m-b item_name" id="name{{$i->id}}"  data-sub_category_id="{{$i->id}}"><option value="">Select Tariff</option>
 @if(!empty($tariff))
 @foreach($tariff as $trow)
<option value="{{$trow->id}}"  @if(isset($i))@if($trow->id == $i->item_name) selected @endif @endif>{{$trow->zonal->name}} - {{$trow->weight}} </option>                                                                        
@endforeach
  @endif
</select>
</div>
<div class="auto1" id="auto1_{{$i->id}}" style="display:{{ $i->tariff_type == 'Manual' ? 'block' : 'none'}};">
<textarea name="{{$i->tariff_type == 'Manual' ? 'item_name[]' : ''}}" class="form-control item_name" id="name1_{{$i->id}}" >{{ isset($i) ? $i->item_name : ''}}</textarea>
</div>
</td>
<td><input type="text" name="price[]" class="form-control item_price{{$i->id}}" placeholder ="price" min="1" required  value="{{ isset($i) ? $i->price : ''}}"/></td>
<input type="hidden" name="unit[]" class="form-control item_unit" placeholder ="unit" required value="{{ isset($i) ? $i->unit : ''}}"/>
<td><select name="tax_rate[]" class="form-control m-b item_tax" required ><option value="0">Select Tax Rate</option>
<option value="0" @if(isset($i))@if('0' == $i->tax_rate) selected @endif @endif>No tax</option>
<option value="0.18" @if(isset($i))@if('0.18' == $i->tax_rate) selected @endif @endif>18%</option></select></td>
<input type="hidden" name="total_tax[]" class="form-control item_total_tax" placeholder ="total" required value="{{ isset($i) ? $i->total_tax : ''}}" readonly jAutoCalc="1 * {price} * {tax_rate}"   />
<td><input type="text" name="total_cost[]" class="form-control item_total" placeholder ="total" required value="{{ isset($i) ? $i->total_cost : ''}}" readonly jAutoCalc="1 * {price}" /></td>
<input type="hidden" name="saved_items_id[]"    class="form-control item_saved{{$i->id}}"  value="{{ isset($i) ? $i->id : ''}}" required />
 
                                                                   
                                                                   
                                                             
                                                               
                                                               
</tr>
@endforeach
@endif


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
                                                                
                                                                href="{{ route('courier.invoice')}}">
                                                                 Cancel
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
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

 <!-- discount Modal -->
  <div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
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

    $(document).on('change', '.type', function() {
        var type = $(this).val();
         var id= $('.supplier').val();
       var sub_category_id = $(this).data('sub_category_id');
        $.ajax({
            url: '{{url("courier/findTariff")}}',
            type: "GET",
            data: {
                id: id,
              type:type,
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#name" + sub_category_id).empty();
               $("#name1_" + sub_category_id).empty();
              

             if(type == 'Manual'){
                $("#auto"+ sub_category_id).css("display", "none");   
                     $("#auto1_"+ sub_category_id).css("display", "block");  
                     $("#name"+ sub_category_id).attr("name", "");;
                      $("#name"+ sub_category_id).prop('required',false);
                     $("#name1_"+ sub_category_id).attr("name", "item_name[]");;
                    $("#name1_"+ sub_category_id).prop('required',true);

                         }else{ 
                      $("#auto1_"+ sub_category_id).css("display", "none");   
                     $("#auto"+ sub_category_id).css("display", "block");  
                     $("#name1_"+ sub_category_id).attr("name", "");;
                      $("#name1_"+ sub_category_id).prop('required',false);
                     $("#name"+ sub_category_id).attr("name", "item_name[]");;
                    $("#name"+ sub_category_id).prop('required',true);

                   $("#name" + sub_category_id).append('<option value="">Select Tariff</option>');
                $.each(response,function(key, value)
                {


                    $("#name"+ sub_category_id).append('<option value=' + value.id+ '>' + value.zone_name + ' -  ' + value.weight + '</option>');
                   
                });   

}                   
               
            }

        });

    });

});
</script>

<script>
    $(document).ready(function(){
      

 


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
                     $('.item_price'+ sub_category_id).val(data[0]["price"]);
                  $('.item_quantity'+ sub_category_id).val(data[0]["weight"]);
                  autoCalcSetup();
          }

        });

});



$(document).on('click', '.rem', function() {
        var btn_value = $(this).attr("value");
        $(this).closest('tr').remove();
        $('tfoot').append(
            '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
            btn_value + '"/>');
        autoCalcSetup();
    });

   

        });
        


    </script>

<script type="text/javascript">
    function model(id,type) {

        $.ajax({
            type: 'GET',
            url: '{{url("courier/courierModal")}}',
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
</script>


@endsection