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
                              @if(!empty($id))
                            <li class="nav-item">
                                <a class="nav-link  active show" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false"> Quotation Form</a>
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
                                                    style="width: 101.219px;">Date</th> 

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
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 150.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($courier))
                                            @foreach ($courier as $row)
                                                     <?php
                                                   $it=App\Models\Courier\CourierItem::where('pacel_id',$row->id)->where('child','1')->where('start','0')->first(); 
                                                    $chk=App\Models\Courier\CourierItem::where('pacel_id',$row->id)->where('child','1')->first(); 
                                                   $close=App\Models\Courier\CourierItem::where('pacel_id',$row->id)->where('child','1')->where('start','1')->first(); 
                                                    ?>
                                            <tr class="gradeA even" role="row">
                                               
                                                <td><a href="{{ route('courier_quotation.show', $row->id)}}">{{$row->confirmation_number}}</a></li></td>
                                                
                                                <td>{{$row->supplier->name}}</td>                                             
                                                <td>{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}</td>
                                                <td>{{number_format($row->due_amount,2)}} {{$row->currency_code}}</td>
                                                

                                                 
                                                <td>                              
                                                        @if($row->status == 0 && $row->good_receive == 0)
                                                    <div class="badge badge-warning badge-shadow">Waiting For Approval</div>
                                                    @elseif($row->good_receive == 1)
                                                    <div class="badge badge-success badge-shadow">Approved</div>
                                                    
                                                    @endif                                                 
                                               </td>
                                         
                                               
                                                 <td>
                                               
                                                                              <div class="form-inline">
  
                                                                                                                <div class="dropdown">
                                                    <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>

                                                    <div class="dropdown-menu">
                                @if($row->good_receive == 0)

                     @if(!empty($it))
                         @can('approve-trip')
                       <a  class="nav-link" title="Start" onclick="return confirm('Are you sure?')"   href="{{ route('courier.start', $row->id)}}">Start Trip</a>
                            @endcan
                       @endif

                            @if(!empty($close))  
                            @can('close-trip')
                       <a  class="nav-link" title="Start" onclick="return confirm('Are you sure?')"   href="{{ route('courier.close_trip', $row->id)}}">Close Trip</a>
                            @endcan                                                
                            @endif

                           

                         <a  class="nav-link" title="Start" onclick="return confirm('Are you sure?')"   href="{{ route('courier.add_trip', $row->id)}}">Add Trip</a>
                          @endif

                      <a  href="#" class="nav-link" title="View" data-toggle="modal"  onclick="model({{ $row->id }},'view-details')" value="{{ $row->id}}" data-target="#appFormModal">View Details</a>    


                     @if(!empty($chk))                                                                                                           
                       <a class="nav-link" id="profile-tab2" href="{{ route('courier_pdfview',['download'=>'pdf','id'=>$row->id]) }}"  role="tab"  aria-selected="false">Download PDF</a>
                        @endif  
                        
                    <a  href="#" class="nav-link" title="Generate Barcode" data-toggle="modal"  onclick="model({{ $row->id }},'barcode')" value="{{ $row->id}}" data-target="#appFormModal">Print Barcode</a>
             

                                           
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
                                      
                                       
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                              
                                                {{ Form::open(['route' => 'courier.save_receive']) }}
                                                @method('POST')
                                               
                                           
                                             <input type="hidden" name="pacel_id"
                                                class="form-control pacel"
                                                value="{{ isset($data) ? $data->id : ''}}" />
                                                 
                                             
                                          <input type="hidden" name="update"
                                                class="form-control"
                                                value="{{ isset($value) ? $value : ''}}" />
                                                   

                                         <input type="hidden" name="id"
                                                class="form-control list"
                                                value="{{ isset($data) ? $id : ''}}" />


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
                                             

                                          <div class="form-group row">
                                      <label class="col-lg-2 col-form-label" for="inputState">Departure Region</label>
                                   <div class="col-lg-4">
                                
                                    <select name="from_region_id"  class="form-control m-b from_region"  id="from_region"   required >
                                      <option value="">Select Departure Region</option>
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
                                    <select name="from_district_id" class="form-control m-b from_district" id="from_district_id" >
                                      <option value="">Select Departure District</option>
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
                                      <option value="">Select Departure District</option>
                                    
                                    </select>
                                  </div>
  @endif
                            
                             </div>

<div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Departure Location</label>

                                                    <div class="col-lg-4">
                                                       <input type="text" name="from_location"  value="{{ isset($data) ? $data->location : ''}}"  class="form-control" >
                                                           </div>
                                                           
