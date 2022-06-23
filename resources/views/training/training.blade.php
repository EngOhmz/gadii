@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Training</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                         
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Training
                                    List</a>
                            </li>
                           
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Training</a>
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
                                                    style="width: 186.484px;">Course/Training</th>
                                                     <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 186.484px;">Vendor</th>
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
                                            @if(!@empty($training))
                                            @foreach ($training as $row)
                                            <tr class="gradeA even" role="row">

                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>{{$row->staff->name}}</td>
                                                <td>{{$row->training_name}}</td>
                                                 <td>{{$row->vendor_name}}</td>

                                                 <td>
                                                    
                                                    {{Carbon\Carbon::parse($row->start_date)->format('d/m/Y')}} - {{Carbon\Carbon::parse($row->end_date)->format('d/m/Y')}} 
                                        
                                                </td>

                                                 <td>
                                                    @if($row->status== 0)
                                                    <div class="badge badge-warning badge-shadow">Pending</div>
                                                    @elseif($row->status == 1)
                                                    <div class="badge badge-info badge-shadow">Started</div>
                                                    @elseif($row->status == 2)
                                                    <div class="badge badge-success badge-shadow">Completed</div>
                                                     @elseif($row->status == 3)
                                                    <div class="badge badge-danger badge-shadow">Terminated</div>

                                                    @endif
                                                </td>
                                               
                                               

                                                <td>
                                                   @if($row->status == 1 || $row->status == 0)
                                                    <a class="btn btn-xs btn-outline-info text-uppercase px-2 rounded"
                                                        title="Edit" onclick="return confirm('Are you sure?')"
                                                        href="{{ route('training.edit', $row->id)}}"><i
                                                            class="fa fa-edit"></i></a>
                                                           

                                                    {!! Form::open(['route' => ['training.destroy',$row->id],
                                                    'method' => 'delete']) !!}
                                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-xs btn-outline-danger text-uppercase px-2 rounded demo4', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}

                                                      
                                                    <div class="btn-group">
                                                        <button class="btn btn-xs btn-success dropdown-toggle"
                                                            data-toggle="dropdown">Change Status<span
                                                                class="caret"></span></button>
                                                        <ul class="dropdown-menu animated zoomIn">
                                                            
                                                            <li class="nav-item"><a class="nav-link"  onclick="return confirm('Are you sure?')"
                                                              href="{{ route('training.start',$row->id)}}">Started
                                                                    </a></li>   
                                                                 
                                                            <li class="nav-item"><a class="nav-link"  onclick="return confirm('Are you sure?')"
                                                              href="{{ route('training.approve',$row->id)}}">Completed
                                                                    </a></li>                          
                                                                  

                                                                   
                                                                       <li class="nav-item"><a class="nav-link" href="{{ route('training.reject',$row->id)}}"
                                                                        role="tab"
                                                                        aria-selected="false" onclick="return confirm('Are you sure?')">Terminated
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
                                        <h5>Create Training</h5>
                                        @else
                                        <h5>Edit Training</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('training.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'training.store']) }}
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
                                                    <label class="col-lg-2 col-form-label">Course/Training</label>
                                                    <div class="col-lg-4">
                                                        
                                                            <input type="text" name="training_name"  value="{{ isset($data) ? $data->training_name: ''}}"
                                                            class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Vendor</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" name="vendor_name"  value="{{ isset($data) ? $data->vendor_name: ''}}"
                                                            class="form-control" required>
                                                    </div>



                                                <label class="col-lg-2 col-form-label">Start Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date"  name="start_date"
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->start_date : ''}}"
                                                            class="form-control" required>
                                                    </div>

                                                   
                                                </div>

                                        
                                         <div class="form-group row end">
                                                    <label class="col-lg-2 col-form-label">End Date</label>
                                                    <div class="col-lg-4">
                                                        <input type="date"  name="end_date"
                                                            placeholder=""
                                                            value="{{ isset($data) ? $data->end_date : ''}}"
                                                            class="form-control" required>
                                                    </div>
                                           <label class="col-lg-2 col-form-label">Performance</label>
                                                    <div class="col-lg-4">
                                                        
                                                            <select class="form-control" name="performance" 
                                                                id="route">
                                                               <option value="0" @if(isset($data)){{  $data->performance == '0'  ? 'selected' : ''}}  @endif >Not Concluded</option>
                                                                                    <option value="1" @if(isset($data)){{  $data->performance == '1'  ? 'selected' : ''}}  @endif >Satisfactory</option>
                                                                                    <option value="2" @if(isset($data)){{  $data->performance == '2'  ? 'selected' : ''}}  @endif >Average</option> 
                                                                                    <option value="3" @if(isset($data)){{  $data->performance == '3'  ? 'selected' : ''}}  @endif >Poor</option>
                                                                                    <option value="4" @if(isset($data)){{  $data->performance  == '4'  ? 'selected' : ''}}  @endif >Excellent</option>
                                                                                   

                                                            </select>
                                                           
                                                    </div>
                                            </div>
                                         

                                            
                                         

                                         
                                                 <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Remarks</label>
                                                    <div class="col-lg-4">
                                                       <textarea id="present" name="remarks" class="form-control" rows="6" data-parsley-id="25">{{ isset($data) ? $data->reason : ''}}</textarea>
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
                                                    <label class="col-lg-2 col-form-label">Training Cost</label>
                                                    <div class="col-lg-4">
                                                        <input type="number"  steps="0.01" name="training_cost"  value="{{ isset($data) ? $data->training_cost: ''}}"
                                                            class="form-control" required>
                                                    </div>
                                                      </div>
                                                
                                                <div class="form-group row">
                                                    <div class="col-lg-offset-2 col-lg-12">
                                                        @if(!@empty($id))

                                                        <a class="btn btn-sm btn-danger float-right m-t-n-xs"
                                                            href="{{ route('training.index')}}">
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








  




@endsection