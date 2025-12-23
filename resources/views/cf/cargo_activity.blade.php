<div class="card-header"> <strong></strong> </div>

<div class="card-body">
    <ul class="nav nav-tabs" id="myTab2" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if ($type == 'cargoActivity' || $type == 'details') active @endif" id="cargo-tab1" data-toggle="tab"
                href="#cargo-home-act" role="tab" aria-controls="home" aria-selected="true">Cargo Activity</a>
        </li>
        <li class="nav-item">
            <a class="nav-link @if ($type == 'edit-cargoActivity') active @endif" id="cargo-tab2" data-toggle="tab"
                href="#cargo-profile-act" role="tab" aria-controls="profile" aria-selected="false">New Cargo Activity</a>
        </li>
    </ul>
    <br>
    <div class="tab-content tab-bordered" id="myTab3Content">
        <div class="tab-pane fade @if ($type == 'cargoActivity' || $type == 'details') active show @endif" id="cargo-home-act" role="tabpanel"
            aria-labelledby="cargo-tab1">
            <div class="table-responsive">
                <table class="table datatable-basic table-striped" style="width:100%">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 156.484px;">#</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 156.484px;">Cargo Name</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">Activity</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">Activity Date</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">Notes</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                style="width: 158.1094px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($cargoActivity))
                            @foreach ($cargoActivity as $row)
                                <tr class="gradeA even" role="row">
                                    <td>{{ $loop->iteration }}</td>
                                    @php
                                        $cargo_name = App\Models\CF\Cargo::find($row->name_id);
                                    @endphp
                                    <td>{{ $cargo_name ? $cargo_name->name : 'N/A' }}</td>
                                    <td>{{ $row->activity }}</td>
                                    <td>{{ Carbon\Carbon::parse($row->activity_date)->format('d/m/Y') }}</td>
                                    <td>{{ $row->notes ?? 'N/A' }}</td>
                                    <td>
                                        <div class="form-inline">
                                            <a class="list-icons-item text-primary" title="Edit"
                                                href="{{ route('edit.cf_details', ['id' => $id, 'type' => 'edit-cargoActivity', 'type_id' => $row->id]) }}"><i
                                                    class="icon-pencil7"></i></a>&nbsp;
                                            <a class="list-icons-item text-danger" title="Delete"
                                                href="{{ route('delete.cf_details', ['type' => 'delete-cargoActivity', 'type_id' => $row->id]) }}"
                                                onclick="return confirm('Are you sure, you want to delete?')"><i
                                                    class="icon-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="tab-pane fade @if ($type == 'edit-cargoActivity') active show @endif" id="cargo-profile-act"
            role="tabpanel" aria-labelledby="cargo-tab2">
            <br>
            <div class="card">
                <div class="card-header">
                    @if ($type == 'edit-cargoActivity')
                        <h5>Edit Cargo Activity</h5>
                    @else
                        <h5>Add New Cargo Activity</h5>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 ">
                            @if ($type == 'edit-cargoActivity')
                                {!! Form::open(['route' => 'update.cf_details', 'enctype' => 'multipart/form-data']) !!}
                                
                                <input type="hidden" name="cf_id" value="{{ $id }}">
                            
                            @else
                                {!! Form::open(['route' => 'save.cf_details', 'enctype' => 'multipart/form-data']) !!}
                                @method('POST')
                            @endif

                            
                            <input type="hidden" name="cf_id" value="{{ $id }}">

                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Cargo Name</label>
                                <div class="col-lg-10">
                                    <select class="m-b account_id" id="name_id" name="name_id" required>
                                        <option value="">Select</option>
                                        @foreach ($Cargo as $row)
                                            <option value="{{ $row->id }}"
                                                @if (isset($selectedCargoActivity) && $selectedCargoActivity->name_id == $row->id) selected @endif >{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Activity</label>
                                <div class="col-lg-10">
                                    <select class="m-b related_class" id="activity" name="activity" required>
                                        <option value="">Select Related</option>
                                        <option value="Clearing">Clearing</option>
                                        <option value="Forwading">Forwading</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Activity Date</label>
                                <div class="col-lg-10">
                                    <input type="date" name="activity_date" required placeholder=""
                                        value="{{ isset($selectedCargoActivity) ? $selectedCargoActivity->activity_date : date('Y-m-d') }}"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Notes</label>
                                <div class="col-lg-10">
                                    <input type="text" name="notes" placeholder="Enter notes"
                                        value="{{ isset($selectedCargoActivity) ? $selectedCargoActivity->notes : '' }}"
                                        class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-offset-2 col-lg-12">
                                    @if ($type == 'edit-cargoActivity')
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

<script type="text/javascript">
    $(document).ready(function() {
        $('.m-b').select2({
            width: '100%',
        });
    });
</script>
