@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Leave</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                         
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Leave
                                    List</a>
                            </li>
                           
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Leave</a>
                            </li>
                           

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
                               
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">#</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Staff Name</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Leave Category</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Duration</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Status</th>


                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!@empty($leave))
                                            @foreach ($leave as $row)
                                            <tr class="gradeA even" role="row">

                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>{{$row->staff->name}}</td>
                                                <td>{{$row->category->leave_category}}</td>

                                                 <td>
                                                    @if($row->leave_type == 'single_day')
                                                    {{Carbon\Carbon::parse($row->leave_start_date)->format('d/m/Y')}} (1 Day)
                                                    @elseif($row->leave_type == 'multiple_days')

                                                     <?php 
                                                $start = strtotime($row->leave_start_date);
                                                $end = strtotime($row->leave_end_date);

                                                $days_between = ceil(abs($end - $start) / 86400);
                                                        ?>

 
                                                    {{Carbon\Carbon::parse($row->leave_start_date)->format('d/m/Y')}} - {{Carbon\Carbon::parse($row->leave_end_date)->format('d/m/Y')}} ({{ $days_between}} days)
                                                    @elseif($row->leave_type == 'hours')
                                                     {{Carbon\Carbon::parse($row->leave_start_date)->format('d/m/Y')}} ({{$row->hours}} hours)
                                                    

                                                    @endif
                                                </td>

                                                 <td>
                                                    @if($row->application_status== 1)
                                                    <div class="badge badge-info badge-shadow">Pending</div>
                                                    @elseif($row->application_status == 2)
                                                    <div class="badge badge-success badge-shadow">Accepted</div>
                                                    @elseif($row->application_status == 3)
                                                    <div class="badge badge-danger badge-shadow">Rejected</div>
                                                    

                                                    @endif
                                                </td>
                                               
                                               

                                                <td>
                                                   @if($row->application_status == 1)
                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        title="Edit" onclick="return confirm('Are you sure?')"
                                                        href="{{ route('leave.edit', $row->id)}}"><i
                                                            class="fa fa-edit"></i></a>
                                                           

                                                    {!! Form::open(['route' => ['leave.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}

                                                         @endif


                                                     @if($row->application_status == 1)
                                                    <div class="btn-group">
                                                        <button class="btn btn-xs btn-success dropdown-toggle"
                                                            data-toggle="dropdown">Change<span
                                                                class="caret"></span></button>
                                                        <ul class="dropdown-menu animated zoomIn">
                                                            

                                                                 
                                                            <li class="nav-item"><a class="nav-link"  onclick="return confirm('Are you sure?')"
                                                              href="{{ route('leave.approve',$row->id)}}">Approve
                                                                    </a></li>                          
                                                                  

                                                                   
                                                                       <li class="nav-item"><a class="nav-link" href="{{ route('leave.reject',$row->id)}}"
                                                                        role="tab"
                                                                        aria-selected="false" onclick="return confirm('Are you sure?')">Reject
                                                                            </a></li>
                                                                           
                                                        </ul>
                                                    </div>
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
                                        @if(empty($id))
                                        <h5>Create Leave</h5>
                                        @else
                                        <h5>Edit Leave</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('leave.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'leave.store']) }}
                                                @method('POST')
                                                @endif




                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Staff</label>
                                                    <div class="col-lg-4">
                                                        <select class="form-control" name="staff_id" required
                                                        id="supplier_id">
                                                        <option value="">Select</option>
                                                        @if(!empty($staff))
                                                        @foreach($staff as $row)

                                                        <option @if(isset($data))
                                                            {{  $data->staff_id == $row->id  ? 'selected' : ''}}
                                                            @endif value="{{ $row->id}}">{{$row->name}}</option>

                                                        @endforeach
                                                        @endif

                                                    </select>
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Leave Category</label>
                                                    <div class="col-lg-4">
                                                        <div class="input-group">
                                                            <select class="form-control" name="leave_category_id" required
                                                                id="route">
                                                                <option value="">Select</option>
                                                                @if(!empty($category))
                                                                @foreach($category as $row)

                                                                <option @if(isset($data))
                                                                    {{  $data->leave_category_id == $row->id  ? 'selected' : ''}}
                                                                    @endif value="{{ $row->id}}">{{$row->leave_category}}</option>

                                                                @endforeach
                                                                @endif

                                                            </select>
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary" type="button"
                                                                    data-toggle="modal" href="routeModal"  
                                                                    data-target="#routeModal"><i
                                                                        class="fa fa-plus-circle"></i></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Leave Type</label>
                                                    <div class="col-lg-4">
                                                        <input type="radio" name="leave_type" value="single_day"  {{(!empty($data))?($data->leave_type =='single_day')?'checked':'':''}} checked="" class="type" >Single day
                                    <input type="radio" name="leave_type" value="multiple_days" {{(!empty($data))?($data->leave_type =='multiple_days')?'checked':'':''}}  class="type" > Multiple days
                                    <input type="radio" name="leave_type" value="hours" class=" type" {{(!empty($data))?($data->leave_type =='hours')?'checked':'':''}}>    Hours
                                
                                                    </div>



                                                <label class="col-lg-2 col-form-label">Start Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date"  name="leave_start_date"
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->leave_start_date : ''}}"
                                                            class="form-control" required>
                                                    </div>

                                                   
                                                </div>

                                        @if(!empty($data->leave_end_date))
                                         <div class="form-group row end">
                                                    <label class="col-lg-2 col-form-label">End Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date"  name="leave_end_date"
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->leave_end_date : ''}}"
                                                            class="form-control">
                                                    </div>
                                            </div>
                                          @else
                                               <div class="form-group row end" style="display:none">
                                                    <label class="col-lg-2 col-form-label">End Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date"  name="leave_end_date"
                                                            placeholder=""
                                                            value=""
                                                            class="form-control">
                                                    </div>
                                            </div>
                                         @endif

                                             @if(!empty($data->hours))
                                          <div class="form-group row hour" >
                                                    <label class="col-lg-2 col-form-label">Hours</label>
                                                    <div class="col-lg-4">
                                                        
                                                            <select class="form-control" name="hours" 
                                                                id="route">
                                                                <option value="">Select</option>
                                                               <option value="1" @if(isset($data)){{  $data->hours == '1'  ? 'selected' : ''}}  @endif >01</option>
                                                                                    <option value="2" @if(isset($data)){{  $data->hours == '2'  ? 'selected' : ''}}  @endif >02</option>
                                                                                    <option value="3" @if(isset($data)){{  $data->hours == '3'  ? 'selected' : ''}}  @endif >03</option>
                                                                                    <option value="4" @if(isset($data)){{  $data->hours == '4'  ? 'selected' : ''}}  @endif >04</option>
                                                                                    <option value="5" @if(isset($data)){{  $data->hours == '5'  ? 'selected' : ''}}  @endif >05</option>
                                                                                    <option value="6" @if(isset($data)){{  $data->hours == '6'  ? 'selected' : ''}}  @endif >06</option>
                                                                                    <option value="7" @if(isset($data)){{  $data->hours == '7'  ? 'selected' : ''}}  @endif >07</option>
                                                                                    <option value="8"@if(isset($data)){{  $data->hours == '8'  ? 'selected' : ''}}  @endif  >08</option>

                                                            </select>
                                                           
                                                    </div>
                                                </div>

                                          @else
                                          <div class="form-group row hour" style="display:none">
                                                    <label class="col-lg-2 col-form-label">Hours</label>
                                                    <div class="col-lg-4">
                                                        
                                                            <select class="form-control" name="hours" 
                                                                id="route">
                                                                <option value="">Select</option>
                                                               <option value="1">01</option>
                                                                                    <option value="2">02</option>
                                                                                    <option value="3">03</option>
                                                                                    <option value="4">04</option>
                                                                                    <option value="5">05</option>
                                                                                    <option value="6">06</option>
                                                                                    <option value="7">07</option>
                                                                                    <option value="8">08</option>

                                                            </select>
                                                           
                                                    </div>
                                                </div>
                                       @endif

                                                 <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Reason</label>
                                                    <div class="col-lg-4">
                                                       <textarea id="present" name="reason" class="form-control" rows="6" data-parsley-id="25">{{ isset($data) ? $data->reason : ''}}</textarea>
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">Attachment</label>
                                                    <div class="col-lg-4">
                                                        
                                                           <input type="file" name="attachment" class="form-control"
                                                                id="attachment"
                                                                value=" "
                                                                placeholder="">
                                                          
                                                    </div>
                                                </div>

                                                
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))

                                                        <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                            href="{{ route('leave.index')}}">
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
</section>





