@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header header-elements-sm-inline"><h4 class="card-title"> Edit Cargo - {{$data->confirmation_number}}</h4>
			<div class="header-elements"> <a href="{{route('order.wb')}}" class="btn btn-secondary btn-xs px-4"><i class="fa fa-arrow-alt-circle-left"></i>  Back	    </a>					
				                	</div>			                	
							</div>
  
                    <div class="card-body">
                       
                        <div class="tab-content tab-bordered" id="myTab3Content">
                           
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="profile2" role="tabpanel"
                                aria-labelledby="profile-tab2">

                                <div class="card">
                                    
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

                                                {{ Form::open(['route' => 'order.update_cargo']) }}
                                                @method('POST')
                                                
                                              <h4 align="center">Enter Item Details</h4>
                                            <hr>
                             
      <input type="hidden" name="collection_id"   value="{{$id}}"    class="form-control" required>
      <input type="hidden" name="weight" value="{{ isset($data) ? $data->weight : ''}}"  class="form-control weight" >
                                                            
                                                           

                                <li>Truck : {{ $truck->truck_name}} - {{ $truck->reg_no}}</li>
                               <li>Driver Name: {{ $driver->driver_name}} </li>                    
     
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
  
 <tr class="line_items">
<td><select name="item_name[]" class="form-control m-b item_name" required  data-sub_category_id={{$items->order_no}}><option value="">Select Item</option>@foreach($route as $n) <option value="{{ $n->id}}" @if(isset($items))@if($n->id == $items->item_name) selected @endif @endif >{{$n->from}} - {{$n->to}} </option>@endforeach</select></td>
 <td><input type="number" name="quantity[]" class="form-control item_quantity{{$items->order_no}}"  placeholder ="quantity" id ="quantity"  value="{{ isset($items) ? $items->quantity : ''}}" required /></td>
<td><input type="number" name="price[]" class="form-control item_price{{$items->order_no}}" placeholder ="price" required  value="{{ isset($items) ? $items->price : ''}}" /></td>
<td><select name="charge[]" class="form-control m-b item_charge'+count{{$items->order_no}}" required >
<option value="0">Select Charge</option>
<option value="1" @if(isset($items))@if('Flat' == $items->charge_type) selected @endif @endif>Flat</option>
<option value="{{$items->distance}}" @if(isset($items))@if('Distance' == $items->charge_type) selected @endif @endif  name="one">Distance per ton</option>
<option value="{{ $data->weight }}" @if(isset($items))@if('Rate' == $items->charge_type)  selected @endif @endif  name="two">Rate per weight</option></select>
</td>
<td><select name="tax_rate[]" class="form-control m-b item_tax'+count{{$items->order_no}}" required >
<option value="0">Select Tax </option>
<option value="0" @if(isset($items))@if($items->tax_rate) selected @endif @endif>No tax</option>
<option value="0.18" @if(isset($items))@if('0.18' == $items->tax_rate) selected @endif @endif>18%</option></select>
</td>
<input type="hidden" name="total_tax[]" class="form-control item_total_tax{{$items->order_no}}'" placeholder ="total" required value="{{ isset($items) ? $items->total_tax : ''}}" readonly jAutoCalc="{quantity} * {price} * {charge} * {tax_rate}"   />
<input type="hidden"  name="distance[]" class="form-control item_distance{{$items->order_no}}"  required   value="{{ isset($items) ? $items->distance : ''}}" />
<td><input type="text" name="total_cost[]" class="form-control item_total{{$items->order_no}}" placeholder ="total" required value="{{ isset($items) ? $items->total_cost : ''}}" readonly jAutoCalc="{quantity} * {price} * {charge} " /></td>
 <input type="hidden" name="item_id"  class="form-control name_list"  value= "{{ isset($items) ? $items->id : ''}}" />  
  <input type="hidden" name="pacel_id"  class="form-control name_list"  value= "{{ isset($items) ? $items->pacel_id : ''}}" />  

</tr>


 @endif
 @endif


          </table>

