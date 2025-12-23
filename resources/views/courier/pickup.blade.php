@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Request Pickup</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id) && empty($id2)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Pickup
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Pickup </a>
                            </li>


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
                                                    style="width: 130.484px;">Client Name</th>
                                               
                                                      
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 101.219px;">Date</th> 

                                                
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 120.219px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 150.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($courier))
                                            @foreach ($courier as $row)
                                            <tr class="gradeA even" role="row">
                                               
                                                <td>{{$row->confirmation_number}}</td>                                                
                                                <td>{{$row->supplier->name}}</td>                                             
                                                <td>{{Carbon\Carbon::parse($row->date)->format('d/m/Y')}}</td>
                                                

                                                
                                                <td>                              
                                                        @if($row->pickup== 0 )
                                                    <div class="badge badge-danger badge-shadow">Waiting For Approval</div>
                                                    @elseif($row->pickup == 1)
                                                    <div class="badge badge-success badge-shadow">Approved For Pickup</div>
                                                                        
                                               </td>
                                           @endif



                                       <td>
                                                                                           
                                                
                                        <div class="form-inline">
  @if($row->pickup== 0)
 <a class="list-icons-item text-primary" title="Edit" onclick="return confirm('Are you sure?')" href="{{ route('courier_pickup.edit', $row->id)}}"> <i class="icon-pencil7"></i></a>&nbsp

 {!! Form::open(['route' => ['courier_pickup.destroy',$row->id], 'method' => 'delete']) !!}
{{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
{{ Form::close() }}

@can('approve-pickup')
 <a  href="#" class="list-icons-item text-success" title="Collect" data-toggle="modal"  onclick="model({{ $row->id }},'assign')" value="{{ $row->id}}" data-target="#appFormModal">                                                    
       <i class="icon-checkmark3"></i> Approve Pickup</a>
 @endcan 
  
@else  
@can('approve-pickup')
 <a  href="#" class="list-icons-item text-primary" title="wbn" data-toggle="modal"  onclick="model({{ $row->id }},'wbn')" value="{{ $row->id}}" data-target="#appFormModal">                                                    
       <i class="icon-plus2"></i> Create WBN</a>
 @endcan 
 
  <div class="dropdown">
&nbsp&nbsp<a href="#" class="list-icons-item dropdown-toggle text-teal" data-toggle="dropdown"><i class="icon-cog6"></i></a>

<div class="dropdown-menu">

  <a  href="#" class="nav-link" title="Generate Barcode" data-toggle="modal"  onclick="model({{ $row->id }},'barcode')" value="{{ $row->id}}" data-target="#appFormModal">Generate Barcode</a>
  </div></div>
 
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
                                        <h5>Create Pickup</h5>
                                        @else
                                        <h5>Edit Pickup</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('courier_pickup.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'courier_pickup.store']) }}
                                                @method('POST')
                                                @endif



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
                                              

                         
<?php $a=1; ?>
          

                                          <div class="form-group row">
                                      <label class="col-lg-2 col-form-label" for="inputState">Departure Region</label>
                                   <div class="col-lg-4">
                                <div class="input-group mb-3">
                                    <select  class="form-control append-button-single-field from_region" name="from_region_id" required  id="from_region_id">
                                      <option value ="">Select Departure Region</option>
                                      @if(!empty($region))
                                                        @foreach($region as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->from_region_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>&nbsp
                                     <button class="btn btn-primary" type="button" data-toggle="modal" onclick="model({{ $a }},'departure')" value="{{ $a}}" data-target="#appFormModal"><i class="icon-plus-circle2"></i></button>
                                  </div></div>



                     @if(!empty($data))
                   
                                    <label for="inputState"  class="col-lg-2 col-form-label">Departure District</label>
                                 <div class="col-lg-4">
                                    <select id="from_district_id" name="from_district_id" class="form-control m-b from_district">
                                      <option value ="">Select Departure District</option>
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
                                      <option value ="">Select Departure District</option>
                                    
                                    </select>
                                  </div>
  @endif
                            
                             </div>


                                            <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Location</label>

                                                    <div class="col-lg-4">
                                                       <input type="text" name="location"  value="{{ isset($data) ? $data->location : ''}}"  class="form-control" >
                                                           
                                                           

                                                    </div>
                                                </div>
                                         

                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Instructions</label>

                                                    <div class="col-lg-10">
                                                        <textarea name="instructions" class="form-control">{{ isset($data) ? $data->instructions : ''}}</textarea>

                                                    </div>
                                                </div>



                                  <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
                                                       
                                                              <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                                
                                                                href="{{ route('courier_pickup.index')}}">
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
</section>

 <!-- discount Modal -->
  <div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
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
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>


 
    </div>
</div>
  </div>

@endsection

@section('scripts')
<script>
       $('.datatable-basic').DataTable({
            autoWidth: false,
             "ordering": false,
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
 $(document).ready(function(){
            $('.m-b').select2({
                            });

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


                    $("#name").append('<option value=' + value.id+ '>' + value.zone_name + ' -  ' + value.weight + ' KG</option>');
                   
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
                  $('.item_quantity').val(data[0]["weight"]);
          }

        });

});


    });
</script>


<script>
$(document).ready(function() {

    $(document).on('change', '.from_region2', function() {
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
                $("#from_district_id2").empty();
                $("#from_district_id2").append('<option value="">Select Departure District</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#from_district_id2").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });

});
</script>


<script>
$(document).ready(function() {

    $(document).on('change', '.to_region2', function() {
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
                $("#to_district_id2").empty();
                $("#to_district_id2").append('<option value="">Select Arrival District</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#to_district_id2").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });

});
</script>

<script>
$(document).ready(function() {

    $(document).on('change', '.supplier2', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("courier/findTariff2")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#name2").empty();
                $("#name2").append('<option value="">Select Tariff</option>');
                $.each(response,function(key, value)
                {


                    $("#name2").append('<option value=' + value.id+ '>' + value.zone_name + ' -  ' + value.weight + ' KG</option>');
                   
                });                      
               
            }

        });

    });

});
</script>

<script>
    $(document).ready(function(){
      

 $(document).on('change', '.item_name2', function(){
        var id = $(this).val();
        $.ajax({
            url: '{{url("courier/findCourierPrice")}}',
                    type: "GET",
          data:{id:id},
             dataType: "json",
          success:function(data)
          {
 console.log(data);
                  $('.item_quantity2').val(data[0]["weight"]);
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


<script>
$(document).ready(function() {

    var msg='The Location already exists. Create another one.';

    $(document).on('keyup', '.location', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("findLocation")}}',
            type: "GET",
            data: {
                id: id,
            },
            dataType: "json",
            success: function(data) {
              console.log(data);
            $("#errors").empty();
            $("#save").attr("disabled", false);
             if (data != '') {
          $("#errors").append(msg);
                 $("#save").attr("disabled", true);
} else {
  
}
            
       
            }

        });

    });

});
</script>

<script type="text/javascript">


    function saveLocation(e){
     
     
     var location= $('#location').val();
     var type = $('#type').val();

     
          $.ajax({
            type: 'GET',
            url: '{{url("addLocation")}}',
             data: {
                 'location':location,

             },
          dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var point = response.name;

                             var option = "<option value='"+id+"'  selected>"+point+"</option>"; 
 
                                   if(type == 'departure'){
                             $('#from_region_id').append(option);
                              $('#appFormModal').hide();
                               $('.modal-backdrop').remove();
                        }
                          else{
                             $('#to_region_id').append(option);
                              $('#appFormModal').hide();
                                $('.modal-backdrop').remove();
                           }
                   
                           
               
            }
          
        });
}
    </script>
@endsection