<!-- route Modal -->
<div class="modal inmodal show" id="routeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Leave Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
  <form id="addRouteForm" method="post" action="javascript:void(0)">
            @csrf
                <div class="modal-body">
                    <p><strong>Make sure you enter valid information</strong> .</p>

                   

                    <div class="form-group row"><label class="col-lg-2 col-form-label">Leave Category</label>

                        <div class="col-lg-10">
                            <input type="text" name="leave_category" id="category" class="form-control category">
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary route">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>

                 </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>

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
</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>


<script>
    $(document).ready(function(){
   

 $(document).on('change', '.type', function(){
var id=$(this).val() ;
console.log(id);
         if($(this).val() == 'multiple_days') {
          $('.end').show(); 
            $('.hour').hide();
        } else if($(this).val() == 'hours') {
            $('.hour').show(); 
           $('.end').hide();
        } 
   else  {
            $('.hour').hide(); 
           $('.end').hide();
        } 
});


$('.route').click(function (event){
event.preventDefault();
       var leave_category= $('.category').val();
      $.ajax({
        type: "POST",
         url: '{{url("addCategory")}}',
             data: {
                 'leave_category':leave_category,
            _token: '{!! csrf_token() !!}',
        },
    dataType: "json",
        success: function(response) {
                console.log(response);
          // do whatever you want with a successful response
                        var id = response.id;
                             var arrival_point = response.leave_category;

                             var option = "<option value='"+id+"'  selected>"+arrival_point+"</option>"; 
                       //$('#routeModal').hide();
                             $('#route').append(option);
                             
        }
      });
    });




    });
</script>






  




@endsection