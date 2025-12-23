<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="formModal">Assign Fuel and Mileage</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        {{ Form::model($id, array('route' => array('order_movement.update', $id), 'method' => 'PUT')) }}
        <div class="modal-body">

         <p><strong>Make sure you enter valid information</strong> .</p>
             <ul>
                @php
                   $data=App\Models\CargoLoading::find($id); 
                     $route =App\Models\Route::find($data->route_id);
                @endphp
                <li>Truck : {{ $data->truck->truck_name}} - {{ $data->truck->reg_no}}</li>
               <li>Driver Name: {{ $data->driver->driver_name}} </li>
              <li>Route Name: From {{ $data->route->from}} to  {{ $data->route->to}} 
            @if(!empty($data->end))
                 - {{$data->end}}
            @endif
 </li>
       @if(!empty($data->receipt))
        <li>Receipt: {{ $data->receipt}} </li>
            @endif
            </ul>

          <div class="form-group">
                <label class="col-lg-6 col-form-label"> Fuel Used In Litre </label>

                <div class="col-lg-12">
                   <input type="number" step="0.01"  name="fuel" value="{{ isset($route) ? $route->loaded_fuel : ''}}" required class="form-control loaded">
                </div>
            </div>
            
             <input type="hidden" step="0.01" value="@if(empty($route->empty_fuel)) 0 @else {{$route->empty_fuel}} @endif" required class="form-control empty">
            
             <div class="col-lg-6">
             <div class="form-check">
             
                <input class="form-check-input checks" type="checkbox"  name="returnFuel" value="1" id="fueltype">
                  <label class="form-check-label" for="fueltype">
                    Go and Return Fuel
                  </label>
            </div>
            </div>

            <div class="form-group">
                <label class="col-lg-6 col-form-label">Millege paid </label>

                <div class="col-lg-12">
                    <input type="number" step="0.01" name="mileage" value="" required class="form-control">
                    
                </div>
            </div>
            
           

    
  <div class="form-group">
                <label class="col-lg-6 col-form-label">Road Toll </label>

                <div class="col-lg-12">
                    <input type="number" step="0.01" name="road_toll" value="{{ isset($route) ? $route->road_toll : ''}}"  class="form-control">
                    
                </div>
            </div>
  <div class="form-group">
                <label class="col-lg-6 col-form-label">Toll Gate </label>

                <div class="col-lg-12">
                    <input type="number" step="0.01" name="toll_gate" value="{{ isset($route) ? $route->toll_gate : ''}}"  class="form-control">
                    
                </div>
            </div>
  <div class="form-group">
                <label class="col-lg-6 col-form-label">Council </label>

                <div class="col-lg-12">
                    <input type="number" step="0.01" name="council" value="{{ isset($route) ? $route->council : ''}}"  class="form-control">
                    
                </div>
            </div>
  <div class="form-group">
                <label class="col-lg-6 col-form-label">Consultant </label>

                <div class="col-lg-12">
                    <input type="number" step="0.01" name="consultant" value="{{ isset($route) ? $route->consultant : ''}}"  class="form-control">
                    
                </div>
            </div>
          
  <div class="form-group">
   <label class="col-lg-6 col-form-label"> Date</label>
                                                    <div class="col-lg-12">
                                                        <input type="date" name="date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ date('Y-m-d')}}" 
                                                            class="form-control">
                                                    </div>
                                                     </div>

                    <input type="hidden" name="type" value="fuel" required class="form-control">
            


        </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        {!! Form::close() !!}
    </div>
</div>



@yield('scripts')

<script type='text/javascript'>
$(document).ready(function() {
      


$('input:checkbox').click(function() {

  if($(this).is(':checked')){  

var a= parseFloat($('.loaded').val());
var b= parseFloat($('.empty').val());
var c = a + b;
console.log(c);
$('.loaded').val(c.toFixed(2));
  
  }
else{
var a= parseFloat($('.loaded').val());
var b= parseFloat($('.empty').val());
var c = a - b;
$('.loaded').val(c.toFixed(2));

}

})



});
</script>