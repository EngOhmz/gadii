<div class="card-header"> <strong></strong> </div>

<div class="card-body">
    <ul class="nav nav-tabs" id="myTab2" role="tablist">
        <li class="nav-item">
            <a class="nav-link @if (
                $type == 'credit' ||
                    $type == 'details' ||
                    $type == 'calendar' ||
                    $type == 'purchase' ||
                    $type == 'debit' ||
                    $type == 'invoice' ||
                    $type == 'comments' ||
                    $type == 'attachment' ||
                    $type == 'milestone' ||
                    $type == 'tasks' ||
                    $type == 'expenses' ||
                    $type == 'estimate' ||
                    $type == 'notes' ||
                    $type == 'activities' ||
                    $type == 'logistic' ||
                    $type == 'cargo' ||
                    $type == 'storage' ||
                    $type == 'charge') active @endif" id="home-tab2" data-toggle="tab"
                href="#milestone-home2" role="tab" aria-controls="home" aria-selected="true">Charge
                List</a>
        </li>

    </ul>
    <br>
    <div class="tab-content tab-bordered" id="myTab3Content">
        <div class="tab-pane fade @if (
            $type == 'credit' ||
                $type == 'details' ||
                $type == 'calendar' ||
                $type == 'purchase' ||
                $type == 'debit' ||
                $type == 'invoice' ||
                $type == 'comments' ||
                $type == 'attachment' ||
                $type == 'milestone' ||
                $type == 'tasks' ||
                $type == 'expenses' ||
                $type == 'estimate' ||
                $type == 'notes' ||
                $type == 'activities' ||
                $type == 'logistic' ||
                $type == 'cargo' ||
                $type == 'storage' ||
                $type == 'charge') active show @endif " id="milestone-home2"
            role="tabpanel" aria-labelledby="home-tab2">
            <div class="table-responsive">
                <table class="table datatable-attachcf table-striped" style="width:100%">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 156.484px;">#</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 156.484px;">CF Service Name</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">Amount</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                style="width: 98.1094px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (!@empty($charge))
                            @foreach ($charge as $row)
                                <tr class="gradeA even" role="row">
                                    <td>{{ $loop->iteration }}</td>
                                    @php $cfname= App\Models\CF\CFservice::find($row->cf_servece_id)->name; @endphp
                                    <td>{{ $cfname }}</td>
                                    <td>{{ $row->amount }}</td>
                                    <td>
                                        <a type="button" data-toggle="modal"
                                            data-target="#edit-charge{{ $row->id }}"
                                            class="list-icons-item text-primary" title="Edit"
                                            href="{{ route('update_det', ['type' => 'edit-charge', 'type_id' => $row->id]) }}"><i
                                                class="icon-pencil7"></i></a>&nbsp

                                        <a class="list-icons-item text-danger" title="Delete"
                                            href="{{ route('cf_delete_details', ['type' => 'delete-charge', 'type_id' => $row->id]) }}"
                                            onclick="return confirm('Are you sure, you want to delete?')"><i
                                                class="icon-trash"></i></a>&nbsp
                                    </td>
                                </tr>
                                <!-- Modal -->
                                <div class="modal fade" id="edit-charge{{ $row->id }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Charge</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12 ">
                                                        {{ Form::open(['route' => 'update_det']) }}
                                                        @method('POST')
                                                        <input type="hidden" name="cf_id"
                                                            value="{{ $id }}">
                                                        <input type="hidden" name="id"
                                                            value="{{ $row->id }}">
                                                        <input type="hidden" name="type" value="charge">
                                                        <div class="form-group row"><label
                                                                class="col-lg-3 col-form-label">CF Service</label>
                                                            <div class="col-lg-9">
                                                                <select name="cf_servece_id" id="cf_servece_id"
                                                                    class="form-control m-b" required>
                                                                    <option value="">Select Here</option>
                                                                    @php $ab = App\Models\CF\CFservice::find($row->cf_servece_id)->name; @endphp
                                                                    @foreach ($CFservice as $c)
                                                                        <option value="{{ $c->id }}"
                                                                            @if (isset($CFservice)) {{ $c->id == $row->cf_servece_id ? 'selected' : '' }} @endif>
                                                                            {{ $c->name }}</option>
                                                                    @endforeach
                                                                </select>

                                                            </div>
                                                        </div>
                                                        <div class="form-group row"><label
                                                                class="col-lg-3 col-form-label">Amount </label>
                                                            <div class="col-lg-9">
                                                                <input type="number" name="amount"
                                                                    value="{{ $row->amount }}" class="form-control"
                                                                    required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-lg-offset-2 col-lg-12">
                                                                <button
                                                                    class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                    type="submit">Save</button>
                                                            </div>
                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
