@extends('layouts.master')


@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-6 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Goal Tracking</h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link @if (empty($id)) active show @endif" id="home-tab2"
                                        data-toggle="tab" href="#cf1" role="tab" aria-controls="home"
                                        aria-selected="true">Goal Tracking
                                        List</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link @if (!empty($id)) active show @endif"
                                        id="profile-tab2" data-toggle="tab" href="#cf2" role="tab"
                                        aria-controls="profile" aria-selected="false">New Goal Tracking</a>
                                </li>

                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade @if (empty($id)) active show @endif"
                                    id="cf1" role="tabpanel" aria-labelledby="home-tab2">
                                    <div class="table-responsive">
                                        <table class="table datatable-basic table-striped">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">#</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Subject</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Type</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Amount</th>
                                                    <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0"
                                                        rowspan="1" colspan="1"
                                                        aria-label="Engine version: activate to sort column ascending"
                                                        style="width: 141.219px;">Target Achievement</th>
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
                                                        style="width: 108.1094px;">Actions</th>
                                                </tr>
                                            </thead>
                                            @if (!@empty($goal))
                                                @foreach ($goal as $row)
                                                    <tr class="gradeA even" role="row">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><a href="{{ route('goal.show', $row->id) }}">
                                                                {{ $row->subject }}</a></td>
                                                        <td>{{ $row->goal_type }}</td>
                                                        <td>{{ $row->target_amount }}</td>
                                                        @php  $c = App\Models\Goal_Tracking\Achievement::find($row->achievement_id)->name; @endphp
                                                        <td>{{ $c }}</td>
                                                        <td>{{ $row->start_date }}</td>
                                                        <td>{{ $row->end_date }}</td>
                                                        <td>
                                                            <div class="form-inline">


                                                                <a class="list-icons-item text-primary" title="Edit"
                                                                    href="{{ route('edit.goal', ['id' => $row->id]) }}"><i
                                                                        class="icon-pencil7"></i></a>&nbsp

                                                                <a class="list-icons-item text-danger" title="Edit"
                                                                    href=""
                                                                    onclick="return confirm('Are you sure, you want to delete?')"><i
                                                                        class="icon-trash"></i></a>&nbsp



                                                            </div>
                                    </div>
                                    </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade @if (!empty($id)) active show @endif" id="cf2"
                                role="tabpanel" aria-labelledby="profile-tab2">

                                <div class="card">
                                    <div class="card-header">
                                        @if (!empty($id))
                                            <h5>Edit Goal Tracking</h5>
                                        @else
                                            <h5>Add New Goal Tracking</h5>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="mx-auto col-12 col-md-10 col-lg-8">
                                                @if (isset($id))
                                                    {{ Form::model($id, ['route' => ['goal.update', $id], 'method' => 'PUT']) }}
                                                @else
                                                    {{ Form::open(['route' => 'goal.store']) }}
                                                    @method('POST')
                                                @endif

                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Subject<span class="text-danger">
                                                            *</span></label>
                                                    <div class="col-lg-10">
                                                        <input type="text" name="subject" class="form-control"
                                                            value="{{ isset($edit_data) ? $edit_data->subject : '' }}"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Goal
                                                        Type<span class="text-danger"> *</span></label>
                                                    <div class="col-lg-10">
                                                        <input type="text" name="goal_type" class="form-control"
                                                            value="{{ isset($edit_data) ? $edit_data->goal_type : '' }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">
                                                        Amount<span class="text-danger"> *</span></label>
                                                    <div class="col-lg-10">
                                                        <input type="number" name="target_amount" class="form-control"
                                                            value="{{ isset($edit_data) ? $edit_data->target_amount : '' }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Target
                                                        Achievement<span class="text-danger"> *</span></label>
                                                    <div class="col-lg-10">
                                                        <select class="m-b form-control" id="user_id"
                                                            name="achievement_id" required>
                                                            <option value="">Select </option>
                                                            @foreach ($data as $row)
                                                                <option value="{{ $row->id }}"
                                                                    @if (isset($edit_data)) @if ($edit_data->achievement_id == $row->id) selected @endif
                                                                    @endif >{{ $row->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">User<span class="text-danger">
                                                            *</span></label>
                                                    <div class="col-lg-10">
                                                        <select class="m-b form-control" id="user_id" name="user_id"
                                                            required>
                                                            <option value="">Select User</option>
                                                            @foreach ($user as $row)
                                                                <option value="{{ $row->id }}"
                                                                    @if (isset($edit_data)) @if ($edit_data->user_id == $row->id) selected @endif
                                                                    @endif >{{ $row->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row"><label class="col-lg-2 col-form-label">Start
                                                        Date<span class="text-danger"> *</span></label>
                                                    <div class="col-lg-10">
                                                        <input type="date" name="start_date" class="form-control"
                                                            value="{{ isset($edit_data) ? $edit_data->start_date : '' }}"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="form-group row"><label class="col-lg-2 col-form-label">End
                                                        Date<span class="text-danger"> *</span></label>
                                                    <div class="col-lg-10">
                                                        <input type="date" name="end_date" class="form-control"
                                                            value="{{ isset($edit_data) ? $edit_data->end_date : '' }}"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Description<span
                                                            class="text-danger"> *</span></label>
                                                    <div class="col-lg-10">
                                                        <textarea class="form-control" name="description">
                                                         {{ isset($edit_data) ? $edit_data->description : '' }}
                                                        </textarea>
                                                    </div>
                                                </div>

                                                @if (!empty($edit_data))
                                                    <?php
                                                    $list = explode(',', $edit_data->assigned_to);
                                                    ?>
                                                @endif
                                                <div class="form-group row"><label
                                                        class="col-lg-2 col-form-label">Permission</label>
                                                    <div class="col-lg-10">
                                                        <div class="form-check">
                                                            <label class="col-lg-2 col-form-label">Assigned To</label>
                                                            <div class="col-lg-8">
                                                                @if (!empty($user))
                                                                    <input type="checkbox" name="select_all"
                                                                        id="example-select-all"> Select All <br>
                                                                    @foreach ($user as $row)
                                                                        <input name="trans_id[]" type="checkbox"
                                                                            class="checks" value="{{ $row->id }}"
                                                                            @if (!empty($edit_data)) <?php if (in_array("$row->id", $list)) {
                                                                                echo 'checked';
                                                                            } ?> @endif>
                                                                        {{ $row->name }} &nbsp;
                                                                    @endforeach
                                                                @endif

                                                            </div>
                                                        </div>
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


    </section>
@endsection

@section('scripts')
    <script>
        $('.datatable-basic').DataTable({
            autoWidth: false,
            "columnDefs": [{
                "orderable": false,
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
    <script src="{{ url('assets/js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('change', '.related_class', function() {
                var id = $(this).attr('id');

                if (id == 'Clients') {
                    $('#ClientsDiv').show();

                } else {
                    $('#ClientsDiv').hide();
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
@endsection
