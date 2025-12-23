@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Fuel</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                         
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Fuel
                                    List</a>
                            </li>
                           
                           
                           

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
                                                    style="width: 28.484px;">#</th>
                                       <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 108.484px;">Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Truck</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Route</th>
                                           
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Fuel Used</th>


                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 108.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($fuel))
                                            @foreach ($fuel as $row)
                                            <tr class="gradeA even" role="row">

                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                            <td>{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}} </td>
                                                <td>{{$row->truck->reg_no}}</td>
                                                <td>From {{$row->route->from}} to {{$row->route->to}}</td>

                                              

                                                @php
                                                    $a=App\Models\Fuel\Refill::where('fuel_id',$row->id)->first();
                                                @endphp
                                                @if (!empty($a))
                                                <td> <a href="#view{{$row->id}}" data-toggle="modal">{{$row->fuel_used}} Litres</a></td>
                                                @else
                                                <td>{{$row->fuel_used}} Litres</td>
                                                @endif
                                               

                                                <td>
                                                <div class="form-inline">
                                                  
                                                    
                                                    
                                                    <div class="dropdown">
                                  <a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>
                                                       <div class="dropdown-menu">
                                                          
                                                            @if($row->due_fuel != 0 )
                                                         <a class="nav-link"
                                                                    title="Refill Fuel"
                                                                    data-toggle="modal"  href="#" data-target="#appFormModal"
                                            data-id="{{ $row->id }}" data-type="refill"
                                            onclick="model({{ $row->id }},'refill')">Refill Fuel
                                                                  </a>
                                                                  @endif

                                                                  
                                                                  
                                                            <a class="nav-link" title="Adjustment Fuel"
                                                                data-toggle="modal" href=""  value="{{ $row->id}}" data-type="adjustment" data-target="#appFormModal"
                                                                onclick="model({{ $row->id }},'adjustment')">Adjustment Fuel
                                                                    </a>                        
                                                                  

                                                                    @if($row->fuel_adjustment != '' )
                                                                    <a class="nav-link" id="profile-tab2"
                                                                        href="{{ route('fuel.approve',$row->id)}}"
                                                                        role="tab"
                                                                        aria-selected="false" onclick="return confirm('Are you sure?')">Approve Adjustment Fuel
                                                                            </a>
                                                                            @endif
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
                                        @if(empty($id))
                                        <h5>Create Fuel</h5>
                                        @else
                                        <h5>Edit Fuel</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('fuel.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'fuel.store']) }}
                                                @method('POST')
                                                @endif


                             <div class="form-group row">
                                                     <label class="col-lg-2 col-form-label"> Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->date : date('Y-m-d')}}" 
                                                            class="form-control" required>
                                                    </div>
                                                  
                                                      <label class="col-lg-2 col-form-label"> Order No</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="order_no"
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->order_no :''}}" 
                                                            class="form-control"  required>
                                                    </div>
                                                  
                                                </div>


                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Truck</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control m-b truck_id" name="truck_id"  id="truck" required>
                                                        <option value="">Select</option>
                                                        @if(!empty($truck))
                                                        @foreach($truck as $row)

                                                        <option @if(isset($data))
                                                            {{  $data->truck_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{ $row->id}}">{{$row->reg_no}}</option>

                                                        @endforeach
                                                        @endif

                                                    </select>
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Driver</label>
                                                    <div class="col-lg-4">
                               <input type="text"  id="driver"  value="" required class="form-control driver" readonly>
                                 <input type="hidden"  name ="driver_id" id="driver_id"   value="{{ isset($data) ? $data->driver_id : ''}}" required class="form-control driver_id">
                                  <p class"errors" id="errors" style="color:red;"></p>                           
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Route</label>
                                                    <div class="col-lg-4">
                                                       
                                                            <select class="form-control m-b" name="route_id" required
                                                                id="route">
                                                                <option value="">Select</option>
                                                                @if(!empty($route))
                                                                @foreach($route as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->route_id == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">From {{$row->from}} to  {{$row->to}}</option>

                                                                @endforeach
                                                                @endif

                                                            </select>
                                                           
                                                    </div>
                                                   
                                                     <label class="col-lg-2 col-form-label">Fuel Used</label>
                                                    <div class="col-lg-4">
                                                        <input type="number" step="0.01" name="fuel_used"
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->fuel_used : ''}}"
                                                            class="form-control"  required>
                                                    </div>
                                                  
                                                </div>






                                                <div class="form-group row">
                                                     <label class="col-lg-2 col-form-label"> Price</label>
                                                    <div class="col-lg-4">
                                                         <input type="number" name="price"
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->price : ''}}" 
                                                            class="form-control"  required>
                                                    </div>
                                                  
                                                      <label class="col-lg-2 col-form-label"> Amount</label>
                                                    <div class="col-lg-4">
                                                        <input type="number" name="amount"
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->amount :''}}" 
                                                            class="form-control"  required>
                                                    </div>
                                                  
                                                </div>


                                                
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))

                                                        <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                            href="{{ route('fuel.index')}}">
                                                           Cancel
                                                        </a>
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            data-toggle="modal" data-target="#myModal"
                                                            type="submit">Update</button>
                                                        @else
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
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