<br><br>
<div class="form-group row">
                <label class="col-lg-2 col-form-label"> Fuel Used In Litre </label>

                <div class="col-lg-4">
                   <input type="number" step="0.01"  name="fuel" value="{{$fuel->fuel_used}}" required class="form-control">
                </div>

                <label class="col-lg-2 col-form-label">Millege paid </label>

                <div class="col-lg-4">
                    <input type="number" step="0.01" name="mileage" value="{{$mileage->total_mileage}}" required class="form-control">
                    
                </div>
            </div>

    
  <div class="form-group row">
                <label class="col-lg-2 col-form-label">Road Toll </label>

                <div class="col-lg-4">
                    <input type="number" step="0.01" name="road_toll" value="{{$loading->road_toll}}"  class="form-control">
                    
                </div>
   
                <label class="col-lg-2 col-form-label">Toll Gate </label>

                <div class="col-lg-4">
                    <input type="number" step="0.01" name="toll_gate" value="{{$loading->toll_gate}}"  class="form-control">
                    
                </div>
            </div>

 <div class="form-group row">
                <label class="col-lg-2 col-form-label">Council </label>

                <div class="col-lg-4">
                    <input type="number" step="0.01" name="council" value="{{$loading->council}}"  class="form-control">
                    
                </div>
            
                <label class="col-lg-2 col-form-label">Consultant </label>

                <div class="col-lg-4">
                    <input type="number" step="0.01" name="consultant" value="{{$loading->consultant}}"  class="form-control">
                    
                </div>
            </div>
          



                   <div class="form-group row">
                <label class="col-lg-2 col-form-label">Receipt</label>

                <div class="col-lg-4">
           <input type="text" name="receipt" id=""  value="{{$loading->receipt}}"  class="form-control ">
                 
                </div>
            
                <label class="col-lg-2 col-form-label">Damaged Bags</label>

                <div class="col-lg-4">
                    <input type="number" name="damaged" value="{{$loading->damaged}}"  class="form-control">
                </div>
            </div>

 <div class="form-group row">
                <label class="col-lg-2 col-form-label">Arrival Address/Location</label>

                <div class="col-lg-4">
           <input type="text" name="end" id=""  value="{{$loading->end}}"  class="form-control ">
                 
                </div>
            </div>

    
                                                <br><div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">

                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
                                                       
                                                        
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


    $(document).ready(function(){
      


 $(document).on('change', '.item_name', function(){
        var id = $(this).val();
        var sub_category_id = $(this).data('sub_category_id');
        var weight=$('.weight').val();
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
       html += '<td><input type="text" name="price[]" class="form-control number item_price'+count+'" placeholder ="price" required  value=""/></td>';
            html += '<td><select name="charge[]" class="form-control m-b item_charge'+count+'" required   data-sub_category_id="'+count+'" ><option value="0">Select Charge </option><option value="1">Flat</option><option value="" name="one">Distance per ton</option><option value="" name="two">Rate per weight</option></select></td>';
       html += '<td><select name="tax_rate[]" class="form-control m-b item_tax'+count+'" required ><option value="0">Select Tax </option><option value="0">No tax</option><option value="0.18">18%</option></select></td>';
 html += '<input type="hidden" name="tax_rate[]" class="form-control item_tax'+count+'"  value="0" required   />';
 html += '<input type="hidden" name="items_id[]" class="form-control item_saved'+count+'"  required   />';
 html += '<input type="hidden"  name="distance[]" class="form-control item_distance'+count+'"  required  value="" />';
 html += '<input type="hidden" name="total_tax[]" class="form-control item_total_tax'+count+'" placeholder ="total" required readonly jAutoCalc="{quantity} * {price} * {charge} * {tax_rate}"   />';
       html += '<td><input type="text" name="total_cost[]" class="form-control item_total'+count+'" placeholder ="total"  jAutoCalc="{quantity} * {price}  * {charge}" required readonly  />';           
        html += '<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="icon-trash"></i></button></td>';

        $('tbody').append(html);
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
            $('tfoot').append('<input type="hidden" name="removed_id[]"  class="form-control name_list" value="'+btn_value+'"/>');  
         autoCalcSetup();
           });  

        });
        


    </script>





@endsection