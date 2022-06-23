@extends('layouts.master')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Farmer Assets</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-2">
                            @can('view-farmer-assets')
                                <ul class="nav nav-pills flex-column" id="myTab4" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link @if(empty($id)  && $type=='tool') active  @endif" id="#tab1"
                                            data-toggle="tab" href="#tab1" role="tab" aria-controls="home"
                                            aria-selected="true">Product Tools</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if(!empty($id)  && $type=='tool') active  @endif" id="#tab2"
                                            data-toggle="tab" href="#tab2" role="tab" aria-controls="profile"
                                            aria-selected="false">New Tool</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if(empty($id)  && $type=='land') active  @endif" id="#tb3"
                                            data-toggle="tab" href="#tab3" role="tab" aria-controls="contact"
                                            aria-selected="false">Land </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link @if(!empty($id)  && $type=='land') active  @endif" id="#tab4"
                                            data-toggle="tab" href="#tab4" role="tab" aria-controls="tab"
                                            aria-selected="false">New Land</a>
                                    </li>
                                </ul>
                                @endcan
                            </div>
                            <div class="col-12 col-sm-12 col-md-10">
                                <div class="tab-content no-padding" id="myTab2Content">
                                    <div class="tab-pane fade @if(empty($id)  && $type=='tool') active show  @endif"
                                        id="tab1" role="tabpanel" aria-labelledby="tab1">
                                        <div class="table-responsive">
                                        @can('view-farmer-assets')
                                            <table class="table table-striped" id="table-1">
                                                <thead>
                                                    <tr role="row">

                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                            aria-label="Browser: activate to sort column ascending"
                                                            style="width: 208.531px;">#</th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                            aria-label="Engine version: activate to sort column ascending"
                                                            style="width: 141.219px;">tool_name</th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                            aria-label="Engine version: activate to sort column ascending"
                                                            style="width: 141.219px;">tool_owner</th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                            aria-label="Engine version: activate to sort column ascending"
                                                            style="width: 141.219px;">tool_quantity</th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                            aria-label="Engine version: activate to sort column ascending"
                                                            style="width: 141.219px;">units</th>

                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                            aria-label="CSS grade: activate to sort column ascending"
                                                            style="width: 98.1094px;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(!@empty($tools))
                                                    @foreach ($tools as $row)
                                                    <tr class="gradeA even" role="row">
                                                        <th>{{ $loop->iteration }}</th>
                                                        <td>{{$row->tool_name}}</td>
                                                        <td>{{$row->owner->firstname}}</td>

                                                        <td>{{$row->quantity}}</td>
                                                        <td>{{$row->units}}</td>



                                                        <td>
                                                        @can('edit-farmer-assets')
                                                            <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                                href="{{ route('register_assets.edit',$row->id )}}">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            @endcan
                                                            @can('delete-farmer-assets')
                                                            <a class="btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4"
                                                                href="{{ route('register_assets.destroy',$row->id,['id'=>$row->id,'type'=>'tool'])}}">
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                            @endcan


                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                    @endif

                                                </tbody>
                                            </table>
                                            @endcan
                                        </div>
                                    </div>
                                    <div class="tab-pane fade @if(!empty($id)  && $type=='tool') active show  @endif"
                                        id="tab2" role="tabpanel" aria-labelledby="tbb2">
                                        <div class="card">
                                            <div class="card-header">
                                                @if(!empty($id))
                                                <h5>Edit Product Tool</h5>
                                                @else
                                                <h5>Add Product Tool</h5>
                                                @endif
                                            </div>
                                            <div class="card-body p-0">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('register_assets.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'register_assets.store']) }}
                                                @method('POST')
                                                @endif
                                                <div class="card-body">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <input type="hidden" name="type" class="form-control"
                                                                id="type" value="tool" placeholder="">
                                                            <label for="inputEmail4">Tool Name</label>
                                                            <input type="text" name="tool_name" class="form-control"
                                                                id="tool_name"
                                                                value=" {{ !empty($data) ? $data->tool_name : ''}}"
                                                                placeholder="" required>
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label for="inputPassword4">Tool Owner</label>
                                                            <select class="form-control m-b" name="owner_id" required>
                                                                @if(!empty($farmer))
                                                                @foreach($farmer as $row)
                                                                <option value="{{$row->id}}"
                                                                    @if(isset($data))@if($data->owner_id == $row->id)
                                                                    selected @endif @endif >{{$row->firstname}}</option>

                                                                @endforeach
                                                                @endif
                                                            </select>

                                                        </div>

                                                    </div>
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6 col-lg-6">
                                                            <label for="inputAddress">Quantity</label>
                                                            <input type="number" name="quantity" class="form-control"
                                                                id="quantity"
                                                                value="{{ !empty($data) ? $data->quantity : ''}}"
                                                                placeholder="" required>

                                                        </div>
                                                        <div class="form-group col-md-6 col-lg-6">
                                                            <label for="inputAddress">Units</label>
                                                            <input type="text" name="units"
                                                                value="{{ !empty($data) ? $data->units : ''}}"
                                                                class="form-control" id="units" required>
                                                        </div>
                                                    </div>



                                                    <div class="form-row">
                                                        <div class="form-group col-md-6 col-lg-6">
                                                        </div>
                                                        <div class="form-group col-md-6 col-lg-6">

                                                            @if(isset($id)) <input type="submit" value="update"
                                                                name="save" class="btn btn-lg btn-primary">
                                                            @else
                                                            <input type="submit" value="save" name="save"
                                                                class="btn btn-lg btn-primary">
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade @if(empty($id)  && $type=='land') active show  @endif"
                                        id="tab3" role="tabpanel" aria-labelledby="tab3">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table-1">
                                                <thead>
                                                    <tr role="row">

                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                            aria-label="Browser: activate to sort column ascending"
                                                            style="width: 208.531px;">#</th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                            aria-label="Engine version: activate to sort column ascending"
                                                            style="width: 141.219px;">location</th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                            aria-label="Engine version: activate to sort column ascending"
                                                            style="width: 141.219px;">land_owner</th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                            aria-label="Engine version: activate to sort column ascending"
                                                            style="width: 141.219px;">size</th>
                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                            aria-label="Engine version: activate to sort column ascending"
                                                            style="width: 141.219px;">land_value</th>

                                                        <th class="sorting" tabindex="0"
                                                            aria-controls="DataTables_Table_0" rowspan="1" colspan="1"
                                                            aria-label="CSS grade: activate to sort column ascending"
                                                            style="width: 98.1094px;">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(!@empty($land))
                                                    @foreach ($land as $row)
                                                    <tr class="gradeA even" role="row">
                                                        <th>{{ $loop->iteration }}</th>
                                                        <td>{{$row->ward->name}}, {{$row->district->name}}, {{$row->region->name}}</td>
                                                        <td>{{$row->owner->firstname}}</td>

                                                        <td>{{$row->size}}</td>
                                                        <td>{{$row->land_value}}</td>



                                                        <td>

                                                            <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                                href="{{ route('register_assets.show',$row->id )}}">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <a class="btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4"
                                                                href="{{ url('/landdelete',$row->id)}}">
                                                                <i class="fa fa-trash"></i>
                                                            </a>


                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                    @endif

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade @if(!empty($id)  && $type=='land') active show  @endif"
                                        id="tab4" role="tabpanel" aria-labelledby="tab4">
                                        <div class="card">
                                            <div class="card-header">
                                                @if(!empty($id))
                                                <h5>Edit Land Properties</h5>
                                                @else
                                                <h5>Add Land Properties</h5>
                                                @endif
                                            </div>
                                            <div class="card-body p-0">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('register_assets.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'register_assets.store']) }}
                                                @method('POST')
                                                @endif
                                                <div class="card-body">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="inputEmail4">Registration Number</label>

                                                            <input type="text" name="reg_no" class="form-control"
                                                                id="reg_no"
                                                                value=" {{ !empty($data) ? $data->reg_no : ''}}"
                                                                placeholder="">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label for="inputEmail4">Location</label>
                                                            <input type="hidden" name="type" class="form-control"
                                                                id="type" value="land" placeholder="">
                                                            <input type="text" name="location" class="form-control"
                                                                id="location"
                                                                value=" {{ !empty($data) ? $data->location : ''}}"
                                                                placeholder="">
                                                        </div>
                                                    </div>
                                                    <div class="form-row">
                                  <div class="form-group col-md-4">
                                    <label for="inputState">Region</label>
                                    <select  id="selectRegionid" name="region_id" class="form-control region">
                                      <option ="">Select region</option>
                                      @if(!empty($region))
                                                        @foreach($region as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->region_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>
  @if(!empty($data))
                              <div class="form-group col-md-4">
                                    <label for="inputState">District</label>
                                    <select id="selectDistrictid" name="district_id" class="form-control district">
                                      <option>Select district</option>
                                    
                                    @if(!empty($district))
                                                        @foreach($district as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->district_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  
                             </div>
@else
 <div class="form-group col-md-4">
                                    <label for="inputState">District</label>
                                    <select id="selectDistrictid" name="district_id" class="form-control district">
                                      <option>Select district</option>
                                    </select>
                                  </div>
                            
 @endif

 @if(!empty($data))
                      <div class="form-group col-md-4">
                                    <label for="inputState">Ward</label>
                                    <select id="selectWardid" name="ward_id" class="form-control">
                                      <option>Select ward</option>
                                    @if(!empty($ward))
                                                        @foreach($ward as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->ward_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>
                 @else
              <div class="form-group col-md-4">
                                   <label for="inputState">Ward</label>
                                    <select id="selectWardid" name="ward_id" class="form-control">
                                      <option>Select ward</option>
                                    
                                    </select>
                                  </div>
  @endif
                             </div>
            


                                                    <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label for="inputPassword4">size</label>
                                                            <input type="size" name="size" class="form-control"
                                                                id="size" value=" {{ !empty($data) ? $data->size : ''}}"
                                                                placeholder="">
                                                        </div>
                                                        <div class="form-group col-md-6 col-lg-6">
                                                            <label for="inputAddress">Land Value</label>

                                                            <input type="number" name="land_value" class="form-control"
                                                                id="land_value"
                                                                value="{{ !empty($data) ? $data->land_value : ''}}"
                                                                placeholder="">

                                                        </div>

                                                    </div>



                                                    <div class="form-row">

                                                        <div class="form-group col-md-6 col-lg-6">
                                                            <label for="inputAddress">Owner</label>
                                                            <select class="form-control m-b" name="owner_id" required>
                                                                @if(!empty($farmer))
                                                                @foreach($farmer as $row)
                                                                <option value="{{$row->id}}"
                                                                    @if(isset($data))@if($data->owner_id == $row->id)
                                                                    selected @endif @endif >{{$row->firstname}}</option>

                                                                @endforeach
                                                                @endif
                                                            </select>
                                                        </div>

                                                        <div class="form-group col-md-6 col-lg-6">
                                                            <label for="inputAddress"></label>
                                                            @if(isset($id))

                                                            <input type="submit" value="update" name="save"
                                                                class="btn btn-lg btn-primary form-control">
                                                            @else
                                                            <input type="submit" value="save" name="save"
                                                                class="btn btn-lg btn-primary form-control">
                                                            @endif


                                                        </div>
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
<!-- delete modal -->
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete?
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <button type="button" type="submit" class="btn btn-danger"><a href="farmer/{{$flist->id ?? ''}}/delete"
                        style="color:white;font-weight:bold">Delete</a></button>
                <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end of the delete model -->

<script>
$(document).ready(function() {

    $(document).on('change', '.region', function() {
        var id = $(this).val();
        $.ajax({
            url: '{{url("findRegion")}}',
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
            url: '{{url("findDistrict")}}',
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
@endsection