@if(!empty($refill))
@foreach($refill as $row)
<!-- Modal -->
<div class="modal fade " id="view{{$row->fuel_id}}"  tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">     
<div class="modal-content">
   <div class="modal-header">
       <h5 class="modal-title"  style="text-align:center;"> 
         Fuel Refill 
            @php    
            $truck=App\Models\Truck::where('id', $row->truck)->get();   
          @endphp
             @foreach($truck as $t)
             For {{$t->reg_no}} 
            @endforeach

            @php    
            $route=App\Models\Route::where('id', $row->route)->get();   
          @endphp
             @foreach($route as $r)
            with Route {{$r->from}} - {{$r->to}}
            @endforeach
        </td>
        <h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">×</span>
       </button>
   </div>


   <div class="modal-body">
<div class="table-responsive">
                        <table class="table datatable-basic table-striped">
<thead>
               <tr>
                <th>#</th>

                       <th>Refill</th>
                   <th>Price per Litre</th>
                   <th>Total Cost</th>
               </tr>
               </thead>

               <?php
                        $total_l=0; 
                   $total_c=0;    

                        $history = \App\Models\Fuel\Refill::where('fuel_id', $row->fuel_id)->get();                                               
?>

<tbody>   
    @foreach($history as $h)

                            <tr>
                                <td>{{ $loop->iteration }}</td>
                               
                    <td >{{$h->litres }} Litres</td>
                   <td>{{number_format($h->price,2) }}</td>                  
                   <td>{{number_format($h->total_cost,2) }} </td>
 
                   @php    
                   $total_l+=$h->litres; 
                   $total_c+=$h->total_cost;   
                  $fuel_b=\App\Models\Fuel\Fuel::find($row->fuel_id); 
                 @endphp
                   
               </tr> 
               @endforeach

                   </tbody>

                   <tfoot>
                 
<tr>
                    <td><b>Total</b></td>
                  
                    
        <td >{{number_format($total_l,2)}} Litres</td>
       <td></td>                  
       <td>{{number_format($total_c,2) }} </td>

   </tr> 

<tr>
                    <td><b>Balance</b></td>
                  
                    
        <td >{{number_format( $fuel_b->fuel_used - $total_l,2)}} Litres</td>
       <td></td>                  
       <td> </td>

   </tr> 

                   </tfoot>
                       </table>
                      </div>
 <div class="modal-footer ">
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
   </div>
  
</div>
</div>
</div>

@endforeach
@endif

<!-- discount Modal -->
<div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
    </div>
</div>



