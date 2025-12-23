<div class="card-header"> <strong></strong> </div>

<div class="card-body">
    <ul class="nav nav-tabs" id="myTab2" role="tablist">
        <li class="nav-item">
            <a class="nav-link  @if (
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
                    $type == 'logistic' ||
                    $type == 'cargo' ||
                    $type == 'storage' ||
                    $type == 'charge' ||
                    $type == 'activities') active @endif" id="home-tab2" data-toggle="tab"
                href="#milestone-home2" role="tab" aria-controls="home" aria-selected="true">Storage
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
                $type == 'storage' ||
                $type == 'charge' ||
                $type == 'logistic' ||
                ($type = 'cargo')) active show @endif " id="milestone-home2"
            role="tabpanel" aria-labelledby="home-tab2">
            <div class="table-responsive">
                <table class="table datatable-attachcf table-striped" style="width:100%">
                    <thead>
                        <tr role="row">
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Platform(s): activate to sort column ascending"
                                style="width: 156.484px;">#</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">Storage Charge</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">DueDate</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">Charge Start</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">Amount</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="Engine version: activate to sort column ascending"
                                style="width: 121.219px;">Recalculate</th>
                            <th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1"
                                colspan="1" aria-label="CSS grade: activate to sort column ascending"
                                style="width: 98.1094px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                        @if (!@empty($storage))
                            @foreach ($storage as $row)
                                <tr class="gradeA even" role="row">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->store_charge }}</td>
                                    <td>{{ $row->due_date }}</td>
                                    <td>{{ $row->charge_start }}</td>
                                    <td>{{ $row->amount }}</td>
                                    <td> <a type="button" class="list-icons-item text-primary" title="Recalculate"
                                            href="{{ route('update_amount', $row->id) }}">Recalculate</a>
                                    </td>
                                    <td>
                                        <div class="form-inline">

                                            <a type="button" data-toggle="modal" data-target="#edit{{ $row->id }}"
                                                class="list-icons-item text-primary" title="Edit"
                                                href="{{ route('cf_delete_details', ['type' => 'edit-storage', 'type_id' => $row->id]) }}"><i
                                                    class="icon-pencil7"></i></a>&nbsp

                                            <a class="list-icons-item text-danger" title="Delete"
                                                href="{{ route('cf_delete_details', ['type' => 'delete-storage', 'type_id' => $row->id]) }}"
                                                onclick="return confirm('Are you sure, you want to delete?')"><i
                                                    class="icon-trash"></i></a>&nbsp
                                                    
                                             <a class="button" href="" data-toggle="modal" value="{{ $data->id }}" title="stock movement"
                                                data-type="assign" data-target="#app2FormModal" onclick="modelStock({{ $data->id }},'stock_movement',{{ $row->id }})"><i
                                                class="icon-car"></i></a>&nbsp


                                        </div>
                                    </td>
                                </tr>
                                <!-- Modal -->
                                <div class="modal fade" id="edit{{ $row->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-sm-12 ">
                                                        {!! Form::open(['route' => 'update_det', 'enctype' => 'multipart/form-data']) !!}
                                                        @method('POST')
                                                        <input type="hidden" name="cf_id"
                                                            value="{{ $id }}">
                                                        <input type="hidden" name="type" value="storage">
                                                        <input type="hidden" name="id"
                                                            value="{{ $row->id }}">
                                                        <div class="form-group row"><label
                                                                class="col-lg-3 col-form-label">Storage Charge</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" name="store_charge"
                                                                    value="{{ $row->store_charge }}"
                                                                    class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row"><label
                                                                class="col-lg-3 col-form-label">Storage Start
                                                                Due</label>
                                                            <div class="col-lg-9">
                                                                <input type="date" name="store_start_date"
                                                                    value="{{ $row->store_start_date }}"
                                                                    class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row"><label
                                                                class="col-lg-3 col-form-label">Due Date</label>
                                                            <div class="col-lg-9">
                                                                <input type="date" name="due_date"
                                                                    value="{{ $row->due_date }}" class="form-control"
                                                                    required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row"><label
                                                                class="col-lg-3 col-form-label">Charge Start of Due
                                                                Date</label>
                                                            <div class="col-lg-9">
                                                                <input type="number" name="charge_start"
                                                                    value="{{ $row->charge_start }}"
                                                                    class="form-control" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-lg-offset-2 col-lg-12">
                                                                <button
                                                                    class="btn btn-sm btn-primary float-right m-t-n-xs"
                                                                    type="submit">Update</button>
                                                            </div>
                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <!--stock movement-->
                    <div class="modal fade" id="app2FormModal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                        </div>
                    </div>
            
                    <div id="appFormModal" class="modal fade" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
            
                                <div class="modal-body">
            
                                </div>
            
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
            
                                </div>
            
                            </div>
                        </div>
                    </div
                <!--end modal-->
            </div>
        </div>
    </div>
</div>
  
        
      