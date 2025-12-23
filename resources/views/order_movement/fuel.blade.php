@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Fuel and Mileage </h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            @if(empty($id))
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Cargo List</a>
                            </li>
                            @else
                           <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">Create Fuel and Mileage</a>
                            </li> 
                            @endif

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(!empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                  {{ Form::model($id, array('route' => array('order_movement.update', $id), 'method' => 'PUT')) }}
 
        <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Truck</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control m-b truck_id" name="truck_id" required
                                                        id="supplier_id">
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
                                                     <input type="hidden"  name ="driver_id" id="driver_id"   value="" required class="form-control driver_id">
                                                         
                                                           <p class"errors" id="errors" style="color:red;"></p>  
                                                          
                                                    </div>
                                                </div>

                                           <div class="form-group row">
                                                 
                                                    <label class="col-lg-2 col-form-label">Route</label>
                                                    <div class="col-lg-4">
                                                     
                                                            <select class="form-control m-b " name="route_id" required
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
                                       <label class="col-lg-2 col-form-label"> Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ date('Y-m-d')}}" 
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Fuel</label>
                                                    <div class="col-lg-4">
                                                      <input type="number" step="0.01"  name="fuel" value="" required class="form-control">
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Mileage</label>
                                                    <div class="col-lg-4">
                                                        <input type="number" step="0.01" name="mileage" value="" required class="form-control">
                                                    </div>
                                                </div>


                  <input type="hidden" name="type" value="driver" required class="form-control">

                                 <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                      
                                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                            type="submit">Save</button>
                                                       
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
                                    <label for="inputState">Departure Location</label>
                                    <select  id="from_region_id" name="from_region_id" id="from_region_id"  class="form-control m-b from_region" required>
                                      <option ="">Select Departure Location</option>
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
                                    <label for="inputState">Arrival Location</label>
                                    <select  id="to_region_id" name="to_region_id"  class="form-control m-b to_region" required>
                                      <option ="">Select Arrival Location</option>
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


<div class="modal-footer">
									<button class="btn btn-link" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
									<button type="submit" class="btn btn-primary route" onclick="saveRoute(this)"><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
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
                {"targets": [3]}
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
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>



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

@endsection