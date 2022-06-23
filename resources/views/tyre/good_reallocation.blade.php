@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tire Reallocation</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Tire Reallocation
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Tire Reallocation</a>
                            </li>

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
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Date</th>
                                               
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Tyre</th>
                                                    
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Source Truck</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Destination Truck</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Allocated by</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($reallocation))
                                            @foreach ($reallocation as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{Carbon\Carbon::parse($row->date)->format('M d, Y')}}</td>
                                                <td>{{$row->tyre_no->reference}}</td> 
                                                <td>{{$row->s_truck->reg_no}} - {{$row->s_truck->truck_name}}</td> 
                                                <td>{{$row->d_truck->reg_no}} - {{$row->d_truck->truck_name}}</td>
                                                <td>{{$row->tyre_staff->name}}</td>                                            
                                                
                                                <td>
                                                 @if($row->status == 0)
                                                 <div class="badge badge-danger badge-shadow">Not Approved</div>
                                           
                                                 @elseif($row->status == 1)
                                                 <span class="badge badge-success badge-shadow"> Approved</span>
 
                                                 @endif
                                             </td>
                                                    
                                                

                                                      <td>
                                                        @if($row->status == 0)
                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        href="{{ route("tyre_reallocation.edit", $row->id)}}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a class="btn btn-xs btn-outline-primary text-uppercase px-2 rounded"
                                                    href="{{ route("tyre_reallocation.approve", $row->id)}}" title="Approve" onclick="return confirm('Are you sure?')">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                               
                                                    {!! Form::open(['route' => ['tyre_reallocation.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}
 @endif
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
                                        <h5>Edit Tire Reallocation</h5>
                                        @else
                                        <h5>Add New Tire Reallocation</h5>
                                        @endif
                                    </div>

                                     
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                              <h6>NOTE: CHOOSE TIRES WITH THE SAME POSTION</h6><br>
                                                     @if(isset($id))
                                                {{ Form::model($id, array('route' => array('tyre_reallocation.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'tyre_reallocation.store']) }}
                                                @method('POST')
                                                @endif

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date" name="date"
                                                            placeholder="0 if does not exist"
                                                            value="{{ isset($data) ? $data->date : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Mechanical</label>
                                                    <div class="col-lg-4">
                                                     <select class="form-control type" name="staff" required
                                                         id="">
                                                 <option value="">Select 
                                                    @if(!empty($staff))
                                                    @foreach($staff as $row)

                                                    <option @if(isset($data))
                                                        {{ $data->staff == $row->id  ? 'selected' : ''}}
                                                        @endif value="{{$row->id}}">{{$row->name}}</option>

                                                    @endforeach
                                                    @endif                                              
 
                                             </select>
                                                   
                                                </div>
                                            </div>

                                                

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Source Truck</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control truck_id" name="source_truck" required
                                                                id="supplier_id">
                                                        <option value="">Select Source</option>
                                                        @if(!empty($truck_s))
                                                        @foreach($truck_s as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->source_truck == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->truck->reg_no}} - {{$row->truck->truck_name}}</option>

                                                        @endforeach
                                                        @endif

                                                    </select>
                                                    </div>
                                                
                                                    <label
                                                    class="col-lg-2 col-form-label">Destination Truck</label>

                                                <div class="col-lg-4">
                                                    <select class="form-control type_id" name="destination_truck" required
                                                    id="">
                                                    <option value="">Select Destination</option>
                                                    @if(!empty($truck))
                                                    @foreach($truck as $row)

                                                    <option @if(isset($data))
                                                        {{ $data->destination_truck == $row->id  ? 'selected' : ''}}
                                                        @endif value="{{$row->id}}">{{$row->truck->reg_no}} - {{$row->truck->truck_name}}</option>

                                                    @endforeach
                                                    @endif
                                            </select>
                                                    </div>
                                                </div>
                                          
                                               
                                        <div class="form-group row">
                <label class="col-lg-2 col-form-label">Source Reading</label>

                <div class="col-lg-4">
                 <input type="text" name="source_reading" value="{{isset($data) ? $data->source_reading : ''}} "   class="form-control"  required>
                    
                </div>

               <label class="col-lg-2 col-form-label">Destination Reading</label>

                <div class="col-lg-4">
                 <input type="text" name="destination_reading" value="{{isset($data) ? $data->destination_reading : ''}}"   class="form-control"  required>
                    
                </div>
            </div>    



                                      <div class="form-group row">
                <label class="col-lg-2 col-form-label">Source Tire</label>

                <div class="col-lg-4">
                  @if(!empty($data->tyre_id))
                                   <select id="tyre" name="tyre_id" class="form-control tyre">
                                      <option >Select Source Tire</option>
                                       @foreach($list as $l)
                                  <option value="{{$l->id}}" @if(isset($data))@if($data->tyre_id == $l->id) selected @endif @endif >{{$l->reference}} </option>
                                   @endforeach
                                    </select>
                                   @else                              
                                  <select id="tyre" name="tyre_id" class="form-control tyre">
                                      <option >Select Tire</option>
                                    
                                    </select>
                                   @endif 
                    
                </div>

 <label class="col-lg-2 col-form-label">Destination Tire</label>

                <div class="col-lg-4">
                  @if(!empty($data->destination_tyre))
                                   <select id="destination_tyre" name="destination_tyre" class="form-control dest_tyre">
                                      <option >Select Destination Tire</option>
                                       @foreach($dest_list as $d_l)
                                  <option value="{{$d_l->id}}" @if(isset($data))@if($data->destination_tyre == $d_l->id) selected @endif @endif >{{$d_l->reference}} </option>
                                   @endforeach
                                    </select>
                                   @else                              
                                  <select id="destination_tyre" name="destination_tyre" class="form-control dest_tyre">
                                      <option value="">Select Destination Tire</option>
                                    
                                    </select>
                                   @endif 
                    
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
$(document).ready(function() {
    $('.dataTables-example').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
                extend: 'copy'
            },
            {
                extend: 'csv'
            },
            {
                extend: 'excel',
                title: 'ExampleFile'
            },
            {
                extend: 'pdf',
                title: 'ExampleFile'
            },

            {
                extend: 'print',
                customize: function(win) {
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
                }
            }
        ]

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
<script>
    $(document).ready(function() {
    
    
        $(document).on('change', '.truck_id', function() {
            var id = $(this).val();
            $.ajax({
                url: '{{url("findTyreDetails")}}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $("#tyre").empty();
                $("#tyre").append('<option value="">Select Source Tire</option>');
                $.each(data,function(key, value)
                {
                 
                    $("#tyre").append('<option value=' + value.id+ '>' + value.reference + ' - ' + value.position + ' Position</option>');
                   
                });
                }
    
            });
    
        });
    
    
    });
    </script>
    
  <script>
    $(document).ready(function() {
    
    
        $(document).on('change', '.type_id', function() {
            var id = $(this).val();
            $.ajax({
                url: '{{url("findTyreDetails")}}',
                type: "GET",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $("#destination_tyre").empty();
                $("#destination_tyre").append('<option value="">Select Destination Tire</option>');
                $.each(data,function(key, value)
                {
                 
                    $("#destination_tyre").append('<option value=' + value.id+ '>' + value.reference + ' - ' + value.position + ' Position</option>');
                   
                });
                }
    
            });
    
        });
    
    
    });
    </script>

<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection