@extends('layouts.master')


@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Task</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs" id="myTab2" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(empty($id)) active show @endif" id="home-tab2" data-toggle="tab"
                                    href="#home2" role="tab" aria-controls="home" aria-selected="true">Task
                                    List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if(!empty($id)) active show @endif" id="profile-tab2"
                                    data-toggle="tab" href="#profile2" role="tab" aria-controls="profile"
                                    aria-selected="false">New Task</a>
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
                                                    style="width: 156.484px;">Task Name</th>
                                               
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Platform(s): activate to sort column ascending"
                                                    style="width: 126.484px;">Category</th>
                                                 <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Start Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="Engine version: activate to sort column ascending"
                                                    style="width: 121.219px;">Due Date</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 148.1094px;">Assigned To</th> 
                                                    
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 128.1094px;">Status</th>
                                                <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                    rowspan="1" colspan="1"
                                                    aria-label="CSS grade: activate to sort column ascending"
                                                    style="width: 98.1094px;">Actions</th>
                                            </tr>
                                        </thead>
                                         <tbody>
                                            @if(!@empty($task))
                                            @foreach ($task as $row)
                                            <tr class="gradeA even" role="row">
                                                
                                                <td><a   href="{{ route("task.show",$row->id)}}">{{$row->task_name}}</a></td>
                                                @php $category = App\Models\Project\TaskCategory::find($row->category_id);  @endphp
                                                <td>{{$category->name}}</td>
                                                       <td>{{$row->task_start_date}}</td>
                                                  <td>{{$row->due_date}}</td>
                                                  
                                                <td>
                                                    <div class="form-inline">
                                                    <a class="nav-link"  href=""  data-toggle="modal" value="{{ $row->id}}" data-type="view" data-target="#appFormModal" onclick="model({{ $row->id }},'view')">View</a>
                                                    <a class="nav-link"  href=""  data-toggle="modal" value="{{ $row->id}}" data-type="assign" data-target="#appFormModal" onclick="model({{ $row->id }},'assign')"><i class="icon-plus-circle2"></i></a>
                                                     </div>
                                                </td>
                                                   
                                                   <td>{{$row->task_status}}</td>

                                                <td>
                                                    
                                                   <div class="form-inline">
                                                       
                                                        