<!-- route Modal -->
<div class="modal fade" id="routeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Route</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
  <form id="addRouteForm" method="post" action="javascript:void(0)">
            @csrf
                <div class="modal-body">
                    <p><strong>Make sure you enter valid information</strong> .</p>
    
                 <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="inputState">Departure Region</label>
                                    <select  id="from_region_id" name="from_region_id" id="from_region_id"  class="form-control m-b from_region" required>
                                      <option ="">Select Departure Region</option>
                                      @if(!empty($region))
                                                        @foreach($region as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->to_region_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>

                  
             <div class="form-group col-md-6">
                                    <label for="inputState">Departure Specific Place</label>
                                     <input type="text" name="depature_specific_place" id="from_district_id"
                                                                value=""
                                                                class="form-control">
                           </div>
                             </div>



                                                                         <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="inputState">Arrival Region</label>
                                    <select  id="to_region_id" name="to_region_id"  class="form-control m-b to_region" required>
                                      <option ="">Select Arrival Region</option>
                                      @if(!empty($region))
                                                        @foreach($region as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->from_region_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>

                   
            <div class="form-group col-md-6">
                                    <label for="inputState">Arrive Specific Place</label>
                                        <input type="text" name="arrive_specific_place" id="to_district_id"
                                                                value=""
                                                                class="form-control">
                                  </div>

                             </div>



                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Distance (KM)</label>

                                                        <div class="col-lg-10">
                                                            <input type="number" name="distance"  step="0.001"
                                                                value=""
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                </div>
            
 <div class="modal-footer ">
             <button class="btn btn-primary"  type="submit" id="save" class="btn btn-primary route" onclick="saveRoute(this)"><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
         <button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
        </div>
                 </form>
          
    </div>
</div>
</div>
</div>

@endsection

@section('scripts')

 
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,         
            "columnDefs": [
                {"targets": [3]},
            
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
    $(document).ready(function(){
   

 $(document).on('change', '.type', function(){
var id=$(this).val() ;
console.log(id);
         if($(this).val() == 'cash') {
          $('.account').show(); 
        } else {
            $('.account').hide(); 
        } 

/*
             * Multiple drop down select
             */
            $('.m-b').select2({
                            });

});


    });
</script>


<script>
$(document).ready(function() {
$(document).on('change', '.truck_id', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("tracking/findDriver")}}',
            type: "GET",
            data: {
                id: id,
            },
            dataType: "json",
            success: function(response) {
                console.log(response);

                  $("#errors").empty();
              $("#save").attr("disabled", false);
                $("#driver").val('');
                 $("#driver_id").val('');

                          if (response == 'Please Assign Driver to the Truck.') {
                          $("#errors").append(response);
                         $("#save").attr("disabled", true);
                        } else {
                       $("#driver").val(response.driver_name);
                        $("#driver_id").val(response.id);
                        }

}

        });
  });


});
</script>

<script type="text/javascript">

    function saveRoute(e){
     
     
      var distance = $('#distance').val();
     var to_region_id = $('#to_region_id').val();    
     var from_region_id = $('#from_region_id').val();
     var to_district_id = $('#to_district_id').val();    
     var from_district_id= $('#from_district_id').val();
     
          $.ajax({
            type: 'GET',
            url: '{{url("addRoute")}}',
             data: {
                 'to_region_id': to_region_id,
                 'distance':distance,
                 'from_region_id' : from_region_id,
                 'from_district_id' : from_district_id,
               'to_district_id': to_district_id,
             },
          dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var arrival_point = response.from;
                              var destination_point = response.to;

                             var option = "<option value='"+id+"'  selected>From "+arrival_point+" to "+destination_point+"</option>"; 

                             $('#route').append(option);
                              $('#routeModal').hide();
                              $('.modal-backdrop').remove();
                   
                               
               
            }
          
        });
}



    function model(id,type) {

$.ajax({
    type: 'GET',
    url: '{{url("discountModal")}}',
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



function calculateCost() {
    
    $('#price,#litres').on('input',function() {
    var price= parseInt($('#price').val());
    var qty = parseFloat($('#litres').val());
    console.log(qty);
    $('#total_c').val((10* 2 ? 10* 2 : 0).toFixed(2));
    });
    
    }


</script>


  <script>
$(document).ready(function() {

    $(document).on('change', '.from_region', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("findFromRegion")}}',
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
            url: '{{url("findToRegion")}}',
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




@endsection