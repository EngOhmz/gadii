@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Milestone</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Milestone
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Milestone</a>
                            </li>

                        </ul>
                        <div class="tab-content tab-bordered" id="myTab3Content">
                            <div class="tab-pane fade @if(empty($id)) active show @endif" id="home2" role="tabpanel"
                                aria-labelledby="home-tab2">
                                <div class="table-responsive">
<!--
                                  <table border="0" cellspacing="15" cellpadding="20">
        <tbody>

<tr>
                 <td></td><td></td><td></td>
        <td><b>Date Filter</b></td><td></td><td><b>Minimum date:</b></td>
            <td><input type="text" id="min" name="min"   class="form-control "></td>
       
            <td><b>Maximum date:</b></td>
            <td><input type="text" id="max" name="max"   class="form-control "></td>
        </tr>
    </tbody></table>
-->
                                  <table class="table datatable-basic table-striped">
                                       <thead>
                                            <tr>
                                              

                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Milestone Name</th>
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">Start Date</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 141.219px;">End Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                            @if(!@empty($milestones))
                                            @foreach ($milestones as $row)
                                            <tr class="gradeA even" role="row">
                                                
                                                     <td>{{$row->name}}</td>
                                                     
                                                <td>{{$row->start_date}}</td>                                           
                                                  
                                                   <td>{{$row->end_date}}</td>

                                                <td>
                                                    
                                                   <div class="form-inline">
                                                       
                                                        
<a class="list-icons-item text-primary" title="Edit"  href="{{ route("milestone.edit",$row->id)}}"><i class="icon-pencil7"></i></a>&nbsp
                                                       

                                                            {!! Form::open(['route' => ['milestone.destroy',$row->id], 'method' => 'delete']) !!}
                                                           {{ Form::button('<i class="icon-trash"></i>', ['type' => 'submit', 'style' => 'border:none;background: none;', 'class' => 'list-icons-item text-danger', 'title' => 'Delete', 'onclick' => "return confirm('Are you sure?')"]) }}
                                                    {{ Form::close() }}
&nbsp
                                                       
                   
                            
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
                                        <h5>Create Milestone</h5>
                                        @else
                                        <h5>Edit Milestone</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('milestone.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'milestone.store']) }}
                                                @method('POST')
                                                @endif

                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Milestone Name</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="name" 
                                                            value="{{ isset($data) ? $data->name : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                                

                                                <div class="form-group row">
                                                <label class="col-lg-2 col-form-label">Milestone Description </label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="description " 
                                                            value="{{ isset($data) ? $data->description : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>

                                                
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Project</label>
                                                    <div class="col-lg-8">
                                                <select class="m-b account_id" id="project_id" name="project_id" required>
                                                    <option value="">Select Project </option>                                                    
                                                            @foreach ($project as $row)                                                             
                                                            <option value="{{$row->id}}" @if(isset($data))@if($data->project_id == $row->id) selected @endif @endif >{{$row->project_name}}</option>
                                                               @endforeach
                                                             </select>
                                                    </div>
                                                </div>
                                                 <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Select Responsible</label>
                                                    <div class="col-lg-8">
                                                <select class="m-b account_id" id="user_id" name="user_id" required>
                                                    <option value="">Select Responsible</option>                                                    
                                                            @foreach ($users as $row)                                                             
                                                            <option value="{{$row->id}}" @if(isset($data))@if($data->user_id == $row->id) selected @endif @endif >{{$row->name}}</option>
                                                               @endforeach
                                                             </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Start Date</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="start_date" required
                                                            placeholder=""
                                                           value="{{ isset($data) ? $data->start_date : date('Y-m-d')}}" 
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                  <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">End Date</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="end_date" required
                                                            placeholder=""
                                                           value="{{ isset($data) ? $data->end_date : date('Y-m-d')}}" 
                                                            class="form-control">
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
<script>
var minDate, maxDate;
 
// Custom filtering function which will search data in column four between two values
$.fn.dataTable.ext.search.push(
    function( settings, data, dataIndex ) {
        var min = minDate.val();
        var max = maxDate.val();
        var date = new Date( data[5] );
 
        if (
            ( min === null && max === null ) ||
            ( min === null && date <= max ) ||
            ( min <= date   && max === null ) ||
            ( min <= date   && date <= max )
        ) {
            return true;
        }
        return false;
    }
);



</script>
<script>
$(document).ready(function() {

    $(document).on('change', '.account_id', function() {
        var id = $(this).val();
  console.log(id);
      
 $.ajax({
            url: '{{url("gl_setup/findSupplier")}}',
            type: "GET",
            data: {
                id: id,
            },
 dataType: "json",
            success: function(data) {
              console.log(data); 
          $("#supplier").css("display", "none");
         if (data == 'OK') {
           $("#supplier").css("display", "block");   
}
     

 }

        });

    });



});

</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection