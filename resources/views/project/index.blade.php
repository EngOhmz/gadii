@extends('layouts.master')
@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Project</h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#home2" role="tab" aria-controls="home"
                                        aria-selected="true">Project
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#profile2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Project</a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="home2" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table datatable-basic table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 176.484px;">Project </th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Platform(s): activate to sort column ascending"
                                                        style="width: 126.484px;">Category</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 121.219px;">Department</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 121.219px;">Client</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 121.219px;">Start Date</th>
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
                                                @if (!@empty($project))
                                                    @foreach ($project as $row)
                                                        <tr class="gradeA even" role="row">

                                                            <td><a href="{{ route('project.show', $row->id) }}">
                                                                    {{ $row->project_name }} - {{ $row->project_no }}</a>
                                                            </td>

                                                            <td>{{ $row->category->category_name }}</td>

                                                            @if (!empty($row->department_id))
                                                                <td>{{ $row->department->name }}</td>
                                                            @else
                                                                <td>-</td>
                                                            @endif

                                                            @if (!empty($row->client_id))
                                                                <td>{{ $row->client->name }}</td>
                                                            @else
                                                                <td>-</td>
                                                            @endif


                                                            <td>{{ Carbon\Carbon::parse($row->start_date)->format('d/m/Y') }}
                                                            </td>

                                                            <td>
                                                                <div class="form-inline">
                                                                    <a class="nav-link" href=""
                                                                        data-toggle="modal" value="{{ $row->id }}"
                                                                        data-type="view" data-target="#appFormModal"
                                                                        onclick="model({{ $row->id }},'view')">View</a>
                                                                    <a class="nav-link" href=""
                                                                        data-toggle="modal" value="{{ $row->id }}"
                                                                        data-type="assign" data-target="#appFormModal"
                                                                        onclick="model({{ $row->id }},'assign')"><i
                                                                            class="icon-plus-circle2"></i></a>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <div class="form-inline">
                                                                    @if ($row->status == 'Cancelled')
                                                                        <div class="badge badge-danger badge-shadow">
                                                                            {{ $row->status }}</div>
                                                                    @elseif($row->status == 'In Progress')
                                                                        <div class="badge badge-info badge-shadow">
                                                                            {{ $row->status }}</div>
                                                                    @elseif($row->status == 'Completed')
                                                                        <span
                                                                            class="badge badge-success badge-shadow">{{ $row->status }}</span>
                                                                    @else
                                                                        <div class="badge badge-warning badge-shadow">
                                                                            {{ $row->status }}</div>
                                                                    @endif


                                                                    <div class="dropdown">&nbsp;
                                                                        <a href="#"
                                                                            class="list-icons-item dropdown-toggle text-teal"
                                                                            data-toggle="dropdown"></a>
                                                                        <div class="dropdown-menu">
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $row->id }}"
                                                                                href="{{ route('project.change_status', ['id' => $row->id, 'status' => 'Started']) }}">Started</a>
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $row->id }}"
                                                                                href="{{ route('project.change_status', ['id' => $row->id, 'status' => 'In Progress']) }}">In
                                                                                Progress</a>
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $row->id }}"
                                                                                href="{{ route('project.change_status', ['id' => $row->id, 'status' => 'On Hold']) }}">On
                                                                                Hold</a>
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $row->id }}"
                                                                                href="{{ route('project.change_status', ['id' => $row->id, 'status' => 'Cancelled']) }}">Cancelled</a>
                                                                            <a class="nav-link change_status"
                                                                                data-id="{{ $row->id }}"
                                                                                href="{{ route('project.change_status', ['id' => $row->id, 'status' => 'Completed']) }}">Completed</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td>
                                                                <div class="form-inline">
                                                                    <a class="list-icons-item text-primary" title="Edit"
                                                                        href="{{ route('project.edit', $row->id) }}"><i
                                                                            class="icon-pencil7"></i></a>&nbsp


                                                                    {!! Form::open(['route' => ['project.destroy', $row->id], 'method' => 'delete']) !!}
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
                                <div class="tab-pane fade @if (!empty($id)) active show @endif"
                                    id="profile2" role="tabpanel" aria-labelledby="profile-tab2">

                                    <div class="card">
                                        <div class="card-header">
                                            @if (empty($id))
                                                <h5>Create Project</h5>
                                            @else
                                                <h5>Edit Project</h5>
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-12 ">
                                                    @if (isset($id))
                                                        {{ Form::model($id, ['route' => ['project.update', $id], 'method' => 'PUT']) }}
                                                    @else
                                                        {{ Form::open(['route' => 'project.store']) }}
                                                        @method('POST')
                                                    @endif

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Project No</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="project_no"
                                                                value="{{ isset($data) ? $data->project_no : $reference }}"
                                                                class="form-control" readonly required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Project Name</label>
                                                        <div class="col-lg-8">
                                                            <input type="text" name="project_name"
                                                                value="{{ isset($data) ? $data->project_name : '' }}"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>


                                                    @if (!empty($data))
                                                        <?php
                                                        $list2 = explode(',', $data->category_id);
                                                        ?>
                                                    @endif

                                                    <?php $a = 1; ?>


                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Project Category</label>
                                                        <div class="col-lg-6">
                                                            @if (!empty($category))
                                                                <input type="checkbox" name="select_all2"
                                                                    id="example-select-all2"> Select All <br>
                                                                @foreach ($category as $row)
                                                                    <input name="category_id[]" type="checkbox"
                                                                        class="checks2" value="{{ $row->id }}"
                                                                        @if (!empty($data)) <?php if (in_array("$row->id", $list2)) {
                                                                            echo 'checked';
                                                                        } ?> @endif>
                                                                    {{ $row->category_name }} &nbsp;
                                                                @endforeach
                                                            @endif

                                                        </div>&nbsp

                                                    </div>


                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Related To</label>
                                                        <div class="col-lg-8">
                                                            <select class="m-b account_id related_class"
                                                                id="goal_tracking_id" name="goal_tracking_id" required>
                                                                <option value="">Select Related</option>
                                                                <option value="Clients"
                                                                    @if (isset($data)) @if ($data->goal_tracking_id == 'Clients') selected @endif
                                                                    @endif >Clients</option>
                                                                <option value="Departments"
                                                                    @if (isset($data)) @if ($data->goal_tracking_id == 'Departments') selected @endif
                                                                    @endif >Departments</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div id="projectDiv" style="display:none">

                                                        <div class="form-group row"><label
                                                                class="col-lg-2 col-form-label">Select Client</label>
                                                            <div class="col-lg-8">
                                                                <select class="m-b account_id" id="client_id"
                                                                    name="client_id">
                                                                    <option value="">Select Client</option>
                                                                    @foreach ($clientspj as $row)
                                                                        <option value="{{ $row->id }}"
                                                                            @if (isset($data)) @if ($data->client_id == $row->id) selected @endif
                                                                            @endif
                                                                            >{{ $row->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                    </div>



                                                    <div id="leadsDiv" style="display:none">

                                                        <div class="form-group row"><label
                                                                class="col-lg-2 col-form-label">Department</label>
                                                            <div class="col-lg-8">
                                                                <select class="m-b account_id" id="department_id"
                                                                    name="department_id">
                                                                    <option value="">Select Department</option>
                                                                    @foreach ($client as $row)
                                                                        <option value="{{ $row->id }}"
                                                                            @if (isset($data)) @if ($data->department_id == $row->id) selected @endif
                                                                            @endif
                                                                            >{{ $row->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Start Date</label>
                                                        <div class="col-lg-8">
                                                            <input type="date" name="start_date" required
                                                                placeholder=""
                                                                value="{{ isset($data) ? $data->start_date : date('Y-m-d') }}"
                                                                class="form-control" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Include Due Date</label>
                                                        <div class="col-lg-8">
                                                            <input type="radio" name="due" value="Yes"
                                                                {{ !empty($data) ? ($data->due == 'Yes' ? 'checked' : '') : '' }}
                                                                class="type"> Yes
                                                            <input type="radio" name="due" value="No"
                                                                class=" type"
                                                                {{ !empty($data) ? ($data->due == 'No' ? 'checked' : '') : '' }}>
                                                            No
                                                        </div>
                                                    </div>

                                                    @if (!empty($data->end_date))
                                                        <div class="form-group row end">
                                                            <label class="col-lg-2 col-form-label">End Date</label>
                                                            <div class="col-lg-8">
                                                                <input type="date" name="end_date" required
                                                                    placeholder=""
                                                                    value="{{ isset($data) ? $data->end_date : date('Y-m-d') }}"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="form-group row end" style="display:none">
                                                            <label class="col-lg-2 col-form-label">End Date</label>
                                                            <div class="col-lg-8">
                                                                <input type="date" name="end_date" required
                                                                    placeholder=""
                                                                    value="{{ isset($data) ? $data->end_date : date('Y-m-d') }}"
                                                                    class="form-control">
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="form-group row"><label
                                                            class="col-lg-2 col-form-label">Status</label>
                                                        <div class="col-lg-8">
                                                            <select class="m-b" id="bank_id" name="status"
                                                                required>

                                                                <option value="">Select</option>

                                                                <option value="Started"
                                                                    @if (isset($data)) @if ($data->status == 'Started') selected @endif
                                                                    @endif >Started</option>

                                                                <option value="In Progress"
                                                                    @if (isset($data)) @if ($data->status == 'In Progress') selected @endif
                                                                    @endif >In Progress</option>

                                                                <option value="On Hold"
                                                                    @if (isset($data)) @if ($data->status == 'On Hold') selected @endif
                                                                    @endif >On Hold</option>

                                                                <option value="Cancelled"
                                                                    @if (isset($data)) @if ($data->status == 'Cancelled') selected @endif
                                                                    @endif >Cancelled</option>
                                                                <option value="Completed"
                                                                    @if (isset($data)) @if ($data->status == 'Completed') selected @endif
                                                                    @endif >Completed</option>

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Description</label>
                                                        <div class="col-lg-8">
                                                            <textarea class="form-control" name="description">{{ isset($data) ? $data->description : '' }}</textarea>

                                                        </div>
                                                    </div>

                                                    @if (!empty($data))
                                                        <?php
                                                        $list = explode(',', $data->assigned_to);
                                                        ?>
                                                    @endif
                                                    <div class="form-group row">
                                                        <label class="col-lg-2 col-form-label">Assigned To</label>
                                                        <div class="col-lg-8">
                                                            @if (!empty($user))
                                                                <input type="checkbox" name="select_all"
                                                                    id="example-select-all"> Select All <br>
                                                                @foreach ($user as $row)
                                                                    <input name="trans_id[]" type="checkbox"
                                                                        class="checks" value="{{ $row->id }}"
                                                                        @if (!empty($data)) <?php if (in_array("$row->id", $list)) {
                                                                            echo 'checked';
                                                                        } ?> @endif>
                                                                    {{ $row->name }} &nbsp;
                                                                @endforeach
                                                            @endif

                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="col-lg-offset-2 col-lg-12">
                                                            @if (!@empty($id))
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

    <!-- discount Modal -->
    <div class="modal fade" id="appFormModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {

            $(document).on('change', '.related_class', function() {

                var id = $(this).val();

                if (id == 'Clients') {
                    $('#projectDiv').show();
                    $('#leadsDiv').hide();
                } else if (id == 'Departments') {
                    $('#projectDiv').hide();
                    $('#leadsDiv').show();
                }
            });
        });
    </script>


    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [{
                "targets": [3]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            "language": {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: {
                    'first': 'First',
                    'last': 'Last',
                    'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
                    'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
                }
            },

        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('change', '.type', function() {
                var id = $(this).val();
                console.log(id);
                if ($(this).val() == 'Yes') {
                    $('.end').show();
                } else {
                    $('.end').hide();
                }
            });
        });
    </script>


    <script>
        $("#example-select-all2").click(function() {
            $(".checks2").prop("checked", $(this).prop("checked"));
        });

        $(".checks2").click(function() {
            if (!$(this).prop("checked")) {
                $("#example-select-all2").prop("checked", false);
            }
        });
    </script>

    <script>
        $("#example-select-all").click(function() {
            $(".checks").prop("checked", $(this).prop("checked"));
        });

        $(".checks").click(function() {
            if (!$(this).prop("checked")) {
                $("#example-select-all").prop("checked", false);
            }
        });
    </script>

    <script type="text/javascript">
        function model(id, type) {

            $.ajax({
                type: 'GET',
                url: '{{ url('project/projectModal') }}',
                data: {
                    'id': id,
                    'type': type,
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

@endsection

