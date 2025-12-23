<div class="card-header"> <strong></strong> </div>
<div class="card-body">
    <ul class="nav nav-tabs" id="myTab2" role="tablist">
        <li class="nav-item">
            <a class="nav-link  @if (
                    $type == 'details' ||
                    $type == 'comments' ||
                    $type == 'task' ||
                    $type == 'milestone') active @endif" id="home-tab2" data-toggle="tab"
                href="#milestone-home2" role="tab" aria-controls="home" aria-selected="true">Milestone
                List</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($type == 'edit-milestone') active @endif" id="profile-tab2" data-toggle="tab"
                href="#milestone-profile2" role="tab" aria-controls="profile" aria-selected="false">New
                Milestone</a>
        </li>

    </ul>
    <br>
    <div class="tab-content tab-bordered" id="myTab3Content">
        <div class="tab-pane fade @if (
                $type == 'details' ||
                $type == 'comments' ||
                $type == 'task' ||
                $type == 'milestone') active show @endif " id="milestone-home2"
            role="tabpanel" aria-labelledby="home-tab2">
            <div class="table-responsive">
                <table class="table datatable-basic table-striped" style="width:100%">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 156.484px;">#</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 156.484px;">Milestone Name</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">Responsible</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">Start Date</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">End Date</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                style="width: 98.1094px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (!@empty($mile))
                            @foreach ($mile as $row)
                                <tr class="gradeA even" role="row">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->name }}</td>
                                    @php $assign = App\Models\User::find($row->responsible_id)->name; @endphp
                                    <td>{{$assign}}</td>  
                                    <td>{{ $row->start_date }}</td>
                                    <td>{{ $row->end_date }}</td>
                                    <td>
                                        <div class="form-inline">
                                            <a class="list-icons-item text-primary" title="Edit"
                                                href="{{ route('edit.goal_details', ['type' => 'edit-milestone', 'type_id' => $row->id]) }}"><i
                                                class="icon-pencil7"></i></a>&nbsp
                                                
                                            <a class="list-icons-item text-danger" title="Edit"
                                                href="{{ route('delete.goal_details', ['type' => 'delete-milestone', 'type_id' => $row->id]) }}"
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
        <div class="tab-pane fade  @if ($type == 'edit-milestone') active show @endif" id="milestone-profile2"
            role="tabpanel" aria-labelledby="profile-tab2">
            <br>
            <div class="card">
                <div class="card-header">
                    @if ($type == 'edit-milestone')
                        <h5>Edit Milestone</h5>
                    @else
                        <h5>Add New Milestone</h5>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 ">
                            @if ($type == 'edit-milestone')
                                {!! Form::open(['route' => 'update.goal_details', 'enctype' => 'multipart/form-data']) !!}
                                <input type="hidden" name="id" value="{{ $type_id }}">
                            @else
                                {!! Form::open(['route' => 'save.goal_details', 'enctype' => 'multipart/form-data']) !!}
                                @method('POST')
                            @endif
                            <input type="hidden" name="goal_id" value="{{ $id }}">
                            <input type="hidden" name="type" value="milestone">

                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label"> Name</label>
                                <div class="col-lg-8">
                                    <input type="text" name="name"
                                        value="{{ isset($edit_data) ? $edit_data->name : '' }}" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label"> Description </label>
                                <div class="col-lg-8">
                                    <input type="text" name="description"
                                        value="{{ isset($edit_data) ? $edit_data->description : '' }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="form-group row"><label class="col-lg-2 col-form-label">Responsible</label>
                                <div class="col-lg-8">
                                    <select class="form-control m-b account_id" id="user_id" name="responsible_id"
                                        required>
                                        <option value="">Select </option>
                                        @foreach ($user as $row)
                                            <option value="{{ $row->id }}"
                                                @if (isset($edit_data)) @if ($edit_data->responsible_id == $row->id) selected @endif
                                                @endif >{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Start Date</label>
                                <div class="col-lg-8">
                                    <input type="date" name="start_date" required placeholder=""
                                        value="{{ isset($edit_data) ? $edit_data->start_date : date('Y-m-d') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">End Date</label>
                                <div class="col-lg-8">
                                    <input type="date" name="end_date" required placeholder=""
                                        value="{{ isset($edit_data) ? $edit_data->end_date : date('Y-m-d') }}"
                                        class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-offset-2 col-lg-12">
                                    @if ($type == 'edit-milestone')
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
