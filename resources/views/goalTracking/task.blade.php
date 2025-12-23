<div class="card-header"> <strong></strong> </div>

<div class="card-body">
    <ul class="nav nav-tabs" id="myTab2" role="tablist">
        <li class="nav-item">
            <a class="nav-link  @if (
                    $type == 'details' ||
                    $type == 'comments' ||
                    $type == 'task' ||
                    $type == 'milestone') active @endif" id="home-tab2" data-toggle="tab"
                href="#task-home2" role="tab" aria-controls="home" aria-selected="true">Tasks
                List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($type == 'edit-task') active @endif" id="profile-tab2" data-toggle="tab"
                href="#task-profile2" role="tab" aria-controls="profile" aria-selected="false">New Tasks</a>
        </li>

    </ul>
    <br>
    <div class="tab-content tab-bordered" id="myTab3Content">
        <div class="tab-pane fade @if (
                $type == 'details' ||
                $type == 'comments'||
                $type == 'task'||
                $type == 'milestone') active show @endif " id="task-home2" role="tabpanel"
            aria-labelledby="home-tab2">
            <div class="table-responsive">
                <table class="table datatable-basic table-striped" style="width:100%">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 156.484px;">#</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 156.484px;">Task Name</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 126.484px;">Category</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">Start Date</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">Due Date</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                style="width: 128.1094px;">Status</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                style="width: 98.1094px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (!@empty($task))
                            @foreach ($task as $row)
                                <tr class="gradeA even" role="row">
                                    <td>{{ $loop->iteration }}</td>
                                    <td><a href="{{ route('goal_task.show', $row->id) }}">{{ $row->task_name }}</a></td>
                                    @php $category = App\Models\Goal_Tracking\TaskCategory::find($row->category_id);  @endphp
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $row->task_start_date }}</td>
                                    <td>{{ $row->due_date }}</td>
                                    <td>{{ $row->task_status }}</td>
                                    <td>
                                        <div class="form-inline">
                                            <a class="list-icons-item text-primary" title="Edit"
                                                href="{{ route('edit.goal_details', ['type' => 'edit-task', 'type_id' => $row->id]) }}"><i
                                                    class="icon-pencil7"></i></a>&nbsp
                                                    
                                            <a class="list-icons-item text-danger" title="Edit"
                                                href="{{ route('delete.goal_details', ['type' => 'delete-tasks', 'type_id' => $row->id]) }}"
                                                onclick="return confirm('Are you sure, you want to delete?')"><i
                                                    class="icon-trash"></i></a>&nbsp
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        @endif

                    </tbody>

                </table>
            </div>
        </div>
        <div class="tab-pane fade  @if ($type == 'edit-task') active show @endif" id="task-profile2"
            role="tabpanel" aria-labelledby="profile-tab2">
            <br>
            <div class="card">
                <div class="card-header">
                    @if ($type == 'edit-task')
                        <h5>Edit Tasks</h5>
                    @else
                        <h5>Add NewTasks</h5>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 ">
                            @if ($type == 'edit-task')
                                {!! Form::open(['route' => 'update.goal_details', 'enctype' => 'multipart/form-data']) !!}
                                <input type="hidden" name="id" value="{{ $type_id }}">
                            @else
                                {!! Form::open(['route' => 'save.goal_details', 'enctype' => 'multipart/form-data']) !!}
                                @method('POST')
                            @endif


                            <input type="hidden" name="goal_id" value="{{ $id }}">
                            <input type="hidden" name="type" value="task">

                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Task Name <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="text" name="task_name"
                                        value="{{ isset($edit_data) ? $edit_data->task_name : '' }}"
                                        class="form-control" required>
                                </div>


                                <label class="col-lg-2 col-form-label">Category <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <select class="m-b category_id" id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @if (!empty($categories))
                                            @foreach ($categories as $row)
                                                <option value="{{ $row->id }}"
                                                    @if (isset($edit_data)) @if ($edit_data->category_id == $row->id) selected @endif
                                                    @endif >{{ $row->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>

                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" data-toggle="modal"
                                            value="" data-target="#betaFormModal" href="betaFormModal"><i
                                                class="icon-plus-circle2"></i></button>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Milestone </label>
                                <div class="col-lg-4">
                                    <select class="m-b" id="milestone_id" name="milestones_id">
                                        <option value="">Select Milestone</option>
                                        @if (!empty($mile))
                                            @foreach ($mile as $row)
                                                <option value="{{ $row->id }}"
                                                    @if (isset($edit_data)) @if ($edit_data->milestone_id == $row->id) selected @endif
                                                    @endif >{{ $row->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>


                                <label class="col-lg-2 col-form-label">Assigned to <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="checkbox" name="select_all" id="example-select-all"> Select All<br>
                                    @if (!empty($user))
                                        @foreach ($user as $row)
                                            <input name="trans_id[]" type="checkbox" class="checks"
                                                value="{{ $row->id }}"> {{ $row->name }} &nbsp;
                                        @endforeach
                                    @endif
                                    </select>

                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Start Date <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="date" name="task_start_date" required placeholder=""
                                        value="{{ isset($edit_data) ? $edit_data->task_start_date : date('Y-m-d') }}"
                                        class="form-control">
                                </div>
                                <label class="col-lg-2 col-form-label">End Date<span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <input type="date" name="due_date" required placeholder=""
                                        value="{{ isset($edit_data) ? $edit_data->due_date : date('Y-m-d') }}"
                                        class="form-control">
                                </div>


                            </div>


                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Status <span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-4">
                                    <select class="m-b" id="bank_id" name="task_status" required>
                                        <option value="">Select Status</option>
                                        <option value="Started"
                                            @if (isset($edit_data)) @if ($edit_data->task_status == 'Started') selected @endif
                                            @endif >Started</option>
                                        <option value="In Progress"
                                            @if (isset($edit_data)) @if ($edit_data->task_status == 'In Progress') selected @endif
                                            @endif >In Progress</option>
                                        <option value="Completed"
                                            @if (isset($edit_data)) @if ($edit_data->task_status == 'Completed') selected @endif
                                            @endif >Completed</option>
                                        <option value="Deferred"
                                            @if (isset($edit_data)) @if ($edit_data->task_status == 'Deferred') selected @endif
                                            @endif >Deferred</option>
                                        <option value="Waiting For Someone"
                                            @if (isset($edit_data)) @if ($edit_data->task_status == 'Waiting For Someone') selected @endif
                                            @endif >Waiting For Someone</option>
                                    </select>
                                </div>
                                <label class="col-lg-2 col-form-label">Task Description</label>
                                <div class="col-lg-4">
                                    <textarea class="form-control" name="task_description">{{ isset($edit_data) ? $edit_data->task_description : '' }}</textarea>

                                </div>
                            </div>



                            <div class="form-group row">
                                <div class="col-lg-offset-2 col-lg-12">
                                    @if ($type == 'edit-task')
                                        <button class="btn btn-sm btn-primary float-right m-t-n-xs"
                                            data-toggle="modal" data-target="#myModal" type="submit">Update</button>
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

<div class="modal fade show" data-backdrop="" id="betaFormModal" tabindex="-1" role="dialog" aria-hidden="true">
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

<script>
function saveCategory(e) {
     
     var name = $('#name').val();
     var description = $('#description').val();
          $.ajax({
            type: 'GET',
            url: '{{url("goalTracking/addCategory")}}',
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
                              $('#betaFormModal').hide();
                   
                               
               
            }
        });
}
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