<a class="list-icons-item text-primary" title="Edit"  href="{{ route("task.edit",$row->id)}}"><i class="icon-pencil7"></i></a>&nbsp
                                                       

                                                            {!! Form::open(['route' => ['task.destroy',$row->id], 'method' => 'delete']) !!}
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
                                        <h5>Create Task</h5>
                                        @else
                                        <h5>Edit Task</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">
                                                @if(isset($id))
                                                {{ Form::model($id, array('route' => array('task.update', $id), 'method' => 'PUT')) }}
                                                @else
                                                {{ Form::open(['route' => 'task.store']) }}
                                                @method('POST')
                                                @endif



                                                <div class="form-group row">
                           <label class="col-lg-2 col-form-label">Task Name</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="task_name" 
                                                            value="{{ isset($data) ? $data->task_name : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                      
                                                
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Category</label>
                                                    <div class="col-lg-6">
                                                <select class="m-b account_id" id="category_id" name="category_id" required>
                                                    <option value="">Select Category</option>                                                    
                                                            @foreach ($categories as $row)                                                             
                                                            <option value="{{$row->id}}" @if(isset($data))@if($data->category_id == $row->id) selected @endif @endif >{{$row->name}}</option>
                                                               @endforeach
                                                             </select>
                                                             
                                                             
                                                    </div>
                                                    
                                                    <div class="col-lg-2">
                                                            <div class="input-group-append">
                                                                <button class="btn btn-primary" type="button"
                                                                    data-toggle="modal" value=""
                                                                    data-target="#appFormModal"  href="appFormModal"><i class="icon-plus-circle2"></i></button>
                                                            </div>
                                                    </div>
                                                    
                                                </div>
                                                 
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Related To</label>
                                                    <div class="col-lg-8">
                                                <select class="m-b account_id related_class" id="goal_tracking_id" name="goal_tracking_id" required>
                                                              <option value="">Select Related</option>                                                     
                                                            <option value="Projects" @if(isset($data))@if($data->goal_tracking_id == 'Projects') selected @endif @endif >Projects</option>
                                                            <option value="Leads" @if(isset($data))@if($data->goal_tracking_id == 'Leads') selected @endif @endif >Leads</option>
                                                             </select>
                                                    </div>
                                                </div>
                                                
                                                <div id="projectDiv" style="display:none">
                                                
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Select Project</label>
                                                    <div class="col-lg-8">
                                                <select class="m-b account_id" id="project_id" name="project_id">
                                                    <option value="">Select Project</option>                                                    
                                                            @foreach ($project as $row)                                                             
                                                            <option value="{{$row->id}}" @if(isset($data))@if($data->project_id == $row->id) selected @endif @endif >{{$row->name}}</option>
                                                               @endforeach
                                                             </select>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Milestone</label>
                                                    <div class="col-lg-8">
                                                        <select class="m-b" id="milestone_id" name="milestone_id">
                                                            <option value="">Select Milestone</option>                                                    
                                                            @foreach ($milestones as $row)                                                             
                                                            <option value="{{$row->id}}" @if(isset($data))@if($data->milestone_id == $row->id) selected @endif @endif >{{$row->name}}</option>
                                                               @endforeach
                                                             </select>
                                                    </div>
                                                </div>
                                                
                                                </div>
                                                
                        
                                                
                                                <div id="leadsDiv" style="display:none">
                                                
                                                 <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Leads</label>
                                                    <div class="col-lg-8">
                                                <select class="m-b account_id" id="leads_id" name="leads_id">
                                                    <option value="">Select Leads</option>                                                    
                                                            @foreach ($leads as $row)                                                             
                                                            <option value="{{$row->id}}" @if(isset($data))@if($data->leads_id == $row->id) selected @endif @endif >{{$row->name}}</option>
                                                               @endforeach
                                                             </select>
                                                    </div>
                                                </div>
                                                
                                                </div>    
                                                
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Start Date</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="task_start_date" required
                                                            placeholder=""
                                                           value="{{ isset($data) ? $data->task_start_date : date('Y-m-d')}}" 
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                  <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Due Date</label>
                                                    <div class="col-lg-8">
                                                        <input type="date" name="due_date" required
                                                            placeholder=""
                                                           value="{{ isset($data) ? $data->due_date : date('Y-m-d')}}" 
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                              <!--  <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Hourly Rate</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="hourly_rate" required
                                                            placeholder=""
                                                          value="{{ isset($data) ? $data->hourly_rate : ''}}" 
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row">
                                                 <label class="col-lg-2 col-form-label">Estimated Hours</label>
                                                    <div class="col-lg-8">
                                                        <input type="numeric" name="estimated_hour" 
                                                            value="{{ isset($data) ? $data->estimated_hour : ''}}"
                                                            class="form-control">
                                                    </div>
                                                </div>  -->
                                                
                                                 <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Status</label>
                                                    <div class="col-lg-8">
                                                       <select class="m-b" id="bank_id" name="task_status" required>
                                                 
                                                                                                                     
                                                            <option value="Started" @if(isset($data))@if($data->task_status == 'Started') selected @endif @endif >Started</option>
                                                            
                                                             <option value="In Progress" @if(isset($data))@if($data->task_status == 'In Progress') selected @endif @endif >In Progress</option>
                                                             
                                                                <option value="Completed" @if(isset($data))@if($data->task_status == 'Completed') selected @endif @endif >Completed</option>
                                                                
                                                                
                                                              <option value="Deferred" @if(isset($data))@if($data->task_status == 'Deferred') selected @endif @endif >Deferred</option>
                                                              
                                                               <option value="Waiting For Someone" @if(isset($data))@if($data->task_status == 'Waiting For Someone') selected @endif @endif >Waiting For Someone</option>
                                                              
                                                              </select>
                                                    </div>
                                                </div>
                                                
                                                
                                              <!--  <div class="form-group row">
                                                    <label class="col-lg-2 col-form-label">Tags</label>
                                                    <div class="col-lg-8">
                                                        <input type="text" name="tags" required
                                                            placeholder=""
                                                           value="{{ isset($data) ? $data->tags : ''}}" 
                                                            class="form-control">
                                                    </div>
                                                </div> -->

                                                  <div class="form-group row">
                                                 <label class="col-lg-2 col-form-label">Task Description</label>
                                                    <div class="col-lg-8">
                                                    <textarea class="form-control" name="task_description">{{ isset($data) ? $data->task_description : ''}}</textarea>
                                                      
                                                    </div>
                                                </div>
                                                
                                     @if(!empty($data))
