@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Maintainance</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Maintainance
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Maintainance</a>
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
                                                    style="width: 141.219px;">Truck</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Driver</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Type</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Mechanical</th>
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
                                            @if(!@empty($maintain))
                                            @foreach ($maintain as $row)
                                            <tr class="gradeA even" role="row">
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{Carbon\Carbon::parse($row->date)->format('M d, Y')}}</td>
                                                <td>
                                                    @php    
                                                    $tr=App\Models\Truck::where('id', $row->truck)->get();   
                                                  @endphp
                                                     @foreach($tr as $t)
                                                     <a href="#view{{$row->truck}}" data-toggle="modal">{{$t->truck_name}}</a>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @php    
                                                    $driver=App\Models\Driver::where('id', $row->driver)->get();   
                                                  @endphp
                                                     @foreach($driver as $d)
                                                    {{$d->driver_name}}
                                                    @endforeach
                                                </td>
                                                    
                                                <td>{{$row->type}}</td>
                                                <td>
                                                    @php    
                                                    $st=App\Models\FieldStaff::where('id', $row->mechanical)->get();   
                                                  @endphp
                                                     @foreach($st as $s)
                                                    {{$s->name}}
                                                    @endforeach
                                                </td>

                                                      <td>
                                                    @if($row->status == 0)
                                                    <div class="badge badge-danger badge-shadow">Incomplete</div>
                                                    @elseif($row->status == 1)
                                                    <div class="badge badge-success badge-shadow">Complete</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($row->status == 0)
                                                    <a class="btn btn-xs btn-outline-primary text-uppercase px-2 rounded"
                                                    href="{{ route("maintainance.approve", $row->id)}}" onclick="return confirm('Are you sure?')" title="Change Status">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                                @endif
                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        href="{{ route("maintainance.edit", $row->id)}}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                   

                                                    {!! Form::open(['route' => ['maintainance.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}

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
                                        <h5>Edit Maintainance</h5>
                                        @else
                                        <h5>Add New Maintainance</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     @if(isset($id))
                                                {{ Form::model($id, array('route' => array('maintainance.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'maintainance.store']) }}
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
                                                
                                                    <label class="col-lg-2 col-form-label">Truck</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control" name="truck" required
                                                                id="supplier_id">
                                                        <option value="">Select Truck Name</option>
                                                        @if(!empty($truck))
                                                        @foreach($truck as $row)

                                                        <option @if(isset($data))
                                                            {{ $data->truck == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{$row->id}}">{{$row->truck_name}}</option>

                                                        @endforeach
                                                        @endif

                                                    </select>
                                                    </div>
                                                </div>

                                                

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Type</label>
                                                   <div class="col-lg-4">
                                                    <select class="form-control" name="type" required
                                                    id="supplier_id">
                                                    <option value="">Select Type</option>
                                                    <option @if(isset($data))
                                                        {{$data->type == 'Minor'  ? 'selected' : ''}}
                                                        @endif value="Minor">Minor</option>
                                                        <option @if(isset($data))
                                                        {{$data->type == 'Major'  ? 'selected' : ''}}
                                                        @endif value="Major">Major</option>
                                                      
                                                </select>
                                                    </div>
                                                
                                               
                                             
                                                    <label
                                                        class="col-lg-2 col-form-label">Mechanical</label>

                                                    <div class="col-lg-4">
                                                        <select class="form-control" name="mechanical" required
                                                        id="supplier_id">
                                                <option value="">Select Mechanical</option>
                                                @if(!empty($staff))
                                                @foreach($staff as $row)

                                                <option @if(isset($data))
                                                    {{$data->mechanical == $row->id  ? 'selected' : ''}}
                                                    @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                @endforeach
                                                @endif

                                            </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row"><label
                                                    class="col-lg-2 col-form-label">Reason</label>

                                                <div class="col-lg-10">
                                                    <textarea name="reason" 
                                            class="form-control" required>@if(isset($data)){{ $data->reason }} @endif</textarea>
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

@if(!empty($maintain))
@foreach( $maintain as $row)
<!-- Modal -->
<div class="modal inmodal " id="view{{$row->truck}}"  tabindex="-1" role="dialog" aria-hidden="true">
                     <div class="modal-dialog"><div class="modal-dialog" role="document">
<div class="modal-content">
   <div class="modal-header">
       <h5 class="modal-title"  style="text-align:center;"> 
        @php    
        $tr=App\Models\Truck::where('id', $row->truck)->get();   
      @endphp
         @foreach($tr as $t)
         Maintainance History For {{$t->truck_name}}
        @endforeach
        <h5>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">×</span>
       </button>
   </div>


   <div class="modal-body">
<div class="table-responsive">
                       <table class="table table-bordered table-striped">
<thead>
               <tr>
                <th>#</th>
                  <th>Date</th>
                       <th>Driver</th>
                       <th>Type</th>
                   <th>Reason</th>
                   <th>Status</th>
               </tr>
               </thead>

               <?php
                        

                        $history = \App\Models\Maintainance::where('truck', $row->truck)->get();                                               
?>

<tbody>   
    @foreach($history as $h)

                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{Carbon\Carbon::parse($h->date)->format('M d, Y')}}</td>
                              
                                <td>
                                    @php    
                                    $driver=App\Models\Driver::where('id', $h->driver)->get();   
                                  @endphp
                                     @foreach($driver as $d)
                                    {{$d->driver_name}}
                                    @endforeach
                                </td>
                                <td >{{$h->type }}</td>
                   <td >{{$h->reason }}</td>
                   
                   <td>
                    @if($h->status == 0)
                    <div class="badge badge-danger badge-shadow">Incomplete</div>
                    @elseif($h->status == 1)
                    <div class="badge badge-success badge-shadow">Complete</div>
                    @endif
                </td>
                   
               </tr> 
               @endforeach

                   </tbody>
                       </table>
                      </div>

   </div>
  
</div>
</div></div>
</div>

@endforeach
@endif

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
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection