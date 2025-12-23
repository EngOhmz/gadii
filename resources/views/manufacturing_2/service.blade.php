@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Service</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Service
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Service</a>
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
                                                    style="width: 98.1094px;">Km Reading</th>
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
                                            @if(!@empty($service))
                                            @foreach ($service as $row)
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
                                                    
                                                <td><a href="#minor{{$row->id}}" data-toggle="modal">{{$row->reading}}</a></td>
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
                                                    href="{{ route("service.approve", $row->id)}}" onclick="return confirm('Are you sure?')" title="Change Status">
                                                    <i class="fa fa-check"></i>
                                                </a>
                                                @endif
                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        href="{{ route("service.edit", $row->id)}}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                   
                                                    {!! Form::open(['route' => ['service.destroy',$row->id],
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
                                        <h5>Edit Service</h5>
                                        @else
                                        <h5>Add New Service</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                     @if(isset($id))
                                                {{ Form::model($id, array('route' => array('service.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'service.store']) }}
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
                                                    <label class="col-lg-2 col-form-label">Km Reading</label>
                                                   <div class="col-lg-4">
                                                    <input type="text" name="reading"
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->reading : ''}}"
                                                            class="form-control" required>
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

                                                <div class="form-group row">
                                                    <label
                                                    class="col-lg-2 col-form-label">Service History</label>

                                                <div class="col-lg-4">
                                                    <textarea name="history" 
                                            class="form-control" required>@if(isset($data)){{ $data->history }} @endif</textarea>
                                                </div>
                                                <label
                                                class="col-lg-2 col-form-label">Next Major Service</label>

                                            <div class="col-lg-4">
                                                <textarea name="major" 
                                        class="form-control" required>@if(isset($data)){{ $data->major }} @endif</textarea>
                                            </div>
                                            </div>

                                            <br>
                                            <h4 align="center">Enter Minor Service Details</h4>
                                            <hr>
                                            
                                            
                                            <button type="button" name="add" class="btn btn-success btn-xs add"><i
                                                    class="fas fa-plus"> Add item</i></button><br>
                                            <br>
                                            <div class="table-responsive">
                                            <table class="table table-bordered" id="cart">
                                                <thead>
                                                    <tr>
                                                        <th>Next Minor Service</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                </tbody>
                                                <tfoot>
                                                    @if(!empty($id))
                                                    @if(!empty($items))
                                                    @foreach ($items as $i)
                                                    <tr class="line_items">
                                                        
                                                       
                                        <td>
                                            <textarea name="minor[]" 
                                        class="form-control item_price{{$i->order_no}}" required style="margin-top:10px;">@if(isset($i)){{ $i->minor }} @endif</textarea>
                                         
                                            </td>

                                                                <input type="hidden" name="saved_id[]"
                                                                class="form-control item_saved{{$i->order_no}}"
                                                                value="{{ isset($i) ? $i->id : ''}}"
                                                                required />
                                                        <td><button type="button" name="remove"
                                                                class="btn btn-danger btn-xs rem"
                                                                value="{{ isset($i) ? $i->id : ''}}"><i
                                                                    class="fas fa-trash"></i></button></td>
                                                    </tr>

                                                    @endforeach
                                                    @endif
                                                    @endif

                                                </tfoot>    
                                            </table>
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

@if(!empty($service))
@foreach( $service as $row)
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
         Service History For {{$t->truck_name}}
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
                       <th>Km Reading</th>
                   <th>Service History</th>
                   <th>Status</th>
               </tr>
               </thead>

               <?php
                        

                        $history = \App\Models\Service::where('truck', $row->truck)->get();                                               
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
                                <td >{{$h->reading }}</td>
                                <td >{{$h->history }}</td>
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

@if(!empty($service))
@foreach( $service as $row)
<!-- Modal -->
<div class="modal inmodal " id="minor{{$row->id}}"  tabindex="-1" role="dialog" aria-hidden="true">
                     <div class="modal-dialog"><div class="modal-dialog" role="document">
<div class="modal-content">
   <div class="modal-header">
       <h5 class="modal-title"  style="text-align:center;"> 
        @php    
        $tr=App\Models\Truck::where('id', $row->truck)->get();   
      @endphp
         @foreach($tr as $t)
         Service History For {{$t->truck_name}}
        @endforeach
       </h5>

        
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">×</span>
       </button>
   </div>

   
   <div class="modal-body">

<div class="table-responsive">
    <table class="table table-bordered table-striped">
               <tr>                
                   <th> Next Major Service</th>
                   <td >{{$row->major}}</td>
               </tr>
                       </table>


                       <table class="table table-bordered table-striped">
<thead>

    
               <tr>
                <th>#</th>                 
                   <th>Next Minor Service</th>
               </tr>
               </thead>

               <?php
                        

                        $minor = \App\Models\ServiceItem::where('service_id', $row->id)->get();                                               
?>

<tbody>   
    
    @foreach($minor as $m)

                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td >{{$m->minor }}</td>
                               
                   
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


    
    <script type="text/javascript">
    $(document).ready(function() {
    
    
        var count = 0;
    
    
        $('.add').on("click", function(e) {
    
            count++;
            var html = '';
            html += '<tr class="line_items">';   
                  
            html += '<td><textarea name="minor[]" class="form-control item_price' + count +'" required  value="" style="margin-top:10px;"/></textarea></td>';
           
            html +='<td><button type="button" name="remove" class="btn btn-danger btn-xs remove"><i class="fas fa-trash"></i></button></td>';
    
            $('tbody').append(html);
           
        });
    
        $(document).on('click', '.remove', function() {
            $(this).closest('tr').remove();
           
        });
    
    
        $(document).on('click', '.rem', function() {
            var btn_value = $(this).attr("value");
            $(this).closest('tr').remove();
            $('tbody').append(
                '<input type="hidden" name="removed_id[]"  class="form-control name_list" value="' +
                btn_value + '"/>');
           
        });
    
    });
    </script>
    
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>
@endsection