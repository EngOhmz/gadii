@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Collection Center</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Collection Center List</a>
                            </li>
                            @can('view-center')
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Collection Center</a>
                            </li>
                            @endcan

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 208.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Name</th>
                                          
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                       rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Operator</th> 
                                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Location</th>
                                         
                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Quantity</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($warehouse))
                                            @foreach ($warehouse as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->name}}</td>
                                               
                                              <td> {{$row->operator->name}}</td>
                                           <td> {{$row->district->name}}</td>                                                                
                                                <td> 
                                         @if($row->head =='1')
                                          @can('edit-center')
 <a  class="nav-link" title="Edit" data-toggle="modal" class="discount"  href="" onclick="model({{ $row->id }},'head')" value="{{ $row->id}}" data-target="#appFormModal" >{{$row->quantity}}</a> 
                                               @else
<a  class="nav-link" title="Edit" data-toggle="modal" class="discount"  href="" onclick="model({{ $row->id }},'quantity')" value="{{ $row->id}}" data-target="#appFormModal" >{{$row->quantity}}</a> 
                                               @endcan
                                                @endif
</td>
                                                <td>
    @can('edit-center')
                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        href="{{ route("collection_center.edit", $row->id)}}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    @endcan
                                                        @can('delete-center')
                                                    <a class="btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4"
                                                        href="{{ route("collection_center.destroy", $row->id)}}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                    @endcan


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
                                    @if(!empty($id))
                                            <h5>Edit Collection Center</h5>
                                            @else
                                            <h5>Add New Collection Center</h5>
                                            @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                            @if(isset($id))
                                                    {{ Form::model($id, array('route' => array('collection_center.update', $id), 'method' => 'PUT')) }}
                                                    @else
                                                    {{ Form::open(['route' => 'collection_center.store']) }}
                                                    @method('POST')
                                                    @endif

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Name <span class="required" style="color:red;"> * </span></label>

                                                        <div class="col-lg-4">
                                                            <input type="text" name="name"
                                                                value="{{ isset($data) ? $data->name : ''}}"
                                                                class="form-control" required>
                                                        </div>

                                                           <label class="col-lg-2 col-form-label">Operator <span class="required" style="color:red;"> * </span></label>
<?php $a=1; ?>
                                                        <div class="col-lg-4">
                                               
                                                              <select name="operator_id" id="operator" class="m-b" required>
                                                                         <option value="">Select</option>
                                                          @if(!empty($operator))
                                                          @foreach($operator as $row)
                                                          <option @if(isset($data))
                                                          {{  $data->operator_id == $row->id  ? 'selected' : ''}}
                                                          @endif value="{{ $row->id}}">{{$row->name}}</option>
                                                          @endforeach
                                                          @endif

                                                        </select>
                                                                      
                                               
                                                 </div>                            

                                                    </div>
                                                  

                                                <div class="form-group row">
                                                <label
                                                            class="col-lg-2 col-form-label">Is it  Main Center<span class="required" style="color:red;"> * </span></label>

                                                        <div class="col-lg-4">
                                                           <select  id="" name="head" class="form-control" required>
                                      <option value="">Select option</option>
                                                        <option @if(isset($data))
                                                            {{ $data->head == '1'  ? 'selected' : ''}}
                                                            @endif value="1">Yes</option>
                                                         <option @if(isset($data))
                                                            {{ $data->head == '0'  ? 'selected' : ''}}
                                                            @endif value="0">No</option>
                                                       
                                    </select>
                                                        </div>
                                                    
                                                
                                                <label
                                                            class="col-lg-2 col-form-label">District <span class="required" style="color:red;"> * </span></label>

                                                        <div class="col-lg-4">
                                                                
                                                              <select id="selectDistrictid" name="district_id" class="district" required>
                                      <option value="">Select district</option>
                                    @if(!empty($district))
                                                        @foreach($district as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->district_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                                 
                                                 </div>
                                                                                           

                                                    

                         

                                             
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label"> AMCOS <span class="required" style="color:red;"> * </span></label>

                                                    <div class="col-lg-4">
                                                        <input type="text" name="amcos"
                                                            value="{{ isset($data) ? $data->amcos : ''}}"
                                                            class="form-control" placeholder="Enter AMCOS" errequired>
                                                    </div>

                                                       
                                                    
                                                </div>



<br>


                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))
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
  <div class="modal inmodal show " id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog">
    </div>
</div></div>
  </div>

@endsection

@section('scripts')
<script>
     $(document).ready(function () {
        new TomSelect("#operator",{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
    new TomSelect("#selectDistrictid",{
        create: false,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
  });



$('.demo4').click(function() {
    swal({
        title: "Are you sure?",
        text: "You will not be able to recover this imaginary file!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        closeOnConfirm: false
    }, function() {
        swal("Deleted!", "Your imaginary file has been deleted.", "success");
    });
});
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

<script>
$(document).ready(function() {

    $(document).on('change', '.region', function() {
        var id = $(this).val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{url("findCenterDistrict")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#selectDistrictid").empty();
                $("#selectDistrictid").append('<option value="">Select district</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#selectDistrictid").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });


 $(document).on('change', '.district', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("findCenterRegion")}}',
            type: "GET",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                console.log(response);
                $("#selectWardid").empty();
                $("#selectWardid").append('<option value="">Select ward</option>');
                $.each(response,function(key, value)
                {
                 
                    $("#selectWardid").append('<option value=' + value.id+ '>' + value.name + '</option>');
                   
                });                      
               
            }

        });

    });



});
</script>


<script type="text/javascript">
    function model(id,type) {

        $.ajax({
            type: 'GET',
            url: '{{url("centerModal")}}',
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
    
    

    function saveOperator(e){
  
          $.ajax({
            type: 'GET',
            url: '{{url("addOperator")}}',
            data:  $('#addClientForm').serialize(),
               
                dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var name = response.name;

                             var option = "<option value='"+id+"'  selected>"+name+" </option>"; 

                             $('#operator').append(option);
                              $('#appFormModal').hide();
                   
                               
               
            }
        });
}


    function saveLicence(e){
     
     
     var to = $('#destination_point').val();
     var distance = $('#distance').val();
     var from = $('#arrival_point').val();

     
          $.ajax({
            type: 'GET',
            url: '{{url("addLicence")}}',
             data:  $('#addLicenceForm').serialize(),
              
          dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var name = response.insurance_name;

                              var option = "<option value='"+id+"'  selected>"+name+" </option>"; 


                             $('#licence').append(option);
                              $('#appFormModal').hide();
                   
                               
               
            }
          
        });
}
    </script>
@endsection