<label  class="col-lg-2 col-form-label">Weight </label>

                <div class="col-lg-4">
                  <input type="number" step="0.01" name="weight"  value="{{ isset($items) ? $items->weight : ''}}"  class="form-control" >
                </div>
                                                    
                                                </div>

{{--
         
                                          <div class="form-group row">
                                      <label class="col-lg-2 col-form-label" for="inputState">Arrival Region</label>
                                   <div class="col-lg-4">
                                    <select name="to_region_id" class="form-control m-b to_region" id="to_region_id">
                                      <option value="">Select Arrival Region</option>
                                      @if(!empty($region))
                                                        @foreach($region as $row)

                                                        <option @if(isset($items))
                                                            {{ $items->to_region_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>

                     @if(!empty($items))
                    
                                    <label for="inputState"  class="col-lg-2 col-form-label">Arrival District</label>
                                 <div class="col-lg-4">
                                    <select name="to_district_id" class="form-control m-b to_district" id="to_district_id">
                                      <option value="">Select Arrival District</option>
                                    @if(!empty($to_district))
                                                        @foreach($to_district as $row)

                                                        <option @if(isset($items))
                                                            {{ $items->to_district_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>
                 @else
             <label for="inputState"  class="col-lg-2 col-form-label">Arrival District</label>
                                 <div class="col-lg-4">
                                     <select name="to_district_id" class="form-control m-b to_district" id="to_district_id">
                                      <option value="">Select Arrival District</option>
                                    
                                    </select>
                                  </div>
  @endif
                            
            

                             </div> 


<div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Arrival Location</label>

                                                    <div class="col-lg-4">
                                                       <input type="text" name="to_location"  value="{{ isset($items) ? $items->location : ''}}"  class="form-control" >
                                                           
                                                           

                                                    </div>
                                                </div>

--}}

<div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Receiver Name</label>

                                                    <div class="col-lg-4">
                                                       <input type="text" name="receiver_name"  value="{{ isset($items) ? $items->receiver_name : ''}}"  class="form-control" >
                                                           
                                                    </div>

                       <label  class="col-lg-2 col-form-label">Receiver Phone </label>

                <div class="col-lg-4">
                  <input type="text" name="receiver_phone"  value="{{ isset($items) ? $items->receiver_phone : ''}}"  class="form-control" >
                </div>
                                                   
                                                </div>


                                                <div class="form-group row">
 

<label
                                                        class="col-lg-2 col-form-label">Instructions</label>

                                                    <div class="col-lg-10">
                                                        <textarea name="instructions" class="form-control"></textarea>

                                                    </div>
                                                </div>





                                     <br>
                                              <h4 align="center">Enter Item Details</h4>
                                            <hr>
                                                 
@if(empty($value))
                                             <button type="button" name="add" class="btn btn-success btn-xs add"><i class="fas fa-plus"> Add item</i></button><br>
@endif
                    
                                              <br>
    <div class="table-responsive">
<table class="table table-bordered" id="cart">
            <thead>
              <tr>
              <th>Type</th>
                <th class="col-sm-2">Tariff</th>
                <th>Price</th>
                 <th>Unit</th>
                <th>Tax</th>
                <th >Total</th>
              
              </tr>
            </thead>
            <tbody>
   
 </tbody>

 <tfoot>  
@if(!empty($items))                             
 <tr class="line_items">
   
<td>
<select name="tariff_type[]" class="form-control m-b type" id="type{{$items->id}}" data-sub_category_id="{{$items->id}}" required>
<option value="">Select Type</option> 
<option value="Automatic" @if(isset($items))@if('Automatic' == $items->tariff_type) selected @endif @endif>Automatic</option>
<option value="Formula" @if(isset($items))@if('Formula' == $items->tariff_type) selected @endif @endif>Formula</option> 
<option value="Manual" @if(isset($items))@if('Manual' == $items->tariff_type) selected @endif @endif>Manual</option>
</select></td> 

 @if(!empty($items))
<?php 
   $tariff= App\Models\Tariff::where('client_id',$data->owner_id)->where('type',$items->tariff_type)->get();
?>
<td >
<div id="auto" class="auto{{$items->id}}" style="display:{{ $items->tariff_type != 'Manual' ? 'block' : 'none'}};">
<select name="{{$items->tariff_type != 'Manual' ? 'item_name[]' : ''}}" class="form-control m-b name{{$items->id}}" id="name" data-sub_category_id="{{$items->id}}"><option value="">Select Tariff</option>
@if(!empty($tariff))
                                                        @foreach($tariff as $trow)

                                                        <option @if(isset($items))
                                                            {{ $items->item_name== $trow->id  ? 'selected' : ''}}
                                                            @endif value="{{$trow->id}}"> {{$trow->zonal->name}} - {{$trow->weight}} </option>

                                                        @endforeach
                                                        @endif
</select>
</div>
<div id="auto1" class="auto1_{{$items->id}}" style="display:{{ $items->tariff_type == 'Manual' ? 'block' : 'none'}};"><textarea name="{{$items->tariff_type == 'Manual' ? 'item_name[]' : ''}}" class="form-control name1_{{$items->id}}" id="name1" >{{ isset($items) ? $items->item_name : ''}}</textarea></div>
</td>

@else                                      
<td>
<div class="auto" id="auto"><select name="item_name[]" class="form-control m-b item_name" id="name"><option value="">Select Tariff</option></select></div>
<div class="auto1" id="auto1" style="display:none;"><textarea name="item_name[]" class="form-control item_name" id="name1" ></textarea></div>
</td>
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


<tr class="line_items">
<td colspan="4"></td>

<td><span class="bold">Total</span>: </td><td><input type="text" name="amount[]" class="form-control item_total" placeholder ="total" required   jAutoCalc="{subtotal} + {tax}" readonly></td>  

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
                           $(".name" + sub_category_id).empty();
               $(".name1_" + sub_category_id).empty();
              

             if(type == 'Manual'){
                
                $(".auto"+ sub_category_id).css("display", "none");   
                     $('.auto1_'+ sub_category_id).css("display", "block");  
                     $(".name"+ sub_category_id).attr("name", "");;
                      $(".name"+ sub_category_id).prop('required',false);
                     $(".name1_"+ sub_category_id).attr("name", "item_name[]");;
                    $(".name1_"+ sub_category_id).prop('required',true);

                         }else{ 
                      $(".auto1_"+ sub_category_id).css("display", "none");   
                     $(".auto"+ sub_category_id).css("display", "block");  
                     $(".name1_"+ sub_category_id).attr("name", "");;
                      $(".name1_"+ sub_category_id).prop('required',false);
                     $(".name"+ sub_category_id).attr("name", "item_name[]");;
                    $(".name"+ sub_category_id).prop('required',true);

                   $(".name" + sub_category_id).append('<option value="">Select Tariff</option>');
                $.each(response,function(key, value)
                {


                    $(".name"+ sub_category_id).append('<option value=' + value.id+ '>' + value.zone_name + ' -  ' + value.weight + '</option>');
                   
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
         html +='<td><select  name="tariff_type[]" class="form-control m-b type"  id="type' + count +'" data-sub_category_id="' +count +'" required ><option value="">Select Type</option><option value="Automatic" >Automatic</option><option value="Formula">Formula</option><option value="Manual">Manual</option></select></td>';
        html +='<td><div id="auto" class="auto' + count +'"><select name="item_name[]" class="form-control m-b name'+ count +'" id="name" data-sub_category_id="' +count +'"><option value="">Select Tariff</option></select></div><div id="auto1" class="auto1_' + count +'"  style="display:none;"><textarea name="item_name[]" class="form-control name1_'+ count +'" id="name1" ></textarea></div></td>';
        html += '<input type="hidden" name="quantity[]" class="form-control item_quantity' + count +'"  placeholder ="weight" id ="quantity"  value="" required />';
        html += '<td><input type="text" name="price[]" class="form-control item_price' + count +'" placeholder ="price" required  value=""/></td>';
        html += '<td><input type="text" name="unit[]" class="form-control item_unit" placeholder ="unit" required value=""/></td>';
        html += '<td><select name="tax_rate[]" class="form-control m-b item_tax' + count + '" required ><option value="0">Select</option><option value="0">No tax</option><option value="0.18">18%</option></select></td>';
        html += '<input type="hidden" name="total_tax[]" class="form-control item_total_tax" placeholder ="total" required value="" readonly jAutoCalc="1 * {price} * {tax_rate}"   />';       
        html += '<td><input type="text" name="total_cost[]" class="form-control item_total" placeholder ="total" required value="" readonly jAutoCalc="1 * {price}" /></td>';
        html +=  '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

        $('tbody').append(html);
        autoCalcSetup();
/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });
    });
    
    
     $(document).on('change', '#name', function(){
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



    $(document).on('click', '.remove', function() {
        $(this).closest('tr').remove();
        autoCalcSetup();
    });

 

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
                $('.modal-dialog').html(data);
            },
            error: function(error) {
                $('#appFormModal').modal('toggle');

            }
        });

    }
</script>

@endsection