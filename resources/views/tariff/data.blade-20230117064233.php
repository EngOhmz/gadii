 @extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tariff</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Tariff
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Tariff</a>
                            </li>
                        <li class="nav-item">
                                <a class="nav-link  " id="importExel-tab"
                                    data-toggle="tab" href="#importExel" role="tab" aria-controls="profile"
                                    aria-selected="false">Import</a>
                            </li>
                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                                      <table class="table datatable-basic table-striped">
                                        <thead>
                                            <tr role="row">

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Browser: activate to sort column ascending"
                                                    style="width: 28.531px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Starting Point</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Destination Point</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 101.219px;">Distance</th> 
                                           <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Client</th> 
                                               <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Price</th> 
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($route))
                                            @foreach ($route as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{$row->from}}</td>
                                                <td>{{$row->to}}</td>
                                                <td>{{$row->distance}} km</td>
                                                <td>{{$row->client->name}}</td>
                                                      <td>{{number_format($row->price,2)}}</td>

                                                <td>
                                                <div class="form-inline">

                                                            <a class="list-icons-item text-primary" title="Edit"
                                                                onclick="return confirm('Are you sure?')"
                                                                href="{{ route("tariff.edit", $row->id)}}"><i class="icon-pencil7"></i>
                                                                    </a>
 
                                                            {!! Form::open(['route' =>
                                                            ['tariff.destroy',$row->id], 'method' => 'delete'])
                                                            !!}
                                                            {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                            {{ Form::close() }}
                                                       

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
                                    @if(!empty($id))
                                            <h5>Edit Tariff</h5>
                                            @else
                                            <h5>Add New Tariff</h5>
                                            @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                            @if(isset($id))
                                                    {{ Form::model($id, array('route' => array('tariff.update', $id), 'method' => 'PUT')) }}
                                                    @else
                                                    {{ Form::open(['route' => 'tariff.store']) }}
                                                    @method('POST')
                                                    @endif



                                       <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="inputState">Zone</label>
                                    <select  id="zone_id" name="zone_id" class="form-control m-b zone" required>
                                      <option ="">Select Zone</option>
                                      @if(!empty($region))
                                                        @foreach($zone as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->zone_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>

   <div class="form-group col-md-6">
                                    <label for="inputState">Weight</label>
                                      <input type="number" name="weight"  step="0.01"
                                                                value="{{ isset($data) ? $data->weight : ''}}" required
                                                                class="form-control">
                                  </div>
</div>



                                                   <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="inputState">Departure Region</label>
                                    <select  id="from_region_id" name="from_region_id" class="form-control m-b from_region" required>
                                      <option ="">Select Departure Region</option>
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
                                    <label for="inputState">Arrival Region</label>
                                    <select  id="to_region_id" name="to_region_id" class="form-control m-b to_region" required>
                                      <option ="">Select Arrival Region</option>
                                      @if(!empty($region))
                                                        @foreach($region as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->to_region_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>
</div>



<!--

                     @if(!empty($data))
                  <div class="form-row">
                      <div class="form-group col-md-6">
                                    <label for="inputState">Departure District</label>
                                    <select id="from_district_id" name="from_district_id" class="form-control from_district">
                                      <option>Select Departure District</option>
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
              <div class="form-group col-md-6">
                                    <label for="inputState">Departure District</label>
                                      <select id="from_district_id" name="from_district_id" class="form-control from_district">
                                      <option selected="">Select Departure District</option>
                                    
                                    </select>
                                  </div>
  @endif
                        
                            
                     @if(!empty($data))
                      <div class="form-group col-md-6">
                                    <label for="inputState">Arrival District</label>
                                    <select id="to_district_id" name="to_district_id" class="form-control to_district">
                                      <option>Select Arrival District</option>
                                    @if(!empty($to_district))
                                                        @foreach($to_district as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->to_district_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>
                 @else
              <div class="form-group col-md-6">
                                    <label for="inputState">Arrival District</label>
                                    <select id="to_district_id" name="to_district_id" class="form-control to_district">
                                      <option selected="">Select Arrival District</option>
                                    
                                    </select>
                                  </div>
  @endif
           
  </div>                 
 -->           

 <div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="inputState">Client</label>
                                    <select  id="client_id" name="client_id" class="form-control m-b client" required>
                                      <option ="">Select Client</option>
                                      @if(!empty($client))
                                                        @foreach($client as $row)
                                                        @if($row->added_by == auth()->user()->added_by)
                                                        <option @if(isset($data))
                                                            {{ $data->client_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->name}}</option>
@endif
                                                        @endforeach
                                                        @endif
                                    </select>
                                  </div>

   <div class="form-group col-md-6">
                                    <label for="inputState">Price</label>
                                        <input type="number" name="price"  step="0.01"
                                                                value="{{ isset($data) ? $data->price : ''}}" required
                                                                class="form-control">
                                  </div>
</div>

                           

<div class="form-row">
                                  <div class="form-group col-md-6">
                                    <label for="inputState">Type</label>
                                    <select  id="type" name="type" class="form-control m-b type" required>
                                      <option ="">Select Type</option>
                                         <option @if(isset($data))  {{ $data->type == 'Automatic'  ? 'selected' : ''}}@endif value="Automatic">Automatic</option>
                                           <option @if(isset($data))  {{ $data->type == 'Formula'  ? 'selected' : ''}}@endif value="Formula">Formula</option>                
                                    </select>
                                  </div>

 <div class="form-group col-md-6">
                                                          <label class="">Distance (KM)</label>
                                                            
                                                            <input type="number" name="distance"  step="0.001"
                                                                value="{{ isset($data) ? $data->distance : ''}}"
                                                                class="form-control" required>
                                                        </div>
</div>



                                                   <div class="form-row">                                                    

                                                        <div class="form-group col-md-6">
                                                       <label class="">Description</label>
                                                         <textarea name="description"  class="form-control" >@if(isset($data)){{ $data->description }} @endif</textarea>                                                                   
                                                                        </div>
                                                                    </div>





                                                                     

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


 <div class="tab-pane fade " id="importExel" role="tabpanel"
                            aria-labelledby="importExel-tab">

                            <div class="card">
                                <div class="card-header">
                                     <form action="{{ route('tariff.sample') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <button class="btn btn-success">Download Sample</button>
                                        </form>
                                 
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12 ">
                                            <div class="container mt-5 text-center">
                                                <h4 class="mb-4">
                                                 Import Excel & CSV File   
                                                </h4>
                                                <form action="{{ route('tariff.import') }}" method="POST" enctype="multipart/form-data">
                                            
                                                    @csrf
                                                    <div class="form-group mb-4">
                                                        <div class="custom-file text-left">
                                                            <input type="file" name="file" class="form-control" id="customFile" required>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-primary">Import Tariff</button>
                                          
                                        </form>
                                       
                                   

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
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>


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