<?php
$list=explode(",", $data->assigned_to);
?>
@endif
                                                   <div class="form-group row">
                                                 <label class="col-lg-2 col-form-label">Assigned To</label>
                                                    <div class="col-lg-8">
                                                     @if(!empty($users))
                                                      <input type="checkbox" name="select_all"  id="example-select-all"> Select All <br>
                                            @foreach ($users as $row)
                                    <input name="trans_id[]" type="checkbox"  class="checks" value="{{$row->id}}" @if(!empty($data)) <?php if(in_array("$row->id",$list)){echo "checked";}?> @endif> {{$row->name}} &nbsp;
                                            @endforeach
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



<!-- supplier Modal -->
<div class="modal fade show" data-backdrop="" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="formModal">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               <form id="addClientForm" method="post" action="javascript:void(0)">
                  @csrf
                                 <div class="modal-body">

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12 ">

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Category Name</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="name"  id="name"                                                                
                                                                class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Description</label>

                                                        <div class="col-lg-10">
                                                            <input type="text" name="description" id="description"
                                                                class="form-control" >
                                                        </div>
                                                    </div>

                                                    
                 
               
                                             </div>
                                       </div>
                                    </div>


                                 </div>
        <div class="modal-footer bg-whitesmoke br">
            <button type="submit" class="btn btn-primary" id="save" onclick="saveCategory(this)" data-dismiss="modal">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>


       </form>

            </div>
        </div>
    </div>
</div>



@endsection

@section('scripts')




<script type="text/javascript">
$(document).ready(function() {

    $(document).on('change', '.related_class', function() {


        var id = $(this).val();

        if (id == 'Projects') {
            $('#projectDiv').show();
            $('#leadsDiv').hide();
        } else if (id == 'Leads') {
            $('#projectDiv').hide();
            $('#leadsDiv').show();
        }


    });
});
</script>

<script>

$("#example-select-all").click(function() {
  $("input[type=checkbox]").prop("checked", $(this).prop("checked"));
});

$("input[type=checkbox]").click(function() {
  if (!$(this).prop("checked")) {
    $("#example-select-all").prop("checked", false);
  }
});


</script>


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

<script type="text/javascript">
    function model(id,type) {

    $.ajax({
        type: 'GET',
         url: '{{url("project/taskModal")}}',
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

function saveCategory(e) {
     
     var name = $('#name').val();
     var description = $('#description').val();
     
          $.ajax({
            type: 'GET',
            url: '{{url("project/addCategory")}}',
             data: {
                 'name':name,
                 'description':description,
             },
                dataType: "json",
             success: function(response) {
                console.log(response);

                               var id = response.id;
                             var name = response.name;

                             var option = "<option value='"+id+"'  selected>"+name+" </option>"; 

                             $('#category_id').append(option);
                              $('#appFormModal').hide();
                   
                               
               
            }
        });
}

</script>
<script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

@endsection